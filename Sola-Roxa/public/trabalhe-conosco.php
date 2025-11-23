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
    body { background: linear-gradient(180deg, #0d0d0d, #0b0b0b); }
  </style>
</head>
<body class="font-sans text-white antialiased">
  
  <!-- Header -->
  <header class="fixed top-0 left-0 w-full z-50 bg-black/80 backdrop-blur-md border-b border-white/10">
    <nav class="max-w-7xl mx-auto px-6 sm:px-8 h-20 flex items-center justify-between">
      <a href="index.php" class="text-2xl font-bold bg-gradient-to-r from-purple-400 to-cyan-400 bg-clip-text text-transparent">
        SOLA ROXA
      </a>
      <div class="flex items-center gap-6">
        <a href="catalog.php" class="text-white/80 hover:text-white transition-colors">Catálogo</a>
        <a href="sobre.php" class="text-white/80 hover:text-white transition-colors">Sobre</a>
        <a href="auth.php" class="text-white/80 hover:text-white transition-colors">Login</a>
      </div>
    </nav>
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
  <script>lucide.createIcons();</script>
</body>
</html>
