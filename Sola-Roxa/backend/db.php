<?php
/**
 * Arquivo de Conexão com Banco de Dados
 * 
 * Este arquivo cria e configura a conexão PDO (PHP Data Objects)
 * com o banco MySQL/MariaDB usando as configurações definidas
 * em config.php.
 * 
 * O objeto $pdo resultante é usado por todas as APIs e páginas
 * para executar queries no banco de dados de forma segura.
 * 
 * Características de segurança:
 * - Modo de erro: ERRMODE_EXCEPTION (lança exceções em caso de erro)
 * - Fetch mode: FETCH_ASSOC (retorna arrays associativos)
 * - Charset: utf8mb4 (suporta emojis e caracteres especiais)
 * - Prepared statements (proteção contra SQL Injection)
 */

// Importa configurações do banco de dados
// Define as constantes DB_HOST, DB_NAME, DB_USER, DB_PASS
require_once __DIR__ . '/config.php';

try {
    // Cria DSN (Data Source Name) para conexão MySQL
    // Formato: "mysql:host=SERVIDOR;dbname=BANCO;charset=CODIFICAÇÃO"
    // utf8mb4 suporta todos os caracteres Unicode, incluindo emojis
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    
    // Cria objeto PDO com opções de segurança e comportamento
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        /**
         * PDO::ERRMODE_EXCEPTION
         * 
         * Faz o PDO lançar exceções em caso de erro
         * Permite uso de try/catch para tratamento de erros
         * Evita verificações manuais de erros após cada query
         * 
         * Alternativas (não recomendadas):
         * - PDO::ERRMODE_SILENT: silencia erros (perigoso)
         * - PDO::ERRMODE_WARNING: mostra warnings PHP
         */
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        
        /**
         * PDO::FETCH_ASSOC
         * 
         * Define modo padrão de fetch como array associativo
         * Resultados vêm como ['coluna' => 'valor']
         * 
         * Alternativas:
         * - PDO::FETCH_NUM: array numérico [0 => 'valor']
         * - PDO::FETCH_OBJ: objeto stdClass
         * - PDO::FETCH_BOTH: associativo + numérico (duplicado)
         */
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    
} catch (PDOException $e) {
    /**
     * Tratamento de falha na conexão
     * 
     * Se a conexão falhar (servidor fora, senha errada, banco não existe),
     * retorna erro JSON e encerra execução.
     * 
     * Isso evita que a aplicação continue sem acesso ao banco,
     * o que causaria erros em cascata.
     * 
     * Em produção, não exponha detalhes do erro ao usuário
     * (mensagens específicas podem ajudar atacantes)
     */
    http_response_code(500); // Internal Server Error
    header('Content-Type: application/json; charset=utf-8');
    
    // Retorna erro genérico (não expõe detalhes da falha)
    echo json_encode(['error' => 'DB connection failed']);
    
    // Opcional: Log do erro real para análise (não mostrar ao usuário)
    // error_log('Falha na conexão DB: ' . $e->getMessage());
    
    exit; // Encerra execução para evitar erros subsequentes
}
