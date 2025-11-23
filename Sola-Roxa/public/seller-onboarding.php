<?php
require_once __DIR__ . '/../backend/auth.php';
// Permite acesso a usuários autenticados (comprador ou vendedor).
// Se o usuário não estiver autenticado, redireciona para `auth.php`.
if (!isLoggedUser() && !isLoggedSeller()) {
  header('Location: auth.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Vender na Sola Roxa — Criar Anúncio</title>
  <meta name="description" content="Seller onboarding & listing creation for Sola Roxa marketplace" />
  <!-- Fonts: import das fontes Google usadas no layout -->
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Poppins:wght@400;600&display=swap"
    rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Fjalla+One&family=Great+Vibes&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Caveat+Brush&display=swap" rel="stylesheet">
  <link rel="icon" href="assets/img/favicon/favicon_io/favicon.ico" />

  <!-- Tailwind CDN: configuração rápida do Tailwind para protótipo -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            roxa: "#8B5CF6",
            cyan: "#00F0FF",
            pagebg: "#090909"
          },
          fontFamily: {
            sans: ["Inter", "ui-sans-serif", "system-ui"]
          },
        },
      },
    };
  </script>

  <!-- Lucide icons: biblioteca de ícones no frontend -->
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

  <style>
    body {
      background: linear-gradient(180deg, #0d0d0d, #0b0b0b);
    }

    .step-active {
      background: linear-gradient(90deg, #8b5cf6);
      color: white;
    }

    .drop-zone {
      border-style: dashed;
      border-width: 2px;
      border-color: rgba(255, 255, 255, 0.06);
    }

    .card {
      background: linear-gradient(180deg,
          rgba(255, 255, 255, 0.02),
          rgba(0, 0, 0, 0.06));
      border: 1px solid rgba(255, 255, 255, 0.04);
    }

    input,
    textarea,
    select {
      background: transparent;
      color: #f8fafb;
      border-color: rgba(255, 255, 255, 0.08);
    }

    /* Tornar as opções do select visíveis no tema escuro.
       Muitos navegadores aplicam estilos nativos ao dropdown; definimos
       cor do texto e fundo das <option> para melhorar contraste no tema.
    */
    select,
    select option {
      color: #f8fafb;
      background-color: #0b0b0b;
    }

    ::placeholder {
      color: rgba(255, 255, 255, 0.5);
    }

    .chip {
      background: rgba(255, 255, 255, 0.04);
    }

    /* Estilos específicos para o modal de sucesso (fundo branco):
       o projeto usa `text-white` globalmente; aqui garantimos que o
       conteúdo do modal tenha texto escuro e botões legíveis. */
    #success-modal .modal-inner {
      color: #111827;
    }

    #success-modal .modal-inner a {
      color: #111827;
      border-color: rgba(0, 0, 0, 0.08);
    }

    #success-modal .modal-inner a:hover {
      background-color: rgba(0, 0, 0, 0.04);
    }

    #success-modal .modal-inner .bg-roxa {
      background-color: #8B5CF6 !important;
      color: #fff !important;
    }
  </style>
</head>

