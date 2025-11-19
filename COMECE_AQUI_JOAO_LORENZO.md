# Instruções Práticas - Como Começar (João & Lorenzo)

## Para João Pedro (Carrinho)

### 1. Setup Inicial
1. Crie sua branch a partir de `main`:
   ```bash
   git checkout main
   git pull origin main
   git checkout -b joao-carrinho
   ```

2. Crie o arquivo `api/add_to_cart.php` (template abaixo)

### 2. Criar `api/add_to_cart.php`
```php
<?php
require_once __DIR__ . '/../../backend/db.php';
require_once __DIR__ . '/../../backend/auth.php';
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Must be logged as user
if (!isLoggedUser()) {
    http_response_code(401);
    echo json_encode(['error' => 'Login required']);
    exit;
}

try {
    $id_produto = intval($_POST['id_produto'] ?? 0);
    $quantidade = intval($_POST['quantidade'] ?? 1);

    if (!$id_produto) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing product id']);
        exit;
    }

    // Verify product exists
    $check = $pdo->prepare('SELECT id_produto FROM produto WHERE id_produto = ?');
    $check->execute([$id_produto]);
    if (!$check->fetch()) {
        http_response_code(404);
        echo json_encode(['error' => 'Product not found']);
        exit;
    }

    // Initialize cart session if not exists
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Check if product already in cart
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id_produto'] == $id_produto) {
            $item['quantidade'] += $quantidade;
            $found = true;
            break;
        }
    }

    // If not found, add new item
    if (!$found) {
        $_SESSION['cart'][] = [
            'id_produto' => $id_produto,
            'quantidade' => $quantidade
        ];
    }

    echo json_encode(['success' => true, 'cart_count' => count($_SESSION['cart'])]);
} catch (Throwable $e) {
    http_response_code(500);
    error_log('Add to cart error: ' . $e->getMessage());
    echo json_encode(['error' => 'Server error']);
    exit;
}
```

### 3. Criar `api/get_cart.php`
```php
<?php
require_once __DIR__ . '/../../backend/db.php';
require_once __DIR__ . '/../../backend/auth.php';
header('Content-Type: application/json; charset=utf-8');

if (!isLoggedUser()) {
    http_response_code(401);
    echo json_encode(['error' => 'Login required']);
    exit;
}

try {
    $cart = $_SESSION['cart'] ?? [];
    $items = [];
    $total = 0;

    foreach ($cart as $cartItem) {
        $stmt = $pdo->prepare('SELECT id_produto, nome, valor, imagem_url FROM produto WHERE id_produto = ?');
        $stmt->execute([$cartItem['id_produto']]);
        $product = $stmt->fetch();

        if ($product) {
            $subtotal = $product['valor'] * $cartItem['quantidade'];
            $items[] = [
                'id_produto' => $product['id_produto'],
                'nome' => $product['nome'],
                'valor' => $product['valor'],
                'imagem_url' => $product['imagem_url'],
                'quantidade' => $cartItem['quantidade'],
                'subtotal' => $subtotal
            ];
            $total += $subtotal;
        }
    }

    echo json_encode(['success' => true, 'items' => $items, 'total' => $total]);
} catch (Throwable $e) {
    http_response_code(500);
    error_log('Get cart error: ' . $e->getMessage());
    echo json_encode(['error' => 'Server error']);
    exit;
}
```

### 4. Criar `api/remove_from_cart.php`
```php
<?php
require_once __DIR__ . '/../../backend/auth.php';
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

if (!isLoggedUser()) {
    http_response_code(401);
    echo json_encode(['error' => 'Login required']);
    exit;
}

$id_produto = intval($_POST['id_produto'] ?? 0);
if (!$id_produto) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing product id']);
    exit;
}

try {
    $cart = $_SESSION['cart'] ?? [];
    $_SESSION['cart'] = array_filter($cart, function($item) use ($id_produto) {
        return $item['id_produto'] != $id_produto;
    });

    echo json_encode(['success' => true, 'cart_count' => count($_SESSION['cart'])]);
} catch (Throwable $e) {
    http_response_code(500);
    error_log('Remove from cart error: ' . $e->getMessage());
    echo json_encode(['error' => 'Server error']);
    exit;
}
```

### 5. Testar com curl
```bash
# 1. Login primeiro (get session cookie)
curl -X POST http://localhost/Projeto-SW-BD/Sola-Roxa/public/api/login_usuario.php \
  -d "email=joao@test.com&password=senha123" \
  -c cookies.txt

# 2. Adicionar produto ao carrinho
curl -X POST http://localhost/Projeto-SW-BD/Sola-Roxa/public/api/add_to_cart.php \
  -d "id_produto=3&quantidade=2" \
  -b cookies.txt

# 3. Ver carrinho
curl http://localhost/Projeto-SW-BD/Sola-Roxa/public/api/get_cart.php \
  -b cookies.txt
```

---

## Para Lorenzo (Endereço & Pagamento)

### 1. Setup Inicial
```bash
git checkout main
git pull origin main
git checkout -b lorenzo-pagamento
```

