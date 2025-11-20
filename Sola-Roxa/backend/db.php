<?php
// Cria e configura a conexão PDO com o banco MySQL usando as constantes
// definidas em `backend/config.php`.
// - Retorna um objeto $pdo pronto para uso por APIs e páginas PHP.
// - Modo de erro: exceção (para facilitar try/catch nas rotas)
// - Fetch padrão: array associativo
require_once __DIR__ . '/config.php';

try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    // Em caso de falha na conexão, retornamos um JSON de erro e encerramos
    // a execução. Isso evita que a aplicação continue sem acesso ao DB.
    http_response_code(500);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['error' => 'DB connection failed']);
    exit;
}
