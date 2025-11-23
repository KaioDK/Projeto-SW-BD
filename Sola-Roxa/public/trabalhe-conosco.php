<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Trabalhe Conosco | Sola Roxa</title>
  <link rel="icon" href="assets/img/favicon/favicon_io/favicon.ico" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
  <style>
    body {
      background: linear-gradient(180deg, #0d0d0d, #0b0b0b);
    }
  </style>
</head>

<body class="font-sans text-white antialiased">

  <!-- Inter font: fonte principal para textos e UI -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Fjalla+One&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Mountains+of+Christmas:wght@400;700&family=Satisfy&display=swap" rel="stylesheet">

  <!-- Header -->
  <header id="site-header" class="fixed w-full z-40 top-0 transition-all duration-300">
    <nav class="max-w-7xl mx-auto px-6 sm:px-8 flex items-center justify-between h-16 transition-all duration-300">
      <div class="flex items-center gap-6">
        <a href="index.php" style="font-family: Fjalla One" class="text-xl font-extrabold tracking-widest">SOLA <span
            class="text-purple-700">ROXA</span></a>
      </div>

      <ul class="hidden md:flex gap-8 text-sm text-white-200 uppercase tracking-wider">
        <li>
          <a class="hover:text-roxa transition" href="index.php#lancamentos">Lançamentos</a>
        </li>
        <li>
          <a class="hover:text-roxa transition" href="catalog.php?estado=novo">Novos</a>
        </li>
        <li>
          <a class="hover:text-roxa transition" href="catalog.php?estado=semi-novo,usado">Outlet</a>
        </li>
        <li>
          <a class="hover:text-roxa transition" href="index.php#colecoes">Colecionáveis</a>
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

  <main class="pt-28 pb-16 min-h-screen">
    <div class="max-w-4xl mx-auto px-6">
      <h1 class="text-4xl font-bold mb-8 bg-gradient-to-r from-purple-400 to-cyan-400 bg-clip-text text-transparent">
        Trabalhe Conosco
      </h1>

      <div class="space-y-8">
        <section class="text-white/80 leading-relaxed">
          <p class="text-lg">A <strong class="text-white">Sola Roxa</strong> está sempre em busca de pessoas talentosas e apaixonadas por sneakers e cultura urbana para fazer parte do nosso time!</p>
        </section>

        <section>
          <h2 class="text-2xl font-semibold mb-4">Por que trabalhar na Sola Roxa?</h2>
          <div class="grid md:grid-cols-2 gap-4">
            <div class="bg-white/5 p-6 rounded-lg border border-white/10">
              <i data-lucide="rocket" class="w-8 h-8 text-purple-400 mb-3"></i>
              <h3 class="font-semibold mb-2">Ambiente Inovador</h3>
              <p class="text-white/70 text-sm">Trabalhe em um ambiente dinâmico e criativo, onde suas ideias são valorizadas.</p>
            </div>
            <div class="bg-white/5 p-6 rounded-lg border border-white/10">
              <i data-lucide="users" class="w-8 h-8 text-purple-400 mb-3"></i>
              <h3 class="font-semibold mb-2">Time Colaborativo</h3>
              <p class="text-white/70 text-sm">Faça parte de uma equipe apaixonada e comprometida com o sucesso coletivo.</p>
            </div>
            <div class="bg-white/5 p-6 rounded-lg border border-white/10">
              <i data-lucide="trending-up" class="w-8 h-8 text-purple-400 mb-3"></i>
              <h3 class="font-semibold mb-2">Crescimento</h3>
              <p class="text-white/70 text-sm">Oportunidades reais de desenvolvimento profissional e crescimento na carreira.</p>
            </div>
            <div class="bg-white/5 p-6 rounded-lg border border-white/10">
              <i data-lucide="heart" class="w-8 h-8 text-purple-400 mb-3"></i>
              <h3 class="font-semibold mb-2">Cultura Sneakerhead</h3>
              <p class="text-white/70 text-sm">Trabalhe com o que você ama: moda, sneakers e cultura urbana.</p>
            </div>
          </div>
        </section>

        <section>
          <h2 class="text-2xl font-semibold mb-4">Áreas de Atuação</h2>
          <ul class="space-y-3 text-white/80">
            <li class="flex items-start gap-3">
              <i data-lucide="check-circle" class="w-5 h-5 text-purple-400 mt-1"></i>
              <span><strong class="text-white">Desenvolvimento:</strong> Frontend, Backend, Mobile</span>
            </li>
            <li class="flex items-start gap-3">
              <i data-lucide="check-circle" class="w-5 h-5 text-purple-400 mt-1"></i>
              <span><strong class="text-white">Marketing:</strong> Social Media, SEO, Performance</span>
            </li>
            <li class="flex items-start gap-3">
              <i data-lucide="check-circle" class="w-5 h-5 text-purple-400 mt-1"></i>
              <span><strong class="text-white">Atendimento:</strong> Suporte ao Cliente, Vendas</span>
            </li>
            <li class="flex items-start gap-3">
              <i data-lucide="check-circle" class="w-5 h-5 text-purple-400 mt-1"></i>
              <span><strong class="text-white">Logística:</strong> Operações, Estoque</span>
            </li>
          </ul>
        </section>

        <section class="bg-purple-900/20 p-8 rounded-lg border border-purple-500/20">
          <h2 class="text-2xl font-semibold mb-4">Envie seu Currículo</h2>
          <p class="text-white/80 mb-4">Interessado em fazer parte do time? Envie seu currículo e portfólio para:</p>
          <a href="mailto:rh@solaroxa.com.br" class="inline-flex items-center gap-2 px-6 py-3 bg-purple-600 hover:bg-purple-700 rounded-lg font-semibold transition">
            <i data-lucide="mail"></i>
            rh@solaroxa.com.br
          </a>
        </section>
      </div>
    </div>
  </main>

  <script src="assets/scripts/main.js"></script>
  <script>
    lucide.createIcons();
  </script>
</body>

</html>