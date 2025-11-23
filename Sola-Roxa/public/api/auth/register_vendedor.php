<?php
/**
 * API de Registro de Vendedor
 * 
 * Endpoint: POST /api/auth/register_vendedor.php
 * Descrição: Cria uma nova conta de vendedor no sistema
 * 
 * Parâmetros POST esperados:
 * - name: Nome completo do vendedor
 * - email: Email único (usado para login)
 * - password: Senha em texto plano (será hasheada)
 * - cpf (opcional): CPF do vendedor
 * 
 * Retorna JSON:
 * - Sucesso: { success: true, id_vendedor: número }
 * - Erro: { error: "mensagem de erro" }
 * 
 * Diferença para register_usuario.php:
 * - Cria registro na tabela `vendedor` (não `usuario`)
 * - Vendedor tem privilégios de criar/gerenciar produtos
 * - Validações e segurança idênticas ao registro de usuário
 */

// Importa conexão com banco de dados e funções auxiliares
require_once __DIR__ . '/../../../backend/db.php';
require_once __DIR__ . '/../../../backend/auth.php';

// Define que a resposta será JSON
header('Content-Type: application/json; charset=utf-8');

// Valida que a requisição é POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

try {
    // Coleta e limpa os dados recebidos do formulário
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validação: verifica campos obrigatórios
    if (!$name || !$email || !$password) {
        http_response_code(400); // Bad Request
        echo json_encode(['error' => 'Missing fields']);
        exit;
    }

    // Verifica se o email já está cadastrado como vendedor
    // Usa prepared statement para segurança (evita SQL Injection)
    $stmt = $pdo->prepare('SELECT id_vendedor FROM vendedor WHERE email = ? LIMIT 1');
    $stmt->execute([$email]);
    
    // Se encontrou registro, email já existe
    if ($stmt->fetch()) {
        http_response_code(409); // Conflict
        echo json_encode(['error' => 'Email already registered']);
        exit;
    }

    // Cria hash seguro da senha usando bcrypt
    // PASSWORD_DEFAULT utiliza bcrypt com custo adequado
    // Hash gerado tem ~60 caracteres e inclui salt automático
    $hash = password_hash($password, PASSWORD_DEFAULT);
    
    // Tratamento do CPF (campo obrigatório no banco)
    $cpf = trim($_POST['cpf'] ?? '');
    
    // Se CPF não foi fornecido, gera um temporário
    if (empty($cpf)) {
        // Gera CPF com 11 dígitos aleatórios
        $cpf = str_pad(rand(10000000000, 99999999999), 11, '0', STR_PAD_LEFT);
        
        // Garante unicidade do CPF gerado
        $attempts = 0;
        while ($attempts < 10) {
            $checkStmt = $pdo->prepare('SELECT id_vendedor FROM vendedor WHERE CPF = ?');
            $checkStmt->execute([$cpf]);
            
            // Se não encontrou, o CPF é único
            if (!$checkStmt->fetch()) {
                break; // CPF único encontrado
            }
            
            // Gera novo CPF e tenta novamente
            $cpf = str_pad(rand(10000000000, 99999999999), 11, '0', STR_PAD_LEFT);
            $attempts++;
        }
    }
    
    // Insere o novo vendedor no banco de dados
    // Usa prepared statement para segurança
    $insert = $pdo->prepare('INSERT INTO vendedor (nome, email, senha, CPF) VALUES (?, ?, ?, ?)');
    $insert->execute([$name, $email, $hash, $cpf]);

    // Retorna sucesso com o ID do vendedor criado
    echo json_encode([
        'success' => true, 
        'id_vendedor' => $pdo->lastInsertId()
    ]);
    
} catch (Throwable $e) {
    // Tratamento de erros inesperados
    // Garante que sempre retornamos JSON válido
    if (!headers_sent()) {
        http_response_code(500); // Internal Server Error
        header('Content-Type: application/json; charset=utf-8');
    }
    
    // Registra o erro no log do servidor para debugging
    error_log('Erro no registro de vendedor: ' . $e->getMessage());
    
    // Retorna erro genérico (não expõe detalhes internos)
    echo json_encode(['error' => 'Server error']);
    exit;
}
