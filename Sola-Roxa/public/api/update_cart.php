<?php
require_once __DIR__ . '/../../backend/auth.php';
header('Content-Type: application/json; charset=utf-8');
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isLoggedUser()) { http_response_code(401); echo json_encode(['error'=>'Não autenticado']); exit; }

$id = intval($_POST['id_produto'] ?? 0);
// Quantidade fixada em 1 (cada anúncio é uma unidade)
$qty = 1;
$size = trim($_POST['tamanho'] ?? $_POST['size'] ?? '');
if ($id <= 0) { http_response_code(400); echo json_encode(['error'=>'Missing product id']); exit; }

if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) $_SESSION['cart'] = [];
// Prevent sellers from adding their own products via this endpoint as well
require_once __DIR__ . '/../../backend/db.php';
try {
    $stmt = $pdo->prepare('SELECT id_vendedor FROM produto WHERE id_produto = ? LIMIT 1');
    $stmt->execute([$id]);
    $prodVendedor = $stmt->fetchColumn();
    if ($prodVendedor && isset($_SESSION['vendedor']['id']) && $_SESSION['vendedor']['id'] == $prodVendedor) {
        http_response_code(403);
        echo json_encode(['error' => 'Você não pode adicionar seu próprio produto ao carrinho']);
        exit;
    }
} catch (Throwable $e) {
    error_log('update_cart seller check error: ' . $e->getMessage());
}
$key = $id . '::' . $size;
// Ensure cart entry exists and qty stays as 1
if (isset($_SESSION['cart'][$key])) {
    $_SESSION['cart'][$key]['qty'] = 1;
} else {
    $_SESSION['cart'][$key] = ['id_produto'=>$id,'qty'=>1,'tamanho'=>$size];
}

$totalItems = 0; foreach ($_SESSION['cart'] as $it) $totalItems += $it['qty'];
echo json_encode(['success'=>true,'items_count'=>$totalItems,'cart'=>array_values($_SESSION['cart'])]);

?>
