<?php
/**
 * API de Verificação de Favorito
 * 
 * Endpoint: GET /api/favorites/check_favorite.php?id_produto=123
 * Descrição: Verifica se produto está nos favoritos do usuário
 * 
 * Parâmetros GET:
 * - id_produto: ID do produto
 * 
 * Uso:
 * - Determinar estado inicial do botão de favorito
 * - UI exibe coração preenchido/vazio conforme resultado
 * 
 * Retorna:
 * - { success: true, favorited: true/false }
 */
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

$productId = (int)($_GET['id_produto'] ?? 0);
if (!$productId) {
    http_response_code(400);
    echo json_encode(['error' => 'ID de produto inválido']);
    exit;
}

try {
    $stmt = $pdo->prepare('SELECT id_favorito FROM favoritos WHERE id_cliente = ? AND id_produto = ?');
    $stmt->execute([$userId, $productId]);
    $favorited = (bool)$stmt->fetch();
    
    echo json_encode(['success' => true, 'favorited' => $favorited]);
} catch (Throwable $e) {
    http_response_code(500);
    error_log('check_favorite error: ' . $e->getMessage());
    echo json_encode(['error' => 'Erro ao verificar favorito']);
}
?>
