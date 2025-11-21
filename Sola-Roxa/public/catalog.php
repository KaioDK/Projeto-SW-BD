<?php
require_once __DIR__ . '/../backend/auth.php';
// get total products count
$totalProducts = 0;
try {
  require_once __DIR__ . '/../backend/db.php';
  $stmt = $pdo->query('SELECT COUNT(*) FROM produto');
  $totalProducts = (int) $stmt->fetchColumn();
} catch (Throwable $e) {
  // leave totalProducts as 0 on error
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Sola Roxa | Urban Luxury Sneakers Marketplace</title>
  <meta name="description" content="Sola Roxa — Luxury urban sneakers marketplace inspired by Golden Goose." />
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Poppins:wght@400;600&display=swap"
    rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Fjalla+One&family=Great+Vibes&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Caveat+Brush&display=swap" rel="stylesheet">
  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            roxa: "#8B5CF6",
            turquoise: "#00E6E6",
            black: "#111111",
            gray: "#E5E7EB",
            white: "#FFFFFF",
          },
          fontFamily: {
            sans: [
              "Inter",
              "Poppins",
              "Montserrat",
              "ui-sans-serif",
              "system-ui",
            ],
          },
        },
      },
    };
  </script>
  <!-- Lucide icons -->
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
  <style>
    body {
      background: linear-gradient(180deg, #111111 0%, #18181b 100%);
    }

    .card-hover:hover {
      transform: scale(1.03);
      box-shadow: 0 8px 32px rgba(139, 92, 246, 0.1);
    }

    .fade-in {
      opacity: 0;
      transform: translateY(24px);
      transition: opacity 0.7s cubic-bezier(0.4, 0, 0.2, 1),
        transform 0.7s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .fade-in.visible {
      opacity: 1;
      transform: none;
    }

    .filter-btn.active {
      background: #8b5cf6;
      color: #111111;
    }

    .size-btn.active {
      border-color: #8b5cf6;
      color: #8b5cf6;
    }

    .quick-actions {
      opacity: 0;
      pointer-events: none;
      transition: opacity 0.3s;
    }

    .card-hover:hover .quick-actions {
      opacity: 1;
      pointer-events: auto;
    }

    /* Badge animation for active filters */
    #filters-badge {
      transform-origin: center;
      transition: transform 220ms cubic-bezier(.2,.9,.2,1), opacity 220ms ease;
      will-change: transform, opacity;
      opacity: 0;
      transform: scale(.8);
      display: none;
    }

    /* visible state (entry animation) */
    #filters-badge.show {
      display: inline-flex;
      animation: pop 360ms cubic-bezier(.2,.9,.2,1);
      opacity: 1;
      transform: scale(1);
    }

    /* exiting state (fade/scale out) */
    #filters-badge.hide {
      opacity: 0;
      transform: scale(.85);
      transition: transform 200ms ease, opacity 200ms ease;
    }

    @keyframes pop {
      0% { transform: scale(.6); opacity: 0; }
      60% { transform: scale(1.08); opacity: 1; }
      100% { transform: scale(1); }
    }

    /* Clear button animations */
    #clear-filters { transition: background-color 220ms ease, color 220ms ease, transform 200ms ease, box-shadow 220ms ease, opacity 200ms ease; }
    #clear-filters.clear-show { transform: translateY(-3px) scale(1.02); box-shadow: 0 8px 24px rgba(139,92,246,0.12); }
    #clear-filters.clear-hide { transform: translateY(0) scale(.985); opacity: 0.92; }

      /* filtered & total count gentle transition */
      #filtered-count, #total-count { display: inline-block; transition: opacity 300ms ease, transform 300ms ease; }
  </style>
</head>

