# Status - Sistema de Autenticação (Vitor Gonçalves)

## ✅ CONCLUÍDO

### Implementação
- ✅ `backend/config.php` - Credenciais e constantes de banco
- ✅ `backend/db.php` - Conexão PDO com tratamento de erros
- ✅ `backend/auth.php` - Helpers de sessão (`isLoggedUser()`, `isLoggedSeller()`, `requireUser()`, `requireSeller()`)

### APIs de Autenticação
- ✅ `api/login_usuario.php` - Login para compradores
- ✅ `api/register_usuario.php` - Registro para compradores (com CPF)
- ✅ `api/login_vendedor.php` - Login para vendedores
- ✅ `api/register_vendedor.php` - Registro para vendedores (com CPF)
- ✅ `api/logout.php` - Logout para ambos

### Frontend
- ✅ `public/auth.php` - Página de login/registro com toggle entre formulários
- ✅ `public/assets/scripts/login.js` - Integrado com APIs (POST real, redirect, validações)
- ✅ `public/assets/uploads/` - Pasta criada para futuros uploads

### Proteção de Rotas
- ✅ `public/cart.php` - Protegido com `requireUser()` (redireciona não-logados para auth.php)
- ✅ `public/seller-onboarding.php` - Protegido com `requireSeller()` (redireciona não-vendedores para auth.php
