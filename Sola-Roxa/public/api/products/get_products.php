<?php
/**
 * API de Listagem de Produtos
 * 
 * Endpoint: GET /api/products/get_products.php
 * Descrição: Retorna lista de produtos com filtros e ordenação
 * 
 * Parâmetros GET opcionais:
 * - seller: Filtra produtos de um vendedor específico (id_vendedor)
 * - search: Busca por nome, descrição ou nome do vendedor
 * - estado: Filtra por estado (CSV: "novo,usado")
 * - sizes: Filtra por tamanhos (CSV: "40,41,42")
 * - order: Ordenação (price-asc, price-desc, recent)
 * 
 * Retorna JSON:
 * - { success: true, products: [{...}, {...}] }
 * 
 * Cada produto contém:
 * - Dados básicos (id, nome, valor, estoque, etc)
 * - nome_vendedor: Nome do vendedor (JOIN)
 * - galeria: Array de URLs de imagens
 * - imagem_url: Primeira imagem (thumbnail)
 */
require_once __DIR__ . '/../../../backend/db.php';
header('Content-Type: application/json; charset=utf-8');

try {
    /**
     * Construção Dinâmica da Query SQL
     * 
     * Inicia com SELECT básico + LEFT JOIN com vendedor
     * Adiciona cláusulas WHERE conforme filtros recebidos
     * Usa prepared statements (? placeholders) para segurança
     * 
     * Arrays auxiliares:
     * - $where: Array de condições SQL
     * - $params: Array de valores para bind (evita SQL injection)
     */
    $sql = 'SELECT p.id_produto, p.id_vendedor, p.nome, p.descricao, p.imagem_url, p.valor, p.estoque, p.data_cadastro, p.estado, p.tamanho, v.nome AS vendedor_nome FROM produto p LEFT JOIN vendedor v ON p.id_vendedor = v.id_vendedor';
    $where = [];  // Condições WHERE
    $params = [];  // Parâmetros para prepared statement

    // Filtro 1: Produtos de um vendedor específico
    // Usado na página de perfil do vendedor (Meus Produtos)
    if (!empty($_GET['seller'])) {
        $where[] = 'p.id_vendedor = ?';
        $params[] = $_GET['seller'];
    }

    // Filtro 2: Busca textual (case-insensitive)
    // Procura em: nome do produto, descrição, nome do vendedor
    // Usa LIKE com wildcards (%) para busca parcial
    if (!empty($_GET['search'])) {
        $s = '%' . strtolower($_GET['search']) . '%';  // Adiciona wildcards
        $where[] = '(LOWER(p.nome) LIKE ? OR LOWER(p.descricao) LIKE ? OR LOWER(v.nome) LIKE ?)';
        $params[] = $s; $params[] = $s; $params[] = $s;  // Mesmo valor 3x (um para cada campo)
    }

    // Filtro 3: Estado do produto (aceita múltiplos valores)
    // Exemplo: ?estado=novo,semi-novo
    // Divide CSV em array e usa IN clause
    if (!empty($_GET['estado'])) {
        $estArr = array_filter(array_map('trim', explode(',', $_GET['estado'])));
        if (count($estArr) > 0) {
            $place = implode(',', array_fill(0, count($estArr), '?'));
            $where[] = "LOWER(p.estado) IN ($place)";
            foreach ($estArr as $e) $params[] = strtolower($e);
        }
    }

    // Filtro 4: Tamanhos (aceita múltiplos valores)
    // Exemplo: ?sizes=40,41,42
    // Similar ao filtro de estado, usa IN clause
    if (!empty($_GET['sizes'])) {
        $szArr = array_filter(array_map('trim', explode(',', $_GET['sizes'])));
        if (count($szArr) > 0) {
            $place = implode(',', array_fill(0, count($szArr), '?'));
            $where[] = "p.tamanho IN ($place)";
            foreach ($szArr as $s) $params[] = $s;
        }
    }

    if (count($where) > 0) {
        $sql .= ' WHERE ' . implode(' AND ', $where);
    }

    // Ordenação dos resultados
    // Padrão: mais recentes primeiro (data_cadastro DESC)
    // Opções: price-asc (menor preço), price-desc (maior preço), recent (mais novo)
    $orderSql = ' ORDER BY p.data_cadastro DESC';
    if (!empty($_GET['order'])) {
        if ($_GET['order'] === 'price-asc') $orderSql = ' ORDER BY p.valor ASC';
        elseif ($_GET['order'] === 'price-desc') $orderSql = ' ORDER BY p.valor DESC';
        elseif ($_GET['order'] === 'recent') $orderSql = ' ORDER BY p.data_cadastro DESC';
    }

    $sql .= $orderSql;

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $products = $stmt->fetchAll();
    /**
     * Pós-processamento: Galeria de Imagens
     * 
     * O campo imagem_url armazena múltiplas URLs como CSV.
     * Este loop converte para array 'galeria' e define 'imagem_url'
     * como primeira imagem (usado como thumbnail nas listagens).
     * 
     * Antes: imagem_url = "img1.jpg,img2.jpg,img3.jpg"
     * Depois: 
     * - galeria = ["img1.jpg", "img2.jpg", "img3.jpg"]
     * - imagem_url = "img1.jpg" (primeira imagem)
     */
    foreach ($products as &$prod) {
        if (!empty($prod['imagem_url'])) {
            $parts = array_filter(array_map('trim', explode(',', $prod['imagem_url'])));
            if (!empty($parts)) {
                $prod['galeria'] = array_values($parts);
                // mantém imagem_url como a primeira imagem para compatibilidade com frontend
                $prod['imagem_url'] = $parts[0];
            }
        }
    }
    unset($prod);

    echo json_encode(['success'=>true,'products'=>$products]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['error'=>'Server error']);
    error_log('get_products error: ' . $e->getMessage());
    exit;
}
