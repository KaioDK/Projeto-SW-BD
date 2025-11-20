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
    echo json_encode(['error' => 'Not authenticated']);
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

    // Se o email mudou, verificar unicidade
    $stmt = $pdo->prepare('SELECT id_cliente FROM usuario WHERE email = ? AND id_cliente <> ? LIMIT 1');
    $stmt->execute([$email, $id]);
    if ($stmt->fetch()) {
        http_response_code(409);
        echo json_encode(['error' => 'Email já em uso']);
        exit;
    }

    if ($senha) {
        $hash = password_hash($senha, PASSWORD_DEFAULT);
        $update = $pdo->prepare('UPDATE usuario SET nome = ?, email = ?, senha = ? WHERE id_cliente = ?');
        $update->execute([$nome, $email, $hash, $id]);
    } else {
        $update = $pdo->prepare('UPDATE usuario SET nome = ?, email = ? WHERE id_cliente = ?');
        $update->execute([$nome, $email, $id]);
    }

    // Atualiza sessão
    $_SESSION['user']['nome'] = $nome;
    $_SESSION['user']['email'] = $email;

    echo json_encode(['success' => true, 'user' => $_SESSION['user']]);
} catch (Throwable $e) {
    error_log('update_profile error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Server error']);
}
