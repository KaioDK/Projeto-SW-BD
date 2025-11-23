<?php
/**
 * API de Exclusão de Produto
 * 
 * Endpoint: POST /api/products/delete_product.php
 * Descrição: Permite que vendedores excluam seus próprios produtos
 * 
 * Parâmetros POST:
 * - id: ID do produto a excluir (obrigatório)
 * 
 * Autorização:
 * - Apenas vendedores autenticados
 * - Vendedor deve ser o dono do produto
 * 
 * Efeitos:
 * - Remove registro da tabela produto
 * - Deleta arquivo de imagem associado (evita órfãos)
 * - Remove de favoritos e carrinhos (CASCADE no banco)
 * 
 * Retorna JSON:
 * - { success: true }
 * - Erro 403: { error: "Not owner" }
 */
require_once __DIR__ . '/../../../backend/db.php';
require_once __DIR__ . '/../../../backend/auth.php';
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$id = intval($_POST['id'] ?? 0);
if (!$id) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing product id']);
    exit;
}

if (!isLoggedSeller()) {
    http_response_code(403);
    echo json_encode(['error' => 'Only sellers can delete products']);
    exit;
}

$id_vendedor = $_SESSION['vendedor']['id'];
try {
    $check = $pdo->prepare('SELECT id_vendedor, imagem_url FROM produto WHERE id_produto = ? LIMIT 1');
    $check->execute([$id]);
    $p = $check->fetch();
    if (!$p || $p['id_vendedor'] != $id_vendedor) {
        http_response_code(403);
        echo json_encode(['error' => 'Not owner']);
        exit;
    }
    /**
     * Limpeza de Arquivo Órfão
     * 
     * Quando um produto é excluído, remove também sua imagem do disco
     * para evitar acumular arquivos não utilizados.
     * 
     * Importante: Apenas primeira imagem é removida (limitação atual)
     * TODO: Remover todas as imagens da galeria
     */
    if ($p['imagem_url']) {
        $path = __DIR__ . '/../' . $p['imagem_url'];
        if (file_exists($path)) unlink($path);
    }
    $stmt = $pdo->prepare('DELETE FROM produto WHERE id_produto = ?');
    $stmt->execute([$id]);
    echo json_encode(['success'=>true]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['error'=>'Server error']);
    error_log('delete_product error: ' . $e->getMessage());
    exit;
}
