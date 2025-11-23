<?php
/**
 * API de Mudança de Senha
 * 
 * Endpoint: POST /api/user/change_password.php
 * Descrição: Permite usuário alterar sua própria senha
 * 
 * Parâmetros POST:
 * - current_password: Senha atual (obrigatório)
 * - new_password: Nova senha (obrigatório)
 * - new_password_confirm: Confirmação (obrigatório)
 * 
 * Validações:
 * - Senha atual correta (password_verify)
 * - Nova senha == confirmação
 * - Nova senha >= 6 caracteres
 * 
 * Segurança:
 * - Nova senha hasheada com password_hash
 * - Não permite mudança sem verificar senha atual
 * 
 * Retorna:
 * - { success: true }
 */
require_once __DIR__ . '/../../../backend/db.php';
require_once __DIR__ . '/../../../backend/auth.php';
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

    $current = $_POST['current_password'] ?? '';
    $new = $_POST['new_password'] ?? '';
    $confirm = $_POST['new_password_confirm'] ?? '';

    if ($new === '' || $current === '' || $confirm === '') {
        http_response_code(400);
        echo json_encode(['error' => 'Todos os campos são obrigatórios']);
        exit;
    }

    if ($new !== $confirm) {
        http_response_code(400);
        echo json_encode(['error' => 'A nova senha e a confirmação não coincidem']);
        exit;
    }

    if (strlen($new) < 6) {
        http_response_code(400);
        echo json_encode(['error' => 'A senha deve ter pelo menos 6 caracteres']);
        exit;
    }

    // buscar hash atual
    $stmt = $pdo->prepare('SELECT senha FROM usuario WHERE id_cliente = ? LIMIT 1');
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$row) {
        http_response_code(404);
        echo json_encode(['error' => 'Usuário não encontrado']);
        exit;
    }

    $hash = $row['senha'];
    if (!password_verify($current, $hash)) {
        http_response_code(403);
        echo json_encode(['error' => 'Senha atual incorreta']);
        exit;
    }

    $newHash = password_hash($new, PASSWORD_DEFAULT);
    $update = $pdo->prepare('UPDATE usuario SET senha = ? WHERE id_cliente = ?');
    $update->execute([$newHash, $id]);

    echo json_encode(['success' => true]);
} catch (Throwable $e) {
    error_log('change_password error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Server error']);
}
