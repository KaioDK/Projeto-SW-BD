<?php
require_once __DIR__ . '/../../backend/auth.php';
require_once __DIR__ . '/../../backend/db.php';
header('Content-Type: application/json; charset=utf-8');
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isLoggedUser()) { http_response_code(401); echo json_encode(['error'=>'Não autenticado']); exit; }

$cart = $_SESSION['cart'] ?? [];
if (empty($cart)) { http_response_code(400); echo json_encode(['error'=>'Cart empty']); exit; }

$userId = (int)($_SESSION['user']['id'] ?? $_SESSION['user']['id_cliente'] ?? 0);
if (!$userId) { http_response_code(400); echo json_encode(['error'=>'Missing user id']); exit; }

// read address selection or fields from POST
$addressId = intval($_POST['address_id'] ?? $_POST['id_endereco'] ?? 0);
$rua = trim($_POST['address'] ?? $_POST['rua'] ?? '');
$cidade = trim($_POST['city'] ?? $_POST['cidade'] ?? '');
$cep = trim($_POST['zip'] ?? $_POST['cep'] ?? '');
$pais = trim($_POST['country'] ?? $_POST['pais'] ?? 'BR');

try {
    $pdo->beginTransaction();
    // Determine which address to use: explicit id, session-chosen, or create new from POST
    $id_endereco = 0;
    if ($addressId > 0) {
        // verify belongs to user
        $stmt = $pdo->prepare('SELECT id_endereco FROM endereco WHERE id_endereco = ? AND id_cliente = ? LIMIT 1');
        $stmt->execute([$addressId, $userId]);
        if ($stmt->fetchColumn()) $id_endereco = $addressId;
        else { $pdo->rollBack(); http_response_code(400); echo json_encode(['error'=>'Address not found']); exit; }
    } elseif (!empty($_SESSION['chosen_address_id'])) {
        $stmt = $pdo->prepare('SELECT id_endereco FROM endereco WHERE id_endereco = ? AND id_cliente = ? LIMIT 1');
        $stmt->execute([intval($_SESSION['chosen_address_id']), $userId]);
        if ($stmt->fetchColumn()) $id_endereco = intval($_SESSION['chosen_address_id']);
    }

    if ($id_endereco === 0) {
        // try to create from provided fields
        if ($rua === '' || $cidade === '' || $pais === '') {
            $pdo->rollBack();
            http_response_code(400);
            echo json_encode(['error'=>'Missing address. Provide address_id or address fields']);
            exit;
        }
        $stmt = $pdo->prepare('INSERT INTO endereco (id_cliente, rua, numero, bairro, cidade, estado) VALUES (?, ?, ?, ?, ?, ?)');
        $numero = intval($_POST['numero'] ?? 0);
        $bairro = trim($_POST['bairro'] ?? '');
        $estado = strtoupper(substr($pais,0,2));
        $stmt->execute([$userId, $rua, $numero, $bairro, $cidade, $estado]);
        $id_endereco = $pdo->lastInsertId();
    }

    // compute total using current product prices
    $total = 0.0;
    $itemsToInsert = [];
    foreach ($cart as $k => $it) {
        $pid = (int)$it['id_produto'];
        $qty = (int)$it['qty'];
        if ($pid <= 0 || $qty <= 0) continue;
        $stmt = $pdo->prepare('SELECT valor, id_vendedor FROM produto WHERE id_produto = ? LIMIT 1');
        $stmt->execute([$pid]);
        $p = $stmt->fetch();
        if (!$p) continue;
        // Prevent buyer (who is also a synced seller) from ordering their own product
        $prodVendedor = $p['id_vendedor'] ?? null;
        if ($prodVendedor && isset($_SESSION['vendedor']['id']) && $_SESSION['vendedor']['id'] == $prodVendedor) {
            $pdo->rollBack();
            http_response_code(403);
            echo json_encode(['error' => 'Você não pode finalizar a compra de um produto seu']);
            exit;
        }
        $price = (float)$p['valor'];
        $subtotal = $price * $qty;
        $total += $subtotal;
        $itemsToInsert[] = ['id_produto'=>$pid,'quantidade'=>$qty,'preco_unitario'=>$price,'subtotal'=>$subtotal];
    }

    $shipping = $total > 3000 ? 0 : 49;
    $valor_total = $total + $shipping;


    // insert pedido (initially pending)
    $stmt = $pdo->prepare('INSERT INTO pedido (id_cliente, id_endereco, valor_total) VALUES (?, ?, ?)');
    $stmt->execute([$userId, $id_endereco, $valor_total]);
    $id_pedido = $pdo->lastInsertId();

    // insert item_pedido rows
    $stmt = $pdo->prepare('INSERT INTO item_pedido (id_pedido, id_produto, quantidade, preco_unitario, subtotal) VALUES (?, ?, ?, ?, ?)');
    foreach ($itemsToInsert as $it) {
        $stmt->execute([$id_pedido, $it['id_produto'], $it['quantidade'], $it['preco_unitario'], $it['subtotal']]);
    }

    // register payment (simulate approval) based on selected method
    $metodo = trim($_POST['payment_method'] ?? $_POST['pay'] ?? $_POST['metodo'] ?? 'credito');
    $status = 'aprovado';
    $stmt = $pdo->prepare('INSERT INTO pagamento (id_pedido, metodo, status, valor_pago) VALUES (?, ?, ?, ?)');
    $stmt->execute([$id_pedido, $metodo, $status, $valor_total]);
    // update pedido status to paid
    $stmt = $pdo->prepare('UPDATE pedido SET status = ? WHERE id_pedido = ?');
    $stmt->execute(['pago', $id_pedido]);

    $pdo->commit();
    // clear cart
    $_SESSION['cart'] = [];
    echo json_encode(['success'=>true,'id_pedido'=>$id_pedido,'valor_total'=>$valor_total,'payment_status'=>$status]);
} catch (Throwable $e) {
    $pdo->rollBack();
    http_response_code(500);
    error_log('checkout error: '.$e->getMessage());
    echo json_encode(['error'=>'Server error','details'=>$e->getMessage()]);
}

?>
