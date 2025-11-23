<?php
/**
 * API de Adição ao Carrinho
 * 
 * Endpoint: POST /api/cart/add_to_cart.php
 * Descrição: Adiciona produto ao carrinho de compras (armazenado em sessão)
 * 
 * Parâmetros POST:
 * - id_produto: ID do produto (obrigatório)
 * - tamanho/size: Tamanho do produto (opcional)
 * 
 * Regras de negócio:
 * - Apenas usuários autenticados podem adicionar ao carrinho
 * - Vendedores NÃO podem adicionar seus próprios produtos
 * - Cada anúncio = 1 unidade (quantidade fixa)
 * - Combina produto + tamanho como chave única
 * 
 * Armazenamento:
 * - Carrinho salvo em $_SESSION['cart']
 * - Formato: array associativo com chave "id::tamanho"
 * 
 * Retorna JSON:
 * - { success: true, items_count: n, cart: [...] }
 */
require_once __DIR__ . '/../../../backend/auth.php';
header('Content-Type: application/json; charset=utf-8');
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isLoggedUser()) {
    http_response_code(401);
    echo json_encode(['error' => 'Não autenticado']);
    exit;
}

$id = intval($_POST['id_produto'] ?? 0);
$qty = 1; // each announcement represents a single unit
$size = trim($_POST['tamanho'] ?? $_POST['size'] ?? '');
if ($qty < 1) $qty = 1;
if (!$id) { http_response_code(400); echo json_encode(['error'=>'Missing product id']); exit; }

/**
 * Proteção: Vendedor Não Pode Comprar Próprio Produto
 * 
 * Verifica se o produto pertence ao vendedor logado.
 * Se sim, retorna erro 403 Forbidden.
 * 
 * Isso evita:
 * - Vendedor "inflar" próprias vendas
 * - Problemas de lógica de negócio
 * - Confusão em relatórios
 */
require_once __DIR__ . '/../../../backend/db.php';
try {
    $stmt = $pdo->prepare('SELECT id_vendedor FROM produto WHERE id_produto = ? LIMIT 1');
    $stmt->execute([$id]);
    $prodVendedor = $stmt->fetchColumn();
    if ($prodVendedor && isset($_SESSION['vendedor']['id']) && $_SESSION['vendedor']['id'] == $prodVendedor) {
        http_response_code(403);
        echo json_encode(['error' => 'Você não pode adicionar seu próprio produto ao carrinho']);
        exit;
    }
} catch (Throwable $e) {
    // If DB check fails, log and continue (do not allow silent bypass)
    error_log('add_to_cart seller check error: ' . $e->getMessage());
}

/**
 * Sistema de Chaves Compostas
 * 
 * Usa combinação produto::tamanho como chave única.
 * Isso permite que mesmo produto em tamanhos diferentes
 * sejam itens separados no carrinho.
 * 
 * Exemplos de chaves:
 * - "123::42" (produto 123, tamanho 42)
 * - "456::" (produto 456, sem tamanho)
 */
if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) $_SESSION['cart'] = [];

// Combina chave por produto + tamanho
$key = $id . '::' . $size;
if (isset($_SESSION['cart'][$key])) {
    // keep single unit semantics
    $_SESSION['cart'][$key]['qty'] = 1;
} else {
    $_SESSION['cart'][$key] = ['id_produto' => $id, 'qty' => 1, 'tamanho' => $size];
}

// respond with cart summary
$totalItems = 0;
foreach ($_SESSION['cart'] as $it) $totalItems += $it['qty'];

echo json_encode(['success'=>true,'items_count'=>$totalItems,'cart'=>array_values($_SESSION['cart'])]);

?>
