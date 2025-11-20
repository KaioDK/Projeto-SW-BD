<?php
require_once __DIR__ . '/../../backend/auth.php';
header('Content-Type: application/json; charset=utf-8');

session_destroy();
// Limpa sessões de usuário e vendedor e encerra a sessão atual.
// - Efeito: usuário fica deslogado tanto como cliente quanto como vendedor.
unset($_SESSION['user']);
unset($_SESSION['vendedor']);
session_destroy();

echo json_encode(['success' => true]);
