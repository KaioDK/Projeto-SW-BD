<?php
require_once __DIR__ . '/../../../backend/auth.php';
require_once __DIR__ . '/../../../backend/db.php';
header('Content-Type: application/json; charset=utf-8');
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isLoggedUser()) {
    http_response_code(401);
    echo json_encode(['error' => 'Não autenticado']);
    exit;
}

$userId = (int)($_SESSION['user']['id'] ?? 0);
if (!$userId) {
    http_response_code(400);
    echo json_encode(['error' => 'ID de usuário inválido']);
    exit;
}

try {
    $stmt = $pdo->prepare('
        SELECT p.*, v.nome as nome_loja, 
               (SELECT COUNT(*) FROM favoritos WHERE id_produto = p.id_produto AND id_cliente = ?) as is_favorited
        FROM favoritos f
        INNER JOIN produto p ON f.id_produto = p.id_produto
        INNER JOIN vendedor v ON p.id_vendedor = v.id_vendedor
        WHERE f.id_cliente = ?
        ORDER BY f.data_adicionado DESC
    ');
    $stmt->execute([$userId, $userId]);
    $favoritos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode(['success' => true, 'favoritos' => $favoritos]);
} catch (Throwable $e) {
    http_response_code(500);
    error_log('get_favorites error: ' . $e->getMessage());
    echo json_encode(['error' => 'Erro ao buscar favoritos']);
}
?>
