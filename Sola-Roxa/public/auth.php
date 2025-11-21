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
    <header
      id="site-header"
      class="fixed w-full z-40 top-0 transition-all duration-300"
    >
      <nav
        class="max-w-7xl mx-auto px-6 sm:px-8 flex items-center justify-between h-16 transition-all duration-300"
      >
        <div class="flex items-center gap-6">
          <a
            href="index.php"
            style="font-family: Fjalla One"
            class="text-xl font-extrabold tracking-widest"
            >SOLA <span class="text-purple-700">ROXA</span></a
          >
        </div>

        <ul
          class="hidden md:flex gap-8 text-sm text-white-200 uppercase tracking-wider"
        >
          <li>
            <a class="hover:text-roxa transition" href="index.php#lancamentos"
              >Lançamentos</a
            >
          </li>
          <li>
            <a class="hover:text-roxa transition" href="index.php#masculino"
              >Masculino</a
            >
          </li>
          <li>
            <a class="hover:text-roxa transition" href="index.php#feminino">Feminino</a>
          </li>
          <li>
            <a class="hover:text-roxa transition" href="#colecoes"
              >Colecionáveis</a
            >
          </li>
          <li>
            <a class="hover:text-roxa transition" href="catalog.php"
              >Marketplace</a
            >
          </li>
        </ul>

        <div class="flex items-center gap-4">
          <button
            aria-label="buscar"
            class="p-2 rounded-md hover:bg-white/5 transition cursor-pointer"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke-width="1.5"
              stroke="currentColor"
              class="size-6"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"
              />
            </svg>
          </button>
          <!-- user -->
          <a href="profile.php">
            <button
              aria-label="conta"
              class="p-2 rounded-md hover:bg-white/5 transition cursor-pointer"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="size-6"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"
                />
              </svg>
            </button>
          </a>
          <!-- cart -->
          <a href="cart.php">
            <button
              aria-label="carrinho"
              class="p-2 rounded-md hover:bg-white/5 transition cursor-pointer"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="size-6"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"
                />
              </svg>
            </button>
          </a>
        </div>
      </nav>
    </header>

    <main class="min-h-screen flex items-center justify-center pt-20">
      <div
        class="max-w-6xl w-full grid grid-cols-1 md:grid-cols-2 gap-6 items-stretch px-6"
      >
        <!-- Left: visual -->
        <div
          class="hidden md:flex relative items-center justify-center rounded-xl overflow-hidden"
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
          <div class="w-full max-w-md glass rounded-xl p-8 shadow-xl">
            <div class="text-center">
              <div
                class="mx-auto w-20 h-20 rounded-full bg-white/5 flex items-center justify-center mb-4 inline-block"
              >
                <img src="assets/img/favicon/favicon.png" alt="" />
              </div>
              <h2 id="form-title" class="text-2xl font-bold">
                Bem-vindo de volta à Sola Roxa
              </h2>
              <p class="text-sm text-white/60 mt-2">De pé em pé</p>
            </div>

            <!-- Forms container -->
            <div class="mt-6 relative">
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

                <div class="flex items-center gap-3 my-2">
                  <div class="h-px bg-white/6 flex-1"></div>
                  <div class="text-xs text-white/50">ou</div>
                  <div class="h-px bg-white/6 flex-1"></div>
                </div>

                <div class="flex gap-3">
                  <button
                    type="button"
                    class="flex-1 py-2 rounded-lg bg-white text-black font-medium flex items-center justify-center gap-2"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      x="0px"
                      y="0px"
                      width="20"
                      height="20"
                      viewbox="0 0 48 48"
                    >
                      <path
                        fill="#FFC107"
                        d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"
                      ></path>
                      <path
                        fill="#FF3D00"
                        d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"
                      ></path>
                      <path
                        fill="#4CAF50"
                        d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"
                      ></path>
                      <path
                        fill="#1976D2"
                        d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"
                      ></path>
                    </svg>
                    Google
                  </button>
                  <button
                    type="button"
                    class="flex-1 py-2 rounded-lg bg-black/60 border border-white/10 flex items-center justify-center gap-2"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 640 640"
                      fill="#ffffff"
                      width="25"
                      height="25"
                    >
                      <path
                        d="M447.1 332.7C446.9 296 463.5 268.3 497.1 247.9C478.3 221 449.9 206.2 412.4 203.3C376.9 200.5 338.1 224 323.9 224C308.9 224 274.5 204.3 247.5 204.3C191.7 205.2 132.4 248.8 132.4 337.5C132.4 363.7 137.2 390.8 146.8 418.7C159.6 455.4 205.8 545.4 254 543.9C279.2 543.3 297 526 329.8 526C361.6 526 378.1 543.9 406.2 543.9C454.8 543.2 496.6 461.4 508.8 424.6C443.6 393.9 447.1 334.6 447.1 332.7zM390.5 168.5C417.8 136.1 415.3 106.6 414.5 96C390.4 97.4 362.5 112.4 346.6 130.9C329.1 150.7 318.8 175.2 321 202.8C347.1 204.8 370.9 191.4 390.5 168.5z"
                      />
                    </svg>
                    Apple
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
                class="space-y-4 absolute inset-0 opacity-0 pointer-events-none"
              >
                <div>
                  <label class="text-sm text-white/70">Nome completo</label>
                  <input
                    type="text"
                    placeholder="Seu nome"
                    class="w-full mt-2 p-3 rounded-lg bg-transparent border border-white/10 text-white placeholder-white/40 input-glow focus:border-roxa outline-none transition"
                    required
                  />
                </div>
                <div>
                  <label class="text-sm text-white/70">E-mail</label>
                  <input
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
                      type="password"
                      placeholder="••••••"
                      class="w-full mt-2 p-3 rounded-lg bg-transparent border border-white/10 text-white placeholder-white/40 input-glow focus:border-roxa outline-none transition"
                      required
                    />
                  </div>
                  <div>
                    <label class="text-sm text-white/70">Confirmar senha</label>
                    <input
                      type="password"
                      placeholder="••••••"
                      class="w-full mt-2 p-3 rounded-lg bg-transparent border border-white/10 text-white placeholder-white/40 input-glow focus:border-roxa outline-none transition"
                      required
                    />
                  </div>
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
