# 📦 Explicação Completa do CRUD de Produtos (Kaio)

## 🎯 O que é CRUD?

**CRUD = Create, Read, Update, Delete** - As 4 operações básicas para gerenciar dados

No Sola Roxa, o CRUD permite que vendedores gerenciem seus produtos.

---

## 1️⃣ CREATE - Criar Produto (`create_product.php`)

### 📝 O que faz?
Cria um novo produto e salva no banco de dados com imagem opcional.

### 🔄 Fluxo Completo:

```
┌─────────────────────────────────────────────────────────────┐
│ 1. USUÁRIO CLICA EM "VENDER"                                │
│    → Abre seller-onboarding.php                             │
└─────────────────┬───────────────────────────────────────────┘
                  ↓
┌─────────────────────────────────────────────────────────────┐
│ 2. PREENCHE FORMULÁRIO (sell.js)                            │
│    - Título do produto                                       │
│    - Preço                                                   │
│    - Descrição                                               │
│    - Estoque                                                 │
│    - Condição (Novo/Usado)                                  │
│    - Imagem (drag/drop ou clique)                           │
│    - Se PRIMEIRO PRODUTO: Dados do vendedor (nome/CPF)      │
└─────────────────┬───────────────────────────────────────────┘
                  ↓
┌─────────────────────────────────────────────────────────────┐
│ 3. ENVIA PARA create_product.php (POST com FormData)        │
│    - Validação de dados (título, preço obrigatórios)        │
│    - Arquivo de imagem                                       │
│    - Dados do seller (se conversão necessária)              │
└─────────────────┬───────────────────────────────────────────┘
                  ↓
┌─────────────────────────────────────────────────────────────┐
│ 4. VERIFICAÇÕES NO BACKEND                                  │
│                                                              │
│    A) SELLER JÁ EXISTE?                                     │
│       └─ SIM: Usa id_vendedor da sessão                    │
│                                                              │
│    B) NÃO É SELLER, MAS TEM DADOS ONBOARDING?               │
│       └─ SIM: Cria novo vendedor com nome/CPF              │
│       └─ Atualiza sessão com vendedor criado               │
│       └─ Usa novo id_vendedor                               │
│                                                              │
│    C) NÃO É SELLER E NEM DADOS ONBOARDING?                  │
│       └─ ERRO: "Only sellers can create products"          │
└─────────────────┬───────────────────────────────────────────┘
                  ↓
┌─────────────────────────────────────────────────────────────┐
│ 5. PROCESSA IMAGEM (se enviada)                             │
│    - Valida tipo (JPEG, PNG, WebP)                          │
│    - Gera nome único: prod_<uniqid>.<ext>                  │
│    - Move para: public/assets/uploads/                      │
│    - Salva caminho relativo: "assets/uploads/prod_..."      │
└─────────────────┬───────────────────────────────────────────┘
                  ↓
┌─────────────────────────────────────────────────────────────┐
│ 6. INSERE NO BANCO (tabela produto)                         │
│    INSERT INTO produto (                                    │
│        id_vendedor,        ← Quem criou                     │
│        nome,               ← Título                          │
│        descricao,          ← Descrição                       │
│        imagem_url,         ← Caminho da imagem              │
│        valor,              ← Preço                           │
│        estoque,            ← Quantidade disponível           │
│        estado              ← Novo/Usado                      │
│    )                                                         │
└─────────────────┬───────────────────────────────────────────┘
                  ↓
┌─────────────────────────────────────────────────────────────┐
│ 7. RETORNA RESPOSTA JSON                                    │
│    { "success": true, "id_produto": 3 }                     │
│                                                              │
│ 8. JAVASCRIPT REDIRECIONA PARA catalog.php                  │
└─────────────────────────────────────────────────────────────┘
```

### 🔑 Código-chave:

