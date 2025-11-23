<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Sola Roxa | Marketplace de Sneakers</title>
  <meta name="description" content="Sola Roxa marketplace." />

  <!-- Fonts: import das fontes Google usadas na página de produto -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Fjalla+One&display=swap" rel="stylesheet" />
  <link rel="icon" href="assets/img/favicon/favicon_io/favicon.ico" />

  <!-- Tailwind CDN: configuração rápida do Tailwind para estilos utilitários -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            roxa: '#8B5CF6',
            cyan: '#00F0FF',
            bg: '#0D0D0D'
          },
        }
      }
    };
  </script>

  <!-- GSAP: biblioteca de animações usada para efeitos e transições -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

  <!-- Lucide icons: ícones SVG utilizados na interface (favoritar, fechar, etc) -->
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

  <style>
    body {
      background: linear-gradient(180deg, #0d0d0d, #0b0b0b);
    }

    /* Miniaturas: imagens auxiliares que atualizam a imagem principal ao clicar */
    .thumb {
      transition: border-color 0.3s ease;
      border: 2px solid transparent;
    }

    .thumb:hover {
      border-color: rgba(139, 92, 246, 0.5);
    }

    /* Galeria do produto: a grade de imagens adicionais será preenchida dinamicamente via JS */
    .glass-effect {
      backdrop-filter: blur(8px);
    }

    /* Abas: descrição e informações adicionais do produto */
    .card {
      background: linear-gradient(180deg, rgba(255, 255, 255, 0.02), rgba(0, 0, 0, 0.06));
      border: 1px solid rgba(255, 255, 255, 0.04);
    }

    /* Produtos relacionados: sugestões/carrossel de produtos similares */
    .btn-glow {
      box-shadow: 0 8px 30px rgba(139, 92, 246, 0.12);
    }

    /* Modal de zoom da imagem: exibe a imagem em alta resolução ao clicar */
    .fav-heart {
      transition: transform .18s ease;
    }

    .fav-heart.active {
      transform: scale(1.15);
      filter: drop-shadow(0 6px 18px rgba(139, 92, 246, 0.18));
    }

    /* Layout improvements for product page */
    .product-info {
      position: static;
    }

    @media (min-width: 1024px) {
      .product-info {
        position: sticky;
        top: 84px;
        align-self: start;
      }
    }

    /* Make main image adapt better and keep aspect ratio */
    #main-image {
      width: 100%;
      height: min(60vh, 540px);
      object-fit: cover;
      border-radius: 0.5rem;
    }

    /* Thumbnails smaller and consistent */
    .thumb {
      width: 96px;
      height: 64px;
      flex: 0 0 auto;
    }

    .thumb img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: 6px;
    }

    /* Product gallery images consistent height */
    #product-gallery-grid img {
      height: 180px;
      object-fit: cover;
      border-radius: 8px;
    }

    /* Make right column content spacing cleaner */
    .product-info .card {
      padding: 1.25rem;
    }

    /* Select size dropdown styling */
    .size-select {
      cursor: pointer;
      appearance: none;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23ffffff'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 0.75rem center;
      background-size: 1.25rem;
      padding-right: 2.5rem;
    }

    .size-select option {
      background-color: #18181b;
      color: white;
    }
  </style>
</head>
<?php
// Pega o ID do produto da URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
session_start();
$isSellerOfProduct = false;
if ($product_id > 0 && isset($_SESSION['vendedor']['id'])) {
  require_once __DIR__ . '/../backend/db.php';
  $stmt = $pdo->prepare('SELECT id_vendedor FROM produto WHERE id_produto = ? LIMIT 1');
  $stmt->execute([$product_id]);
  $pidVendedor = $stmt->fetchColumn();
  if ($pidVendedor && $pidVendedor == $_SESSION['vendedor']['id']) {
    $isSellerOfProduct = true;
  }
}
?>