### 2. Criar `api/add_address.php`
```php
<?php
require_once __DIR__ . '/../../backend/db.php';
require_once __DIR__ . '/../../backend/auth.php';
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

if (!isLoggedUser()) {
    http_response_code(401);
    echo json_encode(['error' => 'Login required']);
    exit;
}

try {
    $id_cliente = $_SESSION['user']['id'];
    $rua = trim($_POST['rua'] ?? '');
    $numero = intval($_POST['numero'] ?? 0);
    $bairro = trim($_POST['bairro'] ?? '');
    $cidade = trim($_POST['cidade'] ?? '');
    $estado = trim($_POST['estado'] ?? '');

    if (!$rua || !$numero || !$bairro || !$cidade || !$estado) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing required fields']);
        exit;
    }

    $stmt = $pdo->prepare('INSERT INTO endereco (id_cliente, rua, numero, bairro, cidade, estado) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([$id_cliente, $rua, $numero, $bairro, $cidade, $estado]);

    echo json_encode(['success' => true, 'id_endereco' => $pdo->lastInsertId()]);
} catch (Throwable $e) {
    http_response_code(500);
    error_log('Add address error: ' . $e->getMessage());
    echo json_encode(['error' => 'Server error']);
    exit;
}
```

### 3. Criar `api/get_address.php`
```php
<?php
require_once __DIR__ . '/../../backend/db.php';
require_once __DIR__ . '/../../backend/auth.php';
header('Content-Type: application/json; charset=utf-8');

if (!isLoggedUser()) {
    http_response_code(401);
    echo json_encode(['error' => 'Login required']);
    exit;
}

try {
    $id_cliente = $_SESSION['user']['id'];
    $stmt = $pdo->prepare('SELECT id_endereco, rua, numero, bairro, cidade, estado FROM endereco WHERE id_cliente = ?');
    $stmt->execute([$id_cliente]);
    $enderecos = $stmt->fetchAll();

    echo json_encode(['success' => true, 'enderecos' => $enderecos]);
} catch (Throwable $e) {
    http_response_code(500);
    error_log('Get address error: ' . $e->getMessage());
    echo json_encode(['error' => 'Server error']);
    exit;
}
```

### 4. Criar `api/register_payment.php`
```php
<?php
require_once __DIR__ . '/../../backend/db.php';
require_once __DIR__ . '/../../backend/auth.php';
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

if (!isLoggedUser()) {
    http_response_code(401);
    echo json_encode(['error' => 'Login required']);
    exit;
}

try {
    $id_pedido = intval($_POST['id_pedido'] ?? 0);
    $metodo = $_POST['metodo'] ?? ''; // CARTAO, PIX, BOLETO

    if (!$id_pedido || !in_array($metodo, ['CARTAO', 'PIX', 'BOLETO'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid data']);
        exit;
    }

    // Verify pedido belongs to this user
    $check = $pdo->prepare('SELECT id_pedido FROM pedido WHERE id_pedido = ? AND id_cliente = ?');
    $check->execute([$id_pedido, $_SESSION['user']['id']]);
    if (!$check->fetch()) {
        http_response_code(403);
        echo json_encode(['error' => 'Not owner of order']);
        exit;
    }

    // Insert payment (simulate approval)
    $stmt = $pdo->prepare('INSERT INTO pagamento (id_pedido, metodo, status) VALUES (?, ?, ?)');
    $stmt->execute([$id_pedido, $metodo, 'APROVADO']);

    echo json_encode(['success' => true, 'id_pagamento' => $pdo->lastInsertId()]);
} catch (Throwable $e) {
    http_response_code(500);
    error_log('Register payment error: ' . $e->getMessage());
    echo json_encode(['error' => 'Server error']);
    exit;
}
```

### 5. Testar
```bash
# 1. Login
curl -X POST http://localhost/Projeto-SW-BD/Sola-Roxa/public/api/login_usuario.php \
  -d "email=joao@test.com&password=senha123" \
  -c cookies.txt

# 2. Adicionar endereço
curl -X POST http://localhost/Projeto-SW-BD/Sola-Roxa/public/api/add_address.php \
  -d "rua=Rua%20A&numero=123&bairro=Centro&cidade=SP&estado=SP" \
  -b cookies.txt

# 3. Listar endereços
curl http://localhost/Projeto-SW-BD/Sola-Roxa/public/api/get_address.php \
  -b cookies.txt
```

---

## Ordem de Implementação Recomendada

1. **João - Semana 1:**
   - [ ] `add_to_cart.php`
   - [ ] `get_cart.php`
   - [ ] `remove_from_cart.php`
   - [ ] Testar com curl

2. **João - Semana 2:**
   - [ ] Integrar com `product.php` (botão "Adicionar")
   - [ ] Integrar com `cart.php` (listar itens)
   - [ ] Testes no navegador

3. **Lorenzo - Paralelo a João:**
   - [ ] `add_address.php`
   - [ ] `get_address.php`
   - [ ] `register_payment.php`
   - [ ] Testar com curl

4. **João - `checkout.php`** (depende de Lorenzo):
   - [ ] Receber `id_endereco` do POST
   - [ ] Criar `pedido` (INSERT)
   - [ ] Criar `item_pedido` para cada item do carrinho
   - [ ] Chamar `register_payment.php`
   - [ ] Limpar `$_SESSION['cart']`

5. **Testes End-to-End:**
   - [ ] Fluxo completo: Registro → Catálogo → Carrinho → Endereço → Pagamento → Sucesso

---

## Dicas Finais

- Use `curl` ou Postman para testar APIs primeiro (sem integração frontend)
- Valide sempre `isLoggedUser()` para proteger endpoints
- Use prepared statements para SQL injection protection
- Log de erros em `C:\xampp\apache\logs\error.log`
- Faça commits pequenos e frequentes (`git add . && git commit -m "..."`)
- Pull request ao terminar, aguarde revisão antes do merge

Boa sorte! 🚀