```php
// 1. Verifica se é vendedor (ou converte)
if (!isLoggedSeller()) {
    if (isLoggedUser() && !empty($_POST['seller_name'])) {
        // Cria novo vendedor
        $insertVend = $pdo->prepare('INSERT INTO vendedor (...) VALUES (?, ?, ?, ?)');
        $_SESSION['vendedor'] = ['id' => $id_vendedor, ...];
    } else {
        // ERRO: não pode criar
        http_response_code(403);
    }
}

// 2. Valida nome e preço (obrigatórios)
$nome = trim($_POST['title'] ?? '');
$valor = trim($_POST['price'] ?? '');
if (!$nome || $valor === '') {
    http_response_code(400);
}

// 3. Processa imagem
$filename = uniqid('prod_', true) . '.' . $ext;
move_uploaded_file($file['tmp_name'], UPLOAD_DIR . $filename);
$imagem_url = 'assets/uploads/' . $filename;

// 4. Insere produto
$stmt = $pdo->prepare('INSERT INTO produto (...) VALUES (?, ?, ?, ?, ?, ?, ?)');
$stmt->execute([$id_vendedor, $nome, $descricao, $imagem_url, $valor, $estoque, $estado]);
```

### 📊 Exemplo na Prática:

```
ENTRADA:
POST /api/create_product.php
title=Nike Dunk Low
price=999.90
stock=5
estado=Novo
image=<arquivo JPEG>

BANCO DE DADOS (antes):
produto: 2 linhas

BANCO DE DADOS (depois):
produto: 3 linhas
├─ id_produto=1, nome="Air Force 1", id_vendedor=1
├─ id_produto=2, nome="Yeezy", id_vendedor=1
└─ id_produto=3, nome="Nike Dunk Low", id_vendedor=1 ✅ NOVO

ARQUIVO (novo):
public/assets/uploads/prod_67345abc123.jpeg ✅ SALVO

RESPOSTA:
{ "success": true, "id_produto": 3 }
```

---

## 2️⃣ READ - Ler Produtos

### A) `get_products.php` - Listar TODOS

#### 📝 O que faz?
Retorna lista de todos os produtos com nome do vendedor.

#### 🔄 Fluxo:

```
GET /api/get_products.php (sem parâmetros)
        ↓
SELECT p.*, v.nome AS vendedor_nome 
FROM produto p 
LEFT JOIN vendedor v ON p.id_vendedor = v.id_vendedor
        ↓
Retorna JSON com todos os produtos
```

#### 🔑 Código:

```php
$sql = 'SELECT p.id_produto, p.nome, p.valor, p.imagem_url, ... 
        FROM produto p 
        LEFT JOIN vendedor v ON p.id_vendedor = v.id_vendedor';
$stmt = $pdo->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll();
echo json_encode(['success'=>true, 'products'=>$products]);
```

#### 💡 Exemplo:

```
RESPOSTA:
{
  "success": true,
  "products": [
    {
      "id_produto": 1,
      "id_vendedor": 1,
      "nome": "Air Force 1",
      "valor": "899.90",
      "imagem_url": "assets/uploads/prod_abc.jpeg",
      "estoque": 10,
      "estado": "Novo",
      "vendedor_nome": "João Zapata"
    },
    {
      "id_produto": 3,
      "id_vendedor": 1,
      "nome": "Nike Dunk Low",
      "valor": "999.90",
      "imagem_url": "assets/uploads/prod_def.jpeg",
      "estoque": 5,
      "estado": "Novo",
      "vendedor_nome": "João Zapata"
    }
  ]
}
```

### B) `get_products.php?seller=1` - Produtos de UM Vendedor

#### 🔄 Fluxo:

```
GET /api/get_products.php?seller=1
        ↓
Adiciona WHERE p.id_vendedor = 1
        ↓
Retorna apenas produtos de vendedor com id=1
```

#### 🔑 Código:

```php
if (isset($_GET['seller'])) {
    $sql .= ' WHERE p.id_vendedor = ?';
    $params[] = $_GET['seller'];
}
```

### C) `get_product.php?id=3` - DETALHES de UM Produto

#### 📝 O que faz?
Retorna dados completos de um produto específico.

#### 🔄 Fluxo:

