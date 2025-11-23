<?php
/**
 * API de Login de Usuário (Cliente)
 * 
 * Endpoint: POST /api/auth/login_usuario.php
 * Descrição: Autentica um cliente e cria sessão
 * 
 * Parâmetros POST esperados:
 * - email: Email cadastrado
 * - password: Senha em texto plano
 * 
 * Retorna JSON:
 * - Sucesso: { success: true, user: { dados do usuário } }
 * - Erro: { error: "mensagem de erro" }
 * 
 * Segurança:
 * - Verifica senha com password_verify (compara com hash)
 * - Prepared statements
 * - Cria sessão PHP com dados do usuário
 */

// Importa conexão com banco e funções de autenticação
require_once __DIR__ . '/../../../backend/db.php';
require_once __DIR__ . '/../../../backend/auth.php';

// Define resposta como JSON
header('Content-Type: application/json; charset=utf-8');

// Valida método HTTP (deve ser POST)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Coleta credenciais enviadas pelo formulário
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

// Validação: verifica se email e senha foram fornecidos
if (!$email || !$password) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Missing fields']);
    exit;
}

// Busca usuário no banco pelo email
// Usa prepared statement para segurança
$stmt = $pdo->prepare('SELECT id_cliente, nome, email, senha, CPF FROM usuario WHERE email = ? LIMIT 1');
$stmt->execute([$email]);
$u = $stmt->fetch();

// Verifica se usuário existe E se a senha está correta
// password_verify compara a senha em texto plano com o hash armazenado
// Retorna true se a senha corresponde ao hash
if (!$u || !password_verify($password, $u['senha'])) {
    http_response_code(401); // Unauthorized (credenciais inválidas)
    echo json_encode(['error' => 'Invalid credentials']);
    exit;
}

// Autenticação bem-sucedida! Cria sessão do usuário
// A sessão persiste entre requisições até o logout
// Armazena dados do usuário em $_SESSION['user']
// Este objeto será acessado por outras páginas para verificar autenticação
$_SESSION['user'] = [
    'id' => $u['id_cliente'],      // ID único do cliente no banco
    'nome' => $u['nome'],          // Nome completo para exibição
    'email' => $u['email'],        // Email (usado para login)
    'cpf' => $u['CPF'] ?? null,    // CPF (pode ser gerado automaticamente)
];

// Retorna sucesso com dados do usuário
// O frontend usa esses dados para personalizar a interface
echo json_encode(['success' => true, 'user' => $_SESSION['user']]);
