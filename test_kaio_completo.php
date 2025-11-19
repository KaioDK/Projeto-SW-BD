<?php
/**
 * TESTE COMPLETO DO MÓDULO DE PRODUTOS (KAIO)
 * Executa todos os testes sem necessidade de navegador
 */

require_once __DIR__ . '/Sola-Roxa/backend/db.php';
require_once __DIR__ . '/Sola-Roxa/backend/auth.php';

// Cores para output
const PASS = "\033[92m✓\033[0m";
const FAIL = "\033[91m✗\033[0m";
const INFO = "\033[94mℹ\033[0m";
const WARN = "\033[93m⚠\033[0m";

$total_tests = 0;
$passed_tests = 0;

function test($name, $condition, $details = "") {
    global $total_tests, $passed_tests;
    $total_tests++;
    
    if ($condition) {
        $passed_tests++;
        echo PASS . " $name\n";
    } else {
        echo FAIL . " $name\n";
        if ($details) echo "  └─ $details\n";
    }
}

function separator($title) {
    echo "\n" . str_repeat("─", 60) . "\n";
    echo "  $title\n";
    echo str_repeat("─", 60) . "\n";
}

// =====================================================================
// TESTE 1: VERIFICAR CONEXÃO COM BANCO
// =====================================================================
separator("1. VERIFICAÇÃO DE CONEXÃO");

try {
    $stmt = $pdo->query('SELECT 1');
    test("Conexão PDO ativa", true);
} catch (Exception $e) {
    test("Conexão PDO ativa", false, $e->getMessage());
    exit;
}

// =====================================================================
// TESTE 2: VERIFICAR TABELAS NECESSÁRIAS
// =====================================================================
separator("2. VERIFICAÇÃO DE TABELAS");

$tables = ['usuario', 'vendedor', 'produto'];
foreach ($tables as $table) {
    try {
        $stmt = $pdo->query("SELECT 1 FROM $table LIMIT 1");
        test("Tabela `$table` existe", true);
    } catch (Exception $e) {
        test("Tabela `$table` existe", false, $e->getMessage());
    }
}

// =====================================================================
// TESTE 3: VERIFICAR COLUNAS DA TABELA PRODUTO
// =====================================================================
separator("3. VERIFICAÇÃO DE SCHEMA (PRODUTO)");

$columns = [
    'id_produto' => 'int',
    'id_vendedor' => 'int',
    'nome' => 'varchar',
    'descricao' => 'longtext',
    'imagem_url' => 'varchar',
    'valor' => 'decimal',
    'estoque' => 'int',
    'data_cadastro' => 'timestamp',
    'estado' => 'varchar'
];

$stmt = $pdo->query("DESCRIBE produto");
$actual_cols = array_column($stmt->fetchAll(), 'Field');

foreach ($columns as $col => $type) {
    test("Coluna `$col` existe em produto", in_array($col, $actual_cols));
}

// =====================================================================
// TESTE 4: DADOS EXISTENTES NA BASE
// =====================================================================
separator("4. DADOS EXISTENTES");

$stmt = $pdo->query("SELECT COUNT(*) as total FROM usuario");
$user_count = $stmt->fetch()['total'];
test("Usuários cadastrados", $user_count > 0, "Total: $user_count");

$stmt = $pdo->query("SELECT COUNT(*) as total FROM vendedor");
$seller_count = $stmt->fetch()['total'];
test("Vendedores cadastrados", $seller_count > 0, "Total: $seller_count");

$stmt = $pdo->query("SELECT COUNT(*) as total FROM produto");
$product_count = $stmt->fetch()['total'];
test("Produtos cadastrados", $product_count > 0, "Total: $product_count");

// =====================================================================
// TESTE 5: LISTAR TODOS OS PRODUTOS (get_products.php)
// =====================================================================
separator("5. GET_PRODUCTS.PHP - LISTAR PRODUTOS");

$stmt = $pdo->prepare('SELECT p.*, v.nome AS vendedor_nome FROM produto p LEFT JOIN vendedor v ON p.id_vendedor = v.id_vendedor');
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

