<?php
/**
 * API de Remoção do Carrinho
 * 
 * Endpoint: POST /api/cart/remove_from_cart.php
 * Descrição: Remove item específico do carrinho
 * 
 * Parâmetros POST:
 * - id_produto: ID do produto a remover
 * - tamanho/size: Tamanho do produto
 * 
 * Comportamento:
 * - Usa chave composta (id::tamanho) para identificar item
 * - Remove usando unset() do array de sessão
 * - Se item não existe, não gera erro (idempotente)
 * 
 * Retorna:
 * - { success: true, items_count, cart }
 */
require_once __DIR__ . '/../../../backend/auth.php';
header('Content-Type: application/json; charset=utf-8');
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isLoggedUser()) {
    http_response_code(401);
    echo json_encode(['error'=>'Não autenticado']);
    exit;
}

$id = intval($_POST['id_produto'] ?? 0);
$size = trim($_POST['tamanho'] ?? $_POST['size'] ?? '');
if (!$id) { http_response_code(400); echo json_encode(['error'=>'Missing product id']); exit; }

if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) $_SESSION['cart'] = [];
$key = $id . '::' . $size;
if (isset($_SESSION['cart'][$key])) {
    unset($_SESSION['cart'][$key]);
}

$totalItems = 0;
foreach ($_SESSION['cart'] as $it) $totalItems += $it['qty'];
echo json_encode(['success'=>true,'items_count'=>$totalItems,'cart'=>array_values($_SESSION['cart'])]);

?>
