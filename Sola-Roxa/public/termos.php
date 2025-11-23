<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Termos de Uso | Sola Roxa</title>
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
      <h1 class="text-4xl font-bold mb-4 bg-gradient-to-r from-purple-400 to-cyan-400 bg-clip-text text-transparent">
        Termos de Uso
      </h1>
      <p class="text-white/60 mb-8">Última atualização: Dezembro de 2024</p>

      <div class="space-y-8 text-white/80 leading-relaxed">

        <section>
          <h2 class="text-2xl font-semibold text-white mb-3">1. Aceitação dos Termos</h2>
          <p>Ao acessar e usar a plataforma Sola Roxa, você concorda com estes Termos de Uso. Se você não concordar com algum termo, não utilize nossos serviços.</p>
        </section>

        <section>
          <h2 class="text-2xl font-semibold text-white mb-3">2. Definições</h2>
          <ul class="list-disc list-inside space-y-2 ml-4">
            <li><strong class="text-white">Plataforma:</strong> marketplace Sola Roxa, incluindo website e aplicativos</li>
            <li><strong class="text-white">Usuário:</strong> qualquer pessoa que acessa a plataforma</li>
            <li><strong class="text-white">Comprador:</strong> usuário que adquire produtos</li>
            <li><strong class="text-white">Vendedor:</strong> usuário que anuncia e vende produtos</li>
          </ul>
        </section>

        <section>
          <h2 class="text-2xl font-semibold text-white mb-3">3. Cadastro e Conta</h2>
          <ul class="list-disc list-inside space-y-2 ml-4">
            <li>É necessário ter 18 anos ou mais para criar uma conta</li>
            <li>Você deve fornecer informações verdadeiras e atualizadas</li>
            <li>Você é responsável pela segurança da sua senha</li>
            <li>Não compartilhe sua conta com terceiros</li>
            <li>Notifique-nos imediatamente sobre qualquer uso não autorizado</li>
          </ul>
        </section>

        <section>
          <h2 class="text-2xl font-semibold text-white mb-3">4. Responsabilidades dos Vendedores</h2>
          <ul class="list-disc list-inside space-y-2 ml-4">
            <li>Garantir a autenticidade dos produtos anunciados</li>
            <li>Fornecer descrições precisas e fotos reais</li>
            <li>Embalar adequadamente os produtos para envio</li>
            <li>Cumprir prazos de envio acordados</li>
            <li>Responder às dúvidas dos compradores em até 48 horas</li>
            <li>Não vender produtos falsificados, roubados ou contrabandeados</li>
          </ul>
        </section>

        <section>
          <h2 class="text-2xl font-semibold text-white mb-3">5. Responsabilidades dos Compradores</h2>
          <ul class="list-disc list-inside space-y-2 ml-4">
            <li>Fornecer endereço de entrega correto e completo</li>
            <li>Efetuar o pagamento conforme as condições acordadas</li>
            <li>Comunicar problemas com produtos dentro do prazo de 7 dias</li>
            <li>Não utilizar a plataforma para fraudes ou atividades ilegais</li>
          </ul>
        </section>

        <section>
          <h2 class="text-2xl font-semibold text-white mb-3">6. Produtos Proibidos</h2>
          <p class="mb-3">É estritamente proibido anunciar:</p>
          <ul class="list-disc list-inside space-y-2 ml-4">
            <li>Produtos falsificados ou réplicas</li>
            <li>Produtos roubados ou de origem ilícita</li>
            <li>Produtos que violem direitos de propriedade intelectual</li>
            <li>Produtos perigosos ou ilegais</li>
            <li>Produtos que violem normas sanitárias ou de segurança</li>
          </ul>
        </section>

        <section>
          <h2 class="text-2xl font-semibold text-white mb-3">7. Pagamentos e Taxas</h2>
          <ul class="list-disc list-inside space-y-2 ml-4">
            <li>Os pagamentos são processados por gateways seguros de terceiros</li>
            <li>A Sola Roxa cobra uma taxa de serviço sobre cada venda realizada</li>
            <li>Os valores das taxas estão disponíveis em nossa página de vendedores</li>
            <li>Todas as transações estão sujeitas a verificações de segurança</li>
          </ul>
        </section>

        <section>
          <h2 class="text-2xl font-semibold text-white mb-3">8. Propriedade Intelectual</h2>
          <p>Todo o conteúdo da plataforma (logos, marcas, textos, imagens, código) é propriedade da Sola Roxa ou de seus licenciadores e está protegido por leis de direitos autorais.</p>
        </section>

        <section>
          <h2 class="text-2xl font-semibold text-white mb-3">9. Limitação de Responsabilidade</h2>
          <ul class="list-disc list-inside space-y-2 ml-4">
            <li>A Sola Roxa atua como intermediadora entre compradores e vendedores</li>
            <li>Não somos responsáveis pela qualidade, autenticidade ou legalidade dos produtos</li>
            <li>Não garantimos disponibilidade ininterrupta da plataforma</li>
            <li>Não nos responsabilizamos por danos indiretos ou perdas de lucro</li>
          </ul>
        </section>

        <section>
          <h2 class="text-2xl font-semibold text-white mb-3">10. Suspensão e Exclusão de Conta</h2>
          <p class="mb-3">Reservamo-nos o direito de suspender ou excluir contas que:</p>
          <ul class="list-disc list-inside space-y-2 ml-4">
            <li>Violem estes Termos de Uso</li>
            <li>Pratiquem fraudes ou atividades ilegais</li>
            <li>Recebam múltiplas reclamações de outros usuários</li>
            <li>Permaneçam inativas por mais de 2 anos</li>
          </ul>
        </section>

        <section>
          <h2 class="text-2xl font-semibold text-white mb-3">11. Modificações dos Termos</h2>
          <p>Podemos atualizar estes Termos de Uso a qualquer momento. Notificaremos os usuários sobre mudanças significativas através do e-mail cadastrado.</p>
        </section>

        <section>
          <h2 class="text-2xl font-semibold text-white mb-3">12. Lei Aplicável e Foro</h2>
          <p>Estes termos são regidos pelas leis brasileiras. Fica eleito o foro da comarca de [Cidade], para dirimir quaisquer dúvidas ou controvérsias.</p>
        </section>

        <section class="bg-purple-900/20 p-6 rounded-lg border border-purple-500/20">
          <h2 class="text-2xl font-semibold text-white mb-3">13. Contato</h2>
          <p>Para dúvidas sobre estes Termos de Uso:</p>
          <div class="mt-4 space-y-2">
            <p><strong class="text-white">E-mail:</strong> juridico@solaroxa.com.br</p>
            <p><strong class="text-white">Suporte:</strong> suporte@solaroxa.com.br</p>
          </div>
        </section>

        <section class="text-sm text-white/60 border-t border-white/10 pt-6">
          <p>Ao continuar usando a Sola Roxa, você confirma que leu, entendeu e aceitou estes Termos de Uso.</p>
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