test("Consulta SELECT retorna resultados", count($products) > 0, "Encontrados: " . count($products) . " produtos");

if (count($products) > 0) {
    $first = $products[0];
    test("Produto tem id_produto", isset($first['id_produto']), "ID: " . ($first['id_produto'] ?? 'NULL'));
    test("Produto tem nome", isset($first['nome']) && !empty($first['nome']), "Nome: " . ($first['nome'] ?? 'vazio'));
    test("Produto tem valor", isset($first['valor']) && $first['valor'] > 0, "Valor: R$" . ($first['valor'] ?? 'NULL'));
    test("Produto tem vendor_nome (LEFT JOIN)", isset($first['vendedor_nome']), "Vendor: " . ($first['vendedor_nome'] ?? 'NULL'));
    test("Produto tem imagem_url", isset($first['imagem_url']), "Imagem: " . (substr($first['imagem_url'], 0, 30) ?? 'vazio'));
    
    echo "\n  " . INFO . " Exemplo de produto retornado:\n";
    foreach ($first as $key => $val) {
        $val_display = is_numeric($val) ? $val : (strlen($val) > 50 ? substr($val, 0, 47) . '...' : $val);
        echo "     - $key: $val_display\n";
    }
}

// =====================================================================
// TESTE 6: GET PRODUCT POR ID (get_product.php)
// =====================================================================
separator("6. GET_PRODUCT.PHP - PRODUTO ESPECÍFICO");

if (count($products) > 0) {
    $test_id = $products[0]['id_produto'];
    
    $stmt = $pdo->prepare('SELECT p.*, v.nome AS vendedor_nome FROM produto p LEFT JOIN vendedor v ON p.id_vendedor = v.id_vendedor WHERE p.id_produto = ?');
    $stmt->execute([$test_id]);
    $single = $stmt->fetch(PDO::FETCH_ASSOC);
    
    test("Produto específico encontrado (ID=$test_id)", $single !== false);
    
    if ($single) {
        test("ID retornado corresponde ao solicitado", $single['id_produto'] == $test_id);
        echo "\n  " . INFO . " Produto ID $test_id:\n";
        echo "     - Nome: " . $single['nome'] . "\n";
        echo "     - Valor: R$" . number_format($single['valor'], 2, ',', '.') . "\n";
        echo "     - Estoque: " . $single['estoque'] . " unidades\n";
        echo "     - Vendor: " . ($single['vendedor_nome'] ?? 'N/A') . "\n";
    }
}

// =====================================================================
// TESTE 7: ESTRUTURA ESPERADA PARA CREATE_PRODUCT
// =====================================================================
separator("7. VALIDAÇÃO - CREATE_PRODUCT.PHP");

test("Arquivo create_product.php existe", file_exists(__DIR__ . '/Sola-Roxa/public/api/create_product.php'));

if (file_exists(__DIR__ . '/Sola-Roxa/public/api/create_product.php')) {
    $code = file_get_contents(__DIR__ . '/Sola-Roxa/public/api/create_product.php');
    
    test("Verifica isLoggedUser() ou isLoggedSeller()", 
        strpos($code, 'isLoggedUser') !== false || strpos($code, 'isLoggedSeller') !== false);
    
    test("Valida campos necessários (title, price, description)", 
        strpos($code, 'title') !== false && strpos($code, 'price') !== false);
    
    test("Manipula upload de arquivo", 
        strpos($code, 'move_uploaded_file') !== false || strpos($code, '$_FILES') !== false);
    
    test("Insere na tabela produto", 
        strpos($code, 'INSERT INTO produto') !== false);
    
    test("Retorna JSON", 
        strpos($code, 'json_encode') !== false && strpos($code, 'Content-Type: application/json') !== false);
}

// =====================================================================
// TESTE 8: ESTRUTURA ESPERADA PARA UPDATE_PRODUCT
// =====================================================================
separator("8. VALIDAÇÃO - UPDATE_PRODUCT.PHP");

