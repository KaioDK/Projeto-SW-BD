<?php
/**
 * API de Listagem de Endereços
 * 
 * Endpoint: GET /api/address/get_address.php
 * Descrição: Retorna todos os endereços do usuário logado
 * 
 * Ordenação: DESC por id (mais recentes primeiro)
 * 
 * Uso:
 * - Seleção de endereço no checkout
 * - Gerenciamento de endereços no perfil
 * 
 * Logs: Contém logs de debug para facilitar troubleshooting
 * 
 * Retorna:
 * - { success: true, addresses: [...] }
 */
require_once __DIR__ . '/../../../backend/auth.php';
require_once __DIR__ . '/../../../backend/db.php';
header('Content-Type: application/json; charset=utf-8');
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isLoggedUser()) { 
    http_response_code(401); 
    error_log('get_address: usuário não autenticado');
    echo json_encode(['error'=>'Não autenticado']); 
    exit; 
}

$userId = (int)($_SESSION['user']['id'] ?? 0);
error_log('get_address: userId = ' . $userId);
error_log('get_address: SESSION = ' . print_r($_SESSION, true));

if (!$userId) { 
    http_response_code(400); 
    error_log('get_address: userId inválido');
    echo json_encode(['error'=>'Missing user id']); 
    exit; 
}

try {
    $stmt = $pdo->prepare('SELECT id_endereco, rua, numero, bairro, cidade, estado FROM endereco WHERE id_cliente = ? ORDER BY id_endereco DESC');
    $stmt->execute([$userId]);
    $rows = $stmt->fetchAll();
    error_log('get_address: encontrados ' . count($rows) . ' endereços para userId ' . $userId);
    echo json_encode(['success'=>true,'addresses'=>$rows]);
} catch (Throwable $e) {
    http_response_code(500);
    error_log('get_address error: ' . $e->getMessage());
    echo json_encode(['error'=>'Server error']);
}

?>