<body class="font-sans text-white">
  <!-- Header -->
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

  <main class="pt-24 pb-16 max-w-7xl mx-auto px-6 sm:px-8">
    <!-- Catalog Section -->
    <section class="mb-10">
      <h1 class="text-5xl font-bold tracking-tight mb-2">SNEAKERS</h1>
      <div class="text-roxa text-lg font-semibold mb-6"><span id="filtered-count"><?php echo $totalProducts; ?></span> de <span id="total-count"><?php echo $totalProducts; ?></span> produtos</div>

      <!-- Search Bar -->
      <div class="mb-8">
        <div class="relative">
          <input type="text" placeholder="Buscar por nome, marca ou modelo..."
            class="w-full px-5 py-3 bg-black/70 border border-white/10 rounded-full text-white placeholder-white/50 focus:outline-none focus:border-roxa" />
          <button class="absolute right-4 top-1/2 -translate-y-1/2 text-white/70 hover:text-roxa transition">
            <i data-lucide="search"></i>
          </button>
        </div>
      </div>

      <!-- Filters -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
        <!-- Size -->
        <div class="bg-black/70 border border-white/10 rounded-xl p-4">
          <h3 class="font-semibold mb-3 flex items-center gap-2 cursor-pointer">
            <i data-lucide="ruler"></i>SIZE
            <i data-lucide="chevron-down" class="ml-auto"></i>
          </h3>
          <div class="grid grid-cols-4 gap-2">
            <button
              class="size-btn px-3 py-2 rounded-lg border border-white/20 text-white hover:border-roxa hover:text-roxa transition">
              34
            </button>
            <button
              class="size-btn px-3 py-2 rounded-lg border border-white/20 text-white hover:border-roxa hover:text-roxa transition">
              35
            </button>
            <button
              class="size-btn px-3 py-2 rounded-lg border border-white/20 text-white hover:border-roxa hover:text-roxa transition">
              36
            </button>
            <button
              class="size-btn px-3 py-2 rounded-lg border border-white/20 text-white hover:border-roxa hover:text-roxa transition">
              37
            </button>
            <button
              class="size-btn px-3 py-2 rounded-lg border border-white/20 text-white hover:border-roxa hover:text-roxa transition">
              38
            </button>
            <button
              class="size-btn px-3 py-2 rounded-lg border border-white/20 text-white hover:border-roxa hover:text-roxa transition">
              39
            </button>
            <button
              class="size-btn px-3 py-2 rounded-lg border border-white/20 text-white hover:border-roxa hover:text-roxa transition">
              40
            </button>
            <button
              class="size-btn px-3 py-2 rounded-lg border border-white/20 text-white hover:border-roxa hover:text-roxa transition">
              41
            </button>
            <button
              class="size-btn px-3 py-2 rounded-lg border border-white/20 text-white hover:border-roxa hover:text-roxa transition">
              42
            </button>
            <button
              class="size-btn px-3 py-2 rounded-lg border border-white/20 text-white hover:border-roxa hover:text-roxa transition">
              43
            </button>
            <button
              class="size-btn px-3 py-2 rounded-lg border border-white/20 text-white hover:border-roxa hover:text-roxa transition">
              44
            </button>
            <button
              class="size-btn px-3 py-2 rounded-lg border border-white/20 text-white hover:border-roxa hover:text-roxa transition">
              45
            </button>
          </div>
        </div>

        <!-- Estado -->
        <div class="bg-black/70 border border-white/10 rounded-xl p-4" data-filter="estado">
          <h3 class="font-semibold mb-3 flex items-center gap-2 cursor-pointer">
            <i data-lucide="tag"></i>ESTADO
            <i data-lucide="chevron-down" class="ml-auto"></i>
          </h3>
          <div class="space-y-2">
            <label class="flex items-center gap-2 cursor-pointer">
              <input type="checkbox" value="novo" class="rounded text-roxa focus:ring-roxa" />
              <span>Novo</span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer">
              <input type="checkbox" value="semi-novo" class="rounded text-roxa focus:ring-roxa" />
              <span>Semi-Novo</span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer">
              <input type="checkbox" value="usado" class="rounded text-roxa focus:ring-roxa" />
              <span>Usado</span>
            </label>
          </div>
        </div>

        <!-- Ordenar Por -->
        <div class="bg-black/70 border border-white/10 rounded-xl p-4">
          <h3 class="font-semibold mb-3 flex items-center gap-2 cursor-pointer">
            <i data-lucide="list-filter"></i>ORDENAR POR
            <i data-lucide="chevron-down" class="ml-auto"></i>
          </h3>
          <select
            class="w-full bg-black/50 border border-white/10 rounded-lg px-3 py-2 text-white focus:outline-none focus:border-roxa">
            <option value="recent">Mais Recentes</option>
            <option value="price-asc">Menor Preço</option>
            <option value="price-desc">Maior Preço</option>
            <option value="popular">Mais Vendidos</option>
          </select>
        </div>
      </div>

        <!-- Toolbar: results count and clear filters -->
        <div class="flex items-center justify-between mb-4">
          <div id="results-count" class="text-white/70 text-sm">Carregando...</div>
          <div class="flex items-center gap-3">
            <div class="relative">
              <button id="clear-filters" class="text-sm text-white/60 hover:text-roxa px-3 py-1 rounded-md">Limpar filtros</button>
              <span id="filters-badge" class="hidden absolute -top-2 -right-2 inline-flex items-center justify-center px-2 py-0.5 text-xs font-medium rounded-full bg-red-600 text-white">0</span>
            </div>
          </div>
        </div>

        <!-- Catalog Grid (rendered dynamically) -->
        <div id="catalog-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
          <!-- cards will be rendered here by JS -->
        </div>
    </section>

    <!-- Optional Filter Sidebar (not implemented, placeholder) -->
    <!-- ... -->
  </main>

  <!-- Footer -->
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
            <a href="sobre.php" class="text-white/60 hover:text-white transition-colors">
            Sobre Sola Roxa
            </a>
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
            <a href="javascript:void(0)" class="text-white/60 hover:text-white transition-colors">Política de Privacidade</a>
          </li>
          <li>
            <a href="javascript:void(0)" class="text-white/60 hover:text-white transition-colors">Termos de Uso</a>
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

  <script>
    lucide.createIcons();

    // Animação de entrada (fade-in) para os cards de produto
    window.addEventListener("DOMContentLoaded", () => {
      setTimeout(() => {
        document.querySelectorAll(".fade-in").forEach((el, i) => {
          setTimeout(() => {
            el.classList.add("visible");
          }, 120 * i);
        });
      }, 200);
    });
  </script>
  <script src="assets/scripts/main.js"></script>
  <script>
    // Expõe informações de sessão atuais para o JS (usado para ações rápidas)
    const CURRENT_SELLER_ID = <?php echo isLoggedSeller() ? (int) $_SESSION['vendedor']['id'] : 'null'; ?>;
    const CURRENT_USER_ID = <?php echo isLoggedUser() ? (int) $_SESSION['user']['id'] : 'null'; ?>;

    function formatPrice(v) {
      // Formata preço recebido como string/numero para formato brasileiro
      // (ex: "999.90" -> "R$ 999,90"). Retorna placeholder se nulo/indefinido.
      if (v === null || v === undefined) return 'R$ —';
      return 'R$ ' + parseFloat(v).toFixed(2).replace('.', ',');
    }

    // Render products into grid (server-side filtering)

    function renderProducts(products) {
      const grid = document.getElementById('catalog-grid');
      grid.innerHTML = '';
      products.forEach((p) => {
        const card = document.createElement('div');
        card.className = 'card-hover fade-in bg-white rounded-2xl overflow-hidden border border-gray p-5 flex flex-col items-center relative cursor-pointer';

        const imgSrc = p.imagem_url ? p.imagem_url : 'assets/img/placeholder.png';
        const image = `<img src="${imgSrc}" alt="${p.nome}" class="w-full h-56 object-cover rounded-xl mb-4 bg-gray" loading="lazy">`;
        const title = `<h3 class="font-bold text-lg mb-1 text-black">${p.nome}</h3>`;
        const desc = `<div class="text-black text-sm mb-1">${(p.estado || '').substring(0, 60)} | ${(p.tamanho || '')}</div>`;
        const price = `<div class="text-roxa font-bold text-xl mb-1">${formatPrice(p.valor)}</div>`;

        // Ações rápidas (editar/excluir) visíveis somente ao vendedor proprietário
        let actions = '';
        if (CURRENT_SELLER_ID && p.id_vendedor && Number(CURRENT_SELLER_ID) === Number(p.id_vendedor)) {
          actions = ``;
        }

        card.innerHTML = actions + image + title + desc + price;

        card.addEventListener('click', (e) => {
          if (e.target.closest('.edit-btn') || e.target.closest('.delete-btn')) return;
          window.location.href = 'product.php?id=' + p.id_produto;
        });

        grid.appendChild(card);
      });

      // animação
      setTimeout(() => {
        document.querySelectorAll('.fade-in').forEach((el, i) => {
          setTimeout(() => el.classList.add('visible'), 80 * i);
        });
      }, 50);
    }

    // Server-side filtering: build query and fetch filtered products
    function buildQuery() {
      const params = new URLSearchParams();
      const searchInput = document.querySelector('input[placeholder^="Buscar"]');
      const q = searchInput ? searchInput.value.trim() : '';
      if (q) params.set('search', q);

      const estadoChecks = Array.from(document.querySelectorAll('[data-filter="estado"] input[type="checkbox"]'));
      const estados = estadoChecks.filter(c => c.checked).map(c => c.value);
      if (estados.length) params.set('estado', estados.join(','));

      const sizeBtns = Array.from(document.querySelectorAll('.size-btn'));
      const activeSizes = sizeBtns.filter(b => b.classList.contains('active')).map(b => b.textContent.trim());
      if (activeSizes.length) params.set('sizes', activeSizes.join(','));

      const orderSel = document.querySelector('select');
      const order = orderSel ? orderSel.value : '';
      if (order) params.set('order', order);

      return params.toString();
    }

    // Count active filters for badge and visual state
    function countActiveFilters() {
      let count = 0;
      const searchInput = document.querySelector('input[placeholder^="Buscar"]');
      const q = searchInput ? searchInput.value.trim() : '';
      if (q) count++;

      const estadoChecks = Array.from(document.querySelectorAll('[data-filter="estado"] input[type="checkbox"]'));
      count += estadoChecks.filter(c => c.checked).length;

      const sizeBtns = Array.from(document.querySelectorAll('.size-btn'));
      count += sizeBtns.filter(b => b.classList.contains('active')).length;

      const orderSel = document.querySelector('select');
      if (orderSel && orderSel.value && orderSel.value !== 'recent') count++;

      return count;
    }

    function updateFilterIndicator() {
      const badge = document.getElementById('filters-badge');
      const clearBtn = document.getElementById('clear-filters');
      if (!badge || !clearBtn) return;
      const active = countActiveFilters();
      if (active > 0) {
        const previous = badge.textContent;
        badge.textContent = active;

        // show badge with entry animation
        badge.classList.remove('hide');
        badge.classList.remove('hidden');
        // force reflow to restart animation
        void badge.offsetWidth;
        badge.classList.add('show');

        // highlight clear button (entry)
        clearBtn.classList.remove('clear-hide');
        clearBtn.classList.add('bg-roxa','text-white','clear-show');

        // subtle pulse when number changes
        if (previous !== String(active)) {
          try {
            badge.animate([
              { transform: 'scale(1)', offset: 0 },
              { transform: 'scale(1.12)', offset: 0.4 },
              { transform: 'scale(1)', offset: 1 }
            ], { duration: 260, easing: 'cubic-bezier(.2,.9,.2,1)' });
          } catch (e) { /* animate may not be available in older browsers */ }
        }

      } else {
        // badge exit animation
        badge.classList.remove('show');
        badge.classList.add('hide');
        // after exit transition, fully hide
        setTimeout(() => {
          badge.classList.remove('hide');
          badge.classList.add('hidden');
        }, 220);

        // clear button exit animation: remove highlight but keep smooth transition
        clearBtn.classList.remove('clear-show');
        clearBtn.classList.add('clear-hide');
        // remove color classes after animation completes
        setTimeout(() => {
          clearBtn.classList.remove('bg-roxa','text-white','clear-hide');
        }, 220);
      }
    }

    async function loadProducts() {
      try {
        const qs = buildQuery();
        const url = 'api/get_products.php' + (qs ? ('?' + qs) : '');
        const countEl = document.getElementById('results-count');
        const grid = document.getElementById('catalog-grid');
        if (countEl) countEl.textContent = 'Carregando...';
        if (grid) grid.innerHTML = '<div class="col-span-full flex items-center justify-center py-16"><svg class="animate-spin h-8 w-8 text-roxa" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path></svg></div>';

        const res = await fetch(url);
        const data = await res.json();
        const filteredEl = document.getElementById('filtered-count');
        // helper to animate filtered count change
        function animateFilteredCount(el, newVal) {
          if (!el) return el.textContent = newVal;
          const prev = el.textContent;
          if (String(prev) === String(newVal)) { el.textContent = newVal; return; }
          try {
            // fade out, change, fade in
            el.animate([
              { opacity: 1, transform: 'translateY(0)' },
              { opacity: 0, transform: 'translateY(-6px)' }
            ], { duration: 180, easing: 'ease-out' }).onfinish = () => {
              el.textContent = newVal;
              el.animate([
                { opacity: 0, transform: 'translateY(6px)' },
                { opacity: 1, transform: 'translateY(0)' }
              ], { duration: 240, easing: 'cubic-bezier(.22,.9,.35,1)' });
            };
          } catch (e) {
            // fallback
            el.textContent = newVal;
          }
        }

        // helper to animate total count change (exposed as window.updateTotalCount)
        function animateTotalCount(el, newVal) {
          if (!el) return el.textContent = newVal;
          const prev = el.textContent;
          if (String(prev) === String(newVal)) { el.textContent = newVal; return; }
          try {
            el.animate([
              { opacity: 1, transform: 'translateY(0)' },
              { opacity: 0, transform: 'translateY(-6px)' }
            ], { duration: 200, easing: 'ease-out' }).onfinish = () => {
              el.textContent = newVal;
              el.animate([
                { opacity: 0, transform: 'translateY(6px)' },
                { opacity: 1, transform: 'translateY(0)' }
              ], { duration: 260, easing: 'cubic-bezier(.22,.9,.35,1)' });
            };
          } catch (e) {
            el.textContent = newVal;
          }
        }

        // expose helper for external usage (e.g., after a sync fetch)
        window.updateTotalCount = function(newTotal) {
          const totalEl = document.getElementById('total-count');
          animateTotalCount(totalEl, newTotal);
        };

        if (!data || !data.products) {
          if (countEl) countEl.textContent = '0 produtos encontrados';
          animateFilteredCount(filteredEl, 0);
          if (grid) grid.innerHTML = '<div class="col-span-full text-center py-12 text-white/60">Nenhum produto encontrado</div>';
          updateFilterIndicator();
          return;
        }

        if (data.products.length === 0) {
          if (countEl) countEl.textContent = '0 produtos encontrados';
          animateFilteredCount(filteredEl, 0);
          if (grid) grid.innerHTML = '<div class="col-span-full text-center py-12 text-white/60">Nenhum produto encontrado</div>';
          updateFilterIndicator();
          return;
        }

        if (countEl) countEl.textContent = data.products.length + ' produtos encontrados';
        animateFilteredCount(filteredEl, data.products.length);
        renderProducts(data.products);
        updateFilterIndicator();
      } catch (err) {
        console.error('Failed loading products', err);
        const countEl = document.getElementById('results-count');
        const grid = document.getElementById('catalog-grid');
        if (countEl) countEl.textContent = 'Erro ao carregar produtos';
        if (grid) grid.innerHTML = '<div class="col-span-full text-center py-12 text-red-400">Erro ao carregar produtos</div>';
        updateFilterIndicator();
      }
    }

    function clearFilters() {
      // clear search
      const searchInput = document.querySelector('input[placeholder^="Buscar"]');
      if (searchInput) searchInput.value = '';
      // clear sizes
      document.querySelectorAll('.size-btn.active').forEach(b => b.classList.remove('active'));
      // clear estados
      document.querySelectorAll('[data-filter="estado"] input[type="checkbox"]').forEach(cb => cb.checked = false);
      // reset order
      const orderSel = document.querySelector('select');
      if (orderSel) orderSel.value = 'recent';
      loadProducts();
      updateFilterIndicator();
    }

    // Hook up filters (server-side)
    window.addEventListener('DOMContentLoaded', () => {
      loadProducts();
      updateFilterIndicator();

      // search debounce
      const searchInput = document.querySelector('input[placeholder^="Buscar"]');
      if (searchInput) {
        let t;
        searchInput.addEventListener('input', () => { clearTimeout(t); t = setTimeout(() => { loadProducts(); updateFilterIndicator(); }, 300); });
      }

      // size buttons
      document.querySelectorAll('.size-btn').forEach(btn => {
        btn.addEventListener('click', () => { btn.classList.toggle('active'); loadProducts(); updateFilterIndicator(); });
      });

      // estado checkboxes
      document.querySelectorAll('[data-filter="estado"] input[type="checkbox"]').forEach(cb => cb.addEventListener('change', () => { loadProducts(); updateFilterIndicator(); }));

      // ordenar select
      const orderSel = document.querySelector('select');
      if (orderSel) orderSel.addEventListener('change', () => { loadProducts(); updateFilterIndicator(); });

      // clear filters button
      const clearBtn = document.getElementById('clear-filters');
      if (clearBtn) clearBtn.addEventListener('click', () => { clearFilters(); });
    });
  </script>
</body>

</html>