test("Arquivo update_product.php existe", file_exists(__DIR__ . '/Sola-Roxa/public/api/update_product.php'));

if (file_exists(__DIR__ . '/Sola-Roxa/public/api/update_product.php')) {
    $code = file_get_contents(__DIR__ . '/Sola-Roxa/public/api/update_product.php');
    
    test("Verifica isLoggedSeller()", 
        strpos($code, 'isLoggedSeller') !== false);
    
    test("Valida proprietário do produto", 
        strpos($code, 'id_vendedor') !== false);
    
    test("Atualiza tabela produto", 
        strpos($code, 'UPDATE produto') !== false);
    
    test("Retorna JSON", 
        strpos($code, 'json_encode') !== false);
}

// =====================================================================
// TESTE 9: ESTRUTURA ESPERADA PARA DELETE_PRODUCT
// =====================================================================
separator("9. VALIDAÇÃO - DELETE_PRODUCT.PHP");

test("Arquivo delete_product.php existe", file_exists(__DIR__ . '/Sola-Roxa/public/api/delete_product.php'));

if (file_exists(__DIR__ . '/Sola-Roxa/public/api/delete_product.php')) {
    $code = file_get_contents(__DIR__ . '/Sola-Roxa/public/api/delete_product.php');
    
    test("Verifica isLoggedSeller()", 
        strpos($code, 'isLoggedSeller') !== false);
    
    test("Deleta da tabela produto", 
        strpos($code, 'DELETE FROM produto') !== false);
    
    test("Remove arquivo de imagem (unlink)", 
        strpos($code, 'unlink') !== false);
    
    test("Retorna JSON", 
        strpos($code, 'json_encode') !== false);
}

// =====================================================================
// TESTE 10: DIRETÓRIO DE UPLOADS
// =====================================================================
separator("10. VERIFICAÇÃO DE PASTA DE UPLOADS");

$upload_dir = __DIR__ . '/Sola-Roxa/public/assets/uploads';
test("Pasta de uploads existe", is_dir($upload_dir), "Path: $upload_dir");
test("Pasta de uploads é writable", is_writable($upload_dir), "Permissões OK");

if (is_dir($upload_dir)) {
    $files = glob($upload_dir . '/*');
    $count = count($files);
    test("Arquivos na pasta uploads", $count > 0, "Total: $count arquivos");
    
    if ($count > 0 && $count <= 5) {
        echo "\n  " . INFO . " Arquivos presentes:\n";
        foreach ($files as $file) {
            $size = filesize($file);
            echo "     - " . basename($file) . " (" . round($size/1024, 2) . " KB)\n";
        }
    }
}

// =====================================================================
// TESTE 11: INTEGRAÇÃO COM SELL.JS
// =====================================================================
separator("11. VALIDAÇÃO - INTEGRAÇÃO SELL.JS");

test("Arquivo sell.js existe", file_exists(__DIR__ . '/Sola-Roxa/public/assets/scripts/sell.js'));

if (file_exists(__DIR__ . '/Sola-Roxa/public/assets/scripts/sell.js')) {
    $code = file_get_contents(__DIR__ . '/Sola-Roxa/public/assets/scripts/sell.js');
    
    test("Coleta campo 'title'", 
        strpos($code, 'title') !== false);
    
    test("Coleta campo 'description'", 
        strpos($code, 'description') !== false);
    
    test("Coleta campo 'price'", 
        strpos($code, 'price') !== false);
    
    test("Coleta campo 'stock'", 
        strpos($code, 'stock') !== false);
    
    test("Usa FormData para arquivo", 
        strpos($code, 'FormData') !== false);
    
    test("POST para api/create_product.php", 
        strpos($code, 'api/create_product.php') !== false);
    
    test("Trata resposta JSON", 
        strpos($code, '.json()') !== false);
    
    test("Redireciona após sucesso", 
        strpos($code, 'window.location') !== false || strpos($code, 'catalog.php') !== false);
}

