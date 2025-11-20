<?php
require_once __DIR__ . '/../../backend/db.php';
require_once __DIR__ . '/../../backend/auth.php';
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if (!$email || !$password) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing fields']);
    exit;
}

$stmt = $pdo->prepare('SELECT id_vendedor, nome, email, senha FROM vendedor WHERE email = ? LIMIT 1');
$stmt->execute([$email]);
$v = $stmt->fetch();

if (!$v || !password_verify($password, $v['senha'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Invalid credentials']);
    exit;
}

// Define sessão do vendedor autenticado
// - Efeito: popula `$_SESSION['vendedor']` utilizado por rotas de vendedor
    $_SESSION['vendedor'] = [
        'id' => $v['id_vendedor'],
        'nome' => $v['nome'],
        'email' => $v['email'],
    ];

echo json_encode(['success' => true, 'vendedor' => $_SESSION['vendedor']]);
