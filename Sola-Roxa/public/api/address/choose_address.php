<?php
require_once __DIR__ . '/../../../backend/auth.php';
require_once __DIR__ . '/../../../backend/db.php';
header('Content-Type: application/json; charset=utf-8');
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isLoggedUser()) { 
    http_response_code(401); 
    error_log('choose_address: usuário não autenticado');
    echo json_encode(['error'=>'Não autenticado']); 
    exit; 
}

$userId = (int)($_SESSION['user']['id'] ?? 0);
$id = intval($_POST['id_endereco'] ?? $_POST['address_id'] ?? 0);
error_log('choose_address: userId=' . $userId . ', addressId=' . $id);

if ($id <= 0) { 
    http_response_code(400); 
    error_log('choose_address: addressId inválido');
    echo json_encode(['error'=>'Missing address id']); 
    exit; 
}

try {
    // verify address belongs to user
    $stmt = $pdo->prepare('SELECT id_endereco FROM endereco WHERE id_endereco = ? AND id_cliente = ? LIMIT 1');
    $stmt->execute([$id, $userId]);
    $found = $stmt->fetchColumn();
    if (!$found) { 
        http_response_code(404); 
        error_log('choose_address: endereço não encontrado ou não pertence ao usuário');
        echo json_encode(['error'=>'Address not found']); 
        exit; 
    }
    // store chosen address in session for checkout
    $_SESSION['chosen_address_id'] = $id;
    error_log('choose_address: endereço ' . $id . ' escolhido com sucesso');
    echo json_encode(['success'=>true,'chosen'=>$id]);
} catch (Throwable $e) {
    http_response_code(500);
    error_log('choose_address error: ' . $e->getMessage());
    echo json_encode(['error'=>'Server error']);
}

?>
