<?php
// Helpers de sessão e autenticação usados por páginas públicas e APIs.
// Funções pequenas que inspecionam/alteram `$_SESSION` para controlar acesso.
// Efeitos colaterais: `requireUser()` e `requireSeller()` podem enviar cabeçalhos
// de redirecionamento (Location) e encerrar a execução com `exit()`.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Sincroniza sessão de vendedor quando o usuário logado possuir um registro
// correspondente na tabela `vendedor`. Tentamos casar pelo `email` primeiro
// (mais comum), e se isso falhar tentamos casar pelo `CPF` quando disponível
// no `$_SESSION['user']`. Isso cobre casos onde o e-mail do vendedor difere
// do e-mail do usuário (por exemplo, migração ou edição posterior).
try {
    if (isset($_SESSION['user']) && !isset($_SESSION['vendedor'])) {
        if (file_exists(__DIR__ . '/db.php')) {
            require_once __DIR__ . '/db.php';
            $email = $_SESSION['user']['email'] ?? null;
            $cpf = $_SESSION['user']['cpf'] ?? null;

            $v = null;
            if ($email) {
                $stmt = $pdo->prepare('SELECT id_vendedor, nome, email, CPF FROM vendedor WHERE email = ? LIMIT 1');
                $stmt->execute([$email]);
                $v = $stmt->fetch();
            }

            // Se não encontramos por email e temos CPF do usuário, tentar por CPF
            if (!$v && $cpf) {
                $stmt = $pdo->prepare('SELECT id_vendedor, nome, email, CPF FROM vendedor WHERE CPF = ? LIMIT 1');
                $stmt->execute([$cpf]);
                $v = $stmt->fetch();
            }

            if ($v) {
                $_SESSION['vendedor'] = ['id' => $v['id_vendedor'], 'nome' => $v['nome'], 'email' => $v['email']];
            }
        }
    }
} catch (Throwable $e) {
    // Não bloquear execução por falha de sincronização de sessão (log opcional)
}

// Retorna true se existir um usuário (cliente) autenticado na sessão.
function isLoggedUser()
{
    return isset($_SESSION['user']);
}

// Retorna true se existir um vendedor autenticado na sessão.
function isLoggedSeller()
{
    return isset($_SESSION['vendedor']);
}

// Garante que a rota seja acessada apenas por usuários autenticados.
// Se não houver usuário, redireciona para `auth.php` (página pública de login)
// e encerra a execução para evitar que o restante do script rode.
function requireUser()
{
    if (!isLoggedUser()) {
        header('Location: auth.php');
        exit;
    }
}

// Garante que a rota seja acessada apenas por vendedores autenticados.
// Comportamento equivalente a `requireUser()` mas verifica `vendedor`.
function requireSeller()
{
    if (!isLoggedSeller()) {
        header('Location: auth.php');
        exit;
    }
}
