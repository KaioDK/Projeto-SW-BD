<?php
require_once __DIR__ . '/../../../backend/auth.php';
require_once __DIR__ . '/../../../backend/db.php';
header('Content-Type: application/json; charset=utf-8');
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isLoggedUser()) { 
    http_response_code(401); 
    error_log('add_address: usuário não autenticado');
    echo json_encode(['error'=>'Não autenticado']); 
    exit; 
}

$userId = (int)($_SESSION['user']['id'] ?? 0);
error_log('add_address: userId = ' . $userId);

if (!$userId) { 
    http_response_code(400); 
    error_log('add_address: userId inválido');
    echo json_encode(['error'=>'Missing user id']); 
    exit; 
}

$rua = trim($_POST['rua'] ?? $_POST['address'] ?? '');
$numero = intval($_POST['numero'] ?? $_POST['numero_casa'] ?? 0);
$bairro = trim($_POST['bairro'] ?? '');
$cidade = trim($_POST['cidade'] ?? $_POST['city'] ?? '');
$estado = trim($_POST['estado'] ?? $_POST['state'] ?? '');

error_log('add_address: rua=' . $rua . ', numero=' . $numero . ', cidade=' . $cidade . ', estado=' . $estado);

if ($rua === '' || $cidade === '' || $estado === '') {
    http_response_code(400);
    error_log('add_address: campos obrigatórios faltando');
    echo json_encode(['error'=>'Missing address fields']);
    exit;
}

try {
    $stmt = $pdo->prepare('INSERT INTO endereco (id_cliente, rua, numero, bairro, cidade, estado) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([$userId, $rua, $numero, $bairro, $cidade, $estado]);
    $id = $pdo->lastInsertId();
    error_log('add_address: endereço criado com id=' . $id);
    echo json_encode(['success'=>true,'id_endereco'=>$id]);
} catch (Throwable $e) {
    http_response_code(500);
    error_log('add_address error: ' . $e->getMessage());
    echo json_encode(['error'=>'Server error: ' . $e->getMessage()]);
}

?>
