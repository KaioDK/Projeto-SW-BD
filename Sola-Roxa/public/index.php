<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Sola Roxa | Marketplace de sneakers</title>
  <meta name="description" content="Sola Roxa — Urban, premium sneakers marketplace inspired by editorial fashion." />
  <link rel="stylesheet" href="assets/css/style.css" />
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

  <!-- Inter font -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Fjalla+One&family=Great+Vibes&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Caveat+Brush&display=swap" rel="stylesheet">
  <style>
    .caveat-brush-regular {
      font-family: "Caveat Brush", cursive;
      font-weight: 400;
      font-style: normal;
    }

    .great-vibes-regular {
      font-family: "Great Vibes", cursive;
      font-weight: 400;
      font-style: normal;
    }

    html {
      scroll-behavior: smooth;
    }
  </style>
  <!-- Tailwind Play CDN (fast for prototypes) -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    // Tailwind config for custom color and fonts
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            roxa: "#8B5CF6",
            neutral: {
              900: "#0b0b0b",
            },
          },
          fontFamily: {
            sans: ["Inter", "ui-sans-serif", "system-ui"],
          },
        },
      },
    };
  </script>

  <!-- GSAP for animations -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
</head>

<body class="bg-[#090909] text-white font-sans antialiased leading-normal">
  <!-- Header / Navbar -->
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
    <!-- background video (use muted autoplay loop) -->
    <video id="hero-video" class="absolute inset-0 w-full h-full object-cover" autoplay muted loop playsinline
      preload="auto">
      <source src="assets/videos/videonatal.mp4" type="video/mp4" />
      <!-- fallback image -->
      <img src="assets/img/carroussel/nike-o-fenomeno-jordan.jpg" alt="Sneakers urbanos"
        class="w-full h-full object-cover" />
    </video>

    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/40 to-transparent"></div>

    <div class="relative z-10 max-w-6xl mx-auto px-6 sm:px-8 h-full flex flex-col justify-center">
      <div class="max-w-3xl">
        <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight leading-tight opacity-0" id="hero-title">
          <span class="text-red-800 caveat-brush-regular">AQUEÇA O</span>
          <span class="great-vibes-regular">JOGO.</span>
          <span class="text-green-800 caveat-brush-regular">É NATAL.</span>
        </h1>
        <p class="mt-6 text-gray-300 max-w-xl opacity-0" id="hero-sub">
          Edição limitada de alto desempenho, inspirada nos clássicos de inverno da quadra. O presente que você merece.
        </p>

        <div class="mt-1 flex flex-wrap gap-1 opacity-0" id="hero-ctas">
          <a href="#masculino"
            class="inline-flex items-center px-1 py-3 text-white rounded-md font-semibold hover:scale-[1.02] transition underline hover:text-roxa transition">Para
            Ele</a>
          <a href="#feminino"
            class="inline-flex items-center px-6 py-3 text-white rounded-md font-semibold hover:scale-[1.02] transition underline hover:text-roxa transition">Para
            Ela</a>
          <a href="#historias"
            class="inline-flex items-center px-1 py-3 text-sm text-white hover:text-roxa transition">Saiba Mais</a>
        </div>
      </div>
    </div>
  </section>

  <!-- Featured Sneakers Carousel -->
  <section id="lancamentos" class="max-w-7xl mx-auto px-6 sm:px-8 py-20">
    <div class="flex items-center justify-between mb-6">
      <h2 class="text-2xl font-bold">Lançamentos</h2>
      <div class="hidden md:flex items-center gap-2">
        <div class="w-[1px] h-8 bg-white/20"></div>
        <span class="text-white/60 text-sm">Deslize para ver mais</span>
      </div>
    </div>
    <div class="relative">
      <button id="feat-left"
        class="absolute left-0 top-1/2 -translate-y-1/2 z-20 p-2 bg-black/60 hover:bg-black/20 rounded-r-md hidden md:block text-white/90">
        ‹
      </button>
      <button id="feat-right"
        class="absolute right-0 top-1/2 -translate-y-1/2 z-20 p-2 bg-black/60 hover:bg-black/20 rounded-l-md hidden md:block text-white/90">
        ›
      </button>

      <div id="featured" class="flex gap-6 overflow-x-auto scrollbar-hide snap-x snap-mandatory scroll-smooth py-2">
        <!-- sample cards -->
        <article
          class="min-w-[260px] md:min-w-[320px] snap-start bg-gradient-to-b from-white/[0.02] to-transparent backdrop-blur-sm rounded-lg overflow-hidden border border-white/10 hover:border-white/20 hover:scale-[1.02] transition-all duration-300">
          <img loading="lazy"
            src="https://cdn.runrepeat.com/storage/gallery/product_primary/39891/nike-ja-1-21212250-720.jpg"
            alt="Sneaker" class="w-full h-64 object-cover" />
          <div class="p-4">
            <h3 class="font-semibold text-white">Nike Ja 1</h3>
            <p class="text-sm text-white/60 mt-1">R$ 1.599</p>
            <div class="mt-4 flex items-center justify-between">
              <a class="inline-flex items-center gap-2 text-white hover:text-purple-300 font-medium transition-colors"
                href="product.php">
                Ver Mais
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
              </a>
              <span class="text-xs text-white/40">Em estoque</span>
            </div>
          </div>
        </article>

        <article
          class="min-w-[260px] md:min-w-[320px] snap-start bg-gradient-to-b from-white/[0.02] to-transparent backdrop-blur-sm rounded-lg overflow-hidden border border-white/10 hover:border-white/20 hover:scale-[1.02] transition-all duration-300">
          <img loading="lazy"
            src="https://cdn.runrepeat.com/storage/gallery/product_primary/38821/new-balance-9060-21208162-720.jpg"
            alt="Sneaker A" class="w-full h-64 object-cover" />
          <div class="p-4">
            <h3 class="font-semibold text-white">New Balance 9060</h3>
            <p class="text-sm text-white/60 mt-1">R$ 1.299</p>
            <div class="mt-4 flex items-center justify-between">
              <a class="inline-flex items-center gap-2 text-white hover:text-purple-300 font-medium transition-colors"
                href="#">
                Ver Mais
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
              </a>
              <span class="text-xs text-white/40">Em estoque</span>
            </div>
          </div>
        </article>

        <article
          class="min-w-[260px] md:min-w-[320px] snap-start bg-gradient-to-b from-white/[0.02] to-transparent backdrop-blur-sm rounded-lg overflow-hidden border border-white/10 hover:border-white/20 hover:scale-[1.02] transition-all duration-300">
          <img loading="lazy"
            src="https://cdn.runrepeat.com/storage/gallery/product_primary/32545/adidas-ozweego-21158485-720.jpg"
            alt="Sneaker B" class="w-full h-64 object-cover" />
          <div class="p-4">
            <h3 class="font-semibold text-white">Adidas Ozweego</h3>
            <p class="text-sm text-white/60 mt-1">R$ 699</p>
            <div class="mt-4 flex items-center justify-between">
              <a class="inline-flex items-center gap-2 text-white hover:text-purple-300 font-medium transition-colors"
                href="#">
                Ver Mais
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
              </a>
              <span class="text-xs text-white/40">Em estoque</span>
            </div>
          </div>
        </article>

        <article
          class="min-w-[260px] md:min-w-[320px] snap-start bg-gradient-to-b from-white/[0.02] to-transparent backdrop-blur-sm rounded-lg overflow-hidden border border-white/10 hover:border-white/20 hover:scale-[1.02] transition-all duration-300">
          <img loading="lazy"
            src="https://cdn.runrepeat.com/storage/gallery/product_primary/39411/nike-zoom-vomero-5-lab-test-and-review-3-21506315-720.jpg"
            alt="Sneaker C" class="w-full h-64 object-cover" />
          <div class="p-4">
            <h3 class="font-semibold text-white">Nike Zoom Vomero 5</h3>
            <p class="text-sm text-white/60 mt-1">R$ 1.234</p>
            <div class="mt-4 flex items-center justify-between">
              <a class="inline-flex items-center gap-2 text-white hover:text-purple-300 font-medium transition-colors"
                href="#">
                Ver Mais
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
              </a>
              <span class="text-xs text-white/40">Em estoque</span>
            </div>
          </div>
        </article>
      </div>
    </div>
  </section>

  <!-- Collections -->
  <section id="colecoes" class="max-w-7xl mx-auto px-6 sm:px-8 py-20">
    <h2 class="text-2xl font-bold mb-6 bg-gradient-to-r from-purple-300 to-white bg-clip-text text-transparent">
      Coleções
    </h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      <div
        class="relative group overflow-hidden rounded-lg bg-gradient-to-b from-[#141414] to-[#0d0d0d] gradient-border">
        <div
          class="absolute inset-0 bg-gradient-to-t from-purple-600/10 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
        </div>
        <img loading="lazy"
          src="https://s2.glbimg.com/1bhoNJLYlyc-9fWOQIhEuuMv65Y=/620x620/smart/e.glbimg.com/og/ed/f/original/2022/08/21/tenis-de-edicao-limitada-tem-cerveja-na-sola.jpg"
          alt="Edição Limitada"
          class="w-full h-56 object-cover transition-transform duration-500 group-hover:scale-105" />
        <div class="p-6">
          <h3 class="font-bold text-lg text-purple-100">Edição Limitada</h3>
          <p class="text-sm text-gray-400 mt-2">
            Peças únicas com acabamento premium.
          </p>
        </div>
      </div>

      <div
        class="relative group overflow-hidden rounded-lg bg-gradient-to-b from-[#141414] to-[#0d0d0d] gradient-border">
        <div
          class="absolute inset-0 bg-gradient-to-t from-purple-600/10 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
        </div>
        <img loading="lazy" src="assets/img/carroussel/nike-o-fenomeno-jordan.jpg" alt="Street Icons"
          class="w-full h-56 object-cover transition-transform duration-500 group-hover:scale-105" />
        <div class="p-6">
          <h3 class="font-bold text-lg text-purple-100">Street Icons</h3>
          <p class="text-sm text-gray-400 mt-2">
            Modelos que marcaram a cultura.
          </p>
        </div>
      </div>

      <div
        class="relative group overflow-hidden rounded-lg bg-gradient-to-b from-[#141414] to-[#0d0d0d] gradient-border">
        <div
          class="absolute inset-0 bg-gradient-to-t from-purple-600/10 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
        </div>
        <img loading="lazy"
          src="assets/img/carroussel/https___hypebeast.com_image_2019_08_best-sneakers-cartoons-collaborations-main-1.avif"
          alt="Colaborações" class="w-full h-56 object-cover transition-transform duration-500 group-hover:scale-105" />
        <div class="p-6">
          <h3 class="font-bold text-lg text-purple-100">Colaborações</h3>
          <p class="text-sm text-gray-400 mt-2">
            Parcerias com artistas e marcas.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- Marketplace Preview -->
  <section id="marketplace" class="max-w-7xl mx-auto px-6 sm:px-8 py-14">
    <div
      class="bg-gradient-to-br from-white/[0.03] via-white/[0.01] to-transparent p-8 rounded-lg flex flex-col md:flex-row items-center gap-8 border border-white/10">
      <div class="flex-1">
        <h2 class="text-2xl font-bold text-white">Marketplace</h2>
        <p class="text-white/70 mt-3 text-lg">
          Compre, venda ou troque sneakers com segurança. Autenticação e
          curadoria feitas por especialistas.
        </p>
        <div class="mt-8 flex flex-wrap gap-4">
          <a href="auth.php"
            class="group px-6 py-3 bg-white text-black rounded-md font-semibold hover:bg-purple-50 transition-all duration-300 flex items-center gap-2">
            Comece Agora
            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
            </svg>
          </a>
          <a href="#"
            class="px-6 py-3 border border-white/20 text-white rounded-md hover:bg-white/5 transition-all duration-300">Saiba
            Como Funciona</a>
        </div>
      </div>

      <div class="w-full md:w-1/3">
        <div class="bg-white/[0.02] backdrop-blur-sm rounded-md p-6 border border-white/10">
          <h4 class="font-semibold text-white">Quer anunciar?</h4>
          <p class="text-sm text-white/60 mt-2">
            Cadastre seu par e alcance colecionadores e streetheads.
          </p>
          <div class="mt-4 grid grid-cols-1 gap-3">
            <a href="seller-onboarding.php">
              <button class="px-4 py-2 bg-white/10 hover:bg-white/15 text-white rounded-md transition-colors">
                Vender
              </button>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section id="hero2" class="relative h-screen w-full overflow-hidden">
    <img id="hero-image" class="absolute inset-0 w-full h-full object-cover"
      src="assets/img/carroussel/Rebook campaign.png"
      alt="Seis pares de tênis Reebok brancos com detalhes coloridos dispostos em círculo em um fundo azul escuro com linhas brancas." />

    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/40 to-transparent"></div>

    <div class="relative z-10 max-w-6xl mx-auto px-6 sm:px-8 h-full flex flex-col justify-center">
      <div class="max-w-3xl">
        <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight leading-tight opacity-0" id="hero-title">
          <span class="text-teal-400">A NOVA ERA</span>
          <span class="text-white">DOS</span>
          <span class="text-white">CLÁSSICOS</span>
        </h1>
        <p class="mt-6 text-gray-300 max-w-xl opacity-0" id="hero-sub">
          O estilo atemporal que redefiniu uma era. Parte da coleção
          <span class="font-black">'My Name Is'</span> da Reebok, esses ícones
          do court estão de volta com um toque contemporâneo.
        </p>

        <div class="mt-8 flex flex-wrap gap-4 opacity-0" id="hero-ctas">
          <a href="https://www.youtube.com/watch?v=CJaQ6_gadr0" target="_blank"
            class="inline-flex items-center px-6 py-3 bg-teal-400 text-black rounded-md font-semibold hover:scale-[1.02] transition">Descubra
            a Coleção</a>
          <a href="https://www.reebok.com.br/club-c"
            class="inline-flex items-center px-6 py-3 border border-white/10 rounded-md hover:bg-white/5 transition"
            target="_blank">Ver Modelos</a>
        </div>
      </div>
    </div>
  </section>

  <section id="sobre-sola-roxa" class="bg-white py-20 px-6 lg:px-20">
    <!-- Título -->
    <h2 class="text-3xl lg:text-4xl font-extrabold text-gray-900 mb-12 uppercase tracking-wide">
      Sobre a Sola <span class="text-purple-700">Roxa</span>
    </h2>

    <!-- Texto principal -->
    <div class="max-w-3xl mb-16">
      <p class="text-gray-700 text-lg leading-relaxed">
        A <span class="text-purple-700 font-semibold">Sola Roxa</span> é o
        ponto de encontro entre o estilo e a exclusividade. Criada para quem
        vive o <span class="font-semibold">streetwear</span> como forma de
        expressão, nosso marketplace conecta colecionadores e apaixonados por
        sneakers de edição limitada.
      </p>
    </div>

    <!-- Icon Row -->
    <div
      class="border-t border-gray-600 mt-16 pt-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-8 text-center text-sm text-gray-700">
      <div>
        <i data-lucide="truck" class="w-6 h-6 mx-auto text-purple-600 mb-3"></i>
        <p class="font-bold">Envio Rápido</p>
        <p class="text-xs text-gray-500">Entrega em até 7 dias úteis</p>
      </div>
      <div>
        <i data-lucide="credit-card" class="w-6 h-6 mx-auto text-purple-600 mb-3"></i>
        <p class="font-bold">Pagamento Seguro</p>
        <p class="text-xs text-gray-500">Com parcelamento fácil</p>
      </div>
      <div>
        <i data-lucide="check-circle" class="w-6 h-6 mx-auto text-purple-600 mb-3"></i>
        <p class="font-bold">Autenticidade</p>
        <p class="text-xs text-gray-500">Tênis 100% verificados</p>
      </div>
      <div>
        <i data-lucide="gift" class="w-6 h-6 mx-auto text-purple-600 mb-3"></i>
        <p class="font-bold">Embalagem Premium</p>
        <p class="text-xs text-gray-500">Cuidado em cada detalhe</p>
      </div>
      <div>
        <i data-lucide="headphones" class="w-6 h-6 mx-auto text-purple-600 mb-3"></i>
        <p class="font-bold">Suporte 24/7</p>
        <p class="text-xs text-gray-500">Atendimento personalizado</p>
      </div>
      <div>
        <i data-lucide="building" class="w-6 h-6 mx-auto text-purple-600 mb-3"></i>
        <p class="font-bold">Estilo Urbano</p>
        <p class="text-xs text-gray-500">Moda e cultura sneaker</p>
      </div>
    </div>
  </section>

  <!-- Lucide Script -->

  <script>
    lucide.createIcons();
  </script>

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