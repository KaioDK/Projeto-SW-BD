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

$stmt = $pdo->prepare('SELECT id_cliente, nome, email, senha FROM usuario WHERE email = ? LIMIT 1');
$stmt->execute([$email]);
$u = $stmt->fetch();

if (!$u || !password_verify($password, $u['senha'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Invalid credentials']);
    exit;
}

// Define sessão do usuário autenticado (mapeia id_cliente -> id)
// - Efeito: altera `$_SESSION['user']` usado pelas páginas públicas
$_SESSION['user'] = [
    'id' => $u['id_cliente'],
    'nome' => $u['nome'],
    'email' => $u['email'],
];

echo json_encode(['success' => true, 'user' => $_SESSION['user']]);
