<?php
/**
 * API de Exclusão de Endereço
 * 
 * Endpoint: POST/DELETE /api/address/delete_address.php
 * Descrição: Remove endereço do usuário
 * 
 * Parâmetros (via JSON body):
 * - id_endereco: ID do endereço a excluir
 * 
 * Validações:
 * - Verifica que endereço existe
 * - Verifica que pertence ao usuário logado (segurança)
 * 
 * Efeito colateral:
 * - Se endereço excluído estava escolhido na sessão, limpa escolha
 * 
 * Retorna:
 * - { success: true }
 */
require_once __DIR__ . '/../../../backend/auth.php';
require_once __DIR__ . '/../../../backend/db.php';
header('Content-Type: application/json; charset=UTF-8');
if (session_status() === PHP_SESSION_NONE) session_start();

// Verifica se usuário está logado
if (!isLoggedUser()) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Usuário não autenticado']);
    exit;
}

$id_cliente = (int)($_SESSION['user']['id'] ?? $_SESSION['user']['id_cliente'] ?? 0);
if (!$id_cliente) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'ID do usuário inválido']);
    exit;
}

// Lê JSON do corpo da requisição
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!isset($data['id_endereco']) || !is_numeric($data['id_endereco'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'ID do endereço não fornecido']);
    exit;
}

$id_endereco = intval($data['id_endereco']);

try {
    // Verifica se o endereço pertence ao usuário antes de excluir
    $stmt = $pdo->prepare("SELECT id_cliente FROM endereco WHERE id_endereco = ?");
    $stmt->execute([$id_endereco]);
    $endereco = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$endereco) {
        http_response_code(404);
        echo json_encode(['success' => false, 'error' => 'Endereço não encontrado']);
        exit;
    }
    
    if ($endereco['id_cliente'] != $id_cliente) {
        http_response_code(403);
        echo json_encode(['success' => false, 'error' => 'Você não tem permissão para excluir este endereço']);
        exit;
    }
    
    // Exclui o endereço
    $stmt = $pdo->prepare("DELETE FROM endereco WHERE id_endereco = ?");
    $stmt->execute([$id_endereco]);
    
    // Se o endereço excluído estava selecionado na sessão, remove a seleção
    if (isset($_SESSION['chosen_address_id']) && $_SESSION['chosen_address_id'] == $id_endereco) {
        unset($_SESSION['chosen_address_id']);
    }
    
    echo json_encode(['success' => true]);
    
} catch (PDOException $e) {
    error_log("Erro ao excluir endereço: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Erro ao excluir endereço']);
}
