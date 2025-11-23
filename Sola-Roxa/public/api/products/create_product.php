<?php
require_once __DIR__ . '/../../../backend/db.php';
require_once __DIR__ . '/../../../backend/auth.php';
header('Content-Type: application/json; charset=utf-8');

// Handlers de exceção / shutdown
// - Durante o desenvolvimento, garantimos que qualquer exceção fatal ou erro
//   seja devolvido como JSON para que o frontend (que faz JSON.parse) não
//   quebre. Em produção, considere suprimir detalhes sensíveis.
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

// Logs de depuração: registra método, POST e metadados de FILES. Útil para
// diagnosticar problemas de upload e payloads inválidos durante o desenvolvimento.
// Atenção: evite logar dados sensíveis em produção.
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

// Autorização: Apenas vendedores podem criar produtos. Se um usuário comum
// (cliente) estiver autenticado e submeter os campos de seller-onboarding,
// o fluxo tentará criar (ou reutilizar) um registro de `vendedor` e atualizar
// `$_SESSION['vendedor']` para permitir a criação do produto em sequência.
if (!isLoggedSeller()) {
    // Se o usuário está logado e submeteu dados de vendedor, criar (ou reutilizar) o vendedor
    if (isLoggedUser() && !empty($_POST['seller_name']) && !empty($_POST['seller_doc'])) {
        $name = trim($_POST['seller_name']);
        $cpf = trim($_POST['seller_doc']);
        $email = $_SESSION['user']['email'];
        // se já existir um vendedor com o mesmo email ou CPF, reutilizar em vez de inserir duplicado
        $checkVend = $pdo->prepare('SELECT id_vendedor, nome, email FROM vendedor WHERE email = ? OR CPF = ? LIMIT 1');
        $checkVend->execute([$email, $cpf]);
        $existing = $checkVend->fetch();
        if ($existing) {
            $id_vendedor = $existing['id_vendedor'];
            // Reutiliza registro existente e atualiza sessão para manter estado
            $_SESSION['vendedor'] = ['id' => $id_vendedor, 'nome' => $existing['nome'] ?? $name, 'email' => $existing['email'] ?? $email];
        } else {
            // Cria novo registro de vendedor (senha gerada aleatoriamente)
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

// Normaliza variantes de estado vindas do frontend para os valores
// canônicos esperados pela coluna ENUM (`Novo`,`Semi-Novo`,`Usado`,`Sem caixa`).
// Exemplos de entrada: "Seminovo", "Semi-Novo", "sem caixa", "Vintage".
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
    // Tratamento das imagens do produto (opcional, suporta múltiplas imagens)
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

    // Caso múltiplos arquivos enviados como `images[]`
    if (!empty($_FILES['images']) && is_array($_FILES['images']['name'])) {
        $images = $_FILES['images'];
        for ($i = 0; $i < count($images['name']); $i++) {
            $name = $images['name'][$i];
            $type = $images['type'][$i] ?? '';
            $tmp = $images['tmp_name'][$i] ?? null;
            $error = $images['error'][$i] ?? UPLOAD_ERR_NO_FILE;
            if (!$name || $error !== UPLOAD_ERR_OK) continue;
            if (!in_array($type, $allowed)) continue;
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            $filename = uniqid('prod_', true) . '.' . $ext;
            $destination = rtrim(UPLOAD_DIR, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $filename;
            if (move_uploaded_file($tmp, $destination)) {
                $saved_urls[] = 'assets/uploads/' . $filename;
            }
        }
    }

    // Fallback para campo único `image` (compatibilidade retroativa)
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

    // Constrói `imagem_url` como CSV das imagens (para compatibilidade com DB atual)
    if (!empty($saved_urls)) {
        $imagem_url = implode(',', $saved_urls);
    }

    // Realiza a inserção do produto no banco. Campos aceitos:
    // - id_vendedor: FK para vendedor
    // - nome, descricao, tamanho, imagem_url, valor, estoque, estado
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
