<?php
// Configurações do banco e paths
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'sola_roxa');
define('DB_USER', 'root');
define('DB_PASS', '');

// Pasta de uploads (ajustável)
define('UPLOAD_DIR', __DIR__ . '/../public/assets/uploads');

// Erros em produção normalmente devem ficar desabilitados; para dev, ative se necessário
ini_set('display_errors', 0);
error_reporting(E_ALL);