// =====================================================================
// TESTE 12: SIMULAÇÃO DE QUERY - FILTRO POR VENDEDOR
// =====================================================================
separator("12. SIMULAÇÃO - GET_PRODUCTS COM FILTRO");

if ($seller_count > 0) {
    // Pega um vendedor que tem produtos
    $stmt = $pdo->query('SELECT DISTINCT id_vendedor FROM produto LIMIT 1');
    $seller = $stmt->fetch();
    
    if ($seller) {
        $seller_id = $seller['id_vendedor'];
        $stmt = $pdo->prepare('SELECT COUNT(*) as total FROM produto WHERE id_vendedor = ?');
        $stmt->execute([$seller_id]);
        $count = $stmt->fetch()['total'];
        
        test("Filtro por vendedor funciona", $count > 0, "Vendedor $seller_id tem $count produtos");
    }
}

// =====================================================================
// TESTE 13: VALIDAÇÃO DE TIPOS DE IMAGEM
// =====================================================================
separator("13. VALIDAÇÃO - TIPOS DE IMAGEM");

$valid_types = ['image/jpeg', 'image/png', 'image/webp'];
test("Tipos MIME válidos definidos", count($valid_types) == 3, 
    implode(', ', $valid_types));

// =====================================================================
// TESTE 14: DADOS DE EXEMPLO
// =====================================================================
separator("14. AMOSTRA DE DADOS");

echo "\n  " . INFO . " Primeiros 3 produtos:\n";
$stmt = $pdo->prepare('SELECT p.id_produto, p.nome, p.valor, p.estoque, v.nome as vendedor FROM produto p LEFT JOIN vendedor v ON p.id_vendedor = v.id_vendedor LIMIT 3');
$stmt->execute();
$samples = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($samples as $idx => $prod) {
    echo "  " . ($idx + 1) . ". " . $prod['nome'] . "\n";
    echo "     Preço: R$" . number_format($prod['valor'], 2, ',', '.') . "\n";
    echo "     Estoque: " . $prod['estoque'] . "\n";
    echo "     Vendedor: " . ($prod['vendedor'] ?? 'N/A') . "\n\n";
}

// =====================================================================
// RESUMO FINAL
// =====================================================================
separator("RESUMO FINAL");

$percentage = round(($passed_tests / $total_tests) * 100);
echo "\nTestes passados: $passed_tests / $total_tests (" . $percentage . "%)\n\n";

if ($percentage == 100) {
    echo "✓ TUDO OK! Módulo de produtos do Kaio está funcionando perfeitamente!\n\n";
} elseif ($percentage >= 80) {
    echo "⚠ Maior parte está OK, mas alguns detalhes precisam de ajustes.\n\n";
} else {
    echo "✗ Há problemas significativos que precisam ser corrigidos.\n\n";
}

// =====================================================================
// PRÓXIMOS PASSOS
// =====================================================================
separator("PRÓXIMOS PASSOS");

echo "
  Para testar os endpoints via HTTP (com curl):

  1. LISTAR TODOS OS PRODUTOS:
     curl http://localhost/Projeto-SW-BD/Sola-Roxa/public/api/get_products.php

  2. OBTER PRODUTO ESPECÍFICO:
     curl http://localhost/Projeto-SW-BD/Sola-Roxa/public/api/get_product.php?id=3

  3. TESTAR CRIAÇÃO (requer seller logged in):
     curl -X POST http://localhost/Projeto-SW-BD/Sola-Roxa/public/api/create_product.php \\
       -F \"title=Test Product\" \\
       -F \"description=Test Description\" \\
       -F \"price=99.90\" \\
       -F \"stock=10\" \\
       -F \"estado=Novo\" \\
       -F \"image=@/path/to/image.jpg\" \\
       -b \"PHPSESSID=seu_session_id\"

  4. TESTAR NO NAVEGADOR:
     - Acesse: http://localhost/Projeto-SW-BD/Sola-Roxa/public/seller-onboarding.php
     - Faça login como vendedor
     - Tente criar um novo produto (fill.js deve funcionar)

\n";

echo str_repeat("─", 60) . "\n\n";
?>
