<?php
require_once __DIR__ . '/../../../backend/db.php';
header('Content-Type: application/json; charset=utf-8');

// Retorna os dados de um produto por `id` via GET
// Saída JSON: { success: true, product: { ... } } ou erro (400/404/500)

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
    // Expor `galeria` como array quando `imagem_url` armazenar múltiplos
    if (!empty($p['imagem_url'])) {
        // Separe por vírgula e remova espaços em branco
        $parts = array_filter(array_map('trim', explode(',', $p['imagem_url'])));
        if (!empty($parts)) {
            $p['galeria'] = array_values($parts);
            // Define imagem_url como a primeira imagem para evitar que a tag <img>
            // receba uma string CSV (causando imagem quebrada)
            $p['imagem_url'] = $parts[0];
        }
    }
    echo json_encode(['success'=>true,'product'=>$p]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['error'=>'Server error']);
    error_log('get_product error: ' . $e->getMessage());
    exit;
}
