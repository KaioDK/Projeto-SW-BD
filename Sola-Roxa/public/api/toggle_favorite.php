<?php
require_once __DIR__ . '/../../backend/auth.php';
require_once __DIR__ . '/../../backend/db.php';
header('Content-Type: application/json; charset=utf-8');
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isLoggedUser()) {
    http_response_code(401);
    echo json_encode(['error' => 'Não autenticado']);
    exit;
}

$userId = (int)($_SESSION['user']['id'] ?? 0);
if (!$userId) {
    http_response_code(400);
    echo json_encode(['error' => 'ID de usuário inválido']);
    exit;
}

$productId = (int)($_POST['id_produto'] ?? 0);
if (!$productId) {
    http_response_code(400);
    echo json_encode(['error' => 'ID de produto inválido']);
    exit;
}

try {
    // Verifica se o produto existe
    $stmt = $pdo->prepare('SELECT id_produto FROM produto WHERE id_produto = ?');
    $stmt->execute([$productId]);
    if (!$stmt->fetch()) {
        http_response_code(404);
        echo json_encode(['error' => 'Produto não encontrado']);
        exit;
    }

    // Verifica se já está nos favoritos
    $stmt = $pdo->prepare('SELECT id_favorito FROM favoritos WHERE id_cliente = ? AND id_produto = ?');
    $stmt->execute([$userId, $productId]);
    
    if ($stmt->fetch()) {
        // Já está nos favoritos, remove
        $stmt = $pdo->prepare('DELETE FROM favoritos WHERE id_cliente = ? AND id_produto = ?');
        $stmt->execute([$userId, $productId]);
        echo json_encode(['success' => true, 'action' => 'removed', 'favorited' => false]);
    } else {
        // Não está nos favoritos, adiciona
        $stmt = $pdo->prepare('INSERT INTO favoritos (id_cliente, id_produto) VALUES (?, ?)');
        $stmt->execute([$userId, $productId]);
        echo json_encode(['success' => true, 'action' => 'added', 'favorited' => true]);
    }
} catch (Throwable $e) {
    http_response_code(500);
    error_log('toggle_favorite error: ' . $e->getMessage());
    echo json_encode(['error' => 'Erro ao processar favorito']);
}
?>
