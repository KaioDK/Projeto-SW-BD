<?php
/**
 * API de Criação de Produto
 * 
 * Endpoint: POST /api/products/create_product.php
 * Descrição: Permite que vendedores criem novos produtos no catálogo
 * 
 * Parâmetros POST esperados:
 * - title/nome: Nome do produto
 * - price/valor: Preço do produto
 * - stock/estoque: Quantidade em estoque
 * - description/descricao: Descrição detalhada
 * - size/tamanho: Tamanho do produto
 * - estado: Estado (Novo, Semi-Novo, Usado, Sem caixa)
 * - image/images[]: Imagem(ns) do produto (upload de arquivo)
 * - seller_name, seller_doc: Dados para onboarding de vendedor (se não for vendedor)
 * 
 * Retorna JSON:
 * - Sucesso: { success: true, id_produto: número }
 * - Erro: { error: "mensagem" }
 * 
 * Funcionalidades especiais:
 * - Onboarding automático: usuários podem se tornar vendedores no mesmo request
 * - Upload múltiplo de imagens (armazenadas como CSV)
 * - Normalização de estados (mapeia variantes para valores ENUM)
 * - Handlers de erro que sempre retornam JSON válido
 */

require_once __DIR__ . '/../../../backend/db.php';
require_once __DIR__ . '/../../../backend/auth.php';
header('Content-Type: application/json; charset=utf-8');

/**
 * Handlers de Exceção e Shutdown
 * 
 * Estes handlers garantem que SEMPRE retornamos JSON válido,
 * mesmo em caso de erros fatais ou exceções não capturadas.
 * Isso evita que o frontend receba HTML de erro e quebre o JSON.parse().
 * 
 * PRODUÇÃO: Remova o campo 'details' para não expor informações sensíveis.
 */
