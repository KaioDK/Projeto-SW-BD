# PRÓXIMA FASE - João Pedro & Lorenzo

## 🟢 João Pedro - Carrinho, Pedido e Itens de Pedido

### Tarefas:
1. **Criar APIs de Carrinho:**
   - `api/add_to_cart.php` → adiciona `id_produto` à sessão `$_SESSION['cart'][]`
   - `api/remove_from_cart.php` → remove produto do carrinho
   - `api/get_cart.php` → retorna conteúdo do carrinho com dados dos produtos

2. **Integrar Frontend:**
   - `public/product.php` → Botão "Adicionar ao Carrinho" → chamada para `add_to_cart.php`
   - `public/cart.php` → Listar itens do carrinho com dados (nome, preço, imagem, quantidade)
   - `public/assets/scripts/cart.js` → Já existe, integrar com APIs

3. **Criar API de Checkout:**
   - `api/checkout.php` → Recebe carrinho da sessão e cria:
     - 1 registro em `pedido` (id_cliente, id_endereco, valor_total, data_pedido)
     - N registros em `item_pedido` (id_pedido, id_produto, quantidade)
     - Limpa `$_SESSION['cart']` após sucesso

### Database Schema Necessário:
```sql
-- Verificar que essas tabelas existem
SELECT * FROM pedido;  -- (id_pedido, id_cliente, id_endereco, valor_total, data_pedido, status)
SELECT * FROM item_pedido;  -- (id_pedido, id_produto, quantidade)
```

### Fluxo:
```
catalog.php → [clica em produto] → product.php 
            → [Adicionar ao Carrinho] → add_to_cart.php 
            → cart.php [mostra itens] 
            → [Finalizar] → checkout.php 
            → pedido criado ✅
```

---

## 🟠 Lorenzo - Endereço e Pagamento

### Tarefas:
1. **Criar APIs de Endereço:**
   - `api/add_address.php` → INSERT INTO endereco (id_cliente, rua, numero, bairro, cidade, estado)
   - `api/get_address.php` → SELECT FROM endereco WHERE id_cliente = ?
   - `api/choose_address.php` → Define qual endereço usar no pedido (session ou banco)

2. **Criar API de Pagamento:**
   - `api/register_payment.php` → INSERT INTO pagamento (id_pedido, metodo, status)
     - Métodos: PIX, CARTAO, BOLETO
     - Status: PENDENTE → APROVADO (simulado/automático por enquanto)

3. **Integrar Frontend:**
   - `public/cart.php` → [Step 2] Formulário de Endereço
   - `public/cart.php` → [Step 3] Seleção de método de pagamento
   - Após checkout → chamar `register_payment.php`

### Database Schema Necessário:
```sql
-- Verificar estrutura
SHOW CREATE TABLE endereco;  -- (id_endereco, id_cliente, rua, numero, bairro, cidade, estado)
SHOW CREATE TABLE pagamento;  -- (id_pagamento, id_pedido, metodo, status, data_pagamento)
```

### Fluxo:
```
cart.php [Step 2] → add_address.php 
        [Step 3] → choose_address.php + seleção de método 
        → register_payment.php 
        → checkout.php 
        → "Obrigado!" modal ✅
```

---

## 📋 Checklist de Conclusão

- [ ] João: APIs de carrinho completas
- [ ] João: Integração com product.php + cart.php
- [ ] João: Checkout criando pedidos no banco
- [ ] Lorenzo: APIs de endereço completas
- [ ] Lorenzo: API de pagamento funcional
- [ ] Lorenzo: Fluxo de checkout → pedido → pagamento funcionando
- [ ] Testes end-to-end: Comprador registra → vê produtos → compra → sucesso

---

## ⚡ Dicas Técnicas

### Sessão do Carrinho
```php
// Adicionar ao carrinho
$_SESSION['cart'][] = ['id_produto' => 5, 'quantidade' => 2];

// Listar carrinho
foreach ($_SESSION['cart'] as $item) {
    // Buscar dados do produto: SELECT FROM produto WHERE id_produto = ?
}

// Calcular total
$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['preco'] * $item['quantidade'];
}
```

### Permissões
- Qualquer usuário logado pode usar carrinho
- Apenas id_cliente da sessão pode criar pedido (seu próprio)
- Endereço deve pertencer ao id_cliente

### Próximas Fases
- Após tudo funcionar → Integração com frontends mais polidos
- Payment gateway real (Stripe, PagSeguro, etc.)
- Email de confirmação de pedido
- Tracking de envio
