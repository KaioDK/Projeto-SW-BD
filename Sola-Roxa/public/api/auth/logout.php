<?php
/**
 * API de Logout (Usuário e Vendedor)
 * 
 * Endpoint: POST /api/auth/logout.php
 * Descrição: Encerra a sessão do usuário ou vendedor logado
 * 
 * Parâmetros: Nenhum (usa sessão PHP automática)
 * 
 * Retorna JSON:
 * - Sempre: { success: true }
 * 
 * Efeitos:
 * - Remove $_SESSION['user'] (se cliente estava logado)
 * - Remove $_SESSION['vendedor'] (se vendedor estava logado)
 * - Destrói a sessão PHP completamente
 * - Usuário precisa fazer login novamente para acessar áreas restritas
 */

// Importa funções de autenticação (inicia sessão se necessário)
require_once __DIR__ . '/../../../backend/auth.php';

// Define resposta como JSON
header('Content-Type: application/json; charset=utf-8');

// Remove sessões de usuário e vendedor
// unset() remove as variáveis específicas da sessão
unset($_SESSION['user']);       // Remove dados do cliente
unset($_SESSION['vendedor']);   // Remove dados do vendedor

// Destrói a sessão PHP completamente
// Isso invalida o ID de sessão e remove todos os dados armazenados
// Após session_destroy(), uma nova sessão será criada na próxima requisição
session_destroy();

// Retorna sucesso (logout sempre bem-sucedido)
echo json_encode(['success' => true]);
