<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Sola Roxa | Entrar</title>
    <meta
      name="description"
      content="Entrar ou criar conta na Sola Roxa — marketplace premium de sneakers."
    />

    <!-- Fonts -->
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Inter:wght@300;400;600;700&display=swap"
      rel="stylesheet"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Creepster&family=Eater&family=Metal+Mania&family=Nosifer&family=Roboto:wght@400;500;700&display=swap"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Fjalla+One&display=swap"
      rel="stylesheet"
    />

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: {
              roxa: "#8B5CF6",
              cyan: "#00F0FF",
              bg: "#0D0D0D",
            },
            fontFamily: {
              pop: ["Poppins", "Inter", "ui-sans-serif", "system-ui"],
            },
          },
        },
      };
    </script>

    <!-- GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

    <!-- Favicon (assumes favicon exists at root). Also link to local asset for environments without root favicon -->
    <link rel="icon" href="/favicon.ico" />
    <link rel="icon" href="assets/img/favicon/favicon_io/favicon.ico" />

    <style>
      body {
        background: linear-gradient(180deg, #070707 0%, #0d0d0d 100%);
      }
      .glass {
        background: rgba(255, 255, 255, 0.02);
        backdrop-filter: blur(8px);
      }
      .input-glow:focus {
        box-shadow: 0 8px 30px rgba(139, 92, 246, 0.12);
      }
      .btn-roxa {
        background: linear-gradient(90deg, #8b5cf6, #6b3cf0);
      }
      .btn-roxa:hover {
        box-shadow: 0 12px 30px rgba(139, 92, 246, 0.22),
          0 0 12px rgba(0, 240, 255, 0.06);
        transform: translateY(-2px);
      }
      
    </style>
  </head>
  <body class="font-pop min-h-screen text-white">
    <header id="site-header" class="fixed w-full z-40 top-0 transition-all duration-300">
    <nav class="max-w-7xl mx-auto px-6 sm:px-8 flex items-center justify-between h-16 transition-all duration-300">
      <div class="flex items-center gap-6">
        <a href="index.php" style="font-family: Fjalla One" class="text-xl font-extrabold tracking-widest">SOLA <span
            class="text-purple-700">ROXA</span></a>
      </div>

      <ul class="hidden md:flex gap-8 text-sm text-white-200 uppercase tracking-wider">
        <li>
          <a class="hover:text-roxa transition" href="#lancamentos">Lançamentos</a>
        </li>
        <li>
          <a class="hover:text-roxa transition" href="catalog.php?estado=novo">Novos</a>
        </li>
        <li>
          <a class="hover:text-roxa transition" href="catalog.php?estado=semi-novo,usado">Outlet</a>
        </li>
        <li>
          <a class="hover:text-roxa transition" href="#colecoes">Colecionáveis</a>
        </li>
        <li>
          <a class="hover:text-roxa transition" href="catalog.php">Marketplace</a>
        </li>
      </ul>

      <div class="flex items-center gap-4">
        <a href="favorites.php">
          <button aria-label="favoritos" class="p-2 rounded-md hover:bg-white/5 transition cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="size-6">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
            </svg>
          </button>
        </a>
        <!-- user -->
        <a href="profile.php">
          <button aria-label="conta" class="p-2 rounded-md hover:bg-white/5 transition cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="size-6">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
            </svg>
          </button>
        </a>
        <!-- cart with badge -->
        <a href="cart.php" class="relative">
          <button aria-label="carrinho" class="p-2 rounded-md hover:bg-white/5 transition cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="size-6">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
            </svg>
            <span id="cart-count"
              class="absolute -top-2 -right-2 min-w-[22px] h-[22px] px-1 rounded-full bg-roxa text-black text-xs font-bold flex items-center justify-center border border-white/10"
              style="display:none;">0</span>
          </button>
        </a>
  </header>

    <main class="min-h-screen flex items-center justify-center py-20">
      <div
        class="max-w-6xl w-full grid grid-cols-1 md:grid-cols-2 gap-6 items-center px-6"
      >
        <!-- Left: visual -->
        <div
          class="hidden md:flex relative items-center justify-center rounded-xl overflow-hidden min-h-[600px]"
        >
          <img
            src="https://images.unsplash.com/photo-1716347685367-1eb5de72eb65?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&q=80&w=387"
            alt="urban texture"
            class="absolute inset-0 w-full h-full object-cover filter brightness-50"
          />
          <div
            class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-black/30"
          ></div>
          <div class="relative z-10 p-12 text-left max-w-md">
            <h3 class="text-4xl font-extrabold tracking-tight">
              <span style="font-family: Fjalla One"
                >SOLA <span class="text-purple-700">ROXA</span></span
              >
            </h3>
            <p class="mt-4 text-white/70">
              De pé em pé — streetwear encontra a passarela. Seja parte da
              comunidade.
            </p>
          </div>
          <div class="absolute left-6 bottom-6 text-xs text-white/50">
            © Sola Roxa
          </div>
        </div>

        <!-- Right: forms -->
        <div class="flex items-center justify-center">
          <div class="w-full max-w-md glass rounded-xl p-8 shadow-xl overflow-visible">
            <div class="text-center">
              <div
                class="mx-auto w-20 h-20 rounded-full bg-white/5 flex items-center justify-center mb-4"
              >
                <img src="assets/img/favicon/favicon.png" alt="" />
              </div>
              <h2 id="form-title" class="text-2xl font-bold">
                Bem-vindo de volta à Sola Roxa
              </h2>
              <p class="text-sm text-white/60 mt-2">De pé em pé</p>
            </div>

            <!-- Forms container -->
            <div class="mt-6">
              <!-- Login -->
              <form id="login-form" class="space-y-4">
                <div>
                  <label class="text-sm text-white/70">E-mail</label>
                  <input
                    type="email"
                    placeholder="seu@exemplo.com"
                    class="w-full mt-2 p-3 rounded-lg bg-transparent border border-white/10 text-white placeholder-white/40 input-glow focus:border-roxa outline-none transition"
                    required
                  />
                </div>
                <div>
                  <label class="text-sm text-white/70">Senha</label>
                  <input
                    type="password"
                    placeholder="••••••••"
                    class="w-full mt-2 p-3 rounded-lg bg-transparent border border-white/10 text-white placeholder-white/40 input-glow focus:border-roxa outline-none transition"
                    required
                  />
                </div>

                <div class="flex items-center justify-between text-sm">
                  <a href="javascript:void(0)" class="text-white/60 hover:text-roxa transition"
                    >Esqueceu sua senha?</a
                  >
                  <div class="flex items-center gap-2">
                    <input type="checkbox" id="remember" class="accent-roxa" />
                    <label for="remember" class="text-white/60">Lembrar</label>
                  </div>
                </div>

                <div>
                  <button
                    type="submit"
                    class="w-full py-3 rounded-lg btn-roxa text-white font-semibold"
                  >
                    Entrar
                  </button>
                </div>

                <p class="text-center text-sm text-white/60 mt-4">
                  Ainda não tem uma conta?
                  <button
                    id="to-register"
                    class="text-roxa font-semibold hover:underline"
                  >
                    Cadastre-se
                  </button>
                </p>
              </form>

              <!-- Register (hidden by default) -->
              <form
                id="register-form"
                class="space-y-4"
                style="display: none;"
              >
                <div>
                  <label class="text-sm text-white/70">Nome completo</label>
                  <input
                    id="register-name"
                    name="name"
                    type="text"
                    placeholder="Seu nome"
                    class="w-full mt-2 p-3 rounded-lg bg-transparent border border-white/10 text-white placeholder-white/40 input-glow focus:border-roxa outline-none transition"
                    required
                  />
                </div>
                <div>
                  <label class="text-sm text-white/70">E-mail</label>
                  <input
                    id="register-email"
                    name="email"
                    type="email"
                    placeholder="seu@exemplo.com"
                    class="w-full mt-2 p-3 rounded-lg bg-transparent border border-white/10 text-white placeholder-white/40 input-glow focus:border-roxa outline-none transition"
                    required
                  />
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                  <div>
                    <label class="text-sm text-white/70">Senha</label>
                    <input
                      id="register-password"
                      name="password"
                      type="password"
                      placeholder="••••••"
                      class="w-full mt-2 p-3 rounded-lg bg-transparent border border-white/10 text-white placeholder-white/40 input-glow focus:border-roxa outline-none transition"
                      required
                    />
                  </div>
                  <div>
                    <label class="text-sm text-white/70">Confirmar senha</label>
                    <input
                      id="register-password-confirm"
                      name="password_confirm"
                      type="password"
                      placeholder="••••••"
                      class="w-full mt-2 p-3 rounded-lg bg-transparent border border-white/10 text-white placeholder-white/40 input-glow focus:border-roxa outline-none transition"
                      required
                    />
                  </div>
                </div>

                <div>
                  <label class="text-sm text-white/70">CPF</label>
                  <input
                    id="register-cpf"
                    name="cpf"
                    type="text"
                    placeholder="000.000.000-00"
                    class="w-full mt-2 p-3 rounded-lg bg-transparent border border-white/10 text-white placeholder-white/40 input-glow focus:border-roxa outline-none transition"
                  />
                </div>

                <div>
                  <button
                    type="submit"
                    class="w-full py-3 rounded-lg bg-white text-black font-semibold"
                  >
                    Cadastrar
                  </button>
                </div>

                <p class="text-center text-sm text-white/60 mt-2">
                  Já tem uma conta?
                  <button
                    id="to-login"
                    class="text-roxa font-semibold hover:underline"
                  >
                    Entrar
                  </button>
                </p>
              </form>
            </div>
          </div>
        </div>
      </div>
    </main>
    <footer class="bg-white/[0.01] mt-12 border-t border-white/10">
      <div
        class="max-w-7xl mx-auto px-6 sm:px-8 py-12 grid grid-cols-1 md:grid-cols-4 gap-8 text-sm"
      >
        <div>
          <h5 class="font-semibold text-white mb-4">Ajuda</h5>
          <ul class="space-y-3">
            <li>
              <a
                href="javascript:void(0)"
                class="text-white/60 hover:text-white transition-colors"
                >FAQ</a
              >
            </li>
            <li>
              <a
                href="javascript:void(0)"
                class="text-white/60 hover:text-white transition-colors"
                >Envios</a
              >
            </li>
            <li>
              <a
                href="javascript:void(0)"
                class="text-white/60 hover:text-white transition-colors"
                >Devoluções</a
              >
            </li>
          </ul>
        </div>

        <div>
          <h5 class="font-semibold text-white mb-4">Sobre Nós</h5>
          <ul class="space-y-3">
            <li>
              <a
                href="javascript:void(0)"
                class="text-white/60 hover:text-white transition-colors"
                >Nosso manifesto</a
              >
            </li>
            <li>
              <a
                href="javascript:void(0)"
                class="text-white/60 hover:text-white transition-colors"
                >Trabalhe conosco</a
              >
            </li>
          </ul>
        </div>

        <div>
          <h5 class="font-semibold text-white mb-4">Redes Sociais</h5>
          <ul class="space-y-3">
            <li>
              <a
                href="javascript:void(0)"
                class="text-white/60 hover:text-white transition-colors"
                >Instagram</a
              >
            </li>
            <li>
              <a
                href="javascript:void(0)"
                class="text-white/60 hover:text-white transition-colors"
                >Twitter</a
              >
            </li>
          </ul>
        </div>

        <div>
          <h5 class="font-semibold text-white mb-4">Termos</h5>
          <ul class="space-y-3">
            <li>
              <a
                href="javascript:void(0)"
                class="text-white/60 hover:text-white transition-colors"
                >Política de Privacidade</a
              >
            </li>
            <li>
              <a
                href="javascript:void(0)"
                class="text-white/60 hover:text-white transition-colors"
                >Termos de Uso</a
              >
            </li>
          </ul>
        </div>
      </div>
      <div class="border-t border-white/10 text-center py-6">
        <div
          class="max-w-7xl mx-auto px-6 sm:px-8 flex flex-col sm:flex-row items-center justify-between gap-4"
        >
          <p class="text-white/40">
            © <span id="year"></span> SOLA ROXA — Todos os direitos reservados
          </p>
          <div class="flex items-center gap-6">
            <a
              href="javascript:void(0)"
              class="text-white/60 hover:text-white transition-colors text-sm"
              >Contato</a
            >
          </div>
        </div>
      </div>
    </footer>
    <script src="assets/scripts/login.js"></script>
  </body>
</html>