<body class="font-pop text-white">

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

  <main class="pt-24 pb-16">
    <div class="max-w-7xl mx-auto px-6 sm:px-8">

      <!-- Product hero -->
      <section class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start" id="product-hero">
        <!-- Conteúdo será preenchido via JS -->
        <div class="lg:col-span-7">
          <div class="rounded-xl overflow-hidden card p-6">
            <div class="relative">
              <button id="fav-btn" class="absolute top-4 right-4 p-3 rounded-full bg-white/6 fav-heart"
                aria-label="Favoritar">
                <i data-lucide="heart" class="text-roxa"></i>
              </button>
            </div>

            <!-- thumbnails -->
            <div class="mt-4 flex gap-3 overflow-x-auto">
            </div>
          </div>
        </div>
      </section>

      <!-- Product gallery -->
      <section class="mt-12">
        <h3 class="text-xl font-semibold mb-4">Galeria</h3>
        <div id="product-gallery-grid" class="grid grid-cols-2 md:grid-cols-4 gap-4">
          <!-- Galeria será preenchida via JS -->
        </div>
      </section>

      <!-- Tabs -->
      <section class="mt-12">
        <div class="flex gap-6 border-b border-white/6">
          <button class="tab-btn pb-3 border-b-2 border-transparent text-white/80 active"
            data-tab="desc">Descrição</button>
        </div>

        <div id="tab-desc" class="mt-6 tab-content">
          <p class="text-white/70"></p>
        </div>
      </section>

      <!-- Related products -->
      <section class="mt-12">
        <h3 class="text-xl font-semibold mb-4">Você também pode gostar</h3>
        <div class="flex gap-4 overflow-x-auto py-2">
          <!-- card -->
          <div class="w-60 flex-shrink-0 card rounded-lg p-3 hover:scale-[1.02] transition-transform">
            <img src="https://cdn.runrepeat.com/storage/gallery/product_primary/38821/new-balance-9060-21208162-720.jpg"
              class="w-full h-40 object-cover rounded">
            <h4 class="mt-3 font-medium">New Balance 9060</h4>
            <div class="text-white/60">R$ 1.299</div>
          </div>
          <div class="w-60 flex-shrink-0 card rounded-lg p-3 hover:scale-[1.02] transition-transform">
            <img src="https://cdn.runrepeat.com/storage/gallery/product_primary/32545/adidas-ozweego-21158485-720.jpg"
              class="w-full h-40 object-cover rounded">
            <h4 class="mt-3 font-medium">Adidas Ozweego</h4>
            <div class="text-white/60">R$ 699</div>
          </div>
          <div class="w-60 flex-shrink-0 card rounded-lg p-3 hover:scale-[1.02] transition-transform">
            <img
              src="https://cdn.runrepeat.com/storage/gallery/product_primary/39411/nike-zoom-vomero-5-lab-test-and-review-3-21506315-720.jpg"
              class="w-full h-40 object-cover rounded">
            <h4 class="mt-3 font-medium">Nike Zoom Vomero 5</h4>
            <div class="text-white/60">R$ 1.234</div>
          </div>
        </div>
      </section>

    </div>
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
            <a href="javascript:void(0)" class="text-white/60 hover:text-white transition-colors">Nosso manifesto</a>
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

  <!-- Image zoom modal -->
  <div id="zoom-modal" class="fixed inset-0 bg-black/70 hidden items-center justify-center z-50">
    <div class="relative max-w-4xl w-full p-6">
      <button id="zoom-close" class="absolute top-4 right-4 p-2 bg-white/6 rounded"><i data-lucide="x"></i></button>
      <img id="zoom-img" src="" class="w-full h-[70vh] object-contain rounded-lg">
    </div>
  </div>

  <script src="assets/scripts/main.js"></script>
  <script>
    lucide.createIcons();
    document.getElementById('year').textContent = new Date().getFullYear();

    // Função para renderizar o produto
    function renderProduct(product) {
      // Renderiza o HTML do produto
      const hero = document.getElementById('product-hero');
      hero.innerHTML = `
          <div class="lg:col-span-7">
            <div class="rounded-xl overflow-hidden card p-6">
              <div class="lg:flex lg:items-start lg:gap-6">
                <!-- Vertical thumbnails on large screens -->
                <div class="hidden lg:flex flex-col gap-3 w-28">
                  ${(product.galeria || []).map(img => `
                    <button class="thumb thumb-vertical rounded-md overflow-hidden" data-src="${img}">
                      <img src="${img}" class="w-full h-full object-cover" loading="lazy">
                    </button>
                  `).join('')}
                </div>
                <!-- Main image -->
                <div class="flex-1">
                  <div class="relative">
                    <img id="main-image" src="${product.imagem_url || (product.galeria && product.galeria[0]) || 'https://cdn.runrepeat.com/storage/gallery/product_primary/39891/nike-ja-1-21212250-720.jpg'}" alt="${product.nome}" class="w-full rounded-lg cursor-zoom-in" loading="lazy">
                    <button id="fav-btn" class="absolute top-4 right-4 p-3 rounded-full bg-white/6 fav-heart" aria-label="Favoritar">
                      <i data-lucide="heart" class="text-roxa"></i>
                    </button>
                  </div>
                  <!-- Horizontal thumbnails for small screens -->
                  <div class="mt-4 flex gap-3 overflow-x-auto block lg:hidden">
                    ${(product.galeria || []).map(img => `
                      <button class="thumb w-24 h-16 rounded-md overflow-hidden" data-src="${img}">
                        <img src="${img}" class="w-full h-full object-cover" loading="lazy">
                      </button>
                    `).join('')}
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="lg:col-span-5">
            <div class="card rounded-xl p-6 product-info">
              <p class="text-sm text-roxa font-semibold">${product.estado || 'Novo'}</p>
              <h1 class="text-3xl font-bold mt-2">${product.nome}</h1>
              
              <div class="mt-6">
                <div class="text-3xl font-bold text-roxa">R$ ${product.valor ?? product.preco ?? product.price ?? ''}</div>
                <p class="text-sm text-white/60 mt-1">Envio gratuito para todo o Brasil</p>
              </div>

              ${(function () {
                // Constroi o bloco de tamanhos somente quando o produto possui informação
                let sizes = [];
                if (product.tamanhos) {
                  if (Array.isArray(product.tamanhos)) sizes = product.tamanhos;
                  else sizes = String(product.tamanhos).split(',').map(s => s.trim()).filter(Boolean);
                } else if (product.tamanho) {
                  sizes = [String(product.tamanho)];
                } else if (product.size) {
                  sizes = Array.isArray(product.size) ? product.size : [String(product.size)];
                }
                if (sizes.length === 0) return '';
                return `
                  <div class="mt-6">
                    <div class="text-sm text-white/70 mb-3">Tamanho</div>
                    <select class="w-full p-3 rounded-md bg-zinc-900 border border-white/10 text-white size-select">
                      ${sizes.map(t => `<option value="${t}">${t}</option>`).join('')}
                    </select>
                  </div>
                `;
              })()}

              <div class="mt-6 space-y-3">
                <?php if ($isSellerOfProduct): ?>
                  <button id="add-cart" class="w-full px-6 py-3 rounded-md bg-gray-600 text-white font-semibold cursor-not-allowed" disabled title="Você não pode comprar seu próprio produto">Adicionar ao Carrinho</button>
                  <button id="buy-now" class="w-full px-6 py-3 rounded-md border border-gray-500 text-gray-400 cursor-not-allowed" disabled title="Você não pode comprar seu próprio produto">Comprar Agora</button>
                <?php else: ?>
                  <button id="add-cart" class="w-full px-6 py-3 rounded-md btn-glow bg-roxa text-white font-semibold hover:bg-roxa/90 transition">Adicionar ao Carrinho</button>
                  <button id="buy-now" class="w-full px-6 py-3 rounded-md border-2 border-cyan text-cyan hover:bg-cyan/10 transition font-semibold">Comprar Agora</button>
                <?php endif; ?>
              </div>

              <div class="mt-6 pt-6 border-t border-white/10 text-sm text-white/60">
                <button class="hover:text-white transition">Compartilhe</button> • <button class="hover:text-white transition">Reportar</button>
              </div>
            </div>
          </div>
        </div>
      `;
      lucide.createIcons();
      // Atualiza conteúdo da aba Descrição também
      const tabDescEl = document.getElementById('tab-desc');
      if (tabDescEl) tabDescEl.innerHTML = `<p class="text-white/70">${product.descricao || ''}</p>`;
      // Adiciona listeners igual antes
    document.querySelectorAll('.thumb').forEach(btn => {
      btn.addEventListener('click', () => {
        const src = btn.dataset.src;
        const main = document.getElementById('main-image');
        gsap.to(main, {
          opacity: 0,
          duration: 0.25,
          onComplete: () => {
            main.src = src;
            gsap.to(main, {
              opacity: 1,
              duration: 0.3
            });
          }
        });
      });
    });
    const favBtn = document.getElementById('fav-btn');
    favBtn.addEventListener('click', () => {
      favBtn.classList.toggle('active');
    });
    document.getElementById('add-cart').addEventListener('click', async () => {
      const btn = document.getElementById('add-cart');
      gsap.fromTo(btn, {
        scale: 1
      }, {
        scale: 0.98,
        duration: 0.08,
        yoyo: true,
        repeat: 1
      });
      // determine selected size
      const sizeSelect = document.querySelector('.size-select');
      const selectedSize = sizeSelect ? sizeSelect.value : '';
      try {
        const fd = new FormData();
        fd.append('id_produto', product.id_produto || product.id);
        if (selectedSize) fd.append('tamanho', selectedSize);
        fd.append('quantidade', 1);
        const res = await fetch('api/add_to_cart.php', {
          method: 'POST',
          body: fd
        });
        const data = await res.json();
        if (data && data.success) {
          const cc = document.getElementById('cart-count');
          if (cc) cc.textContent = data.items_count;
          if (window.srShowToast) window.srShowToast('Adicionado ao carrinho', 'success');
        } else {
          const msg = data && data.error ? data.error : 'Erro ao adicionar ao carrinho';
          if (window.srShowToast) window.srShowToast(msg, 'error');
          else alert(msg);
        }
      } catch (e) {
        if (window.srShowToast) window.srShowToast('Erro de conexão', 'error');
        else alert('Erro de conexão: ' + e.message);
      }
    });
    document.getElementById('buy-now').addEventListener('click', async () => {
      const btn = document.getElementById('buy-now');
      gsap.fromTo(btn, {
        scale: 1
      }, {
        scale: 0.98,
        duration: 0.08,
        yoyo: true,
        repeat: 1
      });
      const sizeSelect = document.querySelector('.size-select');
      const selectedSize = sizeSelect ? sizeSelect.value : '';
      try {
        const fd = new FormData();
        fd.append('id_produto', product.id_produto || product.id);
        if (selectedSize) fd.append('tamanho', selectedSize);
        fd.append('quantidade', 1);
        const res = await fetch('api/add_to_cart.php', {
          method: 'POST',
          body: fd
        });
        const data = await res.json();
        if (data && data.success) {
          // redirect straight to cart/checkout
          window.location.href = 'cart.php';
        } else {
          const msg = data && data.error ? data.error : 'Erro ao adicionar ao carrinho';
          if (window.srShowToast) window.srShowToast(msg, 'error');
          else alert(msg);
        }
      } catch (e) {
        if (window.srShowToast) window.srShowToast('Erro de conexão', 'error');
        else alert('Erro de conexão: ' + e.message);
      }
    });
    window.addEventListener('load', () => {
      gsap.from('.card, #main-image, .card h1', {
        y: 8,
        opacity: 0,
        stagger: 0.05,
        duration: 0.6
      });
    });
    // Zoom modal
    const mainImgEl = document.getElementById('main-image');
    if (mainImgEl) {
      mainImgEl.addEventListener('click', () => {
        const src = document.getElementById('main-image').src;
        document.getElementById('zoom-img').src = src;
        const modal = document.getElementById('zoom-modal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        gsap.fromTo('#zoom-img', {
          scale: 0.98,
          opacity: 0
        }, {
          scale: 1,
          opacity: 1,
          duration: 0.35
        });
      });
    }
    const zoomClose = document.getElementById('zoom-close');
    if (zoomClose) zoomClose.addEventListener('click', () => {
      const modal = document.getElementById('zoom-modal');
      gsap.to('#zoom-img', {
        scale: 0.98,
        opacity: 0,
        duration: 0.15,
        onComplete: () => {
          modal.classList.add('hidden');
          modal.classList.remove('flex');
        }
      });
    });

    // Atualiza a galeria abaixo (se existir)
    const galleryGrid = document.getElementById('product-gallery-grid');
    if (galleryGrid) {
      let gallery = [];
      if (product.galeria && Array.isArray(product.galeria)) gallery = product.galeria;
      else if (product.galeria && typeof product.galeria === 'string') gallery = product.galeria.split(',').map(x => x.trim()).filter(Boolean);
      else if (product.imagem_url) gallery = [product.imagem_url];
      galleryGrid.innerHTML = gallery.map(src => `<img class="w-full h-48 object-cover rounded-lg hover:scale-105 transition" loading="lazy" src="${src}">`).join('');
    }
    }

    // Busca produto pelo ID
    async function fetchProduct(id) {
      try {
        const res = await fetch(`api/get_product.php?id=${id}`);
        const data = await res.json();
        if (data.success && data.product) {
          // Ajusta galeria se vier como string separada
          if (typeof data.product.galeria === 'string') {
            data.product.galeria = data.product.galeria.split(',').map(x => x.trim());
          }
          renderProduct(data.product);
          checkFavoriteStatus(id);
        } else {
          document.getElementById('product-hero').innerHTML = '<div class="col-span-12 text-center py-12 text-xl">Produto não encontrado.</div>';
        }
      } catch (e) {
        document.getElementById('product-hero').innerHTML = '<div class="col-span-12 text-center py-12 text-xl">Erro ao carregar produto.</div>';
      }
    }

    async function checkFavoriteStatus(productId) {
      try {
        const res = await fetch(`api/check_favorite.php?id_produto=${productId}`);
        const data = await res.json();
        if (data.success) {
          const favBtn = document.getElementById('fav-btn');
          if (favBtn) {
            if (data.favorited) {
              favBtn.classList.add('active');
              const icon = favBtn.querySelector('[data-lucide="heart"]');
              if (icon) icon.setAttribute('fill', 'currentColor');
            } else {
              favBtn.classList.remove('active');
              const icon = favBtn.querySelector('[data-lucide="heart"]');
              if (icon) icon.setAttribute('fill', 'none');
            }
          }
        }
      } catch (e) {
        console.error('Error checking favorite:', e);
      }
    }

    async function toggleFavorite(productId) {
      try {
        const fd = new FormData();
        fd.append('id_produto', productId);
        const res = await fetch('api/toggle_favorite.php', {
          method: 'POST',
          body: fd
        });
        const data = await res.json();
        if (data.success) {
          const favBtn = document.getElementById('fav-btn');
          if (favBtn) {
            const icon = favBtn.querySelector('[data-lucide="heart"]');
            if (data.favorited) {
              favBtn.classList.add('active');
              if (icon) icon.setAttribute('fill', 'currentColor');
              if (window.srShowToast) window.srShowToast('Adicionado aos favoritos', 'success');
            } else {
              favBtn.classList.remove('active');
              if (icon) icon.setAttribute('fill', 'none');
              if (window.srShowToast) window.srShowToast('Removido dos favoritos', 'success');
            }
          }
        } else {
          if (window.srShowToast) window.srShowToast(data.error || 'Erro ao favoritar', 'error');
        }
      } catch (e) {
        console.error('Error toggling favorite:', e);
        if (window.srShowToast) window.srShowToast('Erro de conexão', 'error');
      }
    }

    // Executa ao carregar
    window.addEventListener('DOMContentLoaded', () => {
      const id = <?php echo json_encode($product_id); ?>;
      if (id > 0) fetchProduct(id);
      else document.getElementById('product-hero').innerHTML = '<div class="col-span-12 text-center py-12 text-xl">Produto não encontrado.</div>';
      
      // Favoritos handler
      document.addEventListener('click', (e) => {
        const favBtn = e.target.closest('#fav-btn');
        if (favBtn) {
          e.preventDefault();
          const productId = <?php echo json_encode($product_id); ?>;
          if (productId > 0) toggleFavorite(productId);
        }
      });
    });
  </script>
</body>

</html>