<?php
require_once __DIR__ . '/../../../backend/auth.php';
require_once __DIR__ . '/../../../backend/db.php';
header('Content-Type: application/json; charset=utf-8');
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isLoggedUser()) {
    http_response_code(200);
    echo json_encode(['success'=>true,'cart'=>[], 'items_count'=>0]);
    exit;
}

$cart = $_SESSION['cart'] ?? [];
$out = [];
$items_count = 0;
if (!empty($cart)) {
    // cart stored as keyed array; convert to sequential
    foreach ($cart as $k => $it) {
        $id = intval($it['id_produto']);
        // Cada anúncio é um item único (quantidade fixa = 1)
        $qty = 1;
        $size = $it['tamanho'] ?? '';
        if ($id <= 0) continue;
        // fetch product data
        $stmt = $pdo->prepare('SELECT id_produto, nome, valor, imagem_url FROM produto WHERE id_produto = ? LIMIT 1');
        $stmt->execute([$id]);
        $p = $stmt->fetch();
        if (!$p) continue;
        $price = (float)$p['valor'];
        $subtotal = $price * $qty;
        $items_count += $qty;
        // normalize image (use first when stored as CSV)
        $img = $p['imagem_url'] ?? '';
        if (strpos($img, ',') !== false) {
            $parts = array_filter(array_map('trim', explode(',', $img)));
            if (!empty($parts)) $img = $parts[0];
        }

        $out[] = [
            'id_produto' => $id,
            'nome' => $p['nome'],
            'valor' => $price,
            'imagem_url' => $img,
            'qty' => $qty,
            'tamanho' => $size,
            'subtotal' => $subtotal
        ];
    }
}

// compute totals
$subtotal = 0.0;
foreach ($out as $i) $subtotal += $i['subtotal'];
$shipping = $subtotal > 3000 ? 0 : 49;
$total = $subtotal + $shipping;

echo json_encode(['success'=>true,'cart'=>$out,'items_count'=>$items_count,'subtotal'=>$subtotal,'shipping'=>$shipping,'total'=>$total]);

?>
