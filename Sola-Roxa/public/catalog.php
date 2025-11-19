<?php require_once __DIR__ . '/../backend/auth.php'; ?>
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
          <a class="hover:text-roxa transition" href="index.php/#lancamentos">Lançamentos</a>
        </li>
        <li>
          <a class="hover:text-roxa transition" href="index.php/#masculino">Masculino</a>
        </li>
        <li>
          <a class="hover:text-roxa transition" href="index.php/#feminino">Feminino</a>
        </li>
        <li>
          <a class="hover:text-roxa transition" href="index.php/#colecoes">Colecionáveis</a>
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

  <main class="pt-24 pb-16 max-w-7xl mx-auto px-6 sm:px-8">
    <!-- Catalog Section -->
    <section class="mb-10">
      <h1 class="text-5xl font-bold tracking-tight mb-2">SNEAKERS</h1>
      <div class="text-roxa text-lg font-semibold mb-6">365 PRODUCTS</div>

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

        <!-- Gênero -->
        <div class="bg-black/70 border border-white/10 rounded-xl p-4" data-filter="genero">
          <h3 class="font-semibold mb-3 flex items-center gap-2 cursor-pointer">
            <i data-lucide="users"></i>GÊNERO
            <i data-lucide="chevron-down" class="ml-auto"></i>
          </h3>
          <div class="space-y-2">
            <label class="flex items-center gap-2 cursor-pointer">
              <input type="checkbox" class="rounded text-roxa focus:ring-roxa" />
              <span>Masculino</span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer">
              <input type="checkbox" class="rounded text-roxa focus:ring-roxa" />
              <span>Feminino</span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer">
              <input type="checkbox" class="rounded text-roxa focus:ring-roxa" />
              <span>Unissex</span>
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

        <!-- Catalog Grid -->
        <div
          id="catalog-grid"
          class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8"
        >
          <!-- Product Card Example -->
          <a href="product.php">
            <div
              class="card-hover fade-in bg-white rounded-2xl overflow-hidden border border-gray p-5 flex flex-col items-center relative"
              data-category="Super-Star"
              data-colors="black,white"
              data-sizes="40,41,42,43"
              data-condition="new"
              data-date="20251026"
              data-sales="245"
            >
              <div
                class="absolute top-4 left-4 bg-roxa text-black text-xs font-bold px-3 py-1 rounded-full"
              >
                NEW IN
              </div>
              <img
                src="https://cdn.runrepeat.com/storage/gallery/product_content/39891/nike-ja-1-review-20528489-720.jpg"
                alt="Nike Phantom Void"
                class="w-full h-56 object-cover rounded-xl mb-4 bg-gray"
                loading="lazy"
              />
              <h3 class="font-bold text-lg mb-1 text-black">Nike Ja 1</h3>
              <div class="text-black text-sm mb-1">Minimal urban runner</div>
              <div class="text-roxa font-bold text-xl mb-1">R$ 1.799</div>
            </div>
          </a>
          <div
            class="card-hover fade-in bg-white rounded-2xl overflow-hidden border border-gray p-5 flex flex-col items-center relative"
          >
            <img
              src="https://cdn.runrepeat.com/storage/gallery/product_content/35434/adidas-sl-72-review-21894164-720.jpg"
              alt="Adidas Shadow Run"
              class="w-full h-56 object-cover rounded-xl mb-4 bg-gray"
              loading="lazy"
            />
            <h3 class="font-bold text-lg mb-1 text-black">Adidas SL 72</h3>
            <div class="text-black text-sm mb-1">Streetwear classic</div>
            <div class="text-roxa font-bold text-xl mb-1">R$ 1.299</div>
          </div>
          <a href="product.php">
            <div
              class="card-hover fade-in bg-white rounded-2xl overflow-hidden border border-gray p-5 flex flex-col items-center relative"
            >
              <img
                src="https://cdn.runrepeat.com/storage/gallery/product_content/40440/jordan-luka-3-outdoor-001-21807246-720.jpg"
                alt="Jordan Eclipse"
                class="w-full h-56 object-cover rounded-xl mb-4 bg-gray"
                loading="lazy"
              />
              <h3 class="font-bold text-lg mb-1 text-black">Jordan Luka 3</h3>
              <div class="text-black text-sm mb-1">Limited drop</div>
              <div class="text-roxa font-bold text-xl mb-1">R$ 2.099</div>
            </div>
          </a>
          <div
            class="card-hover fade-in bg-white rounded-2xl overflow-hidden border border-gray p-5 flex flex-col items-center relative"
          >
            <img
              src="https://cdn.runrepeat.com/storage/gallery/product_content/39930/puma-magnify-nitro-2-5-21147897-720.jpg"
              alt="Yeezy Nova Pulse"
              class="w-full h-56 object-cover rounded-xl mb-4 bg-gray"
              loading="lazy"
            />
            <h3 class="font-bold text-lg mb-1 text-black">
              PUMA Magnify Nitro 2
            </h3>
            <div class="text-black text-sm mb-1">Urban luxury</div>
            <div class="text-roxa font-bold text-xl mb-1">R$ 2.499</div>
          </div>
        </div>
      </section>

    <!-- Optional Filter Sidebar (not implemented, placeholder) -->
    <!-- ... -->
  </main>

  <!-- Footer -->
  <footer class="bg-black border-t border-white/10 mt-16">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 py-8 flex flex-col md:flex-row items-center justify-between gap-6">
      <a href="index.php" style="font-family: Poppins; letter-spacing: 0.1em"
        class="text-lg font-extrabold tracking-widest uppercase">SOLA <span class="text-roxa">ROXA</span></a>
      <div class="flex gap-6">
        <a href="#" class="text-white/70 hover:text-roxa transition">Terms</a>
        <a href="#" class="text-white/70 hover:text-roxa transition">Privacy</a>
        <a href="#" class="text-white/70 hover:text-roxa transition">Support</a>
      </div>
      <div class="flex gap-4">
        <a href="#" class="text-white/70 hover:text-roxa transition"><i data-lucide="instagram"></i></a>
        <a href="#" class="text-white/70 hover:text-roxa transition"><i data-lucide="twitter"></i></a>
        <a href="#" class="text-white/70 hover:text-roxa transition"><i data-lucide="mail"></i></a>
      </div>
    </div>
  </footer>

  <script>
    lucide.createIcons();

      // Fade-in animation for product cards
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
  </body>
</html>