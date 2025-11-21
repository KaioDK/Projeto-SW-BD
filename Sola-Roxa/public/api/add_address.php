<?php
require_once __DIR__ . '/../../backend/auth.php';
require_once __DIR__ . '/../../backend/db.php';
header('Content-Type: application/json; charset=utf-8');
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isLoggedUser()) { http_response_code(401); echo json_encode(['error'=>'Not authenticated']); exit; }

$userId = (int)($_SESSION['user']['id'] ?? $_SESSION['user']['id_cliente'] ?? 0);
if (!$userId) { http_response_code(400); echo json_encode(['error'=>'Missing user id']); exit; }

$rua = trim($_POST['rua'] ?? $_POST['address'] ?? '');
$numero = intval($_POST['numero'] ?? $_POST['numero_casa'] ?? 0);
$bairro = trim($_POST['bairro'] ?? '');
$cidade = trim($_POST['cidade'] ?? $_POST['city'] ?? '');
$estado = trim($_POST['estado'] ?? $_POST['state'] ?? '');

if ($rua === '' || $cidade === '' || $estado === '') {
    http_response_code(400);
    echo json_encode(['error'=>'Missing address fields']);
    exit;
}

try {
    $stmt = $pdo->prepare('INSERT INTO endereco (id_cliente, rua, numero, bairro, cidade, estado) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([$userId, $rua, $numero, $bairro, $cidade, $estado]);
    $id = $pdo->lastInsertId();
    echo json_encode(['success'=>true,'id_endereco'=>$id]);
} catch (Throwable $e) {
    http_response_code(500);
    error_log('add_address error: ' . $e->getMessage());
    echo json_encode(['error'=>'Server error']);
}

?>
