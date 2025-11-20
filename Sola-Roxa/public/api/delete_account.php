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

    // Deleta o usuário — restrições de FK no DB (endereco, pedido) usarão ON DELETE CASCADE
    $stmt = $pdo->prepare('DELETE FROM usuario WHERE id_cliente = ?');
    $stmt->execute([$id]);

    // Limpa sessão
    unset($_SESSION['user']);
    unset($_SESSION['vendedor']);
    session_destroy();

    echo json_encode(['success' => true]);
} catch (Throwable $e) {
    error_log('delete_account error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Server error']);
}