```
GET /api/get_product.php?id=3
        ↓
SELECT * FROM produto WHERE id_produto = 3
        ↓
Se encontrou: Retorna objeto produto
Se não encontrou: Erro 404
```

#### 💡 Exemplo:

```
ENTRADA:
GET /api/get_product.php?id=3

RESPOSTA:
{
  "id_produto": 3,
  "id_vendedor": 1,
  "nome": "Nike Dunk Low",
  "descricao": "Tênis de skate clássico em excelente estado",
  "imagem_url": "assets/uploads/prod_def.jpeg",
  "valor": "999.90",
  "estoque": 5,
  "data_cadastro": "2025-11-18 10:30:00",
  "estado": "Novo",
  "vendedor_nome": "João Zapata"
}
```

---

## 3️⃣ UPDATE - Atualizar Produto (`update_product.php`)

### 📝 O que faz?
Permite vendedor editar seus próprios produtos (título, preço, estoque, imagem, etc).

### 🔄 Fluxo:

```
┌──────────────────────────────────────────────────┐
│ 1. VENDEDOR CLICA "EDITAR" NO PRODUTO            │
└──────────────┬───────────────────────────────────┘
               ↓
┌──────────────────────────────────────────────────┐
│ 2. VALIDAÇÕES NO BACKEND                         │
│                                                  │
│ ✓ REQUEST METHOD deve ser POST                  │
│ ✓ id_produto obrigatório                        │
│ ✓ Usuário deve estar logado como SELLER         │
│ ✓ SELLER DEVE SER DONO DO PRODUTO               │
│   (id_vendedor no BD == $_SESSION['vendedor']['id'])
└──────────────┬───────────────────────────────────┘
               ↓
┌──────────────────────────────────────────────────┐
│ 3. CONSTRÓI UPDATE DINÂMICO                      │
│                                                  │
│ Se title enviado:  UPDATE ... nome = ?          │
│ Se price enviado:  UPDATE ... valor = ?         │
│ Se stock enviado:  UPDATE ... estoque = ?       │
│ Se image enviado:  Processa e UPDATE imagem_url│
│                                                  │
│ Só atualiza campos que foram alterados!         │
└──────────────┬───────────────────────────────────┘
               ↓
┌──────────────────────────────────────────────────┐
│ 4. EXECUTA UPDATE                                │
│    UPDATE produto SET ...                        │
│    WHERE id_produto = ?                          │
└──────────────┬───────────────────────────────────┘
               ↓
┌──────────────────────────────────────────────────┐
│ 5. RETORNA RESPOSTA JSON                         │
│    { "success": true, "updated": true }          │
└──────────────────────────────────────────────────┘
```

### 🔑 Código-chave:

```php
// 1. Verifica propriedade
if (!isLoggedSeller()) return erro;

$check = $pdo->prepare('SELECT id_vendedor FROM produto WHERE id_produto = ?');
$check->execute([$id]);
$p = $check->fetch();
if (!$p || $p['id_vendedor'] != $_SESSION['vendedor']['id']) {
    return erro 403; // Não é dono!
}

// 2. Constrói UPDATE dinâmico
$fields = [];
$params = [];
if (isset($_POST['title'])) {
    $fields[] = 'nome = ?';
    $params[] = $_POST['title'];
}
if (isset($_POST['price'])) {
    $fields[] = 'valor = ?';
    $params[] = $_POST['price'];
}
// ... mais campos ...

// 3. Executa
$sql = 'UPDATE produto SET ' . implode(', ', $fields) . ' WHERE id_produto = ?';
$params[] = $id;
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
```

### 💡 Exemplo:

```
ENTRADA:
POST /api/update_product.php
id=3
title=Nike Dunk Low Retro
price=1099.90
stock=3

BANCO (antes):
id_produto=3, nome="Nike Dunk Low", valor="999.90", estoque=5

BANCO (depois):
id_produto=3, nome="Nike Dunk Low Retro", valor="1099.90", estoque=3 ✅

RESPOSTA:
{ "success": true, "updated": true }
```

