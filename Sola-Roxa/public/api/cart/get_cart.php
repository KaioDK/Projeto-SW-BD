<?php
/**
 * API de Consulta do Carrinho
 * 
 * Endpoint: GET /api/cart/get_cart.php
 * Descrição: Retorna conteúdo do carrinho com dados enriquecidos
 * 
 * Autenticação:
 * - Usuário não logado: retorna carrinho vazio (sem erro)
 * - Usuário logado: retorna itens com dados completos
 * 
 * Enriquecimento de dados:
 * - Busca informações atuais do produto (nome, preço, imagem)
 * - Calcula subtotal por item (preço × quantidade)
 * - Calcula totais gerais (subtotal + frete)
 * 
 * Cálculo de frete:
 * - GRATUITO se subtotal > R$ 3000
 * - R$ 49,00 se subtotal <= R$ 3000
 * 
 * Retorna JSON:
 * - { success: true, cart: [...], items_count, subtotal, shipping, total }
 */
require_once __DIR__ . '/../../../backend/auth.php';
require_once __DIR__ . '/../../../backend/db.php';
header('Content-Type: application/json; charset=utf-8');
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isLoggedUser()) {
    http_response_code(200);
    echo json_encode(['success'=>true,'cart'=>[], 'items_count'=>0]);
    exit;
}

$cart = $_SESSION['cart'] ?? [];
$out = [];
$items_count = 0;
/**
 * Loop de Enriquecimento de Dados
 * 
 * Para cada item no carrinho:
 * 1. Busca dados atualizados do produto no banco
 * 2. Normaliza imagem (primeira se for CSV)
 * 3. Calcula subtotal do item
 * 4. Monta objeto com dados completos
 * 
 * Produtos que não existem mais são ignorados (continue)
 */
if (!empty($cart)) {
    // cart stored as keyed array; convert to sequential
    foreach ($cart as $k => $it) {
        $id = intval($it['id_produto']);
        // Cada anúncio é um item único (quantidade fixa = 1)
        $qty = 1;
        $size = $it['tamanho'] ?? '';
        if ($id <= 0) continue;
        // fetch product data
        $stmt = $pdo->prepare('SELECT id_produto, nome, valor, imagem_url FROM produto WHERE id_produto = ? LIMIT 1');
        $stmt->execute([$id]);
        $p = $stmt->fetch();
        if (!$p) continue;
        $price = (float)$p['valor'];
        $subtotal = $price * $qty;
        $items_count += $qty;
        // Normaliza imagem: usa primeira se armazenada como CSV
        // Exemplo: "img1.jpg,img2.jpg" -> "img1.jpg"
        $img = $p['imagem_url'] ?? '';
        if (strpos($img, ',') !== false) {
            $parts = array_filter(array_map('trim', explode(',', $img)));
            if (!empty($parts)) $img = $parts[0];
        }

        $out[] = [
            'id_produto' => $id,
            'nome' => $p['nome'],
            'valor' => $price,
            'imagem_url' => $img,
            'qty' => $qty,
            'tamanho' => $size,
            'subtotal' => $subtotal
        ];
    }
}

/**
 * Cálculo de Totais
 * 
 * Subtotal: Soma de todos os subtotais dos itens
 * Frete: R$ 49 se subtotal <= R$ 3000, senão GRÁTIS
 * Total: Subtotal + Frete
 */
$subtotal = 0.0;
foreach ($out as $i) $subtotal += $i['subtotal'];
$shipping = $subtotal > 3000 ? 0 : 49;
$total = $subtotal + $shipping;

echo json_encode(['success'=>true,'cart'=>$out,'items_count'=>$items_count,'subtotal'=>$subtotal,'shipping'=>$shipping,'total'=>$total]);

?>
