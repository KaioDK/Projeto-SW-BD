<?php
require_once __DIR__ . '/../../backend/db.php';
header('Content-Type: application/json; charset=utf-8');

// Retorna lista de produtos (opcionalmente filtrada por vendedor)
// Saída JSON: { success: true, products: [...] }

try {
    // Build SQL with optional filters: search, estado (csv), sizes (csv), order
    $sql = 'SELECT p.id_produto, p.id_vendedor, p.nome, p.descricao, p.imagem_url, p.valor, p.estoque, p.data_cadastro, p.estado, p.tamanho, v.nome AS vendedor_nome FROM produto p LEFT JOIN vendedor v ON p.id_vendedor = v.id_vendedor';
    $where = [];
    $params = [];

    if (!empty($_GET['seller'])) {
        $where[] = 'p.id_vendedor = ?';
        $params[] = $_GET['seller'];
    }

    if (!empty($_GET['search'])) {
        $s = '%' . strtolower($_GET['search']) . '%';
        $where[] = '(LOWER(p.nome) LIKE ? OR LOWER(p.descricao) LIKE ? OR LOWER(v.nome) LIKE ?)';
        $params[] = $s; $params[] = $s; $params[] = $s;
    }

    if (!empty($_GET['estado'])) {
        // estado can be comma-separated
        $estArr = array_filter(array_map('trim', explode(',', $_GET['estado'])));
        if (count($estArr) > 0) {
            $place = implode(',', array_fill(0, count($estArr), '?'));
            $where[] = "LOWER(p.estado) IN ($place)";
            foreach ($estArr as $e) $params[] = strtolower($e);
        }
    }

    if (!empty($_GET['sizes'])) {
        $szArr = array_filter(array_map('trim', explode(',', $_GET['sizes'])));
        if (count($szArr) > 0) {
            $place = implode(',', array_fill(0, count($szArr), '?'));
            $where[] = "p.tamanho IN ($place)";
            foreach ($szArr as $s) $params[] = $s;
        }
    }

    if (count($where) > 0) {
        $sql .= ' WHERE ' . implode(' AND ', $where);
    }

    // ordering
    $orderSql = ' ORDER BY p.data_cadastro DESC';
    if (!empty($_GET['order'])) {
        if ($_GET['order'] === 'price-asc') $orderSql = ' ORDER BY p.valor ASC';
        elseif ($_GET['order'] === 'price-desc') $orderSql = ' ORDER BY p.valor DESC';
        elseif ($_GET['order'] === 'recent') $orderSql = ' ORDER BY p.data_cadastro DESC';
    }

    $sql .= $orderSql;

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