### ⚠️ Segurança: Validação de Dono

```
Vendedor 1 tenta editar produto de Vendedor 2:
id_produto=5 (dono: Vendedor 2)
$_SESSION['vendedor']['id'] = 1

VERIFICAÇÃO:
SELECT id_vendedor FROM produto WHERE id_produto = 5
Retorna: id_vendedor = 2

2 != 1 ✗

RESPOSTA:
403 Forbidden
{ "error": "Not owner" }
```

---

## 4️⃣ DELETE - Deletar Produto (`delete_product.php`)

### 📝 O que faz?
Remove um produto do banco E deleta a imagem do servidor.

### 🔄 Fluxo:

```
┌──────────────────────────────────────────────────┐
│ 1. VENDEDOR CLICA "DELETAR" PRODUTO              │
└──────────────┬───────────────────────────────────┘
               ↓
┌──────────────────────────────────────────────────┐
│ 2. VALIDAÇÕES                                    │
│                                                  │
│ ✓ REQUEST METHOD = POST                         │
│ ✓ Usuário é SELLER                              │
│ ✓ SELLER É DONO DO PRODUTO                      │
└──────────────┬───────────────────────────────────┘
               ↓
┌──────────────────────────────────────────────────┐
│ 3. BUSCA IMAGEM DO PRODUTO                       │
│    SELECT id_vendedor, imagem_url               │
│    FROM produto WHERE id_produto = ?            │
│                                                  │
│    Se imagem_url não vazio:                     │
│    Calcula caminho: public/assets/uploads/...   │
│    Deleta arquivo do disco                      │
└──────────────┬───────────────────────────────────┘
               ↓
┌──────────────────────────────────────────────────┐
│ 4. DELETA DO BANCO                               │
│    DELETE FROM produto WHERE id_produto = ?     │
└──────────────┬───────────────────────────────────┘
               ↓
┌──────────────────────────────────────────────────┐
│ 5. RETORNA SUCESSO                               │
│    { "success": true }                           │
└──────────────────────────────────────────────────┘
```

### 🔑 Código-chave:

```php
// 1. Verifica propriedade
$check = $pdo->prepare('SELECT id_vendedor, imagem_url FROM produto WHERE id_produto = ?');
$check->execute([$id]);
$p = $check->fetch();
if (!$p || $p['id_vendedor'] != $_SESSION['vendedor']['id']) {
    return erro 403;
}

// 2. Deleta imagem do disco
if ($p['imagem_url']) {
    $path = __DIR__ . '/../' . $p['imagem_url'];
    if (file_exists($path)) {
        unlink($path); // Remove arquivo
    }
}

// 3. Deleta do banco
$stmt = $pdo->prepare('DELETE FROM produto WHERE id_produto = ?');
$stmt->execute([$id]);
```

### 💡 Exemplo:

```
ENTRADA:
POST /api/delete_product.php
id=3

BANCO (antes):
id_produto=3, imagem_url="assets/uploads/prod_def.jpeg"

DISCO (antes):
public/assets/uploads/prod_def.jpeg (arquivo JPEG existe)

BANCO (depois):
❌ id_produto=3 (deletado)

DISCO (depois):
❌ public/assets/uploads/prod_def.jpeg (deletado)

RESPOSTA:
{ "success": true }
```

---

## 🔐 Segurança Implementada

### 1. **Autenticação**
```php
requireUser()     // Apenas usuários logados
requireSeller()   // Apenas vendedores
isLoggedUser()    // Verifica se é comprador
isLoggedSeller()  // Verifica se é vendedor
```

### 2. **Autorização (Proprietário)**
```php
// Apenas criador pode editar/deletar
$check = $pdo->prepare('SELECT id_vendedor FROM produto WHERE id_produto = ?');
if ($p['id_vendedor'] != $_SESSION['vendedor']['id']) {
    // ERRO: Não é proprietário
}
```

