<?php
require_once __DIR__ . '/../../backend/auth.php';
require_once __DIR__ . '/../../backend/db.php';
header('Content-Type: application/json; charset=utf-8');
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isLoggedUser()) { http_response_code(401); echo json_encode(['error'=>'Not authenticated']); exit; }

$userId = (int)($_SESSION['user']['id'] ?? $_SESSION['user']['id_cliente'] ?? 0);
if (!$userId) { http_response_code(400); echo json_encode(['error'=>'Missing user id']); exit; }

try {
    $stmt = $pdo->prepare('SELECT id_endereco, rua, numero, bairro, cidade, estado FROM endereco WHERE id_cliente = ? ORDER BY id_endereco DESC');
    $stmt->execute([$userId]);
    $rows = $stmt->fetchAll();
    echo json_encode(['success'=>true,'addresses'=>$rows]);
} catch (Throwable $e) {
    http_response_code(500);
    error_log('get_address error: ' . $e->getMessage());
    echo json_encode(['error'=>'Server error']);
}

?>
