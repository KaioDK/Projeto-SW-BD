<?php
require_once __DIR__ . '/../../backend/db.php';
require_once __DIR__ . '/../../backend/auth.php';
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

try {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$name || !$email || !$password) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing fields']);
        exit;
    }

    // check existing (schema uses id_vendedor)
    $stmt = $pdo->prepare('SELECT id_vendedor FROM vendedor WHERE email = ? LIMIT 1');
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        http_response_code(409);
        echo json_encode(['error' => 'Email already registered']);
        exit;
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);
    // The `vendedor` table requires CPF (not null). 
    // If not provided, generate a unique one (format: random 11 digits)
    $cpf = trim($_POST['cpf'] ?? '');
    if (empty($cpf)) {
        // Generate unique CPF: random 11-digit number
        $cpf = str_pad(rand(10000000000, 99999999999), 11, '0', STR_PAD_LEFT);
        // Ensure uniqueness
        $attempts = 0;
        while ($attempts < 10) {
            $checkStmt = $pdo->prepare('SELECT id_vendedor FROM vendedor WHERE CPF = ?');
            $checkStmt->execute([$cpf]);
            if (!$checkStmt->fetch()) {
                break;
            }
            $cpf = str_pad(rand(10000000000, 99999999999), 11, '0', STR_PAD_LEFT);
            $attempts++;
        }
    }
    $insert = $pdo->prepare('INSERT INTO vendedor (nome, email, senha, CPF) VALUES (?, ?, ?, ?)');
    $insert->execute([$name, $email, $hash, $cpf]);

    echo json_encode(['success' => true, 'id_vendedor' => $pdo->lastInsertId()]);
} catch (Throwable $e) {
    if (!headers_sent()) {
        http_response_code(500);
        header('Content-Type: application/json; charset=utf-8');
    }
    error_log('Register vendedor error: ' . $e->getMessage());
    echo json_encode(['error' => 'Server error']);
    exit;
}
