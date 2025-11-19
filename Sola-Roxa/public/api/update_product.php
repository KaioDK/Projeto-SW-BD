<?php
require_once __DIR__ . '/../../backend/db.php';
require_once __DIR__ . '/../../backend/auth.php';
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

// Only seller can update
if (!isLoggedSeller()) {
    http_response_code(403);
    echo json_encode(['error' => 'Only sellers can update products']);
    exit;
}

$id_vendedor = $_SESSION['vendedor']['id'];

try {
    // verify ownership
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
    if (isset($_POST['title'])) { $fields[] = 'nome = ?'; $params[] = $_POST['title']; }
    if (isset($_POST['descricao'])) { $fields[] = 'descricao = ?'; $params[] = $_POST['descricao']; }
    if (isset($_POST['price'])) { $fields[] = 'valor = ?'; $params[] = $_POST['price']; }
    if (isset($_POST['stock'])) { $fields[] = 'estoque = ?'; $params[] = intval($_POST['stock']); }
    if (isset($_POST['estado'])) { $fields[] = 'estado = ?'; $params[] = $_POST['estado']; }

    // image
    if (!empty($_FILES['image']['name'])) {
        // reuse create product code for upload
        $file = $_FILES['image'];
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid('prod_', true) . '.' . $ext;
        if (!defined('UPLOAD_DIR')) {
            require_once __DIR__ . '/../../backend/config.php';
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
