<?php
/**
 * Arquivo de Configuração do Sistema
 * 
 * Centraliza todas as configurações de conexão com banco de dados,
 * diretórios e comportamento de erros da aplicação.
 * 
 * IMPORTANTE: Ajuste estes valores conforme o ambiente:
 * - Desenvolvimento: display_errors=1, senhas vazias OK
 * - Produção: display_errors=0, senhas fortes, HTTPS obrigatório
 */

// ============================================
// CONFIGURAÇÕES DE BANCO DE DADOS
// ============================================

/**
 * Host do servidor MySQL/MariaDB
 * 
 * Valores comuns:
 * - '127.0.0.1' ou 'localhost' para servidor local (XAMPP, WAMP, etc)
 * - IP ou domínio para servidores remotos
 */
define('DB_HOST', '127.0.0.1');

/**
 * Nome do banco de dados
 * 
 * O banco 'sola_roxa' deve existir e conter as tabelas:
 * - usuario (clientes)
 * - vendedor (vendedores)
 * - produto (catálogo)
 * - carrinho (itens no carrinho)
 * - pedido (compras finalizadas)
 * - favoritos (produtos favoritados)
 * - endereco (endereços de entrega)
 * - metodo_pagamento (formas de pagamento)
 */
define('DB_NAME', 'sola_roxa');

/**
 * Usuário do banco de dados
 * 
 * Em desenvolvimento com XAMPP geralmente é 'root'
 * Em produção, crie usuário específico com privilégios limitados
 */
define('DB_USER', 'root');

/**
 * Senha do banco de dados
 * 
 * XAMPP padrão não tem senha (string vazia)
 * PRODUÇÃO: USE SENHA FORTE e armazene em variável de ambiente
 */
define('DB_PASS', '');

// ============================================
// CONFIGURAÇÕES DE DIRETÓRIOS
// ============================================

/**
 * Diretório de uploads
 * 
 * Caminho absoluto onde serão armazenados:
 * - Imagens de produtos (upload de vendedores)
 * - Galeria de imagens de produtos
 * - Possíveis avatares de usuários (futuramente)
 * 
 * Caminho relativo ao backend: ../public/assets/uploads/
 * Caminho web: /Projeto-SW-BD/Sola-Roxa/public/assets/uploads/
 * 
 * Certifique-se que este diretório tem permissões de escrita
 * no servidor web (chmod 755 ou 777 dependendo do ambiente)
 */
define('UPLOAD_DIR', __DIR__ . '/../public/assets/uploads');

// ============================================
// CONFIGURAÇÕES DE ERRO E DEBUGGING
// ============================================

/**
 * Controle de exibição de erros
 * 
 * DESENVOLVIMENTO (display_errors = 1):
 * - Mostra erros diretamente na página
 * - Facilita debugging
 * - NUNCA use em produção (expõe informações sensíveis)
 * 
 * PRODUÇÃO (display_errors = 0):
 * - Erros não são exibidos ao usuário
 * - Erros são registrados em log
 * - Protege contra vazamento de informações
 */
ini_set('display_errors', 0); // 0 = desabilitado, 1 = habilitado

/**
 * Nível de reporte de erros
 * 
 * E_ALL: Reporta todos os tipos de erro
 * - Erros fatais (E_ERROR)
 * - Warnings (E_WARNING)
 * - Notices (E_NOTICE)
 * - Deprecated (E_DEPRECATED)
 * 
 * Em produção, considere usar:
 * error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED)
 * para reduzir ruído nos logs
 */
error_reporting(E_ALL);

