<?php
require_once __DIR__ . '/../backend/auth.php';
requireUser();

$user = $_SESSION['user'] ?? null;
function firstName($full)
{
    $full = trim($full ?? '');
    if ($full === '')
        return '';
    $parts = preg_split('/\s+/', $full);
    return $parts[0];
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Sola Roxa | Meu Perfil</title>
    <meta name="description" content="Perfil do usuário - Sola Roxa" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap"
        rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fjalla+One&family=Great+Vibes&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Caveat+Brush&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        roxa: '#8B5CF6',
                        cyan: '#00F0FF',
                        bg: '#0D0D0D'
                    },
                    fontFamily: {
                        pop: ['Poppins', 'ui-sans-serif', 'system-ui']
                    }
                }
            }
        };
    </script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <style>
        .side-link {
            transition: all .12s ease
        }

        .side-link:hover {
            color: #8B5CF6
        }
    </style>
</head>

<body class="bg-[#090909] text-white font-sans antialiased leading-normal">

    <header id="site-header" class="fixed w-full z-40 top-0 transition-all duration-300">
        <nav class="max-w-7xl mx-auto px-6 sm:px-8 flex items-center justify-between h-16 transition-all duration-300">
            <div class="flex items-center gap-6">
                <a href="index.php" style="font-family: Fjalla One" class="text-xl font-extrabold tracking-widest">SOLA
                    <span class="text-purple-700">ROXA</span></a>
            </div>

            <ul class="hidden md:flex gap-8 text-sm text-white-200 uppercase tracking-wider">
                <li>
                    <a class="hover:text-roxa transition" href="#lancamentos">Lançamentos</a>
                </li>
                <li>
                    <a class="hover:text-roxa transition" href="#masculino">Masculino</a>
                </li>
                <li>
                    <a class="hover:text-roxa transition" href="#feminino">Feminino</a>
                </li>
                <li>
                    <a class="hover:text-roxa transition" href="#colecoes">Colecionáveis</a>
                </li>
                <li>
                    <a class="hover:text-roxa transition" href="catalog.php">Marketplace</a>
                </li>
            </ul>

            <div class="flex items-center gap-4">
                <button aria-label="buscar" class="p-2 rounded-md hover:bg-white/5 transition cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </button>
                <!-- Ícone / link para área do usuário (acesso à autenticação/perfil) -->
                <a href="profile.php">
                    <button aria-label="conta" class="p-2 rounded-md hover:bg-white/5 transition cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                    </button>
                </a>
                <!-- Ícone / link para o carrinho de compras -->
                <a href="cart.php">
                    <button aria-label="carrinho" class="p-2 rounded-md hover:bg-white/5 transition cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                    </button>
                </a>
            </div>
        </nav>
    </header>

    <main class="max-w-7xl mx-auto px-6 sm:px-8 py-20">
        <h2 class="text-3xl font-bold text-white  mb-6">BEM-VINDO(A),
            <?php echo htmlspecialchars(strtoupper(firstName($user['nome'] ?? '')) ?: 'USUÁRIO'); ?>
        </h2>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Barra lateral (navegação da conta do usuário) -->
            <aside class="lg:col-span-3 bg-white/[0.02] rounded shadow-sm p-4 border border-white/6">
                <nav class="flex flex-col gap-4">
                    <a href="profile.php"
                        class="flex items-center gap-3 p-3 rounded side-link bg-white/5 text-roxa border-l-4 border-roxa">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>

                        <span class="font-semibold">Perfil</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 p-3 rounded side-link bg-transparent text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                        </svg>

                        <span>Pedidos</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 p-3 rounded side-link bg-transparent text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 0 0-3.7-3.7 48.678 48.678 0 0 0-7.324 0 4.006 4.006 0 0 0-3.7 3.7c-.017.22-.032.441-.046.662M19.5 12l3-3m-3 3-3-3m-12 3c0 1.232.046 2.453.138 3.662a4.006 4.006 0 0 0 3.7 3.7 48.656 48.656 0 0 0 7.324 0 4.006 4.006 0 0 0 3.7-3.7c.017-.22.032-.441.046-.662M4.5 12l3 3m-3-3-3 3" />
                        </svg>

                        <span>Devoluções</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 p-3 rounded side-link bg-transparent text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205 3 1m1.5.5-1.5-.5M6.75 7.364V3h-3v18m3-13.636 10.5-3.819" />
                        </svg>

                        <span>Meus Endereços</span>
                    </a>
                </nav>
            </aside>

            <!-- Conteúdo principal do perfil -->
            <section class="lg:col-span-9 bg-white/[0.02] rounded shadow-sm p-6 border border-white/10">
                <h3 class="text-xl font-bold mb-4 text-white">PERFIL</h3>

                <form id="profile-form" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm text-white/70">Nome *</label>
                            <input name="nome" type="text" value="<?php echo htmlspecialchars($user['nome'] ?? ''); ?>"
                                class="w-full mt-2 p-3 border rounded bg-transparent border-white/10 text-white placeholder-white/40" />
                        </div>
                        <div>
                            <label class="text-sm text-white/70">Sobrenome</label>
                            <input name="sobrenome" type="text" value=""
                                class="w-full mt-2 p-3 border rounded bg-transparent border-white/10 text-white placeholder-white/40" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm text-white/70">E-mail *</label>
                            <input name="email" type="email"
                                value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>"
                                class="w-full mt-2 p-3 border rounded bg-transparent border-white/10 text-white placeholder-white/40" />
                        </div>
                        <div>
                            <label class="text-sm text-white/70">Confirmar e-mail *</label>
                            <input name="email_confirm" type="email"
                                value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>"
                                class="w-full mt-2 p-3 border rounded bg-transparent border-white/10 text-white placeholder-white/40" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                        <div>
                            <label class="text-sm text-white/70">Senha</label>
                            <input name="senha" type="password" placeholder="••••••••"
                                class="w-full mt-2 p-3 border rounded bg-transparent border-white/10 text-white placeholder-white/40" />
                            <a href="#" class="text-sm text-roxa mt-2 inline-block">Alterar senha</a>
                        </div>
                        <div class="mb-7">
                            <label class="text-sm text-white/70">Código de área</label>
                            <select name="ddd"
                                class="w-full mt-2 p-3 border rounded bg-transparent border-white/10 text-white">
                                <option>+55 (BR)</option>
                                <option>+1 (US)</option>
                                <option>+44 (UK)</option>
                                <option>+33 (FR)</option>
                                <option>+49 (DE)</option>
                                <option>+34 (ES)</option>
                            </select>
                        </div>
                        <div class="mb-7">
                            <label class="text-sm text-white/70">Telefone</label>
                            <input name="telefone" type="tel" value=""
                                class="w-full mt-2 p-3 border rounded bg-transparent border-white/10 text-white placeholder-white/40" />
                        </div>
                    </div>

                    <div class="mt-4">
                        <div class="flex items-start gap-3">
                            <input id="consent1" type="checkbox" name="consent_marketing" class="mt-1" />
                            <label for="consent1" class="text-sm text-white/70">Campanhas de marketing e promoções
                                (e-mail, SMS, etc.)</label>
                        </div>
                        <div class="flex items-start gap-3 mt-2">
                            <input id="consent2" type="checkbox" name="consent_personalization" class="mt-1" />
                            <label for="consent2" class="text-sm text-white/70">Desejo dar consentimento ao tratamento
                                de meus dados para fins de análise e personalização</label>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 mt-6">
                        <button id="cancel-btn" type="button"
                            class="px-6 py-3 border border-white/10 rounded text-white">CANCELAR</button>
                        <button id="save-btn" type="button" class="px-6 py-3 bg-roxa text-white rounded">SALVAR</button>
                    </div>
                </form>

                <div class="mt-8 border-t border-white/6 pt-6">
                    <h4 class="font-semibold text-white">EXCLUIR SUA CONTA</h4>
                    <p class="text-sm text-white/60 mt-2">Ao apagar sua conta, você não fará mais parte da Família Sola
                        Roxa e perderá todas as informações relacionadas a esta conta.</p>
                    <button id="delete-account"
                        class="mt-4 px-4 py-2 border border-white/10 rounded text-red-400">EXCLUIR CONTA</button>
                </div>
            </section>
        </div>

        <?php if (isLoggedSeller()): ?>
            <!-- Seção de produtos do vendedor (apenas visível para vendedores) -->
            <div class="mt-12">
                <h2 class="text-3xl font-bold text-white mb-6">MEUS PRODUTOS</h2>
                <div id="seller-products-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="text-center py-12 col-span-full">
                        <p class="text-white/60">Carregando seus produtos...</p>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <!-- Mensagem para usuários que não são vendedores -->
            <div class="mt-12 bg-white/[0.02] rounded shadow-sm p-6 border border-white/10">
                <h2 class="text-2xl font-bold text-white mb-4">QUEIRA VENDER CONOSCO?</h2>
                <p class="text-white/60 mb-4">Você não está cadastrado como vendedor. Clique no botão abaixo para iniciar o
                    processo de onboarding.</p>
                <a href="seller-onboarding.php"
                    class="inline-block px-6 py-3 bg-roxa text-white rounded hover:bg-roxa/90 transition">
                    COMEÇAR A VENDER
                </a>
            </div>
        <?php endif; ?>
    </main>

    <script>
        lucide.createIcons();
    </script>

    <?php if (isLoggedSeller()): ?>
        <script>
            // Expõe o ID do vendedor para o JS (usado para carregar produtos do vendedor)
            const CURRENT_SELLER_ID = <?php echo (int) $_SESSION['vendedor']['id']; ?>;
        </script>
        <script src="assets/scripts/profile_products.js"></script>
    <?php endif; ?>

    <!-- Rodapé: links úteis, termos e contato -->
    <footer class="bg-white/[0.01] mt-12 border-t border-white/10">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 py-12 grid grid-cols-1 md:grid-cols-4 gap-8 text-sm">
            <div>
                <h5 class="font-semibold text-white mb-4">Ajuda</h5>
                <ul class="space-y-3">
                    <li><a href="#" class="text-white/60 hover:text-white transition-colors">FAQ</a></li>
                    <li><a href="#" class="text-white/60 hover:text-white transition-colors">Envios</a></li>
                    <li><a href="#" class="text-white/60 hover:text-white transition-colors">Devoluções</a></li>
                </ul>
            </div>
            <div>
                <h5 class="font-semibold text-white mb-4">Sobre Nós</h5>
                <ul class="space-y-3">
                    <li><a href="#" class="text-white/60 hover:text-white transition-colors">Nosso manifesto</a></li>
                    <li><a href="#" class="text-white/60 hover:text-white transition-colors">Trabalhe conosco</a></li>
                </ul>
            </div>
            <div>
                <h5 class="font-semibold text-white mb-4">Redes Sociais</h5>
                <ul class="space-y-3">
                    <li><a href="#" class="text-white/60 hover:text-white transition-colors">Instagram</a></li>
                    <li><a href="#" class="text-white/60 hover:text-white transition-colors">Twitter</a></li>
                </ul>
            </div>
            <div>
                <h5 class="font-semibold text-white mb-4">Termos</h5>
                <ul class="space-y-3">
                    <li><a href="#" class="text-white/60 hover:text-white transition-colors">Política de Privacidade</a>
                    </li>
                    <li><a href="#" class="text-white/60 hover:text-white transition-colors">Termos de Uso</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-white/10 text-center py-6">
            <div class="max-w-7xl mx-auto px-6 sm:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-white/40">© <span id="year"></span> SOLA ROXA — Todos os direitos reservados</p>
                <div class="flex items-center gap-6"><a href="#"
                        class="text-white/60 hover:text-white transition-colors text-sm">Contato</a></div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="assets/scripts/main.js"></script>

    <script>
        document.getElementById('cancel-btn').addEventListener('click', function () {
            window.location.href = 'index.php';
        });

        document.getElementById('save-btn').addEventListener('click', async function () {
            const form = document.getElementById('profile-form');
            const data = new FormData(form);
            try {
                const res = await fetch('api/update_profile.php', {
                    method: 'POST',
                    body: data
                });
                if (!res.ok) throw new Error('Resposta inválida');
                const json = await res.json();
                if (json.success) {
                    alert('Perfil atualizado com sucesso');
                    window.location.reload();
                } else {
                    alert(json.error || 'Falha ao atualizar perfil');
                }
            } catch (e) {
                alert('Não foi possível atualizar — back-end pode não estar implementado. (' + e.message + ')');
            }
        });

        document.getElementById('delete-account').addEventListener('click', async function () {
            if (!confirm('Tem certeza que deseja excluir sua conta? Esta ação não pode ser desfeita.')) return;
            try {
                const res = await fetch('api/delete_account.php', {
                    method: 'POST'
                });
                if (res.ok) {
                    alert('Conta excluída');
                    window.location.href = 'index.php';
                } else {
                    alert('Falha ao excluir conta');
                }
            } catch (e) {
                alert('Erro ao conectar com o servidor');
            }
        });
    </script>
</body>

</html>