<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Política de Devoluções | Sola Roxa</title>
  <link rel="icon" href="assets/img/favicon/favicon_io/favicon.ico" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
  <style>
    body {
      background: linear-gradient(180deg, #0d0d0d, #0b0b0b);
    }
  </style>
</head>

<!-- Inter font: fonte principal para textos e UI -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
  href="https://fonts.googleapis.com/css2?family=Fjalla+One&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
  rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Mountains+of+Christmas:wght@400;700&family=Satisfy&display=swap" rel="stylesheet">

<body class="font-sans text-white antialiased">

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
        Política de Devoluções e Trocas
      </h1>

      <div class="space-y-8 text-white/80 leading-relaxed">
        <section>
          <h2 class="text-2xl font-semibold mb-4 text-white">Prazo para Devolução</h2>
          <p>Conforme o Código de Defesa do Consumidor, você tem até <strong class="text-white">7 dias corridos</strong> após o recebimento do produto para solicitar devolução ou troca, sem necessidade de justificativa.</p>
        </section>

        <section>
          <h2 class="text-2xl font-semibold mb-4 text-white">Condições do Produto</h2>
          <p>Para que a devolução seja aceita, o produto deve atender aos seguintes requisitos:</p>
          <ul class="list-disc list-inside mt-3 space-y-2 ml-4">
            <li>Estar sem sinais de uso</li>
            <li>Com a embalagem original intacta</li>
            <li>Acompanhado de todos os acessórios e manuais</li>
            <li>Com etiquetas originais anexadas</li>
          </ul>
        </section>

        <section>
          <h2 class="text-2xl font-semibold mb-4 text-white">Como Solicitar</h2>
          <p>Para solicitar uma troca ou devolução:</p>
          <ol class="list-decimal list-inside mt-3 space-y-2 ml-4">
            <li>Acesse sua conta e vá até "Meus Pedidos"</li>
            <li>Selecione o pedido e clique em "Solicitar Devolução"</li>
            <li>Escolha o motivo e aguarde aprovação</li>
            <li>Envie o produto de volta conforme instruções recebidas</li>
          </ol>
        </section>

        <section>
          <h2 class="text-2xl font-semibold mb-4 text-white">Reembolso</h2>
          <p>Após recebermos e aprovarmos a devolução, o reembolso será processado em até 10 dias úteis. O valor será devolvido na mesma forma de pagamento utilizada na compra.</p>
        </section>

        <section>
          <h2 class="text-2xl font-semibold mb-4 text-white">Frete de Devolução</h2>
          <p>Em caso de <strong class="text-white">defeito de fabricação ou erro no envio</strong>, o frete de devolução é por nossa conta. Em outros casos, o custo fica a cargo do cliente.</p>
        </section>

        <section>
          <h2 class="text-2xl font-semibold mb-4 text-white">Trocas</h2>
          <p>Para trocas de tamanho ou cor, siga o mesmo procedimento de devolução. O novo produto será enviado após recebermos o item original. Sujeito a disponibilidade em estoque.</p>
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