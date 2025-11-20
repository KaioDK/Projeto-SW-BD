<?php
// Helpers de sessão e autenticação usados por páginas públicas e APIs.
// Funções pequenas que inspecionam/alteram `$_SESSION` para controlar acesso.
// Efeitos colaterais: `requireUser()` e `requireSeller()` podem enviar cabeçalhos
// de redirecionamento (Location) e encerrar a execução com `exit()`.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
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
