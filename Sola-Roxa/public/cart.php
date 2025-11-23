<?php
require_once __DIR__ . '/../backend/auth.php';
// Apenas usuários autenticados podem acessar o carrinho
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
    content="Carrinho e checkout - Sola Roxa marketplace" />

  <!-- Fonts: import das fontes Google utilizadas no site -->
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap"
    rel="stylesheet" />

  <!-- Tailwind CDN: uso rápido do Tailwind para estilos utilitários -->
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
          fontFamily: {
            pop: ["Poppins", "ui-sans-serif", "system-ui"]
          },
        },
      },
    };
  </script>

  <!-- GSAP: biblioteca de animações (entradas e transições) -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
  <!-- Lucide icons: ícones SVG usados na UI -->
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
  <link rel="icon" href="assets/img/favicon/favicon_io/favicon.ico" />

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Creepster&family=Eater&family=Metal+Mania&family=Nosifer&family=Roboto:wght@400;500;700&display=swap"
    rel="stylesheet" />
  <link
    href="https://fonts.googleapis.com/css2?family=Fjalla+One&display=swap"
    rel="stylesheet" />

  <style>
    body {
      background: #0d0d0d;
    }

    .glass {
      background: rgba(255, 255, 255, 0.02);
      backdrop-filter: blur(8px);
    }

    .card {
      background: linear-gradient(180deg,
          rgba(255, 255, 255, 0.02),
          rgba(0, 0, 0, 0.08));
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

  <main class="pt-20 pb-16">
    <div class="max-w-7xl mx-auto px-6 sm:px-8">
      <!-- Barra de progresso do checkout (etapas) -->
      <div class="mb-8">
        <div class="flex items-center justify-center gap-6">
          <div id="step-cart" class="flex items-center gap-3">
            <div
              class="w-9 h-9 rounded-full bg-roxa flex items-center justify-center">
              1
            </div>
            <div class="text-sm text-white/70">Carrinho</div>
          </div>
          <div class="w-32 h-0.5 bg-white/6"></div>
          <div id="step-address" class="flex items-center gap-3">
            <div
              class="w-9 h-9 rounded-full bg-white/6 flex items-center justify-center text-white">
              2
            </div>
            <div class="text-sm text-white/50">Endereço</div>
          </div>
          <div class="w-32 h-0.5 bg-white/6"></div>
          <div id="step-pay" class="flex items-center gap-3">
            <div
              class="w-9 h-9 rounded-full bg-white/6 flex items-center justify-center text-white">
              3
            </div>
            <div class="text-sm text-white/50">Pagamento</div>
          </div>
        </div>
      </div>

      <!-- Seção do Carrinho: lista de itens e resumo do pedido -->
      <section
        id="cart-section"
        class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-8">
          <h1 class="text-3xl font-bold text-center lg:text-left">
            Seu Carrinho
          </h1>
          <div id="cart-items" class="mt-6 space-y-4">
            <?php
            // Render cart items from session (server-side) so content appears even
            // if JS is cached/disabled. Falls back to empty box when no items.
            if (session_status() === PHP_SESSION_NONE) session_start();
            $cart = $_SESSION['cart'] ?? [];
            if (!empty($cart)) {
              try {
                require_once __DIR__ . '/../backend/db.php';
                foreach ($cart as $k => $it) {
                  $pid = intval($it['id_produto'] ?? 0);
                  $qty = intval($it['qty'] ?? 1);
                  $size = htmlspecialchars($it['tamanho'] ?? '');
                  if ($pid <= 0) continue;
                  $stmt = $pdo->prepare('SELECT id_produto, nome, valor, imagem_url FROM produto WHERE id_produto = ? LIMIT 1');
                  $stmt->execute([$pid]);
                  $p = $stmt->fetch();
                  if (!$p) continue;
                  $img_raw = $p['imagem_url'] ?? '';
                  if (strpos($img_raw, ',') !== false) {
                    $parts = array_filter(array_map('trim', explode(',', $img_raw)));
                    $img_raw = !empty($parts) ? $parts[0] : $img_raw;
                  }
                  $img = htmlspecialchars($img_raw ?: 'assets/img/placeholder.png');
                  $nome = htmlspecialchars($p['nome']);
                  $valor = number_format((float)$p['valor'], 2, ',', '.');
                  $subtotal = number_format($qty * (float)$p['valor'], 2, ',', '.');
            ?>
                  <div class="flex gap-4 items-center p-4 rounded-xl card">
                    <img src="<?php echo $img; ?>" alt="sneaker" class="w-28 h-20 object-cover rounded-md" />
                    <div class="flex-1">
                      <div class="flex items-start justify-between">
                        <div>
                          <h3 class="font-semibold"><?php echo $nome; ?></h3>
                          <p class="text-sm text-white/60">Tamanho: <?php echo $size ? $size : '-'; ?></p>
                        </div>
                        <div class="text-right">
                          <div class="text-lg font-semibold">R$ <?php echo $valor; ?></div>
                          <button class="text-sm text-white/60 hover:text-roxa mt-2 remove-btn" data-id="<?php echo $pid; ?>" data-size="<?php echo $size; ?>">Remover</button>
                        </div>
                      </div>
                      <!-- Cada anúncio é um item único — não exibimos controle de quantidade -->
                      <div class="mt-4 flex items-center gap-3">
                        <div class="text-sm text-white/60">Quantidade: 1</div>
                      </div>
                    </div>
                  </div>
            <?php
                }
              } catch (Throwable $e) {
                // ignore rendering errors; JS will attempt to load cart dynamically
              }
            } else {
              echo '<div class="col-span-full text-center py-12 text-white/60">Seu carrinho está vazio.</div>';
            }
            ?>
          </div>
        </div>

        <!-- Resumo do pedido (subtotal, frete, total) -->
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
                class="flex justify-between text-white/90 font-semibold text-lg">
                <span>Total</span><span id="total">R$ 3.281</span>
              </div>
            </div>
            <button
              id="to-checkout"
              class="mt-6 w-full py-3 rounded-lg btn-glow bg-roxa text-black font-semibold">
              Finalizar Compra
            </button>
          </div>
        </aside>
      </section>

      <!-- Seção de Checkout (inicialmente oculto) -->
      <section id="checkout-section" class="hidden mt-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
          <div class="lg:col-span-8 space-y-6">
            <h2 class="text-2xl font-bold">Finalizar Compra</h2>
            
            <!-- Seleção de Endereço -->
            <div class="p-6 rounded-xl card">
              <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold">Endereço de Entrega</h3>
                <button id="add-new-address-btn" class="text-sm text-roxa hover:text-roxa/80 flex items-center gap-2">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                  </svg>
                  Novo Endereço
                </button>
              </div>

              <!-- Lista de endereços salvos -->
              <div id="saved-addresses" class="space-y-3">
                <p class="text-white/60 text-center py-4">Carregando endereços...</p>
              </div>

              <!-- Formulário de novo endereço (oculto) -->
              <div id="new-address-form-container" class="hidden mt-4 p-4 bg-white/5 rounded-lg">
                <h4 class="text-sm font-semibold mb-3">Adicionar Novo Endereço</h4>
                <form id="new-address-form" class="space-y-3">
                  <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div class="md:col-span-2">
                      <label class="text-sm text-white/70">Rua / Avenida *</label>
                      <input name="rua" type="text" required class="w-full mt-1 p-2 rounded bg-transparent border border-white/10 text-white" />
                    </div>
                    <div>
                      <label class="text-sm text-white/70">Número *</label>
                      <input name="numero" type="number" required class="w-full mt-1 p-2 rounded bg-transparent border border-white/10 text-white" />
                    </div>
                  </div>
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                      <label class="text-sm text-white/70">Bairro</label>
                      <input name="bairro" type="text" class="w-full mt-1 p-2 rounded bg-transparent border border-white/10 text-white" />
                    </div>
                    <div>
                      <label class="text-sm text-white/70">Cidade *</label>
                      <input name="cidade" type="text" required class="w-full mt-1 p-2 rounded bg-transparent border border-white/10 text-white" />
                    </div>
                  </div>
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                      <label class="text-sm text-white/70">Estado (UF) *</label>
                      <select name="estado" required class="w-full mt-1 p-2 rounded bg-zinc-900 border border-white/10 text-white">
                        <option value="">Selecione</option>
                        <option value="AC">Acre</option>
                        <option value="AL">Alagoas</option>
                        <option value="AP">Amapá</option>
                        <option value="AM">Amazonas</option>
                        <option value="BA">Bahia</option>
                        <option value="CE">Ceará</option>
                        <option value="DF">Distrito Federal</option>
                        <option value="ES">Espírito Santo</option>
                        <option value="GO">Goiás</option>
                        <option value="MA">Maranhão</option>
                        <option value="MT">Mato Grosso</option>
                        <option value="MS">Mato Grosso do Sul</option>
                        <option value="MG">Minas Gerais</option>
                        <option value="PA">Pará</option>
                        <option value="PB">Paraíba</option>
                        <option value="PR">Paraná</option>
                        <option value="PE">Pernambuco</option>
                        <option value="PI">Piauí</option>
                        <option value="RJ">Rio de Janeiro</option>
                        <option value="RN">Rio Grande do Norte</option>
                        <option value="RS">Rio Grande do Sul</option>
                        <option value="RO">Rondônia</option>
                        <option value="RR">Roraima</option>
                        <option value="SC">Santa Catarina</option>
                        <option value="SP">São Paulo</option>
                        <option value="SE">Sergipe</option>
                        <option value="TO">Tocantins</option>
                      </select>
                    </div>
                  </div>
                  <div class="flex gap-2 justify-end">
                    <button type="button" id="cancel-new-address" class="px-4 py-2 text-sm border border-white/10 rounded text-white/70 hover:text-white">Cancelar</button>
                    <button type="submit" class="px-4 py-2 text-sm bg-roxa text-white rounded hover:bg-roxa/90">Salvar</button>
                  </div>
                </form>
              </div>
            </div>

            <!-- Método de Pagamento -->
            <div class="p-6 rounded-xl card">
              <h3 class="text-lg font-semibold mb-4">Método de Pagamento</h3>
              <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <label class="flex items-center gap-3 p-4 rounded-lg border border-white/10 cursor-pointer hover:border-roxa/50 transition payment-option">
                  <input type="radio" name="payment_method" value="credito" checked class="text-roxa" />
                  <div>
                    <div class="font-medium">Cartão de Crédito</div>
                    <div class="text-xs text-white/60">Aprovação instantânea</div>
                  </div>
                </label>
                <label class="flex items-center gap-3 p-4 rounded-lg border border-white/10 cursor-pointer hover:border-roxa/50 transition payment-option">
                  <input type="radio" name="payment_method" value="pix" class="text-roxa" />
                  <div>
                    <div class="font-medium">Pix</div>
                    <div class="text-xs text-white/60">Pagamento rápido</div>
                  </div>
                </label>
                <label class="flex items-center gap-3 p-4 rounded-lg border border-white/10 cursor-pointer hover:border-roxa/50 transition payment-option">
                  <input type="radio" name="payment_method" value="boleto" class="text-roxa" />
                  <div>
                    <div class="font-medium">Boleto</div>
                    <div class="text-xs text-white/60">Vence em 3 dias</div>
                  </div>
                </label>
              </div>
            </div>
          </div>

          <aside class="lg:col-span-4">
            <div class="p-6 rounded-xl card">
              <h3 class="font-semibold">Resumo do Pedido</h3>
              <div id="mini-list" class="mt-4 space-y-3">
                <!-- Itens compactos preenchidos pelo JavaScript durante o checkout -->
              </div>
              <div class="mt-4 flex justify-between text-white/70">
                <span>Subtotal</span><span id="mini-sub">R$ 0</span>
              </div>
              <div class="flex justify-between text-white/70">
                <span>Frete</span><span id="mini-shipping">R$ 0</span>
              </div>
              <div
                class="flex justify-between text-white/90 font-semibold text-lg">
                <span>Total</span><span id="mini-total">R$ 0</span>
              </div>
              <button
                id="confirm-order"
                class="mt-6 w-full py-3 rounded-lg btn-glow bg-roxa text-black font-semibold">
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
      class="max-w-7xl mx-auto px-6 sm:px-8 py-12 grid grid-cols-1 md:grid-cols-4 gap-8 text-sm">
      <div>
        <h5 class="font-semibold text-white mb-4">Ajuda</h5>
        <ul class="space-y-3">
          <li>
            <a
              href="javascript:void(0)"
              class="text-white/60 hover:text-white transition-colors">FAQ</a>
          </li>
          <li>
            <a
              href="javascript:void(0)"
              class="text-white/60 hover:text-white transition-colors">Envios</a>
          </li>
          <li>
            <a
              href="javascript:void(0)"
              class="text-white/60 hover:text-white transition-colors">Devoluções</a>
          </li>
        </ul>
      </div>

      <div>
        <h5 class="font-semibold text-white mb-4">Sobre Nós</h5>
        <ul class="space-y-3">
          <li>
            <a
              href="javascript:void(0)"
              class="text-white/60 hover:text-white transition-colors">Nosso manifesto</a>
          </li>
          <li>
            <a
              href="javascript:void(0)"
              class="text-white/60 hover:text-white transition-colors">Trabalhe conosco</a>
          </li>
        </ul>
      </div>

      <div>
        <h5 class="font-semibold text-white mb-4">Redes Sociais</h5>
        <ul class="space-y-3">
          <li>
            <a
              href="javascript:void(0)"
              class="text-white/60 hover:text-white transition-colors">Instagram</a>
          </li>
          <li>
            <a
              href="javascript:void(0)"
              class="text-white/60 hover:text-white transition-colors">Twitter</a>
          </li>
        </ul>
      </div>

      <div>
        <h5 class="font-semibold text-white mb-4">Termos</h5>
        <ul class="space-y-3">
          <li>
            <a
              href="javascript:void(0)"
              class="text-white/60 hover:text-white transition-colors">Política de Privacidade</a>
          </li>
          <li>
            <a
              href="javascript:void(0)"
              class="text-white/60 hover:text-white transition-colors">Termos de Uso</a>
          </li>
        </ul>
      </div>
    </div>
    <div class="border-t border-white/10 text-center py-6">
      <div
        class="max-w-7xl mx-auto px-6 sm:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
        <p class="text-white/40">
          © <span id="year"></span> SOLA ROXA — Todos os direitos reservados
        </p>
        <div class="flex items-center gap-6">
          <a
            href="javascript:void(0)"
            class="text-white/60 hover:text-white transition-colors text-sm">Contato</a>
        </div>
      </div>
    </div>
  </footer>

  <!-- Modal de confirmação exibido após finalização do pedido -->
  <div
    id="modal"
    class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50">
    <div class="bg-[#0d0d0d] p-8 rounded-xl text-center glass">
      <h3 class="text-2xl font-bold mb-2">
        Obrigado por comprar com a Sola Roxa!
      </h3>
      <p class="text-white/60 mb-4">
        Seu pedido foi recebido e está sendo processado.
      </p>
      <button
        id="close-modal"
        class="px-6 py-2 rounded bg-roxa text-black font-semibold">
        Fechar
      </button>
    </div>
  </div>

  <script src="assets/scripts/main.js"></script>
  <script src="assets/scripts/cart.js?v=2"></script>
</body>

</html>