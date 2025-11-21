<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sola Roxa — Sobre</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
  <link rel="icon" href="assets/img/favicon/favicon_io/favicon.ico" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Fjalla+One&family=Great+Vibes&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">
  <style>
    :root {
      --roxa: #A020F0;
      --cyan: #00E5FF;
      --bg: #090909;
    }

    /* subtle custom utilities */
    .text-roxa {
      color: var(--roxa);
    }

    .accent-roxa {
      background: linear-gradient(90deg, rgba(160, 32, 240, 1) 0%, rgba(0, 224, 255, 0.7) 100%);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
    }

    .glass-card {
      background: linear-gradient(180deg, rgba(255, 255, 255, 0.02), rgba(255, 255, 255, 0.01));
      backdrop-filter: blur(6px);
      border: 1px solid rgba(255, 255, 255, 0.04);
    }

    .hero-image-overlay::after {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(180deg, rgba(0, 0, 0, 0.15), rgba(0, 0, 0, 0.45));
      pointer-events: none;
    }

    .split-img-clip {
      clip-path: polygon(0 0, 100% 0, 85% 100%, 0% 100%);
    }

    /* community horizontal scroll */
    .snap-x {
      scroll-snap-type: x mandatory;
    }

    .snap-item {
      scroll-snap-align: center;
    }

    /* micro interactions */
    .hover-lift:hover {
      transform: translateY(-6px);
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.6);
    }

    /* responsive tweaks */
    @media (max-width: 768px) {
      .split-img-clip {
        clip-path: none;
      }
    }
  </style>
</head>

