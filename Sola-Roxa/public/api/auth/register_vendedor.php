<?php
require_once __DIR__ . '/../../../backend/db.php';
require_once __DIR__ . '/../../../backend/auth.php';
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

    // Verifica se o email já está registrado (a tabela usa `id_vendedor` como PK)
    $stmt = $pdo->prepare('SELECT id_vendedor FROM vendedor WHERE email = ? LIMIT 1');
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        http_response_code(409);
        echo json_encode(['error' => 'Email already registered']);
        exit;
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);
    // A tabela `vendedor` exige CPF (campo NOT NULL).
    // Se o CPF não for enviado, gera-se um CPF único temporário de 11 dígitos
    // para não violar a restrição durante o cadastro via frontend.
    $cpf = trim($_POST['cpf'] ?? '');
    if (empty($cpf)) {
        // Gera um CPF único: número aleatório de 11 dígitos
        $cpf = str_pad(rand(10000000000, 99999999999), 11, '0', STR_PAD_LEFT);
        // Verifica a unicidade e re-genera se necessário (limite de tentativas).
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
