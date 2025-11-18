<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                <!-- user -->
                <a href="auth.php">
                    <button aria-label="conta" class="p-2 rounded-md hover:bg-white/5 transition cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                    </button>
                </a>
                <!-- cart -->
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
  <!-- Hero -->
  <section id="hero" class="relative h-screen w-full overflow-hidden">
    <!-- background imagem -->
    <img src="assets/img/carroussel/pexels-jddaniel-2385477.jpg" alt="Sneakers urbanos"
                class="absolute inset-0 w-full h-full object-cover" />
        </section>
        <section id="hero2" class="relative h-screen w-full overflow-hidden">
            <div class="relative z-10 max-w-6xl mx-auto px-1 sm:px-1 h-full flex flex-col justify-center">
            <div class="max-w-3xl">
                <p>AAAAAAAAAAAA</p>
      </div>
    </div>
        </section>

    <!-- Footer -->
  <footer class="bg-white/[0.01] mt-12 border-t border-white/10">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 py-12 grid grid-cols-1 md:grid-cols-4 gap-8 text-sm">
      <div>
        <h5 class="font-semibold text-white mb-4">Ajuda</h5>
        <ul class="space-y-3">
          <li>
            <a href="#" class="text-white/60 hover:text-white transition-colors">FAQ</a>
          </li>
          <li>
            <a href="#" class="text-white/60 hover:text-white transition-colors">Envios</a>
          </li>
          <li>
            <a href="#" class="text-white/60 hover:text-white transition-colors">Devoluções</a>
          </li>
        </ul>
      </div>

      <div>
        <h5 class="font-semibold text-white mb-4">Sobre Nós</h5>
        <ul class="space-y-3">
        <li>
            <a href="sobre.php" class="text-white/60 hover:text-white transition-colors">
            Sobre Sola Roxa
            </a>
        </li>
          <li>
            <a href="#" class="text-white/60 hover:text-white transition-colors">Trabalhe conosco</a>
          </li>
        </ul>
      </div>

      <div>
        <h5 class="font-semibold text-white mb-4">Redes Sociais</h5>
        <ul class="space-y-3">
          <li>
            <a href="#" class="text-white/60 hover:text-white transition-colors">Instagram</a>
          </li>
          <li>
            <a href="#" class="text-white/60 hover:text-white transition-colors">Twitter</a>
          </li>
        </ul>
      </div>

      <div>
        <h5 class="font-semibold text-white mb-4">Termos</h5>
        <ul class="space-y-3">
          <li>
            <a href="#" class="text-white/60 hover:text-white transition-colors">Política de Privacidade</a>
          </li>
          <li>
            <a href="#" class="text-white/60 hover:text-white transition-colors">Termos de Uso</a>
          </li>
        </ul>
      </div>
    </div>
    <div class="border-t border-white/10 text-center py-6">
      <div class="max-w-7xl mx-auto px-6 sm:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
        <p class="text-white/40">
          © <span id="year"></span> SOLA ROXA — Todos os direitos reservados
        </p>
        <div class="flex items-center gap-6">
          <a href="#" class="text-white/60 hover:text-white transition-colors text-sm">Contato</a>
        </div>
      </div>
    </div>
  </footer>

  <!-- Scripts -->
  <script src="assets/scripts/main.js"></script>
</body>

</html>