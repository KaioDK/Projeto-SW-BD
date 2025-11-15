# Guia de Testes - Sistema de Autenticação (Vitor)

## ✅ AJUSTES REALIZADOS

### 1. **login.js** - Integração com APIs
   - ✓ Alterado para fazer requisições reais às APIs
   - ✓ Login agora envia POST para `api/login_usuario.php`
   - ✓ Registro agora envia POST para `api/register_usuario.php`
   - ✓ Após sucesso, redireciona para `index.php`
   - ✓ Validação de senhas coincidentes no registro

### 2. **login.js** - Correção de função helper
   - ✓ Corrigido `qs()` para `document.querySelector()`

### 3. **Pasta de uploads**
   - ✓ Criada: `/public/assets/uploads/`

## 📋 CHECKLIST DE TESTES

### **TESTE 1: Registro de Usuário (Comprador)**
**Objetivo:** Verificar se um novo usuário consegue se registrar

**Passos:**
1. Acesse `http://localhost/Projeto-SW-BD/Sola-Roxa/public/auth.php`
2. Clique em "Cadastre-se"
3. Preencha:
   - Nome: `João Silva`
   - Email: `joao@test.com`
   - Senha: `senha123`
   - Confirmar senha: `senha123`
4. Clique em "Cadastrar"

**Esperado:**
- ✓ Mensagem: "Cadastro realizado! Faça login agora."
- ✓ Formulário volta para login
- ✓ No banco de dados, tabela `usuario` deve ter um novo registro

**Comando SQL para verificar:**
```sql
SELECT * FROM usuario WHERE email = 'joao@test.com';
```

---

### **TESTE 2: Login de Usuário (Comprador)**
**Objetivo:** Verificar se o usuário consegue fazer login

**Passos:**
1. Em `auth.php`, preencha:
   - Email: `joao@test.com`
   - Senha: `senha123`
2. Clique em "Entrar"

**Esperado:**
- ✓ Mensagem: "Login realizado com sucesso!"
- ✓ Redireciona para `index.php`
- ✓ `$_SESSION['user']` está setado (visível em ferramentas de dev)
- ✓ Cookies de sessão aparecem no navegador

**Teste com credenciais erradas:**
- Email: `joao@test.com` + Senha: `senha_errada`
- Esperado: "Invalid credentials"

---

### **TESTE 3: Proteção de cart.php**
**Objetivo:** Verificar se página de carrinho é protegida

**Passos:**
1. **Sem estar logado:** Acesse `http://localhost/Projeto-SW-BD/Sola-Roxa/public/cart.php`
   - Esperado: ✓ Redireciona para `auth.php`

2. **Após login:** Acesse `cart.php` novamente
   - Esperado: ✓ Carrega a página normalmente

---

### **TESTE 4: Registro de Vendedor**
**Objetivo:** Verificar se um novo vendedor consegue se registrar

**Obs:** Você precisará acessar a página de registro de vendedor diretamente ou via um link que ainda não existe. Para testar, você pode:
- Fazer requisição POST manualmente via `curl` ou Postman
- Ou esperar pela integração no frontend

**Teste com Postman/curl:**
```bash
POST http://localhost/Projeto-SW-BD/Sola-Roxa/public/api/register_vendedor.php
Content-Type: application/x-www-form-urlencoded

name=Loja Teste&email=vendedor@test.com&password=vendedor123
```

**Esperado:**
- ✓ Resposta: `{"success": true, "id": <id_novo>}`
- ✓ Novo registro em tabela `vendedor`

---

### **TESTE 5: Login de Vendedor**
**Objetivo:** Verificar se o vendedor consegue fazer login

**Teste com Postman/curl:**
```bash
POST http://localhost/Projeto-SW-BD/Sola-Roxa/public/api/login_vendedor.php
Content-Type: application/x-www-form-urlencoded

email=vendedor@test.com&password=vendedor123
```

**Esperado:**
- ✓ Resposta: `{"success": true, "vendedor": {...}}`
- ✓ `$_SESSION['vendedor']` está setado

---

### **TESTE 6: Proteção de seller-onboarding.php**
**Objetivo:** Verificar se página de venda é protegida

**Passos:**
1. **Sem estar logado como vendedor:** Acesse `seller-onboarding.php`
   - Esperado: ✓ Redireciona para `auth.php`

2. **Após login como vendedor:** Acesse `seller-onboarding.php` novamente
   - Esperado: ✓ Carrega a página normalmente

---

### **TESTE 7: Logout**
**Objetivo:** Verificar se logout funciona para ambos (usuário e vendedor)

**Teste com Postman/curl:**
```bash
POST http://localhost/Projeto-SW-BD/Sola-Roxa/public/api/logout.php
```

**Esperado:**
- ✓ Resposta: `{"success": true}`
- ✓ Ambas as sessões (`$_SESSION['user']` e `$_SESSION['vendedor']`) são destruídas
- ✓ Tentativa de acessar `cart.php` redireciona para `auth.php`

---

## 🔍 VERIFICAÇÕES ADICIONAIS

### **Verificar banco de dados:**
```sql
-- Verificar usuários
SELECT id, nome, email FROM usuario;

-- Verificar vendedores
SELECT id, nome, email FROM vendedor;

-- Verificar senhas (devem estar hashadas, não em texto plano)
SELECT email, LEFT(senha, 20) as senha_hash FROM usuario LIMIT 1;
```

### **Verificar logs de erro PHP:**
- No XAMPP, verifique: `C:\xampp\apache\logs\error.log`
- Ou nas Developer Tools do navegador (Console)

### **Testar com JavaScript Console:**
```javascript
// Verificar se sessão está ativa
fetch('api/check_session.php').then(r => r.json()).then(d => console.log(d));
```

---

## ⚠️ POSSÍVEIS PROBLEMAS E SOLUÇÕES

| Problema | Solução |
|----------|---------|
| "Database connection failed" | Verifique `config.php`: host, user, pass, db name |
| "Missing fields" nas APIs | Envie `email` e `password` via POST (form-data) |
| "Invalid credentials" mesmo com dados certos | Verifique se a senha foi feita hash com `password_hash()` |
| Sessão não persiste após reload | Verifique cookies do navegador (DevTools → Application → Cookies) |
| 404 em `/api/` | Verifique se os arquivos existem em `/public/api/` |

---

## 📝 PRÓXIMAS FASES

Após confirmar que tudo funciona, você pode:
- ✓ Fazer merge da branch `vitor-auth` para `main`
- ✓ Integrar com frontend de seller-onboarding
- ✓ Adicionar suporte para Google/Apple login
- ✓ Criar página de perfil de usuário/vendedor
