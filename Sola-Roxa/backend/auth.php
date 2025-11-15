<?php
// Session and helpers for authentication
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isLoggedUser()
{
    return isset($_SESSION['user']);
}

function isLoggedSeller()
{
    return isset($_SESSION['vendedor']);
}

function requireUser()
{
    if (!isLoggedUser()) {
        // redirect to public auth page (relative to public pages)
        header('Location: auth.php');
        exit;
    }
}

function requireSeller()
{
    if (!isLoggedSeller()) {
        header('Location: auth.php');
        exit;
    }
}
