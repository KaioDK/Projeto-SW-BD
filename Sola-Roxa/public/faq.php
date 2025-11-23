<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>FAQ | Sola Roxa</title>
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
        Perguntas Frequentes
      </h1>

      <div class="space-y-6">
        <!-- FAQ Item -->
        <div class="bg-white/5 rounded-lg p-6 border border-white/10">
          <h3 class="text-xl font-semibold mb-3">Como faço um pedido?</h3>
          <p class="text-white/70">Navegue pelo nosso marketplace, escolha o produto desejado, selecione o tamanho e clique em "Comprar Agora" ou "Adicionar ao Carrinho". Finalize seu pedido no carrinho informando endereço e forma de pagamento.</p>
        </div>

        <div class="bg-white/5 rounded-lg p-6 border border-white/10">
          <h3 class="text-xl font-semibold mb-3">Quais são as formas de pagamento?</h3>
          <p class="text-white/70">Aceitamos PIX, cartão de crédito e boleto bancário. O pagamento é processado de forma segura através da nossa plataforma.</p>
        </div>

        <div class="bg-white/5 rounded-lg p-6 border border-white/10">
          <h3 class="text-xl font-semibold mb-3">Quanto tempo demora a entrega?</h3>
          <p class="text-white/70">O prazo varia de acordo com sua região e o vendedor. Em média, as entregas são realizadas entre 5 a 15 dias úteis após a confirmação do pagamento.</p>
        </div>

        <div class="bg-white/5 rounded-lg p-6 border border-white/10">
          <h3 class="text-xl font-semibold mb-3">Posso trocar ou devolver?</h3>
          <p class="text-white/70">Sim! Você tem até 7 dias após o recebimento para solicitar troca ou devolução, conforme o Código de Defesa do Consumidor. O produto deve estar em perfeitas condições.</p>
        </div>

        <div class="bg-white/5 rounded-lg p-6 border border-white/10">
          <h3 class="text-xl font-semibold mb-3">Como faço para vender na Sola Roxa?</h3>
          <p class="text-white/70">Acesse a página de cadastro de vendedor, preencha seus dados e comece a anunciar seus produtos. É rápido, fácil e sem custos iniciais!</p>
        </div>

        <div class="bg-white/5 rounded-lg p-6 border border-white/10">
          <h3 class="text-xl font-semibold mb-3">Os produtos são autênticos?</h3>
          <p class="text-white/70">Trabalhamos apenas com vendedores verificados e incentivamos a transparência nas descrições. Em caso de dúvidas sobre autenticidade, entre em contato com o vendedor antes da compra.</p>
        </div>
      </div>
    </div>
  </main>

  <script src="assets/scripts/main.js"></script>
  <script>
    lucide.createIcons();
  </script>
</body>

</html>