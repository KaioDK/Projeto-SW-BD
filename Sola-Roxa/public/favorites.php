<?php
require_once __DIR__ . '/../backend/auth.php';
if (session_status() === PHP_SESSION_NONE) session_start();

$isLoggedIn = isLoggedUser();
if (!$isLoggedIn) {
  header('Location: auth.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Meus Favoritos | Sola Roxa</title>
  <meta name="description" content="Seus produtos favoritos na Sola Roxa." />
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Fjalla+One&display=swap" rel="stylesheet" />
  <link rel="icon" href="assets/img/favicon/favicon_io/favicon.ico" />

  <!-- Inter font: fonte principal para textos e UI -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Fjalla+One&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Mountains+of+Christmas:wght@400;700&family=Satisfy&display=swap" rel="stylesheet">

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            roxa: "#8B5CF6",
            cyan: "#00F0FF",
            bg: "#0D0D0D"
          },
        },
      },
    };
  </script>
  <!-- Lucide icons -->
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
  <style>
    body {
      background: linear-gradient(180deg, #0d0d0d, #0b0b0b);
    }

    .card {
      background: linear-gradient(180deg, rgba(255, 255, 255, 0.02), rgba(0, 0, 0, 0.06));
      border: 1px solid rgba(255, 255, 255, 0.04);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
      transform: translateY(-4px);
      box-shadow: 0 8px 32px rgba(139, 92, 246, 0.15);
    }

    .empty-state {
      min-height: 60vh;
    }
  </style>
</head>

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

  <!-- Main -->
  <main class="pt-28 pb-16 min-h-screen">
    <div class="max-w-7xl mx-auto px-6">
      <h1 class="text-4xl font-bold mb-8 bg-gradient-to-r from-roxa to-cyan bg-clip-text text-transparent">
        Meus Favoritos
      </h1>

      <!-- Products Grid -->
      <div id="favorites-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <!-- Loading -->
        <div class="col-span-full text-center py-12">
          <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-roxa border-t-transparent"></div>
          <p class="mt-4 text-white/60">Carregando favoritos...</p>
        </div>
      </div>

      <!-- Empty State -->
      <div id="empty-state" class="hidden empty-state flex flex-col items-center justify-center text-center">
        <i data-lucide="heart" class="w-24 h-24 text-white/20 mb-6"></i>
        <h2 class="text-2xl font-semibold mb-2">Nenhum favorito ainda</h2>
        <p class="text-white/60 mb-6">Explore o marketplace e adicione produtos aos seus favoritos</p>
        <a href="catalog.php" class="px-6 py-3 bg-roxa hover:bg-roxa/80 rounded-full font-semibold transition">
          Explorar Produtos
        </a>
      </div>
    </div>
  </main>

  <!-- Footer -->
  <footer class="border-t border-white/5 py-8">
    <div class="max-w-7xl mx-auto px-6 text-center text-white/40 text-sm">
      © 2024 Sola Roxa. Todos os direitos reservados.
    </div>
  </footer>

  <script>
    lucide.createIcons();

    async function loadFavorites() {
      try {
        const res = await fetch('api/favorites/get_favorites.php');
        const data = await res.json();

        if (data.success && data.favoritos && data.favoritos.length > 0) {
          renderFavorites(data.favoritos);
        } else {
          showEmptyState();
        }
      } catch (e) {
        console.error('Error loading favorites:', e);
        showEmptyState();
      }
    }

    function renderFavorites(favoritos) {
      const grid = document.getElementById('favorites-grid');
      grid.innerHTML = favoritos.map(product => {
        const price = parseFloat(product.valor || 0);
        // Se imagem_url contém múltiplas imagens separadas por vírgula, pega só a primeira
        let imgSrc = product.imagem_url || 'assets/img/placeholder.jpg';
        if (imgSrc.includes(',')) {
          imgSrc = imgSrc.split(',')[0].trim();
        }

        return `
          <div class="card rounded-lg overflow-hidden group">
            <div class="relative">
              <a href="product.php?id=${product.id_produto}">
                <img src="${imgSrc}" alt="${product.nome}" class="w-full h-64 object-cover">
              </a>
              <button 
                onclick="removeFavorite(${product.id_produto})" 
                class="absolute top-3 right-3 p-2 bg-black/60 hover:bg-black/80 rounded-full transition"
                aria-label="Remover dos favoritos">
                <i data-lucide="heart" fill="currentColor" class="text-roxa w-5 h-5"></i>
              </button>
            </div>
            <div class="p-4">
              <p class="text-xs text-white/50 mb-1">${product.nome_loja || 'Vendedor'}</p>
              <a href="product.php?id=${product.id_produto}">
                <h3 class="font-semibold text-lg mb-2 line-clamp-2 hover:text-roxa transition">${product.nome}</h3>
              </a>
              <div class="flex items-center justify-between">
                <p class="text-xl font-bold text-roxa">R$ ${price.toFixed(2)}</p>
                <a href="product.php?id=${product.id_produto}" 
                   class="px-4 py-2 bg-roxa/10 hover:bg-roxa hover:text-black rounded-full text-sm font-semibold transition">
                  Ver Detalhes
                </a>
              </div>
            </div>
          </div>
        `;
      }).join('');

      lucide.createIcons();
    }

    function showEmptyState() {
      document.getElementById('favorites-grid').innerHTML = '';
      document.getElementById('empty-state').classList.remove('hidden');
      document.getElementById('empty-state').classList.add('flex');
      lucide.createIcons();
    }

    async function removeFavorite(productId) {
      try {
        const fd = new FormData();
        fd.append('id_produto', productId);
        const res = await fetch('api/favorites/toggle_favorite.php', {
          method: 'POST',
          body: fd
        });
        const data = await res.json();

        if (data.success) {
          // Reload favorites
          loadFavorites();
        }
      } catch (e) {
        console.error('Error removing favorite:', e);
      }
    }

    window.addEventListener('DOMContentLoaded', loadFavorites);
  </script>
</body>

</html>