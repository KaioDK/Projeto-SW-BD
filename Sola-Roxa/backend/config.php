<?php
// Configurações de conexão com o banco e caminhos utilizados pela aplicação
// - Ajuste estes valores conforme o ambiente (desenvolvimento / produção)
// - `DB_*`: parâmetros usados para criar o DSN PDO
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'sola_roxa');
define('DB_USER', 'root');
define('DB_PASS', '');

// Diretório onde os uploads públicos (imagens, galerias) serão armazenados.
// Valor absoluto para facilitar chamadas de move_uploaded_file() e leitura.
// Pode ser alterado se a infraestrutura exigir um local diferente.
define('UPLOAD_DIR', __DIR__ . '/../public/assets/uploads');

// Controle de exibição de erros: em produção deixe `display_errors` desabilitado
// para não vazar informações sensíveis. Em ambiente de desenvolvimento, ative
// a exibição para facilitar depuração (ou use um logger centralizado).
ini_set('display_errors', 0);
error_reporting(E_ALL);

