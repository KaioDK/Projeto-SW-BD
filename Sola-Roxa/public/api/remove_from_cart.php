<?php
require_once __DIR__ . '/../../backend/auth.php';
header('Content-Type: application/json; charset=utf-8');
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isLoggedUser()) {
    http_response_code(401);
    echo json_encode(['error'=>'Not authenticated']);
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
