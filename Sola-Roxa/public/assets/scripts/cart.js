// Inicializa ícones e informações estáticas da página
lucide.createIcons();

// Insert current year (safe guard if element not present). Do NOT redeclare `yearEl` if defined elsewhere.
let _yearEl = (typeof yearEl !== 'undefined') ? yearEl : document.getElementById('year');
if (_yearEl) _yearEl.textContent = new Date().getFullYear();

const format = (v) => "R$ " + Number(v).toLocaleString("pt-BR", { minimumFractionDigits: 2, maximumFractionDigits: 2 });

// Load cart from server and render
async function loadCart() {
  try {
    const res = await fetch('api/get_cart.php');
    const data = await res.json();
    if (!data || !data.cart) return;
    const container = document.getElementById('cart-items');
    container.innerHTML = '';
    data.cart.forEach(item => {
      const el = document.createElement('div');
      el.className = 'flex gap-4 items-center p-4 rounded-xl card';
      el.innerHTML = `
        <img src="${item.imagem_url || 'assets/img/placeholder.png'}" alt="sneaker" class="w-28 h-20 object-cover rounded-md" />
        <div class="flex-1">
          <div class="flex items-start justify-between">
            <div>
              <h3 class="font-semibold">${item.nome}</h3>
              <p class="text-sm text-white/60">Tamanho: ${item.tamanho || '-'} </p>
            </div>
            <div class="text-right">
              <div class="text-lg font-semibold">${format(item.valor)}</div>
              <button class="text-sm text-white/60 hover:text-roxa mt-2 remove-btn" data-id="${item.id_produto}" data-size="${item.tamanho}">Remover</button>
            </div>
          </div>
          <div class="mt-4 flex items-center gap-3">
            <div class="text-sm text-white/60">Quantidade: 1</div>
          </div>
        </div>
      `;
      container.appendChild(el);
    });

    // update totals (guard elements exist)
    const subtotalEl = document.getElementById('subtotal'); if (subtotalEl) subtotalEl.textContent = format(data.subtotal || 0);
    const shippingEl = document.getElementById('shipping'); if (shippingEl) shippingEl.textContent = format(data.shipping || 0);
    const totalEl = document.getElementById('total'); if (totalEl) totalEl.textContent = format(data.total || 0);
    const miniSubEl = document.getElementById('mini-sub'); if (miniSubEl) miniSubEl.textContent = format(data.subtotal || 0);
    const miniShipEl = document.getElementById('mini-shipping'); if (miniShipEl) miniShipEl.textContent = format(data.shipping || 0);
    const miniTotalEl = document.getElementById('mini-total'); if (miniTotalEl) miniTotalEl.textContent = format(data.total || 0);

    // update cart count if element exists
    const cc = document.getElementById('cart-count');
    if (cc) cc.textContent = data.items_count || 0;
    if (window.srUpdateCartCount) window.srUpdateCartCount();

    attachCartHandlers();
  } catch (e) {
    console.error('Failed to load cart', e);
  }
}

function attachCartHandlers() {
  // Only attach remove handlers (no quantity controls)
  document.querySelectorAll('.remove-btn').forEach(btn => btn.addEventListener('click', async (e) => {
    const id = e.currentTarget.dataset.id;
    const size = e.currentTarget.dataset.size || '';
    const el = e.currentTarget.closest('.card');
    try {
      const ok = await removeFromCart(id, size);
      if (ok) {
        // animate removal only on success
        gsap.to(el, { duration: 0.25, opacity: 0, height: 0, margin: 0, onComplete: () => el.remove() });
        setTimeout(() => loadCart(), 300);
      } else {
        // show error and reload to reflect server state
        alert('Falha ao remover item do carrinho');
        await loadCart();
      }
    } catch (err) {
      console.error(err);
      alert('Erro de conexão');
    }
  }));
}

async function updateQty(id, qty, size) {
  const fd = new FormData(); fd.append('id_produto', id); fd.append('quantidade', qty); if (size) fd.append('tamanho', size);
  try { await fetch('api/update_cart.php', { method: 'POST', body: fd }); } catch (e) { console.error(e); }
}

async function removeFromCart(id, size) {
  const fd = new FormData(); fd.append('id_produto', id); fd.append('tamanho', size || '');
  try {
    const res = await fetch('api/remove_from_cart.php', { method: 'POST', body: fd });
    if (!res.ok) return false;
    const data = await res.json();
    return data && data.success;
  } catch (e) { console.error(e); return false; }
}

// Proceed to checkout: show checkout section and populate mini-list
document.getElementById('to-checkout').addEventListener('click', async () => {
  const res = await fetch('api/get_cart.php');
  const data = await res.json();
  const mini = document.getElementById('mini-list');
  mini.innerHTML = '';
  data.cart.forEach(i => {
    const div = document.createElement('div');
    div.className = 'flex items-center gap-3';
    div.innerHTML = `<img src="${i.imagem_url || 'assets/img/placeholder.png'}" class="w-12 h-10 object-cover rounded"> <div class="flex-1 text-sm">${i.nome} <div class='text-white/60 text-xs'>Qtd: ${i.qty}</div></div> <div class='text-sm font-semibold'>${format(i.subtotal)}</div>`;
    mini.appendChild(div);
  });
  // switch views (same code)
  gsap.to('#cart-section', { duration: 0.35, opacity: 0, pointerEvents: 'none', onComplete: () => {
    document.getElementById('cart-section').classList.add('hidden');
    document.getElementById('checkout-section').classList.remove('hidden');
    gsap.fromTo('#checkout-section', { opacity: 0, y: 20 }, { opacity: 1, y: 0 });
  }});
  // update progress visuals
  document.querySelector('#step-cart div')?.classList?.add('text-white/50');
  document.getElementById('step-cart').querySelector('div')?.classList?.remove('bg-roxa');
  document.getElementById('step-address').querySelector('div').classList.remove('bg-white/6');
  document.getElementById('step-address').querySelector('div').classList.add('bg-roxa');
});

// Confirm order: send checkout data to server
document.getElementById('confirm-order').addEventListener('click', async () => {
  const form = document.getElementById('checkout-form');
  const fd = new FormData(form);
  try {
    const res = await fetch('api/checkout.php', { method: 'POST', body: fd });
    const data = await res.json();
    if (data && data.success) {
      // show modal
      const modal = document.getElementById('modal'); modal.classList.remove('hidden'); modal.classList.add('flex');
      gsap.fromTo('#modal > div', { scale: 0.96, opacity: 0 }, { scale: 1, opacity: 1, duration: 0.35 });
      // optionally redirect to order page
    } else {
      alert('Erro ao finalizar pedido: ' + (data.error || JSON.stringify(data)));
    }
  } catch (e) { alert('Erro de conexão: ' + e.message); }
});

document.getElementById('close-modal').addEventListener('click', () => {
  const modal = document.getElementById('modal');
  gsap.to('#modal > div', { scale: 0.96, opacity: 0, duration: 0.2, onComplete: () => { modal.classList.add('hidden'); modal.classList.remove('flex'); } });
});

// initialize
loadCart();

// small entrance animation
window.addEventListener('load', () => { gsap.from('main h1, main h2', { y: 8, opacity: 0, stagger: 0.06, duration: 0.6 }); });
