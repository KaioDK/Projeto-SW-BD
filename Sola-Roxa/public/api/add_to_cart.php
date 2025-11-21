<?php
require_once __DIR__ . '/../../backend/auth.php';
header('Content-Type: application/json; charset=utf-8');
if (session_status() === PHP_SESSION_NONE) session_start();

// Apenas usuários logados podem usar o carrinho
if (!isLoggedUser()) {
    http_response_code(401);
    echo json_encode(['error' => 'Not authenticated']);
    exit;
}

$id = intval($_POST['id_produto'] ?? 0);
$qty = 1; // each announcement represents a single unit
$size = trim($_POST['tamanho'] ?? $_POST['size'] ?? '');
if ($qty < 1) $qty = 1;
if (!$id) { http_response_code(400); echo json_encode(['error'=>'Missing product id']); exit; }

// Prevent sellers from adding their own products
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
    // If DB check fails, log and continue (do not allow silent bypass)
    error_log('add_to_cart seller check error: ' . $e->getMessage());
}

if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) $_SESSION['cart'] = [];

// combine key by product+size
$key = $id . '::' . $size;
if (isset($_SESSION['cart'][$key])) {
    // keep single unit semantics
    $_SESSION['cart'][$key]['qty'] = 1;
} else {
    $_SESSION['cart'][$key] = ['id_produto' => $id, 'qty' => 1, 'tamanho' => $size];
}

// respond with cart summary
$totalItems = 0;
foreach ($_SESSION['cart'] as $it) $totalItems += $it['qty'];

echo json_encode(['success'=>true,'items_count'=>$totalItems,'cart'=>array_values($_SESSION['cart'])]);

?>
