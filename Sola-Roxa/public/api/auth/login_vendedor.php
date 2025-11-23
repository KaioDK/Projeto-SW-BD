<?php
/**
 * API de Login de Vendedor
 * 
 * Endpoint: POST /api/auth/login_vendedor.php
 * Descrição: Autentica um vendedor e cria sessão
 * 
 * Parâmetros POST esperados:
 * - email: Email cadastrado
 * - password: Senha em texto plano
 * 
 * Retorna JSON:
 * - Sucesso: { success: true, vendedor: { dados do vendedor } }
 * - Erro: { error: "mensagem de erro" }
 * 
 * Diferença para login_usuario.php:
 * - Autentica na tabela `vendedor` (não `usuario`)
 * - Cria $_SESSION['vendedor'] (não $_SESSION['user'])
 * - Vendedor tem acesso a funcionalidades de gestão de produtos
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

// Busca vendedor no banco pelo email
// Usa prepared statement para segurança
$stmt = $pdo->prepare('SELECT id_vendedor, nome, email, senha FROM vendedor WHERE email = ? LIMIT 1');
$stmt->execute([$email]);
$v = $stmt->fetch();

// Verifica se vendedor existe E se a senha está correta
// password_verify compara a senha em texto plano com o hash armazenado
if (!$v || !password_verify($password, $v['senha'])) {
    http_response_code(401); // Unauthorized (credenciais inválidas)
    echo json_encode(['error' => 'Invalid credentials']);
    exit;
}

// Autenticação bem-sucedida! Cria sessão do vendedor
// A sessão persiste entre requisições até o logout
// Armazena dados do vendedor em $_SESSION['vendedor']
// Este objeto é usado por páginas de gestão de produtos
$_SESSION['vendedor'] = [
    'id' => $v['id_vendedor'],     // ID único do vendedor no banco
    'nome' => $v['nome'],          // Nome completo para exibição
    'email' => $v['email'],        // Email (usado para login)
];

// Retorna sucesso com dados do vendedor
// O frontend usa esses dados para personalizar a interface de gestão
echo json_encode(['success' => true, 'vendedor' => $_SESSION['vendedor']]);
