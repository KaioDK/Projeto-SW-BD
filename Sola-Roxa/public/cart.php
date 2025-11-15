<?php
require_once __DIR__ . '/../backend/auth.php';
// Only logged users may access the cart
requireUser();
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Sola Roxa | Carrinho & Checkout</title>
    <meta
      name="description"
      content="Carrinho e checkout - Sola Roxa marketplace"
    />

    <!-- Fonts -->
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap"
      rel="stylesheet"
    />

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: { roxa: "#8B5CF6", cyan: "#00F0FF", bg: "#0D0D0D" },
            fontFamily: { pop: ["Poppins", "ui-sans-serif", "system-ui"] },
          },
        },
      };
    </script>

    <!-- GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <!-- Lucide icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Creepster&family=Eater&family=Metal+Mania&family=Nosifer&family=Roboto:wght@400;500;700&display=swap"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Fjalla+One&display=swap"
      rel="stylesheet"
    />

    <style>
      body {
        background: #0d0d0d;
      }
      .glass {
        background: rgba(255, 255, 255, 0.02);
        backdrop-filter: blur(8px);
      }
      .card {
        background: linear-gradient(
          180deg,
          rgba(255, 255, 255, 0.02),
          rgba(0, 0, 0, 0.08)
        );
        border: 1px solid rgba(255, 255, 255, 0.06);
      }
      .glow:hover {
        box-shadow: 0 8px 28px rgba(139, 92, 246, 0.12);
      }
      .btn-glow {
        transition: all 0.18s ease;
      }
      .btn-glow:hover {
        box-shadow: 0 0 18px rgba(139, 92, 246, 0.22);
        transform: translateY(-2px);
      }
    </style>
  </head>
  <body class="font-pop text-white antialiased leading-relaxed">
    <header
      id="site-header"
      class="fixed w-full z-40 top-0 transition-all duration-300"
    >
      <nav
        class="max-w-7xl mx-auto px-6 sm:px-8 flex items-center justify-between h-16 transition-all duration-300"
      >
        <div class="flex items-center gap-6">
          <a
            href="index.php"
            style="font-family: Fjalla One"
            class="text-xl font-extrabold tracking-widest"
            >SOLA <span class="text-purple-700">ROXA</span></a
          >
        </div>

        <ul
          class="hidden md:flex gap-8 text-sm text-white-200 uppercase tracking-wider"
        >
          <li>
            <a class="hover:text-roxa transition" href="index.php/#lancamentos"
              >Lançamentos</a
            >
          </li>
          <li>
            <a class="hover:text-roxa transition" href="index.php#masculino"
              >Masculino</a
            >
          </li>
          <li>
            <a class="hover:text-roxa transition" href="index.php/#feminino">Feminino</a>
          </li>
          <li>
            <a class="hover:text-roxa transition" href="index.php/#colecoes"
              >Colecionáveis</a
            >
          </li>
          <li>
            <a class="hover:text-roxa transition" href="catalog.php"
              >Marketplace</a
            >
          </li>
        </ul>

        <div class="flex items-center gap-4">
          <button
            aria-label="buscar"
            class="p-2 rounded-md hover:bg-white/5 transition cursor-pointer"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke-width="1.5"
              stroke="currentColor"
              class="size-6"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"
              />
            </svg>
          </button>
          <!-- user -->
          <a href="auth.php">
            <button
              aria-label="conta"
              class="p-2 rounded-md hover:bg-white/5 transition cursor-pointer"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="size-6"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"
                />
              </svg>
            </button>
          </a>
          <!-- cart -->
          <a href="cart.php">
            <button
              aria-label="carrinho"
              class="p-2 rounded-md hover:bg-white/5 transition cursor-pointer"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="size-6"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"
                />
              </svg>
            </button>
          </a>
        </div>
      </nav>
    </header>

    <main class="pt-20 pb-16">
      <div class="max-w-7xl mx-auto px-6 sm:px-8">
        <!-- Progress bar -->
        <div class="mb-8">
          <div class="flex items-center justify-center gap-6">
            <div id="step-cart" class="flex items-center gap-3">
              <div
                class="w-9 h-9 rounded-full bg-roxa flex items-center justify-center"
              >
                1
              </div>
              <div class="text-sm text-white/70">Carrinho</div>
            </div>
            <div class="w-32 h-0.5 bg-white/6"></div>
            <div id="step-address" class="flex items-center gap-3">
              <div
                class="w-9 h-9 rounded-full bg-white/6 flex items-center justify-center text-black"
              >
                2
              </div>
              <div class="text-sm text-white/50">Endereço</div>
            </div>
            <div class="w-32 h-0.5 bg-white/6"></div>
            <div id="step-pay" class="flex items-center gap-3">
              <div
                class="w-9 h-9 rounded-full bg-white/6 flex items-center justify-center text-black"
              >
                3
              </div>
              <div class="text-sm text-white/50">Pagamento</div>
            </div>
          </div>
        </div>

        <!-- Cart Section -->
        <section
          id="cart-section"
          class="grid grid-cols-1 lg:grid-cols-12 gap-8"
        >
          <div class="lg:col-span-8">
            <h1 class="text-3xl font-bold text-center lg:text-left">
              Seu Carrinho
            </h1>
            <div class="mt-6 space-y-4">
              <!-- Item 1 -->
              <div class="flex gap-4 items-center p-4 rounded-xl card">
                <img
                  src="https://cdn.runrepeat.com/storage/gallery/product_primary/32545/adidas-ozweego-21158485-720.jpg"
                  alt="sneaker"
                  class="w-28 h-20 object-cover rounded-md"
                />
                <div class="flex-1">
                  <div class="flex items-start justify-between">
                    <div>
                      <h3 class="font-semibold">Adidas Ozweego</h3>
                      <p class="text-sm text-white/60">
                        Tamanho: 42 • Cor: Branco/Azul
                      </p>
                    </div>
                    <div class="text-right">
                      <div class="text-lg font-semibold">R$ 699</div>
                      <button
                        class="text-sm text-white/60 hover:text-roxa mt-2 remove-btn"
                        data-id="1"
                      >
                        Remover
                      </button>
                    </div>
                  </div>

                  <div class="mt-4 flex items-center gap-3">
                    <label class="text-sm text-white/60">Quantidade</label>
                    <div class="ml-2 flex items-center gap-2">
                      <button
                        class="px-2 py-1 rounded border border-white/10 qty-decrease"
                        data-id="1"
                      >
                        -
                      </button>
                      <input
                        type="number"
                        min="1"
                        value="1"
                        class="w-14 text-center rounded bg-transparent border border-white/10 p-1 qty-input"
                        data-id="1"
                      />
                      <button
                        class="px-2 py-1 rounded border border-white/10 qty-increase"
                        data-id="1"
                      >
                        +
                      </button>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Item 2 -->
              <div class="flex gap-4 items-center p-4 rounded-xl card">
                <img
                  src="https://cdn.runrepeat.com/storage/gallery/product_primary/38821/new-balance-9060-21208162-720.jpg"
                  alt="sneaker"
                  class="w-28 h-20 object-cover rounded-md"
                />
                <div class="flex-1">
                  <div class="flex items-start justify-between">
                    <div>
                      <h3 class="font-semibold">New Balance 9060</h3>
                      <p class="text-sm text-white/60">
                        Tamanho: 40 • Cor: Branco
                      </p>
                    </div>
                    <div class="text-right">
                      <div class="text-lg font-semibold">R$ 1.299</div>
                      <button
                        class="text-sm text-white/60 hover:text-roxa mt-2 remove-btn"
                        data-id="2"
                      >
                        Remover
                      </button>
                    </div>
                  </div>
                  <div class="mt-4 flex items-center gap-3">
                    <label class="text-sm text-white/60">Quantidade</label>
                    <div class="ml-2 flex items-center gap-2">
                      <button
                        class="px-2 py-1 rounded border border-white/10 qty-decrease"
                        data-id="2"
                      >
                        -
                      </button>
                      <input
                        type="number"
                        min="1"
                        value="2"
                        class="w-14 text-center rounded bg-transparent border border-white/10 p-1 qty-input"
                        data-id="2"
                      />
                      <button
                        class="px-2 py-1 rounded border border-white/10 qty-increase"
                        data-id="2"
                      >
                        +
                      </button>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Item 3 -->
              <div class="flex gap-4 items-center p-4 rounded-xl card">
                <img
                  src="https://cdn.runrepeat.com/storage/gallery/product_primary/39411/nike-zoom-vomero-5-lab-test-and-review-3-21506315-720.jpg"
                  alt="sneaker"
                  class="w-28 h-20 object-cover rounded-md"
                />
                <div class="flex-1">
                  <div class="flex items-start justify-between">
                    <div>
                      <h3 class="font-semibold">Nike Zoom Vomero 5</h3>
                      <p class="text-sm text-white/60">
                        Tamanho: 41 • Cor: Branco
                      </p>
                    </div>
                    <div class="text-right">
                      <div class="text-lg font-semibold">R$ 1.234</div>
                      <button
                        class="text-sm text-white/60 hover:text-roxa mt-2 remove-btn"
                        data-id="3"
                      >
                        Remover
                      </button>
                    </div>
                  </div>
                  <div class="mt-4 flex items-center gap-3">
                    <label class="text-sm text-white/60">Quantidade</label>
                    <div class="ml-2 flex items-center gap-2">
                      <button
                        class="px-2 py-1 rounded border border-white/10 qty-decrease"
                        data-id="3"
                      >
                        -
                      </button>
                      <input
                        type="number"
                        min="1"
                        value="1"
                        class="w-14 text-center rounded bg-transparent border border-white/10 p-1 qty-input"
                        data-id="3"
                      />
                      <button
                        class="px-2 py-1 rounded border border-white/10 qty-increase"
                        data-id="3"
                      >
                        +
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Order summary -->
          <aside class="lg:col-span-4">
            <div class="p-6 rounded-xl card sticky top-28">
              <h2 class="font-semibold text-lg">Resumo do Pedido</h2>
              <div class="mt-4 space-y-3">
                <div class="flex justify-between text-white/70">
                  <span>Subtotal</span><span id="subtotal">R$ 3.232</span>
                </div>
                <div class="flex justify-between text-white/70">
                  <span>Frete</span><span id="shipping">R$ 49</span>
                </div>
                <div
                  class="flex justify-between text-white/90 font-semibold text-lg"
                >
                  <span>Total</span><span id="total">R$ 3.281</span>
                </div>
              </div>
              <button
                id="to-checkout"
                class="mt-6 w-full py-3 rounded-lg btn-glow bg-roxa text-black font-semibold"
              >
                Finalizar Compra
              </button>
            </div>
          </aside>
        </section>

        <!-- Checkout Section (hidden initially) -->
        <section id="checkout-section" class="hidden mt-12">
          <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-8">
              <h2 class="text-2xl font-bold mb-4">Finalizar Compra</h2>
              <div class="p-6 rounded-xl card">
                <form id="checkout-form" class="space-y-4">
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                      <label class="text-sm text-white/70">Nome completo</label>
                      <input
                        name="name"
                        required
                        class="w-full mt-2 p-3 rounded bg-transparent border border-white/10"
                      />
                    </div>
                    <div>
                      <label class="text-sm text-white/70">Telefone</label>
                      <input
                        name="phone"
                        required
                        class="w-full mt-2 p-3 rounded bg-transparent border border-white/10"
                      />
                    </div>
                  </div>

                  <div>
                    <label class="text-sm text-white/70">Endereço</label>
                    <input
                      name="address"
                      required
                      class="w-full mt-2 p-3 rounded bg-transparent border border-white/10"
                    />
                  </div>

                  <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div>
                      <label class="text-sm text-white/70">Cidade</label>
                      <input
                        name="city"
                        required
                        class="w-full mt-2 p-3 rounded bg-transparent border border-white/10"
                      />
                    </div>
                    <div>
                      <label class="text-sm text-white/70">CEP</label>
                      <input
                        name="zip"
                        required
                        class="w-full mt-2 p-3 rounded bg-transparent border border-white/10"
                      />
                    </div>
                    <div>
                      <label class="text-sm text-white/70">País</label>
                      <input
                        name="country"
                        required
                        class="w-full mt-2 p-3 rounded bg-transparent border border-white/10"
                      />
                    </div>
                  </div>

                  <div>
                    <div class="text-sm font-semibold mb-2">
                      Método de pagamento
                    </div>
                    <div class="flex gap-3">
                      <label
                        class="flex-1 p-3 rounded border border-white/10 cursor-pointer"
                      >
                        <input
                          type="radio"
                          name="pay"
                          value="card"
                          class="mr-2"
                          checked
                        />
                        Cartão
                      </label>
                      <label
                        class="flex-1 p-3 rounded border border-white/10 cursor-pointer"
                      >
                        <input
                          type="radio"
                          name="pay"
                          value="pix"
                          class="mr-2"
                        />
                        Pix
                      </label>
                      <label
                        class="flex-1 p-3 rounded border border-white/10 cursor-pointer"
                      >
                        <input
                          type="radio"
                          name="pay"
                          value="boleto"
                          class="mr-2"
                        />
                        Boleto
                      </label>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <aside class="lg:col-span-4">
              <div class="p-6 rounded-xl card">
                <h3 class="font-semibold">Resumo do Pedido</h3>
                <div id="mini-list" class="mt-4 space-y-3">
                  <!-- small items populated by JS -->
                </div>
                <div class="mt-4 flex justify-between text-white/70">
                  <span>Subtotal</span><span id="mini-sub">R$ 0</span>
                </div>
                <div class="flex justify-between text-white/70">
                  <span>Frete</span><span id="mini-shipping">R$ 0</span>
                </div>
                <div
                  class="flex justify-between text-white/90 font-semibold text-lg"
                >
                  <span>Total</span><span id="mini-total">R$ 0</span>
                </div>
                <button
                  id="confirm-order"
                  class="mt-6 w-full py-3 rounded-lg btn-glow bg-roxa text-black font-semibold"
                >
                  Confirmar Pedido
                </button>
              </div>
            </aside>
          </div>
        </section>
      </div>
    </main>

    <footer class="bg-white/[0.01] mt-12 border-t border-white/10">
      <div
        class="max-w-7xl mx-auto px-6 sm:px-8 py-12 grid grid-cols-1 md:grid-cols-4 gap-8 text-sm"
      >
        <div>
          <h5 class="font-semibold text-white mb-4">Ajuda</h5>
          <ul class="space-y-3">
            <li>
              <a
                href="#"
                class="text-white/60 hover:text-white transition-colors"
                >FAQ</a
              >
            </li>
            <li>
              <a
                href="#"
                class="text-white/60 hover:text-white transition-colors"
                >Envios</a
              >
            </li>
            <li>
              <a
                href="#"
                class="text-white/60 hover:text-white transition-colors"
                >Devoluções</a
              >
            </li>
          </ul>
        </div>

        <div>
          <h5 class="font-semibold text-white mb-4">Sobre Nós</h5>
          <ul class="space-y-3">
            <li>
              <a
                href="#"
                class="text-white/60 hover:text-white transition-colors"
                >Nosso manifesto</a
              >
            </li>
            <li>
              <a
                href="#"
                class="text-white/60 hover:text-white transition-colors"
                >Trabalhe conosco</a
              >
            </li>
          </ul>
        </div>

        <div>
          <h5 class="font-semibold text-white mb-4">Redes Sociais</h5>
          <ul class="space-y-3">
            <li>
              <a
                href="#"
                class="text-white/60 hover:text-white transition-colors"
                >Instagram</a
              >
            </li>
            <li>
              <a
                href="#"
                class="text-white/60 hover:text-white transition-colors"
                >Twitter</a
              >
            </li>
          </ul>
        </div>

        <div>
          <h5 class="font-semibold text-white mb-4">Termos</h5>
          <ul class="space-y-3">
            <li>
              <a
                href="#"
                class="text-white/60 hover:text-white transition-colors"
                >Política de Privacidade</a
              >
            </li>
            <li>
              <a
                href="#"
                class="text-white/60 hover:text-white transition-colors"
                >Termos de Uso</a
              >
            </li>
          </ul>
        </div>
      </div>
      <div class="border-t border-white/10 text-center py-6">
        <div
          class="max-w-7xl mx-auto px-6 sm:px-8 flex flex-col sm:flex-row items-center justify-between gap-4"
        >
          <p class="text-white/40">
            © <span id="year"></span> SOLA ROXA — Todos os direitos reservados
          </p>
          <div class="flex items-center gap-6">
            <a
              href="#"
              class="text-white/60 hover:text-white transition-colors text-sm"
              >Contato</a
            >
          </div>
        </div>
      </div>
    </footer>

    <!-- Confirmation modal -->
    <div
      id="modal"
      class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50"
    >
      <div class="bg-[#0d0d0d] p-8 rounded-xl text-center glass">
        <h3 class="text-2xl font-bold mb-2">
          Obrigado por comprar com a Sola Roxa!
        </h3>
        <p class="text-white/60 mb-4">
          Seu pedido foi recebido e está sendo processado.
        </p>
        <button
          id="close-modal"
          class="px-6 py-2 rounded bg-roxa text-black font-semibold"
        >
          Fechar
        </button>
      </div>
    </div>

    <script src="assets/scripts/cart.js"></script>
  </body>
</html>
