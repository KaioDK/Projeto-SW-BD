<?php
require_once __DIR__ . '/../../backend/db.php';
header('Content-Type: application/json; charset=utf-8');

try {
    $sql = 'SELECT p.id_produto, p.id_vendedor, p.nome, p.descricao, p.imagem_url, p.valor, p.estoque, p.data_cadastro, p.estado, v.nome AS vendedor_nome FROM produto p LEFT JOIN vendedor v ON p.id_vendedor = v.id_vendedor';
    $params = [];
    if (isset($_GET['seller'])) {
        $sql .= ' WHERE p.id_vendedor = ?';
        $params[] = $_GET['seller'];
    }
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $products = $stmt->fetchAll();
    echo json_encode(['success'=>true,'products'=>$products]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['error'=>'Server error']);
    error_log('get_products error: ' . $e->getMessage());
    exit;
}
