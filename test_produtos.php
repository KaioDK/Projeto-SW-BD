<?php
require_once __DIR__ . '/Sola-Roxa/backend/db.php';

header('Content-Type: application/json');

try {
    $stmt = $pdo->prepare('SELECT id_produto, nome, valor FROM produto LIMIT 5');
    $stmt->execute();
    $prods = $stmt->fetchAll();
    echo json_encode(['success' => true, 'count' => count($prods), 'products' => $prods]);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
