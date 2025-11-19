<?php
require_once __DIR__ . '/../../backend/db.php';
require_once __DIR__ . '/../../backend/auth.php';
header('Content-Type: application/json; charset=utf-8');

// Debugging: log invocation, POST and FILES to Apache/PHP error log
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

// Must be seller — allow logged users to convert to seller if they supply seller info
if (!isLoggedSeller()) {
    // if user is logged and submitted seller onboarding info, create vendor
    if (isLoggedUser() && !empty($_POST['seller_name']) && !empty($_POST['seller_doc'])) {
        $name = trim($_POST['seller_name']);
        $cpf = trim($_POST['seller_doc']);
        $email = $_SESSION['user']['email'];
        // create vendor record
        $pwd = bin2hex(random_bytes(8));
        $hash = password_hash($pwd, PASSWORD_DEFAULT);
        $insertVend = $pdo->prepare('INSERT INTO vendedor (nome, email, senha, CPF) VALUES (?, ?, ?, ?)');
        $insertVend->execute([$name, $email, $hash, $cpf]);
        $id_vendedor = $pdo->lastInsertId();
        // set session vendedor
        $_SESSION['vendedor'] = ['id' => $id_vendedor, 'nome' => $name, 'email' => $email];
    } else {
        http_response_code(403);
        echo json_encode(['error' => 'Only sellers can create products']);
        exit;
    }
} else {
    $id_vendedor = $_SESSION['vendedor']['id'];
}

// validate required fields
$nome = trim($_POST['title'] ?? $_POST['nome'] ?? '');
$valor = trim($_POST['price'] ?? $_POST['valor'] ?? '');
$estoque = intval($_POST['stock'] ?? $_POST['estoque'] ?? 0);
$descricao = trim($_POST['description'] ?? $_POST['descricao'] ?? '');
$estado = $_POST['estado'] ?? 'Novo';

if (!$nome || $valor === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Missing name or price']);
    exit;
}

try {
    // image handling (optional, single image)
    $imagem_url = null;
    if (!empty($_FILES['image']['name'])) {
        $file = $_FILES['image'];
        // basic checks
        $allowed = ['image/jpeg','image/png','image/webp'];
        if (!in_array($file['type'], $allowed)) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid image type']);
            exit;
        }
        if ($file['error'] !== UPLOAD_ERR_OK) {
            http_response_code(400);
            echo json_encode(['error' => 'Image upload failed']);
            exit;
        }
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid('prod_', true) . '.' . $ext;
        // use UPLOAD_DIR
        if (!defined('UPLOAD_DIR')) {
            require_once __DIR__ . '/../../backend/config.php';
        }
        if (!is_dir(UPLOAD_DIR)) {
            mkdir(UPLOAD_DIR, 0755, true);
        }
        $destination = rtrim(UPLOAD_DIR, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $filename;
        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to save image']);
            exit;
        }
        // store relative path for frontend
        $imagem_url = 'assets/uploads/' . $filename;
    }

    $stmt = $pdo->prepare('INSERT INTO produto (id_vendedor, nome, descricao, imagem_url, valor, estoque, estado) VALUES (?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$id_vendedor, $nome, $descricao, $imagem_url, $valor, $estoque, $estado]);

    $id = $pdo->lastInsertId();
    echo json_encode(['success' => true, 'id_produto' => $id]);
} catch (Throwable $e) {
    http_response_code(500);
    // Log full error and return message details to help local debugging
    $msg = $e->getMessage();
    error_log('create_product error: ' . $msg . '\nTrace: ' . $e->getTraceAsString());
    echo json_encode(['error' => 'Server error', 'details' => $msg]);
    exit;
}