set_exception_handler(function($e){
    http_response_code(500);
    $msg = $e instanceof Throwable ? $e->getMessage() : (string)$e;
    echo json_encode(['error' => 'Server exception', 'details' => $msg]);
    exit;
});
register_shutdown_function(function(){
    $err = error_get_last();
    if ($err && in_array($err['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        http_response_code(500);
        $text = isset($err['message']) ? $err['message'] : 'Fatal error';
        echo json_encode(['error' => 'Fatal error', 'details' => $text]);
        exit;
    }
});

/**
 * Logs de Depuração
 * 
 * Registra informações detalhadas sobre a requisição para facilitar debugging:
 * - Método HTTP usado
 * - Todos os dados POST recebidos
 * - Metadados dos arquivos enviados (nome, tipo, erros)
 * 
 * IMPORTANTE: Em produção, evite logar dados sensíveis (senhas, tokens, etc)
 */
error_log('create_product invoked. METHOD=' . ($_SERVER['REQUEST_METHOD'] ?? ''));
try {
    error_log('create_product POST: ' . json_encode($_POST));
    $files_info = [];
    foreach ($_FILES as $k => $f) {
        $files_info[$k] = ['name' => $f['name'] ?? null, 'type' => $f['type'] ?? null, 'error' => $f['error'] ?? null];
    }
    error_log('create_product FILES: ' . json_encode($files_info));
} catch (Throwable $tmp) {
    error_log('create_product debug log failed: ' . $tmp->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

/**
 * Autorização e Onboarding de Vendedor
 * 
 * Apenas vendedores podem criar produtos. Este endpoint implementa
 * onboarding automático para permitir que usuários comuns se tornem vendedores:
 * 
 * Fluxo 1 - Vendedor já cadastrado:
 * - Verifica isLoggedSeller() = true
 * - Usa id_vendedor da sessão
 * 
 * Fluxo 2 - Usuário comum com dados de vendedor:
 * - Recebe seller_name e seller_doc no POST
 * - Verifica se já existe vendedor com mesmo email/CPF (reutiliza)
 * - Se não existe, cria novo registro em tabela vendedor
 * - Atualiza $_SESSION['vendedor'] para dar acesso imediato
 * 
 * Fluxo 3 - Não autorizado:
 * - Nem vendedor nem dados para onboarding
 * - Retorna 403 Forbidden
 */
if (!isLoggedSeller()) {
    // Se o usuário está logado e submeteu dados de vendedor, criar (ou reutilizar) o vendedor
    if (isLoggedUser() && !empty($_POST['seller_name']) && !empty($_POST['seller_doc'])) {
        $name = trim($_POST['seller_name']);
        $cpf = trim($_POST['seller_doc']);
        $email = $_SESSION['user']['email'];
        // Verifica se já existe vendedor com mesmo email ou CPF
        // Isso evita duplicatas e permite reutilizar registros existentes
        // Útil quando usuário já se cadastrou como vendedor anteriormente
        $checkVend = $pdo->prepare('SELECT id_vendedor, nome, email FROM vendedor WHERE email = ? OR CPF = ? LIMIT 1');
        $checkVend->execute([$email, $cpf]);
        $existing = $checkVend->fetch();
        if ($existing) {
            $id_vendedor = $existing['id_vendedor'];
            // Vendedor já existe: reutiliza registro existente
            // Atualiza sessão para dar acesso às funcionalidades de vendedor
            // Isso permite que o produto seja criado na sequência
            $_SESSION['vendedor'] = ['id' => $id_vendedor, 'nome' => $existing['nome'] ?? $name, 'email' => $existing['email'] ?? $email];
        } else {
            // Vendedor não existe: cria novo registro
            // Gera senha aleatória (16 caracteres hexadecimais)
            // O vendedor pode alterá-la depois via change_password
            $pwd = bin2hex(random_bytes(8));
            $hash = password_hash($pwd, PASSWORD_DEFAULT);
            $insertVend = $pdo->prepare('INSERT INTO vendedor (nome, email, senha, CPF) VALUES (?, ?, ?, ?)');
            $insertVend->execute([$name, $email, $hash, $cpf]);
            $id_vendedor = $pdo->lastInsertId();
            // definir sessão do vendedor recém-criado
            $_SESSION['vendedor'] = ['id' => $id_vendedor, 'nome' => $name, 'email' => $email];
        }
    } else {
        http_response_code(403);
        echo json_encode(['error' => 'Only sellers can create products']);
        exit;
    }
} else {
    $id_vendedor = $_SESSION['vendedor']['id'];
}

// Validação dos campos obrigatórios do produto
$nome = trim($_POST['title'] ?? $_POST['nome'] ?? '');
$valor = trim($_POST['price'] ?? $_POST['valor'] ?? '');
$estoque = intval($_POST['stock'] ?? $_POST['estoque'] ?? 0);
$descricao = trim($_POST['description'] ?? $_POST['descricao'] ?? '');
$tamanho = trim($_POST['size'] ?? $_POST['tamanho'] ?? '');
$estado_raw = trim($_POST['estado'] ?? 'Novo');

/**
 * Normalização de Estados do Produto
 * 
 * O campo 'estado' no banco é ENUM com valores fixos:
 * - 'Novo'
 * - 'Semi-Novo'
 * - 'Usado'
 * - 'Sem caixa'
 * 
 * Este código normaliza as variantes que podem vir do frontend:
 * - Remove espaços, hífens, acentos
 * - Converte para minúsculas
 * - Mapeia para os valores ENUM corretos
 * 
 * Exemplos de mapeamento:
 * - "Seminovo" ou "Semi-Novo" -> "Semi-Novo"
 * - "sem caixa" ou "semcaixa" -> "Sem caixa"
 * - "Vintage" -> "Usado" (Vintage não existe no ENUM)
 */
$k = strtolower(preg_replace('/[^a-z0-9]/i', '', $estado_raw));
switch ($k) {
    case 'novo':
        $estado = 'Novo';
        break;
    case 'seminovo':
    case 'semnovo':
        $estado = 'Semi-Novo';
        break;
    case 'semcaixa':
    case 'semcaixas':
        $estado = 'Sem caixa';
        break;
    case 'usado':
        $estado = 'Usado';
        break;
    case 'vintage':
        // Não existe 'Vintage' no ENUM do DB; mapear para 'Usado'
        $estado = 'Usado';
        break;
    default:
        // fallback seguro
        $estado = 'Novo';
}

if (!$nome || $valor === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Missing name or price']);
    exit;
}

try {
    /**
     * Tratamento de Upload de Imagens
     * 
     * Suporta múltiplas imagens por produto:
     * - Campo images[] para uploads múltiplos
     * - Campo image para upload único (retrocompatibilidade)
     * 
     * Tipos de imagem aceitos:
     * - JPEG (.jpg, .jpeg)
     * - PNG (.png)
     * - WebP (.webp) - formato moderno, menor tamanho
     * - AVIF (.avif) - formato mais recente, melhor compressão
     * 
     * Segurança:
     * - Validação de MIME type
     * - Nome de arquivo único (uniqid + timestamp)
     * - Armazenamento em diretório seguro (UPLOAD_DIR)
     * 
     * Armazenamento:
     * - Imagens salvas em assets/uploads/
     * - URLs armazenadas como CSV no campo imagem_url
     * - Primeira imagem usada como thumbnail
     */
    $imagem_url = null;
    $saved_urls = [];
    // Tipos permitidos
    $allowed = ['image/jpeg','image/png','image/webp','image/avif'];

    // Garante UPLOAD_DIR disponível
    if (!defined('UPLOAD_DIR')) {
        require_once __DIR__ . '/../../../backend/config.php';
    }
    if (!is_dir(UPLOAD_DIR)) {
        mkdir(UPLOAD_DIR, 0755, true);
    }

    // Processamento de Múltiplas Imagens (images[])
    // Itera sobre cada arquivo enviado no array
    if (!empty($_FILES['images']) && is_array($_FILES['images']['name'])) {
        $images = $_FILES['images'];
        for ($i = 0; $i < count($images['name']); $i++) {
            $name = $images['name'][$i];      // Nome original do arquivo
            $type = $images['type'][$i] ?? '';  // MIME type
            $tmp = $images['tmp_name'][$i] ?? null;  // Caminho temporário no servidor
            $error = $images['error'][$i] ?? UPLOAD_ERR_NO_FILE;  // Código de erro PHP
            
            // Pula arquivo se houver erro no upload
            if (!$name || $error !== UPLOAD_ERR_OK) continue;
            
            // Valida tipo de arquivo (apenas imagens permitidas)
            if (!in_array($type, $allowed)) continue;
            // Extrai extensão original do arquivo
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            
            // Gera nome único: prod_ + timestamp + hash + extensão
            // Exemplo: prod_674234abc123def.jpg
            $filename = uniqid('prod_', true) . '.' . $ext;
            
            // Monta caminho completo de destino
            $destination = rtrim(UPLOAD_DIR, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $filename;
            
            // Move arquivo do diretório temporário para destino final
            // Se sucesso, adiciona URL relativa ao array
            if (move_uploaded_file($tmp, $destination)) {
                $saved_urls[] = 'assets/uploads/' . $filename;
            }
        }
    }

    /**
     * Fallback: Campo Image Único
     * 
     * Se nenhuma imagem foi enviada via images[], tenta processar
     * upload único via campo 'image'.
     * 
     * Isso mantém compatibilidade com código antigo que usava
     * apenas um upload por vez.
     */
    if (empty($saved_urls) && !empty($_FILES['image']['name'])) {
        $file = $_FILES['image'];
        if ($file['error'] === UPLOAD_ERR_OK && in_array($file['type'], $allowed)) {
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = uniqid('prod_', true) . '.' . $ext;
            $destination = rtrim(UPLOAD_DIR, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $filename;
            if (move_uploaded_file($file['tmp_name'], $destination)) {
                $saved_urls[] = 'assets/uploads/' . $filename;
            }
        }
    }

    /**
     * Construção do Campo imagem_url
     * 
     * O banco armazena múltiplas imagens em um único campo TEXT
     * usando formato CSV (separadas por vírgula).
     * 
     * Exemplo: "assets/uploads/prod_123.jpg,assets/uploads/prod_124.jpg"
     * 
     * Nas APIs de leitura (get_product, get_products), este CSV é
     * convertido em array 'galeria' para facilitar uso no frontend.
     */
    if (!empty($saved_urls)) {
        $imagem_url = implode(',', $saved_urls);
    }

    /**
     * Inserção do Produto no Banco
     * 
     * Campos da tabela produto:
     * - id_produto: PK auto-increment
     * - id_vendedor: FK para tabela vendedor (owner do produto)
     * - nome: Nome/título do produto
     * - descricao: Descrição detalhada
     * - tamanho: Tamanho (ex: 42, M, G, Único)
     * - imagem_url: URLs das imagens (CSV)
     * - valor: Preço em reais (DECIMAL)
     * - estoque: Quantidade disponível (INT)
     * - estado: ENUM (Novo, Semi-Novo, Usado, Sem caixa)
     * - data_cadastro: TIMESTAMP automático
     * 
     * Usa prepared statement para segurança (SQL Injection protection)
     */
    $stmt = $pdo->prepare('INSERT INTO produto (id_vendedor, nome, descricao, tamanho, imagem_url, valor, estoque, estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$id_vendedor, $nome, $descricao, $tamanho ?: null, $imagem_url, $valor, $estoque, $estado]);

    $id = $pdo->lastInsertId();
    echo json_encode(['success' => true, 'id_produto' => $id]);
} catch (Throwable $e) {
    http_response_code(500);
    // Registra erro completo no log para diagnóstico local. Retornamos detalhes
    // no JSON apenas para facilitar a depuração em ambiente de desenvolvimento.
    // Em produção, remova `details` ou supra-os para não vazar informações.
    $msg = $e->getMessage();
    error_log('create_product error: ' . $msg . "\nTrace: " . $e->getTraceAsString());
    echo json_encode(['error' => 'Server error', 'details' => $msg]);
    exit;
}