### 3. **Validação de Entrada**
```php
$nome = trim($_POST['title'] ?? '');
if (!$nome) { /* erro */ }

// Validação de tipo de arquivo
if (!in_array($file['type'], ['image/jpeg','image/png','image/webp'])) {
    /* erro */
}
```

### 4. **SQL Injection Prevention**
```php
// ✅ SEGURO: Prepared Statements
$stmt = $pdo->prepare('INSERT INTO produto (...) VALUES (?, ?, ...)');
$stmt->execute([$id, $nome, ...]);

// ❌ INSEGURO: String concatenation
$sql = "SELECT * FROM produto WHERE id = " . $_GET['id'];
```

---

## 📱 Como tudo funciona integrado

### **Fluxo de um Vendedor**

```
1. REGISTRO COMO USUÁRIO
   Preenche login.php
   → register_usuario.php cria cuenta
   → $_SESSION['user'] criada
   
2. CLICA EM "VENDER"
   → seller-onboarding.php abre
   
3. CRIA PRIMEIRO PRODUTO
   Preenche sell.js (título, preço, imagem, dados do vendedor)
   → create_product.php:
     - Verifica: Não é vendedor YET
     - Verifica: Tem dados de onboarding (nome/CPF)
     - Cria registro em tabela vendedor
     - Atualiza $_SESSION['vendedor']
     - Salva imagem
     - Insere em tabela produto
   → Redireciona para catalog.php
   
4. EDITA PRODUTO
   Clica "editar"
   → update_product.php:
     - Verifica: É vendedor
     - Verifica: É DONO do produto
     - Atualiza campos modificados
     - Se imagem: processa nova
   → Volta para seller-onboarding.php
   
5. DELETA PRODUTO
   Clica "deletar"
   → delete_product.php:
     - Verifica: É vendedor
     - Verifica: É DONO
     - Remove imagem do disco
     - Remove do banco
   → Volta ao listar produtos
```

### **Fluxo de um Comprador**

```
1. REGISTRO
   login.php → register_usuario.php
   → $_SESSION['user'] criada
   
2. PROCURA PRODUTOS
   catalog.php
   → GET /api/get_products.php
   → Mostra todos os produtos com foto/nome/preço
   
3. VÊ DETALHES
   Clica no produto
   → product.php?id=3
   → GET /api/get_product.php?id=3
   → Mostra descricao completa, estoque, vendedor
   
4. ADICIONA AO CARRINHO (João implementará)
   Clica "Adicionar ao Carrinho"
   → POST /api/add_to_cart.php
   → $_SESSION['cart'][] adicionado
   
5. CHECKOUT (João implementará)
   cart.php
   → POST /api/checkout.php (cria pedido)
   → POST /api/register_payment.php (cria pagamento)
```

---

## 🎯 Resumo Rápido

| Operação | Endpoint | Método | Requer | Faz |
|----------|----------|--------|--------|-----|
| **CREATE** | `create_product.php` | POST | Seller (ou dados onboarding) | Insere produto + salva imagem |
| **READ 1** | `get_products.php` | GET | Nenhum | Lista todos produtos |
| **READ 2** | `get_products.php?seller=X` | GET | Nenhum | Lista produtos de vendedor X |
| **READ 3** | `get_product.php?id=X` | GET | Nenhum | Detalhes do produto X |
| **UPDATE** | `update_product.php` | POST | Seller (dono) | Edita campos do produto |
| **DELETE** | `delete_product.php` | POST | Seller (dono) | Deleta produto e imagem |

---

## ✅ Testes Realizados

```
✓ Create: Cadastrou Nike Dunk Low (id_produto=3)
✓ Read All: Retornou 1 produto com vendedor_nome
✓ Read One: Retornou detalhes de id_produto=3
✓ Update: Atualizaria preço/nome (sem permissão para testar)
✓ Delete: Deletaria produto e imagem (sem permissão para testar)

❌ Testes pendentes:
  - Update/Delete com credenciais de vendedor
  - Múltiplas imagens
  - Validação de CPF duplicado na conversão
```

Agora você entende como o CRUD funciona! 🚀
