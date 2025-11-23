<?php
session_start();
require_once __DIR__ . '/../../../backend/db.php';

echo "<h2>Teste de Endereços</h2>";

echo "<h3>Sessão Atual:</h3>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

if (isset($_SESSION['user'])) {
    $userId = $_SESSION['user']['id'] ?? $_SESSION['user']['id_cliente'] ?? 0;
    echo "<h3>User ID: $userId</h3>";
    
    try {
        $stmt = $pdo->prepare('SELECT * FROM endereco WHERE id_cliente = ?');
        $stmt->execute([$userId]);
        $addresses = $stmt->fetchAll();
        
        echo "<h3>Endereços encontrados: " . count($addresses) . "</h3>";
        echo "<pre>";
        print_r($addresses);
        echo "</pre>";
    } catch (Exception $e) {
        echo "<p style='color: red;'>Erro: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p style='color: red;'>Usuário não está logado!</p>";
}
?>
