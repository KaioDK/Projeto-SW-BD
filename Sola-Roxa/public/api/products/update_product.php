<?php
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

// Autorização: somente vendedores autenticados podem atualizar produtos.
// O endpoint também valida que o produto pertence ao vendedor logado.
if (!isLoggedSeller()) {
    http_response_code(403);
    echo json_encode(['error' => 'Only sellers can update products']);
    exit;
}

$id_vendedor = $_SESSION['vendedor']['id'];

try {
    // Verifica propriedade do produto (pertence ao vendedor logado?)
    $check = $pdo->prepare('SELECT id_vendedor FROM produto WHERE id_produto = ? LIMIT 1');
    $check->execute([$id]);
    $p = $check->fetch();
    if (!$p || $p['id_vendedor'] != $id_vendedor) {
        http_response_code(403);
        echo json_encode(['error' => 'Not owner']);
        exit;
    }

    $fields = [];
    $params = [];
    // Nome do produto: aceitar tanto `title` (inglês) quanto `nome` (pt-br)
    if (isset($_POST['title'])) { $fields[] = 'nome = ?'; $params[] = $_POST['title']; }
    if (isset($_POST['nome'])) { $fields[] = 'nome = ?'; $params[] = $_POST['nome']; }
    if (isset($_POST['descricao'])) { $fields[] = 'descricao = ?'; $params[] = $_POST['descricao']; }
    if (isset($_POST['size']) || isset($_POST['tamanho'])) { $fields[] = 'tamanho = ?'; $params[] = $_POST['size'] ?? $_POST['tamanho']; }
    // Preço: aceitar `price` (inglês) ou `valor` (pt-br). Sanitiza formatação com vírgula.
    if (isset($_POST['price']) || isset($_POST['valor'])) {
        $raw = isset($_POST['price']) ? $_POST['price'] : $_POST['valor'];
        // remove símbolos e espaços, substitui ',' por '.' para decimal
        $san = str_replace(['R$', ' ', '\u00A0'], '', $raw);
        $san = str_replace(',', '.', $san);
        $san = preg_replace('/[^0-9.\-]/', '', $san);
        $fields[] = 'valor = ?';
        $params[] = $san;
    }
    if (isset($_POST['stock'])) { $fields[] = 'estoque = ?'; $params[] = intval($_POST['stock']); }
    if (isset($_POST['estado'])) { $fields[] = 'estado = ?'; $params[] = $_POST['estado']; }

    // Tratamento de imagem (opcional): reutiliza a lógica de upload do create_product
    // Observação: não há validação de tipo/tamanho aqui; considerar validar em produção.
    if (!empty($_FILES['image']['name'])) {
        $file = $_FILES['image'];
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid('prod_', true) . '.' . $ext;
        if (!defined('UPLOAD_DIR')) {
            require_once __DIR__ . '/../../../backend/config.php';
        }
        if (!is_dir(UPLOAD_DIR)) {
            mkdir(UPLOAD_DIR, 0755, true);
        }
        $destination = rtrim(UPLOAD_DIR, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $filename;
        move_uploaded_file($file['tmp_name'], $destination);
        $fields[] = 'imagem_url = ?';
        $params[] = 'assets/uploads/' . $filename;
    }

    if (count($fields) === 0) {
        echo json_encode(['success' => true, 'updated' => false]);
        exit;
    }

    $params[] = $id;
    $sql = 'UPDATE produto SET ' . implode(', ', $fields) . ' WHERE id_produto = ?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    echo json_encode(['success' => true, 'updated' => true]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error']);
    error_log('update_product error: ' . $e->getMessage());
    exit;
}
