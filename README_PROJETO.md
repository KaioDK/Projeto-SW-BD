# Sola Roxa - Marketplace de Sneakers
## Status Geral do Projeto (Nov 2025)

---

## ✅ FASES CONCLUÍDAS

### 🟣 VITOR GONÇALVES - Autenticação e Sessões
**Status: 100% Concluído** ✅

- ✅ Database connection (PDO)
- ✅ Login/Registro de usuário (comprador)
- ✅ Login/Registro de vendedor
- ✅ Logout com destruição de sessão
- ✅ Proteção de rotas (`requireUser()`, `requireSeller()`)
- ✅ Separação de contextos (`$_SESSION['user']` vs `$_SESSION['vendedor']`)
- ✅ Geração automática de CPF único (quando não fornecido)
- ✅ Upload de imagem de avatar/loja

**Documentação:** `STATUS_AUTENTICACAO.md`

**Testes:** Todos 7 testes passaram ✅

---

### 🔵 KAIO LIMA - Gerenciamento de Produtos
**Status: 100% Concluído** ✅

- ✅ `get_products.php` - Listar todos (com filtro por vendedor)
- ✅ `get_product.php?id=` - Detalhe de um produto
- ✅ `create_product.php` - Criar com upload de imagem
- ✅ `update_product.php` - Editar com validação de proprietário
- ✅ `delete_product.php` - Deletar com limpeza de arquivo
- ✅ Integração com `sell.js` (seller-onboarding.php)
- ✅ Upload de imagem em `/public/assets/uploads/`
- ✅ Onboarding automático: comprador vira vendedor ao criar produto

**Documentação:** `STATUS_PRODUTOS_KAIO.md`

**DB Test:** 1 produto existente (Nike Dunk Low) ✅

---

## ⏳ PRÓXIMAS FASES

### 🟢 JOÃO PEDRO - Carrinho, Pedido e Itens de Pedido
**Status: Em Começar**

| Tarefa | Status |
|--------|--------|
| `api/add_to_cart.php` | ⏳ |
| `api/remove_from_cart.php` | ⏳ |
| `api/get_cart.php` | ⏳ |
| `api/checkout.php` | ⏳ |
| Integração com `product.php` | ⏳ |
| Integração com `cart.php` | ⏳ |

**Documentação:** `TAREFAS_JOAO_LORENZO.md`

---

### 🟠 LORENZO - Endereço e Pagamento
**Status: Em Começar**

| Tarefa | Status |
|--------|--------|
| `api/add_address.php` | ⏳ |
| `api/get_address.php` | ⏳ |
| `api/choose_address.php` | ⏳ |
| `api/register_payment.php` | ⏳ |
| Integração com `cart.php` | ⏳ |

**Documentação:** `TAREFAS_JOAO_LORENZO.md`

---

## 🗂️ Estrutura de Banco de Dados

### Tabelas Implementadas

```
┌─────────────────────┐
│  usuario            │ ← Login/Register (Vitor)
├─────────────────────┤
│ • id_cliente (PK)   │
│ • nome              │
│ • email (UNIQUE)    │
│ • senha (HASH)      │
│ • CPF (UNIQUE)      │
└─────────────────────┘

┌─────────────────────┐
│  vendedor           │ ← Login/Register (Vitor)
├─────────────────────┤
│ • id_vendedor (PK)  │
│ • nome              │
│ • email (UNIQUE)    │
│ • senha (HASH)      │
│ • CPF (UNIQUE)      │
└─────────────────────┘

┌──────────────────────┐
│  produto             │ ← CRUD (Kaio)
├──────────────────────┤
│ • id_produto (PK)    │
│ • id_vendedor (FK)   │
│ • nome               │
│ • descricao          │
│ • imagem_url         │
│ • valor              │
│ • estoque            │
│ • estado (ENUM)      │
│ • data_cadastro      │
└──────────────────────┘

┌──────────────────────┐
│  pedido              │ ← Criar (João)
├──────────────────────┤
│ • id_pedido (PK)     │
│ • id_cliente (FK)    │
│ • id_endereco (FK)   │
│ • valor_total        │
│ • data_pedido        │
│ • status             │
└──────────────────────┘

┌──────────────────────┐
│  item_pedido         │ ← Criar (João)
├──────────────────────┤
│ • id_pedido (FK)     │
│ • id_produto (FK)    │
│ • quantidade         │
│ • preco_unitario     │
└──────────────────────┘

┌──────────────────────┐
│  endereco            │ ← CRUD (Lorenzo)
├──────────────────────┤
│ • id_endereco (PK)   │
│ • id_cliente (FK)    │
│ • rua                │
│ • numero             │
│ • bairro             │
│ • cidade             │
│ • estado             │
└──────────────────────┘

┌──────────────────────┐
│  pagamento           │ ← Criar (Lorenzo)
├──────────────────────┤
│ • id_pagamento (PK)  │
│ • id_pedido (FK)     │
│ • metodo (ENUM)      │
│ • status (ENUM)      │
│ • data_pagamento     │
└──────────────────────┘
```

