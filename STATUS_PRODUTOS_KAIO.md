# Status - Gerenciamento de Produtos (Kaio Lima)

## ✅ IMPLEMENTADO

### APIs Completas
- ✅ `api/get_products.php` - Retorna todos os produtos (com filtro opcional por vendedor)
- ✅ `api/get_product.php?id=` - Retorna dados de um produto específico
- ✅ `api/create_product.php` - Vendedor cadastra produto (com upload de imagem)
  - Permite usuário comum se converter em vendedor automaticamente
- ✅ `api/update_product.php` - Vendedor edita produto (upload de imagem opcional)
- ✅ `api/delete_product.php` - Vendedor exclui produto (deleta arquivo de imagem)

### Frontend Integration
- ✅ `public/assets/scripts/sell.js` - Integrado com create_product.php
  - Coleta dados do formulário (título, descrição, preço, condição, imagem)
  - Suporta dados de onboarding do vendedor (nome, CPF)
  - Upload de imagem via drag-drop
  - Preview de anúncio
  - Redirect para catalog.php após sucesso

### Upload de Imagem
- ✅ Validação de tipo (JPEG, PNG, WebP)
- ✅ Geração de nome único (`prod_<timestamp>.<ext>`)
- ✅ Salvo em `/public/assets/uploads/`
- ✅ Retorna path relativo (`assets/uploads/...`) no JSON
- ✅ Delete automático de arquivo ao deletar produto

### Permissões
- ✅ Create: Qualquer usuário logado (comprador vira vendedor automaticamente) ou vendedor existente
- ✅ Update/Delete: Apenas o vendedor dono do produto
- ✅ Read: Público (sem autenticação necessária)

---

## 📊 Teste Realizado

```bash
# Verificar produtos existentes
$ curl "http://localhost/Projeto-SW-BD/Sola-Roxa/public/api/get_products.php"
→ {"success":true,"count":1,"products":[{"id_produto":3,"nome":"Nike Dunk Low","valor":"999.90"}]}
```

---

## 🔧 PRÓXIMOS PASSOS

### Para Kaio (Produtos)
- [ ] Testar create_product.php via formulário em seller-onboarding.php
- [ ] Validar upload de imagem (drag-drop funciona?)
- [ ] Testar update_product.php (editar existente)
- [ ] Testar delete_product.php (deletar com verificação de proprietário)

### Para João (Carrinho/Pedido)
- [ ] Integrar `api/get_products.php` no catalog.php
- [ ] Criar `api/add_to_cart.php` (adiciona id_produto à sessão)
- [ ] Criar `api/remove_from_cart.php`
- [ ] Criar `api/get_cart.php` (retorna produtos do carrinho)
- [ ] Criar `api/checkout.php` (cria pedido + itens)

### Para Lorenzo (Endereço/Pagamento)
- [ ] Integrar `api/add_address.php` (endereço de entrega)
- [ ] Integrar `api/choose_address.php` (seleciona endereço para pedido)
- [ ] Integrar `api/register_payment.php` (registra pagamento)

---

## 📁 Arquivos Modificados

```
✅ public/api/get_products.php
✅ public/api/get_product.php
✅ public/api/create_product.php
✅ public/api/update_product.php
✅ public/api/delete_product.php
✅ public/assets/scripts/sell.js
✅ public/assets/uploads/ [PASTA CRIADA]
```

---

## 🗂️ Schema - Tabela `produto`

| Campo | Tipo | Restrições | Descrição |
|-------|------|-----------|-----------|
| `id_produto` | INT(11) | PK, AUTO_INCREMENT | ID único |
| `id_vendedor` | INT(11) | FK → vendedor | Dono do produto |
| `nome` | VARCHAR(255) | NOT NULL | Título |
| `descricao` | TEXT | DEFAULT NULL | Descrição longa |
| `imagem_url` | VARCHAR(255) | DEFAULT NULL | Path relativo ao upload |
| `valor` | DECIMAL(10,2) | NOT NULL | Preço |
| `estoque` | INT(11) | DEFAULT 0 | Quantidade |
| `data_cadastro` | DATETIME | DEFAULT CURRENT_TIMESTAMP | Quando foi criado |
| `estado` | ENUM | DEFAULT 'Novo' | Novo/Semi-Novo/Usado/Sem caixa |

---

## ✨ Features Principais

1. **CRUD Completo**: Criar, ler, atualizar, deletar produtos
2. **Upload de Imagem**: Drag-drop, validação de tipo, salvo em disco
3. **Onboarding Automático**: Comprador vira vendedor ao criar primeiro produto
4. **Validação**: Apenas dono pode editar/deletar seu produto
5. **Soft Delete**: Imagem removida do disco ao deletar produto
