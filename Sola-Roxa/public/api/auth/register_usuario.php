<?php
/**
 * API de Registro de Usuário (Cliente)
 * 
 * Endpoint: POST /api/auth/register_usuario.php
 * Descrição: Cria uma nova conta de cliente no sistema
 * 
 * Parâmetros POST esperados:
 * - name: Nome completo do usuário
 * - email: Email único (usado para login)
 * - password: Senha em texto plano (será hasheada)
 * - cpf (opcional): CPF do usuário
 * 
 * Retorna JSON:
 * - Sucesso: { success: true, id_cliente: número }
 * - Erro: { error: "mensagem de erro" }
 * 
 * Segurança:
 * - Senha hasheada com bcrypt (password_hash)
 * - Prepared statements (proteção SQL Injection)
 * - Validação de email único
 * - Geração automática de CPF se não fornecido
 */

// Importa conexão com banco de dados e funções auxiliares
require_once __DIR__ . '/../../../backend/db.php';
require_once __DIR__ . '/../../../backend/auth.php';

// Define que a resposta será JSON
header('Content-Type: application/json; charset=utf-8');

// Valida que a requisição é POST (método correto para criar recursos)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

try {
    // Coleta e limpa os dados recebidos do formulário
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? ''; // Não faz trim na senha (pode ter espaços intencionais)

    // Validação: verifica se todos os campos obrigatórios foram preenchidos
    if (!$name || !$email || !$password) {
        http_response_code(400); // Bad Request
        echo json_encode(['error' => 'Campos obrigatórios ausentes']);
        exit;
    }

    // Verifica se o email já está cadastrado no banco
    // Usa prepared statement para segurança (evita SQL Injection)
    $stmt = $pdo->prepare('SELECT id_cliente FROM usuario WHERE email = ? LIMIT 1');
    $stmt->execute([$email]);
    
    // Se encontrou um registro, o email já existe
    if ($stmt->fetch()) {
        http_response_code(409); // Conflict
        echo json_encode(['error' => 'Email já registrado!']);
        exit;
    }

    // Cria o hash da senha usando bcrypt (algoritmo seguro e moderno)
    // PASSWORD_DEFAULT usa bcrypt com custo adequado
    // O hash gerado tem ~60 caracteres e inclui salt automático
    $hash = password_hash($password, PASSWORD_DEFAULT);
    
    // Tratamento do CPF (campo obrigatório no banco)
    $cpf = trim($_POST['cpf'] ?? '');
    
    // Se CPF não foi fornecido, gera um temporário
    if (empty($cpf)) {
        // Gera CPF com 11 dígitos aleatórios
        $cpf = str_pad(rand(10000000000, 99999999999), 11, '0', STR_PAD_LEFT);
        
        // Garante que o CPF gerado é único no banco
        $attempts = 0;
        while ($attempts < 10) {
            $checkStmt = $pdo->prepare('SELECT id_cliente FROM usuario WHERE CPF = ?');
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
    
    // Insere o novo usuário no banco de dados
    // Usa prepared statement para segurança
    $insert = $pdo->prepare('INSERT INTO usuario (nome, email, senha, CPF) VALUES (?, ?, ?, ?)');
    $insert->execute([$name, $email, $hash, $cpf]);

    // Retorna sucesso com o ID do usuário criado
    echo json_encode([
        'success' => true, 
        'id_cliente' => $pdo->lastInsertId()
    ]);
    
} catch (Throwable $e) {
    // Tratamento de erros inesperados
    // Garante que sempre retornamos JSON válido (evita quebrar o frontend)
    if (!headers_sent()) {
        http_response_code(500); // Internal Server Error
        header('Content-Type: application/json; charset=utf-8');
    }
    
    // Registra o erro no log do servidor para debugging
    // Em produção, esses logs devem ser monitorados
    error_log('Erro no registro de usuário: ' . $e->getMessage());
    
    // Retorna erro genérico (não expõe detalhes internos)
    echo json_encode(['error' => 'Server error']);
    exit;
}
