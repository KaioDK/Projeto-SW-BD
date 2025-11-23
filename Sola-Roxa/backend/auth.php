<?php
/**
 * Arquivo de Helpers de Autenticação e Sessão
 * 
 * Este arquivo fornece funções auxiliares para gerenciar autenticação
 * de usuários e vendedores em todo o sistema.
 * 
 * Funcionalidades principais:
 * - Inicialização automática de sessões PHP
 * - Sincronização automática de sessão vendedor para usuários logados
 * - Funções para verificar autenticação (isLoggedUser, isLoggedSeller)
 * - Funções para proteger rotas (requireUser, requireSeller)
 * 
 * Este arquivo é incluído em todas as páginas e APIs que precisam
 * verificar autenticação ou acessar dados de sessão.
 */

// Inicia a sessão PHP se ainda não foi iniciada
// A sessão é necessária para armazenar dados entre requisições
// Verifica se a sessão não está ativa para evitar erro de "session already started"
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Sincronização Automática de Sessão Vendedor
 * 
 * Quando um usuário (cliente) está logado, este código verifica automaticamente
 * se ele também possui uma conta de vendedor no sistema. Isso permite que
 * um mesmo usuário atue tanto como comprador quanto vendedor.
 * 
 * Estratégia de busca:
 * 1. Primeiro tenta encontrar vendedor pelo email do usuário
 * 2. Se não encontrar por email, tenta pelo CPF (caso tenha sido cadastrado diferente)
 * 
 * Se encontrar correspondência, popula $_SESSION['vendedor'] automaticamente
 * Isso dá acesso às funcionalidades de vendedor sem login separado
 */
try {
    // Verifica se usuário está logado MAS vendedor não está
    // Isso indica que pode haver uma conta vendedor não sincronizada
    if (isset($_SESSION['user']) && !isset($_SESSION['vendedor'])) {
        // Importa conexão com banco se arquivo existe
        if (file_exists(__DIR__ . '/db.php')) {
            require_once __DIR__ . '/db.php';
            
            // Extrai email e CPF da sessão do usuário
            $email = $_SESSION['user']['email'] ?? null;
            $cpf = $_SESSION['user']['cpf'] ?? null;

            $v = null; // Variável para armazenar dados do vendedor encontrado
            
            // Tentativa 1: Busca vendedor pelo email
            if ($email) {
                $stmt = $pdo->prepare('SELECT id_vendedor, nome, email, CPF FROM vendedor WHERE email = ? LIMIT 1');
                $stmt->execute([$email]);
                $v = $stmt->fetch();
            }

            // Tentativa 2: Se não encontrou por email e temos CPF, busca por CPF
            // Útil quando vendedor usou email diferente no cadastro
            if (!$v && $cpf) {
                $stmt = $pdo->prepare('SELECT id_vendedor, nome, email, CPF FROM vendedor WHERE CPF = ? LIMIT 1');
                $stmt->execute([$cpf]);
                $v = $stmt->fetch();
            }

            // Se encontrou vendedor correspondente, cria sessão de vendedor
            if ($v) {
                $_SESSION['vendedor'] = [
                    'id' => $v['id_vendedor'],
                    'nome' => $v['nome'],
                    'email' => $v['email']
                ];
            }
        }
    }
} catch (Throwable $e) {
    // Se falhar a sincronização, não bloqueia a aplicação
    // O usuário continua logado normalmente como cliente
    // Log opcional pode ser adicionado aqui para debugging
    // error_log('Falha na sincronização de sessão vendedor: ' . $e->getMessage());
}

/**
 * Verifica se há um usuário (cliente) autenticado
 * 
 * @return bool True se existe $_SESSION['user'], false caso contrário
 */
function isLoggedUser()
{
    return isset($_SESSION['user']);
}

/**
 * Verifica se há um vendedor autenticado
 * 
 * @return bool True se existe $_SESSION['vendedor'], false caso contrário
 */
function isLoggedSeller()
{
    return isset($_SESSION['vendedor']);
}

/**
 * Protege uma rota/página para acesso apenas de usuários autenticados
 * 
 * Se não houver usuário logado, redireciona para página de login (auth.php)
 * e encerra a execução para evitar que código sensível seja executado.
 * 
 * Uso típico no início de páginas restritas:
 * ```php
 * require_once 'backend/auth.php';
 * requireUser(); // Garante que só usuários logados acessem
 * ```
 */
function requireUser()
{
    if (!isLoggedUser()) {
        header('Location: auth.php');
        exit; // Importante: encerra execução após redirect
    }
}

/**
 * Protege uma rota/página para acesso apenas de vendedores autenticados
 * 
 * Funcionamento idêntico ao requireUser(), mas verifica sessão de vendedor.
 * Usado em páginas de gestão de produtos e outras funcionalidades exclusivas.
 * 
 * Uso típico em páginas de vendedor:
 * ```php
 * require_once 'backend/auth.php';
 * requireSeller(); // Garante que só vendedores logados acessem
 * ```
 */
function requireSeller()
{
    if (!isLoggedSeller()) {
        header('Location: auth.php');
        exit; // Importante: encerra execução após redirect
    }
}