---

## 📡 Fluxo Completo de Compra (Esperado após conclusão)

```
1. [VITOR] Usuário registra como comprador
   POST /api/register_usuario.php
   ↓
2. [VITOR] Usuário faz login
   POST /api/login_usuario.php
   ↓
3. [KAIO] Visualiza catálogo de produtos
   GET /api/get_products.php
   ↓
4. [KAIO] Visualiza detalhes de um produto
   GET /api/get_product.php?id=3
   ↓
5. [JOÃO] Adiciona produto ao carrinho
   POST /api/add_to_cart.php
   ↓
6. [JOÃO] Visualiza carrinho
   GET /api/get_cart.php
   ↓
7. [LORENZO] Adiciona endereço de entrega
   POST /api/add_address.php
   ↓
8. [LORENZO] Seleciona método de pagamento
   POST /api/choose_address.php
   ↓
9. [LORENZO] Registra pagamento
   POST /api/register_payment.php
   ↓
10. [JOÃO] Finaliza compra (cria pedido)
    POST /api/checkout.php
    ↓
✅ Pedido criado com sucesso!
```

---

## 📂 Documentação Disponível

| Arquivo | Conteúdo |
|---------|----------|
| `STATUS_AUTENTICACAO.md` | Vitor: Login/autenticação/proteção de rotas |
| `STATUS_PRODUTOS_KAIO.md` | Kaio: APIs de produtos, CRUD, upload |
| `TAREFAS_JOAO_LORENZO.md` | João e Lorenzo: próximas tarefas |
| `TESTING_GUIDE.md` | Guia de testes com exemplos SQL/curl |
| `AJUSTES_REALIZADOS.md` | Resumo de correções aplicadas |

---

## 🚀 Próximas Ações

1. **João (Carrinho):**
   - Comece pelas APIs de carrinho (`add_to_cart`, `get_cart`, `remove_from_cart`)
   - Integre com `product.php` e `cart.php`
   - Teste com curl antes de integrar no frontend

2. **Lorenzo (Pagamento):**
   - Paralelo a João: implemente APIs de endereço e pagamento
   - Valide que endereço pertence ao usuário logado
   - Teste checkout completo

3. **Testes End-to-End:**
   - Após João e Lorenzo: teste fluxo completo
   - Registrar → Catálogo → Carrinho → Checkout → Pedido criado

4. **Merge & Deploy:**
   - Branch `vitor-auth` → `main` (Vitor)
   - Branch `kaio-produtos` → `main` (Kaio, se houver branch)
   - Branch `joao-carrinho` → `main` (João)
   - Branch `lorenzo-pagamento` → `main` (Lorenzo)

---

## 📞 Contato / Suporte

Se encontrar erros:
1. Verifique `error_log` em `C:\xampp\apache\logs\error.log`
2. Ative debug temporário na API (cópia de `register_usuario.php` com detail)
3. Teste via curl antes de integrar no frontend

---

**Projeto iniciado:** Nov 2025
**Última atualização:** Nov 18, 2025
**Status Global:** 40% Concluído (2/5 fases)
