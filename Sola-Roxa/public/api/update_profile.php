<?php
require_once __DIR__ . '/../../backend/db.php';
require_once __DIR__ . '/../../backend/auth.php';
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

if (!isLoggedUser()) {
    http_response_code(401);
    echo json_encode(['error' => 'Não autenticado']);
    exit;
}

try {
    $user = $_SESSION['user'];
    $id = (int) $user['id'];

    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if ($nome === '' || $email === '') {
        http_response_code(400);
        echo json_encode(['error' => 'Nome e email são obrigatórios']);
        exit;
    }

    // Iniciar transação para manter consistência entre usuario e vendedor
    $pdo->beginTransaction();

    // Se o email mudou, verificar unicidade na tabela usuario
    $stmt = $pdo->prepare('SELECT id_cliente FROM usuario WHERE email = ? AND id_cliente <> ? LIMIT 1');
    $stmt->execute([$email, $id]);
    if ($stmt->fetch()) {
        $pdo->rollBack();
        http_response_code(409);
        echo json_encode(['error' => 'Email já em uso']);
        exit;
    }

    // Se o usuário também estiver autenticado como vendedor, garanta unicidade em vendedor
    $updatedSeller = null;
    if (!empty($_SESSION['vendedor']) && !empty($_SESSION['vendedor']['id'])) {
        $sellerId = (int) $_SESSION['vendedor']['id'];
        $stmt = $pdo->prepare('SELECT id_vendedor FROM vendedor WHERE email = ? AND id_vendedor <> ? LIMIT 1');
        $stmt->execute([$email, $sellerId]);
        if ($stmt->fetch()) {
            $pdo->rollBack();
            http_response_code(409);
            echo json_encode(['error' => 'Email já em uso por outro vendedor']);
            exit;
        }
    }

    if ($senha) {
        $hash = password_hash($senha, PASSWORD_DEFAULT);
        $update = $pdo->prepare('UPDATE usuario SET nome = ?, email = ?, senha = ? WHERE id_cliente = ?');
        $update->execute([$nome, $email, $hash, $id]);
    } else {
        $update = $pdo->prepare('UPDATE usuario SET nome = ?, email = ? WHERE id_cliente = ?');
        $update->execute([$nome, $email, $id]);
    }

    // Se o usuário também for vendedor (sessão ativa), atualize a tabela vendedor correspondente
    if (!empty($_SESSION['vendedor']) && !empty($_SESSION['vendedor']['id'])) {
        $sellerId = (int) $_SESSION['vendedor']['id'];
        $upd = $pdo->prepare('UPDATE vendedor SET nome = ?, email = ? WHERE id_vendedor = ?');
        $upd->execute([$nome, $email, $sellerId]);

        // Recarrega dados do vendedor atualizado para retorno
        $sel = $pdo->prepare('SELECT id_vendedor, nome, email FROM vendedor WHERE id_vendedor = ? LIMIT 1');
        $sel->execute([$sellerId]);
        $updatedSeller = $sel->fetch();
        // Atualiza sessão do vendedor
        if ($updatedSeller) {
            $_SESSION['vendedor']['nome'] = $updatedSeller['nome'];
            $_SESSION['vendedor']['email'] = $updatedSeller['email'];
        }
    }

    // Commit da transação
    $pdo->commit();

    // Atualiza sessão do usuário
    $_SESSION['user']['nome'] = $nome;
    $_SESSION['user']['email'] = $email;

    $response = ['success' => true, 'user' => $_SESSION['user']];
    if ($updatedSeller) $response['vendedor'] = $updatedSeller;

    echo json_encode($response);
} catch (Throwable $e) {
    error_log('update_profile error: ' . $e->getMessage());
    if ($pdo && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    http_response_code(500);
    echo json_encode(['error' => 'Server error']);
}
