<?php
require_once __DIR__ . '/../../backend/db.php';
require_once __DIR__ . '/../../backend/auth.php';
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

try {
    // If a seller is logged, they are deleting their seller account
    if (isLoggedSeller()) {
        $seller = $_SESSION['vendedor'];
        $id_vendedor = (int) $seller['id'];

        // Check for existing products
        $check = $pdo->prepare('SELECT COUNT(*) FROM produto WHERE id_vendedor = ?');
        $check->execute([$id_vendedor]);
        $count = (int) $check->fetchColumn();
        if ($count > 0) {
            http_response_code(400);
            echo json_encode(['error' => 'Não é possível excluir a conta de vendedor enquanto existirem anúncios ativos. Remova seus anúncios primeiro.']);
            exit;
        }

        // Safe to delete vendedor
        $del = $pdo->prepare('DELETE FROM vendedor WHERE id_vendedor = ?');
        $del->execute([$id_vendedor]);

        unset($_SESSION['vendedor']);
        echo json_encode(['success' => true, 'deleted' => 'vendedor']);
        exit;
    }

    // If a regular user is logged, delete the user account
    if (isLoggedUser()) {
        $user = $_SESSION['user'];
        $id = (int) $user['id'];

        // Delete usuario (FKs in DB are expected to cascade where applicable)
        $stmt = $pdo->prepare('DELETE FROM usuario WHERE id_cliente = ?');
        $stmt->execute([$id]);

        unset($_SESSION['user']);
        unset($_SESSION['vendedor']);
        session_destroy();

        echo json_encode(['success' => true, 'deleted' => 'usuario']);
        exit;
    }

    http_response_code(401);
    echo json_encode(['error' => 'Não autenticado']);
    exit;
} catch (Throwable $e) {
    error_log('delete_account error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Server error']);
}
