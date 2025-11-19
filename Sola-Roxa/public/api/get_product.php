<?php
require_once __DIR__ . '/../../backend/db.php';
header('Content-Type: application/json; charset=utf-8');

$id = intval($_GET['id'] ?? 0);
if (!$id) {
    http_response_code(400);
    echo json_encode(['error'=>'Missing id']);
    exit;
}
try {
    $stmt = $pdo->prepare('SELECT p.*, v.nome AS vendedor_nome FROM produto p LEFT JOIN vendedor v ON p.id_vendedor = v.id_vendedor WHERE p.id_produto = ? LIMIT 1');
    $stmt->execute([$id]);
    $p = $stmt->fetch();
    if (!$p) {
        http_response_code(404);
        echo json_encode(['error'=>'Not found']);
        exit;
    }
    echo json_encode(['success'=>true,'product'=>$p]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['error'=>'Server error']);
    error_log('get_product error: ' . $e->getMessage());
    exit;
}
