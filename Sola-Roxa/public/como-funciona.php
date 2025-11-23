<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Como Funciona | Sola Roxa</title>
  <meta name="description" content="Entenda como comprar e vender sneakers no marketplace Sola Roxa" />
  <link rel="icon" href="assets/img/favicon/favicon_io/favicon.ico" />

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fjalla+One&display=swap" rel="stylesheet">

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            roxa: "#8B5CF6",
          },
          fontFamily: {
            sans: ["Inter", "ui-sans-serif", "system-ui"],
          },
        },
      },
    };
  </script>

  <!-- GSAP -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

  <style>
    .gradient-border {
      position: relative;
    }
    .gradient-border::before {
      content: '';
      position: absolute;
      inset: 0;
      border-radius: 0.5rem;
      padding: 1px;
      background: linear-gradient(135deg, rgba(139, 92, 246, 0.3), transparent);
      -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
      -webkit-mask-composite: xor;
      mask-composite: exclude;
    }
  </style>
</head>

<body class="bg-[#090909] text-white font-sans antialiased leading-normal">
  <!-- Header -->
  <header id="site-header" class="fixed w-full z-40 top-0 transition-all duration-300 bg-black/80 backdrop-blur-md">
    <nav class="max-w-7xl mx-auto px-6 sm:px-8 flex items-center justify-between h-16">
      <div class="flex items-center gap-6">
        <a href="index.php" style="font-family: Fjalla One" class="text-xl font-extrabold tracking-widest">
          SOLA <span class="text-purple-700">ROXA</span>
        </a>
      </div>

      <ul class="hidden md:flex gap-8 text-sm text-white-200 uppercase tracking-wider">
        <li><a class="hover:text-roxa transition" href="index.php#lancamentos">Lançamentos</a></li>
        <li><a class="hover:text-roxa transition" href="catalog.php?estado=novo">Novos</a></li>
        <li><a class="hover:text-roxa transition" href="catalog.php?estado=semi-novo,usado">Outlet</a></li>
        <li><a class="hover:text-roxa transition" href="index.php#colecoes">Colecionáveis</a></li>
        <li><a class="hover:text-roxa transition" href="catalog.php">Marketplace</a></li>
      </ul>

      <div class="flex items-center gap-4">
        <a href="profile.php">
          <button aria-label="conta" class="p-2 rounded-md hover:bg-white/5 transition cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
            </svg>
          </button>
        </a>
        <a href="cart.php" class="relative">
          <button aria-label="carrinho" class="p-2 rounded-md hover:bg-white/5 transition cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
            </svg>
            <span id="cart-count" class="absolute -top-2 -right-2 min-w-[22px] h-[22px] px-1 rounded-full bg-roxa text-black text-xs font-bold flex items-center justify-center border border-white/10" style="display:none;">0</span>
          </button>
        </a>
      </div>
    </nav>
  </header>

  <!-- Hero -->
  <section class="pt-28 pb-16 px-6 sm:px-8">
    <div class="max-w-4xl mx-auto text-center">
      <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight leading-tight">
        Como Funciona o <span class="text-roxa">Marketplace</span>
      </h1>
      <p class="mt-6 text-lg text-gray-400 max-w-2xl mx-auto">
        Compre, venda ou troque sneakers de edição limitada com segurança, autenticidade e curadoria especializada.
      </p>
    </div>
  </section>

  <!-- Para Compradores -->
  <section class="max-w-7xl mx-auto px-6 sm:px-8 py-16">
    <div class="mb-12">
      <h2 class="text-3xl font-bold mb-3 flex items-center gap-3">
        <i data-lucide="shopping-bag" class="w-8 h-8 text-roxa"></i>
        Para Compradores
      </h2>
      <p class="text-gray-400">Encontre os sneakers dos seus sonhos com segurança</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <!-- Step 1 -->
      <div class="bg-gradient-to-b from-white/[0.05] to-transparent p-6 rounded-xl border border-white/10 gradient-border">
        <div class="w-12 h-12 rounded-full bg-roxa/20 flex items-center justify-center mb-4">
          <span class="text-2xl font-bold text-roxa">1</span>
        </div>
        <h3 class="text-xl font-bold mb-3">Navegue no Catálogo</h3>
        <p class="text-gray-400 mb-4">
          Explore centenas de sneakers autênticos de edição limitada. Use filtros para encontrar tamanho, marca, estado e preço ideal.
        </p>
        <a href="catalog.php" class="text-roxa hover:text-purple-400 font-semibold text-sm flex items-center gap-2">
          Ver Catálogo
          <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </a>
      </div>

      <!-- Step 2 -->
      <div class="bg-gradient-to-b from-white/[0.05] to-transparent p-6 rounded-xl border border-white/10 gradient-border">
        <div class="w-12 h-12 rounded-full bg-roxa/20 flex items-center justify-center mb-4">
          <span class="text-2xl font-bold text-roxa">2</span>
        </div>
        <h3 class="text-xl font-bold mb-3">Adicione ao Carrinho</h3>
        <p class="text-gray-400 mb-4">
          Encontrou o par perfeito? Adicione ao carrinho e revise os detalhes: tamanho, estado, fotos e descrição do vendedor.
        </p>
        <div class="flex items-center gap-2 text-sm text-gray-500">
          <i data-lucide="shield-check" class="w-4 h-4 text-green-500"></i>
          Produto verificado
        </div>
      </div>

      <!-- Step 3 -->
      <div class="bg-gradient-to-b from-white/[0.05] to-transparent p-6 rounded-xl border border-white/10 gradient-border">
        <div class="w-12 h-12 rounded-full bg-roxa/20 flex items-center justify-center mb-4">
          <span class="text-2xl font-bold text-roxa">3</span>
        </div>
        <h3 class="text-xl font-bold mb-3">Finalize com Segurança</h3>
        <p class="text-gray-400 mb-4">
          Escolha seu endereço de entrega e método de pagamento (Cartão, Pix ou Boleto). Receba confirmação imediata e acompanhe o envio.
        </p>
        <div class="flex items-center gap-2 text-sm text-gray-500">
          <i data-lucide="truck" class="w-4 h-4 text-blue-500"></i>
          Entrega rápida
        </div>
      </div>
    </div>

    <!-- Garantias -->
    <div class="mt-12 bg-gradient-to-br from-roxa/10 to-transparent p-8 rounded-xl border border-roxa/20">
      <h3 class="text-xl font-bold mb-4 flex items-center gap-3">
        <i data-lucide="shield" class="w-6 h-6 text-roxa"></i>
        Nossa Garantia para Compradores
      </h3>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-300">
        <div class="flex items-start gap-3">
          <i data-lucide="check-circle" class="w-5 h-5 text-green-500 mt-1"></i>
          <div>
            <p class="font-semibold">Autenticidade 100%</p>
            <p class="text-sm text-gray-400">Todos os produtos passam por verificação rigorosa</p>
          </div>
        </div>
        <div class="flex items-start gap-3">
          <i data-lucide="check-circle" class="w-5 h-5 text-green-500 mt-1"></i>
          <div>
            <p class="font-semibold">Pagamento Seguro</p>
            <p class="text-sm text-gray-400">Transações protegidas e criptografadas</p>
          </div>
        </div>
        <div class="flex items-start gap-3">
          <i data-lucide="check-circle" class="w-5 h-5 text-green-500 mt-1"></i>
          <div>
            <p class="font-semibold">Suporte Dedicado</p>
            <p class="text-sm text-gray-400">Equipe disponível 24/7 para ajudar</p>
          </div>
        </div>
        <div class="flex items-start gap-3">
          <i data-lucide="check-circle" class="w-5 h-5 text-green-500 mt-1"></i>
          <div>
            <p class="font-semibold">Rastreamento Completo</p>
            <p class="text-sm text-gray-400">Acompanhe seu pedido em tempo real</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Divisor -->
  <div class="max-w-7xl mx-auto px-6 sm:px-8">
    <div class="h-px bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>
  </div>

  <!-- Para Vendedores -->
  <section class="max-w-7xl mx-auto px-6 sm:px-8 py-16">
    <div class="mb-12">
      <h2 class="text-3xl font-bold mb-3 flex items-center gap-3">
        <i data-lucide="store" class="w-8 h-8 text-roxa"></i>
        Para Vendedores
      </h2>
      <p class="text-gray-400">Transforme sua coleção em oportunidade</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <!-- Step 1 -->
      <div class="bg-gradient-to-b from-white/[0.05] to-transparent p-6 rounded-xl border border-white/10 gradient-border">
        <div class="w-12 h-12 rounded-full bg-roxa/20 flex items-center justify-center mb-4">
          <span class="text-2xl font-bold text-roxa">1</span>
        </div>
        <h3 class="text-xl font-bold mb-3">Cadastre-se como Vendedor</h3>
        <p class="text-gray-400 mb-4">
          Crie sua conta gratuita e configure seu perfil de vendedor. Processo rápido com verificação de identidade para segurança da comunidade.
        </p>
        <a href="seller-onboarding.php" class="text-roxa hover:text-purple-400 font-semibold text-sm flex items-center gap-2">
          Começar Agora
          <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </a>
      </div>

      <!-- Step 2 -->
      <div class="bg-gradient-to-b from-white/[0.05] to-transparent p-6 rounded-xl border border-white/10 gradient-border">
        <div class="w-12 h-12 rounded-full bg-roxa/20 flex items-center justify-center mb-4">
          <span class="text-2xl font-bold text-roxa">2</span>
        </div>
        <h3 class="text-xl font-bold mb-3">Crie seu Anúncio</h3>
        <p class="text-gray-400 mb-4">
          Fotografe seu sneaker, adicione título, descrição, tamanho, estado e preço. Quanto mais detalhes, maior a confiança do comprador.
        </p>
        <div class="flex flex-wrap gap-2 text-xs">
          <span class="px-2 py-1 bg-white/5 rounded">Múltiplas fotos</span>
          <span class="px-2 py-1 bg-white/5 rounded">Descrição rica</span>
          <span class="px-2 py-1 bg-white/5 rounded">Preço justo</span>
        </div>
      </div>

      <!-- Step 3 -->
      <div class="bg-gradient-to-b from-white/[0.05] to-transparent p-6 rounded-xl border border-white/10 gradient-border">
        <div class="w-12 h-12 rounded-full bg-roxa/20 flex items-center justify-center mb-4">
          <span class="text-2xl font-bold text-roxa">3</span>
        </div>
        <h3 class="text-xl font-bold mb-3">Venda e Receba</h3>
        <p class="text-gray-400 mb-4">
          Quando seu produto for vendido, você recebe notificação instantânea. Embale com cuidado e envie para o comprador. Pagamento liberado após confirmação.
        </p>
        <div class="flex items-center gap-2 text-sm text-gray-500">
          <i data-lucide="banknote" class="w-4 h-4 text-green-500"></i>
          Receba em até 7 dias
        </div>
      </div>
    </div>

    <!-- Taxas e Vantagens -->
    <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-8">
      <!-- Taxas -->
      <div class="bg-gradient-to-br from-white/[0.05] to-transparent p-8 rounded-xl border border-white/10">
        <h3 class="text-xl font-bold mb-4 flex items-center gap-3">
          <i data-lucide="percent" class="w-6 h-6 text-roxa"></i>
          Taxas Transparentes
        </h3>
        <div class="space-y-3 text-gray-300">
          <div class="flex justify-between items-center pb-3 border-b border-white/10">
            <span>Taxa de Listagem</span>
            <span class="font-bold text-green-500">GRÁTIS</span>
          </div>
          <div class="flex justify-between items-center pb-3 border-b border-white/10">
            <span>Comissão por Venda</span>
            <span class="font-bold">10%</span>
          </div>
          <div class="flex justify-between items-center">
            <span>Transferência Bancária</span>
            <span class="font-bold text-green-500">SEM CUSTO</span>
          </div>
        </div>
        <p class="text-sm text-gray-400 mt-4">
          * Você só paga quando vender. Sem mensalidades, sem taxas ocultas.
        </p>
      </div>

      <!-- Vantagens -->
      <div class="bg-gradient-to-br from-roxa/10 to-transparent p-8 rounded-xl border border-roxa/20">
        <h3 class="text-xl font-bold mb-4 flex items-center gap-3">
          <i data-lucide="star" class="w-6 h-6 text-roxa"></i>
          Por Que Vender na Sola Roxa?
        </h3>
        <div class="space-y-3 text-gray-300">
          <div class="flex items-start gap-3">
            <i data-lucide="users" class="w-5 h-5 text-roxa mt-1"></i>
            <div>
              <p class="font-semibold">Alcance Qualificado</p>
              <p class="text-sm text-gray-400">Milhares de colecionadores e entusiastas</p>
            </div>
          </div>
          <div class="flex items-start gap-3">
            <i data-lucide="zap" class="w-5 h-5 text-roxa mt-1"></i>
            <div>
              <p class="font-semibold">Venda Rápida</p>
              <p class="text-sm text-gray-400">Produtos de qualidade vendem em média em 3 dias</p>
            </div>
          </div>
          <div class="flex items-start gap-3">
            <i data-lucide="shield-check" class="w-5 h-5 text-roxa mt-1"></i>
            <div>
              <p class="font-semibold">Proteção contra Fraude</p>
              <p class="text-sm text-gray-400">Sistema anti-fraude e pagamento garantido</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA Final -->
  <section class="max-w-7xl mx-auto px-6 sm:px-8 py-16">
    <div class="bg-gradient-to-br from-roxa/20 via-roxa/5 to-transparent p-12 rounded-2xl border border-roxa/30 text-center">
      <h2 class="text-3xl md:text-4xl font-bold mb-4">Pronto para Começar?</h2>
      <p class="text-gray-400 mb-8 max-w-2xl mx-auto">
        Junte-se à maior comunidade de sneakerheads do Brasil. Compre, venda e conecte-se com outros apaixonados por cultura urbana.
      </p>
      <div class="flex flex-wrap gap-4 justify-center">
        <a href="catalog.php" class="px-8 py-4 bg-roxa text-white rounded-lg font-semibold hover:bg-purple-600 transition-all duration-300 flex items-center gap-2">
          Explorar Marketplace
          <i data-lucide="arrow-right" class="w-5 h-5"></i>
        </a>
        <a href="seller-onboarding.php" class="px-8 py-4 border border-white/20 text-white rounded-lg hover:bg-white/5 transition-all duration-300">
          Começar a Vender
        </a>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-white/[0.01] mt-12 border-t border-white/10">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 py-12 grid grid-cols-1 md:grid-cols-4 gap-8 text-sm">
      <div>
        <h5 class="font-semibold text-white mb-4">Ajuda</h5>
        <ul class="space-y-3">
          <li><a href="javascript:void(0)" class="text-white/60 hover:text-white transition-colors">FAQ</a></li>
          <li><a href="javascript:void(0)" class="text-white/60 hover:text-white transition-colors">Envios</a></li>
          <li><a href="javascript:void(0)" class="text-white/60 hover:text-white transition-colors">Devoluções</a></li>
        </ul>
      </div>
      <div>
        <h5 class="font-semibold text-white mb-4">Sobre Nós</h5>
        <ul class="space-y-3">
          <li><a href="sobre.php" class="text-white/60 hover:text-white transition-colors">Sobre Sola Roxa</a></li>
          <li><a href="javascript:void(0)" class="text-white/60 hover:text-white transition-colors">Trabalhe conosco</a></li>
        </ul>
      </div>
      <div>
        <h5 class="font-semibold text-white mb-4">Redes Sociais</h5>
        <ul class="space-y-3">
          <li><a href="javascript:void(0)" class="text-white/60 hover:text-white transition-colors">Instagram</a></li>
          <li><a href="javascript:void(0)" class="text-white/60 hover:text-white transition-colors">Twitter</a></li>
        </ul>
      </div>
      <div>
        <h5 class="font-semibold text-white mb-4">Termos</h5>
        <ul class="space-y-3">
          <li><a href="javascript:void(0)" class="text-white/60 hover:text-white transition-colors">Política de Privacidade</a></li>
          <li><a href="javascript:void(0)" class="text-white/60 hover:text-white transition-colors">Termos de Uso</a></li>
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

  <script>
    lucide.createIcons();
    document.getElementById('year').textContent = new Date().getFullYear();

    // Animate on load
    window.addEventListener('load', () => {
      gsap.from('h1', { y: 30, opacity: 0, duration: 0.8 });
      gsap.from('h2', { y: 20, opacity: 0, duration: 0.6, stagger: 0.1, delay: 0.3 });
      gsap.from('.gradient-border', { y: 20, opacity: 0, duration: 0.5, stagger: 0.1, delay: 0.5 });
    });
  </script>
  <script src="assets/scripts/main.js"></script>
</body>

</html>
