<?php
require_once __DIR__ . '/../../../backend/auth.php';
require_once __DIR__ . '/../../../backend/db.php';
header('Content-Type: application/json; charset=utf-8');
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isLoggedUser()) { http_response_code(401); echo json_encode(['error'=>'Não autenticado']); exit; }

$userId = (int)($_SESSION['user']['id'] ?? $_SESSION['user']['id_cliente'] ?? 0);
$pedidoId = intval($_POST['id_pedido'] ?? 0);
$metodo = trim($_POST['metodo'] ?? $_POST['pay'] ?? 'pix');
$valor = floatval($_POST['valor'] ?? 0);

if ($pedidoId <= 0 || $valor <= 0) { http_response_code(400); echo json_encode(['error'=>'Missing payment data']); exit; }

try {
    // Verify pedido belongs to user
    $stmt = $pdo->prepare('SELECT id_pedido FROM pedido WHERE id_pedido = ? AND id_cliente = ? LIMIT 1');
    $stmt->execute([$pedidoId, $userId]);
    $p = $stmt->fetchColumn();
    if (!$p) { http_response_code(404); echo json_encode(['error'=>'Order not found']); exit; }

    // Simulate payment approval
    $status = 'aprovado';
    $stmt = $pdo->prepare('INSERT INTO pagamento (id_pedido, metodo, status, valor_pago) VALUES (?, ?, ?, ?)');
    $stmt->execute([$pedidoId, $metodo, $status, $valor]);

    // update pedido status to paid
    $stmt = $pdo->prepare('UPDATE pedido SET status = ? WHERE id_pedido = ?');
    $stmt->execute(['pago', $pedidoId]);

    echo json_encode(['success'=>true,'status'=>$status]);
} catch (Throwable $e) {
    http_response_code(500);
    error_log('register_payment error: ' . $e->getMessage());
    echo json_encode(['error'=>'Server error']);
}

?>