<body class="font-sans text-white bg-[#090909] antialiased">
  <!-- Header: barra de navegação superior fixa -->
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

  <main class="pt-20 max-w-7xl mx-auto px-6 sm:px-8 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
      <!-- Lado esquerdo: passos do onboarding (wizard) -->
      <aside class="lg:col-span-4">
        <div class="card rounded-2xl p-6">
          <h2 class="text-lg font-semibold">Começar a vender</h2>
          <p class="text-sm text-white/60 mt-2">
            Siga os passos para listar seu produto na Sola Roxa.
          </p>

          <nav class="mt-6 space-y-4">
            <button class="w-full text-left p-3 rounded-2xl drop-shadow-sm step step-active flex items-center gap-3"
              data-step="1">
              <div class="w-8 h-8 rounded-full flex items-center justify-center bg-white/5 text-white">
                1
              </div>
              <div>
                <div class="font-medium">Dados do vendedor</div>
                <div class="text-xs text-white/60">Conta e verificação</div>
              </div>
            </button>

            <button class="w-full text-left p-3 rounded-2xl step flex items-center gap-3" data-step="2">
              <div class="w-8 h-8 rounded-full flex items-center justify-center bg-white/5 text-white/60">
                2
              </div>
              <div>
                <div class="font-medium">Detalhes do produto</div>
                <div class="text-xs text-white/60">
                  Título, marca e condição
                </div>
              </div>
            </button>

            <button class="w-full text-left p-3 rounded-2xl step flex items-center gap-3" data-step="3">
              <div class="w-8 h-8 rounded-full flex items-center justify-center bg-white/5 text-white/60">
                3
              </div>
              <div>
                <div class="font-medium">Preço & Fotos</div>
                <div class="text-xs text-white/60">Envio e imagens</div>
              </div>
            </button>

            <!-- passo 4 removido (Revisar & Publicar) -->
          </nav>

          <div class="mt-6">
            <div class="text-xs text-white/60">Progresso</div>
            <div class="w-full bg-white/5 h-2 rounded-full mt-2 overflow-hidden">
              <div id="progress-bar" class="h-2 rounded-full bg-gradient-to-r from-roxa to-roxa w-1/4"></div>
            </div>
          </div>
        </div>
      </aside>

      <!-- Lado direito: formulário de criação de anúncio -->
      <section class="lg:col-span-8">
        <form id="listing-form" class="card rounded-2xl p-6 space-y-6">
          <div class="flex items-center justify-between">
            <h3 class="text-xl font-semibold">Criar novo anúncio</h3>
            <div class="text-sm text-white/60">
              Passo <span id="current-step">1</span> de 3
            </div>
          </div>

          <!-- Informações do vendedor (passo 1) -->
          <div data-panel="1" class="panel">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="text-sm font-medium">Nome do vendedor</label>
                <input id="seller-name" type="text" placeholder="Seu nome ou loja"
                  class="mt-2 w-full rounded-md border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-roxa" required />
              </div>
              <div>
                <label class="text-sm font-medium">Documento (CPF/CNPJ)</label>
                <input id="seller-doc" type="text" placeholder="000.000.000-00"
                  class="mt-2 w-full rounded-md border px-3 py-2" required />
              </div>
            </div>
            <div class="mt-4">
              <label class="text-sm font-medium">Biografia curta</label>
              <textarea id="seller-bio" rows="3" class="mt-2 w-full rounded-md border px-3 py-2"
                placeholder="Sobre você ou sua loja (opcional)"></textarea>
            </div>
          </div>

          <!-- Detalhes do produto (passo 2) -->
          <div data-panel="2" class="panel hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="text-sm font-medium">Título do produto</label>
                <input id="title" type="text" placeholder="Nike Dunk Low Purple Pulse"
                  class="mt-2 w-full rounded-md border px-3 py-2" required />
              </div>
              <div>
                <label class="text-sm font-medium">Categoria</label>
                <select id="category" class="mt-2 w-full rounded-md border px-3 py-2" required>
                  <option>Sneakers</option>
                  <option>Streetwear</option>
                  <option>Accessories</option>
                  <option>Collectibles</option>
                </select>
              </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
              <div>
                <label class="text-sm font-medium">Marca</label>
                <input id="brand" type="text" placeholder="Nike, Adidas..."
                  class="mt-2 w-full rounded-md border px-3 py-2" required />
              </div>
              <div>
                <label class="text-sm font-medium">Tamanho</label>
                <input id="size" type="text" placeholder="Ex: 40, 41, 38-44"
                  class="mt-2 w-full rounded-md border px-3 py-2" required />
              </div>
              <div>
                <label class="text-sm font-medium">Condição</label>
                <select id="condition" class="mt-2 w-full rounded-md border px-3 py-2" required>
                  <option value="Novo">Novo</option>
                  <option value="Semi-Novo">Semi-Novo</option>
                  <option value="Usado">Usado</option>
                </select>
              </div>
            </div>

            <div class="mt-4">
              <label class="text-sm font-medium">Descrição</label>
              <textarea id="description" rows="5" maxlength="1000" class="mt-2 w-full rounded-md border px-3 py-2"
                placeholder="Detalhes sobre material, defeitos, histórico..." required></textarea>
              <div class="text-sm text-white/60 mt-1">
                Caracteres: <span id="desc-count">0</span>/1000
              </div>
            </div>

            <!-- Tags removidas conforme solicitado -->
          </div>

          <!-- Preço e fotos (passo 3) -->
          <div data-panel="3" class="panel hidden">
            <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
              <div>
                <label class="text-sm font-medium">Preço (R$)</label>
                <input id="price" type="number" min="0" step="1" placeholder="2499"
                  class="mt-2 w-full rounded-md border px-3 py-2" required />
              </div>
            </div>

            <div class="mt-4">
              <label class="text-sm font-medium">Imagens (até 6)</label>
              <div id="drop-zone"
                class="drop-zone mt-2 p-6 rounded-2xl bg-white/50 border border-dashed border-gray-200 text-center text-gray-600 cursor-pointer">
                <div class="flex items-center justify-center gap-3">
                  <i data-lucide="image" class="text-2xl text-white/80"></i>
                  <div>
                    <div class="font-medium text-white">
                      Arraste imagens aqui ou clique para selecionar
                    </div>
                    <div class="text-sm text-white/60">
                      JPG, PNG — até 6 fotos
                    </div>
                  </div>
                </div>
                <input id="file-input" type="file" accept="image/*" multiple class="hidden" />
              </div>

              <div id="thumbs" class="mt-4 grid grid-cols-3 gap-3"></div>
            </div>
          </div>

          <!-- Revisar e publicar (passo 4) -->
          <!-- Painel de revisão removido -->

          <div class="flex items-center justify-between">
            <div>
              <button type="button" id="prev-btn" class="px-4 py-2 rounded-md text-sm border border-white/10">
                Anterior
              </button>
              <button type="button" id="next-btn" class="ml-2 px-4 py-2 rounded-md text-sm bg-white text-black border">
                Próximo
              </button>
            </div>
            <div class="flex items-center gap-3">
              <button type="button" id="publish-btn"
                class="px-5 py-2 rounded-2xl bg-gradient-to-r from-roxa to-roxa text-white font-semibold">
                Publicar
              </button>
            </div>
          </div>
        </form>
      </section>
    </div>
  </main>

  <!-- Modal de sucesso exibido após publicação do anúncio -->
  <div id="success-modal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white modal-inner rounded-2xl p-8 max-w-md w-full text-center shadow-xl">
      <h3 class="text-2xl font-semibold">
        ✨ Seu produto foi publicado com sucesso na Sola Roxa!
      </h3>
      <p class="text-gray-600 mt-3">
        Seu anúncio já está visível no marketplace.
      </p>
      <div class="mt-6 flex justify-center gap-3">
        <a href="catalog.php" class="px-4 py-2 rounded-md border">Ver anúncio</a>
        <button id="close-success" class="px-4 py-2 rounded-md bg-roxa text-white">
          Fechar
        </button>
      </div>
    </div>
  </div>
  <footer class="bg-white/[0.01] mt-12 border-t border-white/10">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 py-12 grid grid-cols-1 md:grid-cols-4 gap-8 text-sm">
      <div>
        <h5 class="font-semibold text-white mb-4">Ajuda</h5>
        <ul class="space-y-3">
          <li>
            <a href="faq.php" class="text-white/60 hover:text-white transition-colors">FAQ</a>
          </li>
          <li>
            <a href="envios.php" class="text-white/60 hover:text-white transition-colors">Envios</a>
          </li>
          <li>
            <a href="devolucoes.php" class="text-white/60 hover:text-white transition-colors">Devoluções</a>
          </li>
        </ul>
      </div>

      <div>
        <h5 class="font-semibold text-white mb-4">Sobre Nós</h5>
        <ul class="space-y-3">
          <li>
            <a href="sobre.php" class="text-white/60 hover:text-white transition-colors">Nosso manifesto</a>
          </li>
          <li>
            <a href="trabalhe-conosco.php" class="text-white/60 hover:text-white transition-colors">Trabalhe conosco</a>
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
            <a href="privacidade.php" class="text-white/60 hover:text-white transition-colors">Política de Privacidade</a>
          </li>
          <li>
            <a href="termos.php" class="text-white/60 hover:text-white transition-colors">Termos de Uso</a>
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
          <a href="javascript:void(0)" class="text-white/60 hover:text-white transition-colors text-sm">Contato</a>
        </div>
      </div>
    </div>
  </footer>
  <script src="assets/scripts/main.js"></script>
  <script src="assets/scripts/sell.js"></script>
</body>

</html>