<body class="bg-[#090909] text-white font-sans antialiased leading-normal">
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

  <!-- HERO: Split 50/50 -->
  <main class="pt-16">
    <section class="grid grid-cols-1 md:grid-cols-2 h-screen">
      <!-- Left: editorial montage -->
      <div class="relative overflow-hidden hero-image-overlay">
        <img src="assets/img/carroussel/pexels-jddaniel-2385477.jpg" alt="Editorial montage"
          class="absolute inset-0 w-full h-full object-cover opacity-100 transform scale-105 split-img-clip" />
        <!-- layered photos for editorial feel -->
        <img src="assets/img/carroussel/nike-o-fenomeno-jordan.jpg" alt="Editorial detail"
          class="absolute right-6 top-12 w-3/5 h-auto object-cover border-4 border-black/30 drop-shadow-lg transform rotate-3 transition-all duration-700 hover:scale-105" />

      </div>

      <!-- Right: clean white space with copy -->
      <div class="flex items-center justify-center px-8">
        <div class="max-w-xl">
          <h1 class="text-4xl md:text-5xl font-extrabold leading-tight mb-4">No Ritmo da <span
              class="text-purple-500">Sola Roxa</span></h1>
          <p class="text-lg text-white/70 mb-6">Onde estilo, cultura urbana e autenticidade se encontram.</p>

          <p class="text-sm text-white/60 mb-6">Sola Roxa é um marketplace com uma comunidade vibrante que
            conecta apaixonados por sneakers, estilo e cultura de rua. Inspirados pelas ruas e pela cultura jovem,
            trazemos peças únicas, colabs e histórias que movem o passo.</p>

          <div class="flex gap-4 items-center">
            <a href="catalog.php"
              class="px-5 py-3 rounded-md bg-gradient-to-r from-purple-600 to-[#A020F0] text-black font-semibold shadow hover:brightness-110 transition">Explorar
              Marketplace</a>
            <a href="#philosophy" class="text-white/60 hover:text-white underline">Saiba mais</a>
          </div>

          <div class="mt-10 flex gap-6 items-center text-sm text-white/60">
            <div class="flex items-center gap-3">
              <span class="inline-block w-2 h-2 rounded-full bg-[#A020F0]"></span>
              Curadoria premium
            </div>
            <div class="flex items-center gap-3">
              <span class="inline-block w-2 h-2 rounded-full bg-[#A020F0]"></span>
              Comunidade ativa
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Brand Philosophy -->
    <section id="philosophy" class="py-20">
      <div class="max-w-6xl mx-auto px-6 text-center">
        <div class="max-w-3xl mx-auto mb-12">
          <h2 class="text-3xl font-bold mb-4">Nossa Filosofia</h2>
          <p class="text-lg text-white/70 leading-relaxed">
            Acreditamos que cada passo tem um ritmo próprio. A Sola Roxa nasceu para celebrar estilo,
            autenticidade e a liberdade de expressão através dos sneakers. Somos criadores, contadores de histórias
            e fomentadores de uma cena onde o streetwear vira linguagem.
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
          <div>
            <img src="assets/img/carroussel/shoes-4026771.jpg" alt="lifestyle"
              class="w-full h-80 object-cover rounded-md shadow-lg" />
          </div>
          <div class="text-left">
            <p class="text-white/70 mb-4">Mais do que vender tênis, nós escrevemos capítulos na história de quem
              veste. Cada peça que circula no nosso marketplace foi escolhida por sua narrativa — design, rareza ou
              significado cultural. Acreditamos em autenticidade acima de tudo.</p>
            <a href="#values" class="inline-block mt-4 text-sm text-white/60 hover:text-white underline">Missão,
              Visão e Valores</a>
          </div>
        </div>
      </div>
    </section>

    <!-- Mission / Vision / Values -->
    <section id="values" class="py-12 bg-gradient-to-b from-black/0 to-black/60">
      <div class="max-w-6xl mx-auto px-6">
        <h3 class="text-2xl font-bold mb-8 text-center">Missão · Visão · Valores</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div class="glass-card p-6 rounded-md hover-lift transition-transform duration-300">
            <div class="flex items-center gap-4 mb-4">
              <i data-lucide="target" class="text-white"></i>
              <h4 class="font-semibold">Missão</h4>
            </div>
            <p class="text-white/60 text-sm">Ser a plataforma que conecta cultura, colecionadores e criadores,
              transformando cada compra em uma experiência editorial.</p>
          </div>

          <div class="glass-card p-6 rounded-md hover-lift transition-transform duration-300">
            <div class="flex items-center gap-4 mb-4">
              <i data-lucide="zap" class="text-white"></i>
              <h4 class="font-semibold">Visão</h4>
            </div>
            <p class="text-white/60 text-sm">Elevar o streetwear brasileiro ao nível global, valorizando histórias e
              designers locais.</p>
          </div>

          <div class="glass-card p-6 rounded-md hover-lift transition-transform duration-300">
            <div class="flex items-center gap-4 mb-4">
              <i data-lucide="heart" class="text-white"></i>
              <h4 class="font-semibold">Valores</h4>
            </div>
            <p class="text-white/60 text-sm">Comunidade, autenticidade, curadoria consciente e respeito pela cena.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Lifestyle full-width banner -->
    <section class="relative my-12">
      <div class="h-72 md:h-96 w-full overflow-hidden rounded-md">
        <img src="assets/img/carroussel/child-8179655.jpg" alt="friends laughing"
          class="w-full h-full object-cover brightness-75" />
        <div class="absolute inset-0 flex items-center justify-center">
          <div class="text-center">
            <h3 class="text-3xl md:text-4xl font-extrabold">Mais do que sneakers — um movimento.</h3>
            <p class="text-white/70 mt-2">A rua é nossa passarela. A amizade, a risada e o passo marcam a identidade.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Community Section: horizontal scroll grid -->
    <section class="py-12">
      <div class="max-w-6xl mx-auto px-6">
        <div class="flex items-center justify-between mb-6">
          <h3 class="text-2xl font-bold">Feito pela rua. Feito por você.</h3>
          <div class="hidden md:flex gap-2">
            <button id="prev" aria-label="anterior" class="p-2 bg-white/5 rounded-md">◀</button>
            <button id="next" aria-label="próximo" class="p-2 bg-white/5 rounded-md">▶</button>
          </div>
        </div>

        <div id="community" class="flex gap-6 overflow-x-auto snap-x py-4 scroll-smooth">
          <!-- sample community images -->
          <div class="min-w-[260px] snap-item rounded-md overflow-hidden hover:scale-105 transition">
            <img src="assets/img/carroussel/pexels-jddaniel-2385477.jpg" alt="user 1"
              class="w-full h-64 object-cover" />
          </div>
          <div class="min-w-[260px] snap-item rounded-md overflow-hidden hover:scale-105 transition">
            <img src="assets/img/carroussel/nike-o-fenomeno-jordan.jpg" alt="user 2" class="w-full h-64 object-cover" />
          </div>
          <div class="min-w-[260px] snap-item rounded-md overflow-hidden hover:scale-105 transition">
            <img
              src="assets/img/carroussel/https___hypebeast.com_image_2019_08_best-sneakers-cartoons-collaborations-main-1.avif"
              alt="user 3" class="w-full h-64 object-cover" />
          </div>
        </div>

        <p class="text-sm text-white/60 mt-6">Compartilhe seu look com <span class="text-roxa">#SolaRoxa</span> para
          aparecer
          aqui.</p>
      </div>
    </section>
  </main>

  <!-- Footer (kept structure) -->
  <footer class="bg-white/[0.01] mt-12 border-t border-white/10">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 py-12 grid grid-cols-1 md:grid-cols-4 gap-8 text-sm">
      <div>
        <h5 class="font-semibold text-white mb-4">Ajuda</h5>
        <ul class="space-y-3">
          <li>
            <a href="javascript:void(0)" class="text-white/60 hover:text-white transition-colors">FAQ</a>
          </li>
          <li>
            <a href="javascript:void(0)" class="text-white/60 hover:text-white transition-colors">Envios</a>
          </li>
          <li>
            <a href="javascript:void(0)" class="text-white/60 hover:text-white transition-colors">Devoluções</a>
          </li>
        </ul>
      </div>

      <div>
        <h5 class="font-semibold text-white mb-4">Sobre Nós</h5>
        <ul class="space-y-3">
          <li>
            <a href="sobre.php" class="text-white/60 hover:text-white transition-colors">Sobre Sola Roxa</a>
          </li>
          <li>
            <a href="javascript:void(0)" class="text-white/60 hover:text-white transition-colors">Trabalhe conosco</a>
          </li>
        </ul>
      </div>

      <div>
        <h5 class="font-semibold text-white mb-4">Redes Sociais</h5>
        <ul class="space-y-3">
          <li>
            <a href="javascript:void(0)" class="text-white/60 hover:text-white transition-colors">Instagram</a>
          </li>
          <li>
            <a href="javascript:void(0)" class="text-white/60 hover:text-white transition-colors">Twitter</a>
          </li>
        </ul>
      </div>

      <div>
        <h5 class="font-semibold text-white mb-4">Termos</h5>
        <ul class="space-y-3">
          <li>
            <a href="javascript:void(0)" class="text-white/60 hover:text-white transition-colors">Política de
              Privacidade</a>
          </li>
          <li>
            <a href="javascript:void(0)" class="text-white/60 hover:text-white transition-colors">Termos de Uso</a>
          </li>
        </ul>
      </div>
    </div>
    <div class="border-t border-white/10 text-center py-6">
      <div class="max-w-7xl mx-auto px-6 sm:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
        <p class="text-white/40">© <span id="year"></span> SOLA ROXA — Todos os direitos reservados</p>
        <div class="flex items-center gap-6">
          <a href="javascript:void(0)" class="text-white/60 hover:text-white transition-colors text-sm">Contato</a>
        </div>
      </div>
    </div>
  </footer>

  <!-- Scripts -->
  <script>
    // init lucide icons
    if (window.lucide) {
      window.lucide.replace({ width: 20, height: 20, stroke: 'currentColor' })
    }

    // set year
    document.getElementById('year').textContent = new Date().getFullYear();

    // simple carousel controls
    const container = document.getElementById('community')
    const prev = document.getElementById('prev')
    const next = document.getElementById('next')
    if (prev && next && container) {
      prev.addEventListener('click', () => container.scrollBy({ left: -300, behavior: 'smooth' }))
      next.addEventListener('click', () => container.scrollBy({ left: 300, behavior: 'smooth' }))
    }

    // subtle reveal on scroll
    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) entry.target.classList.add('opacity-100', 'translate-y-0')
      })
    }, { threshold: 0.12 })

    document.querySelectorAll('.glass-card, .hover-lift').forEach(el => {
      el.classList.add('opacity-0', 'translate-y-6', 'transition', 'duration-700')
      observer.observe(el)
    })
  </script>
  <script src="assets/scripts/main.js"></script>
</body>

</html>