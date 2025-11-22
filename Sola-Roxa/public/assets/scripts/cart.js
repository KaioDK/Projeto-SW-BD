// Inicializa ícones e informações estáticas da página
lucide.createIcons();

// Insert current year (safe guard if element not present). Do NOT redeclare `yearEl` if defined elsewhere.
let _yearEl = (typeof yearEl !== 'undefined') ? yearEl : document.getElementById('year');
if (_yearEl) _yearEl.textContent = new Date().getFullYear();

const format = (v) => "R$ " + Number(v).toLocaleString("pt-BR", { minimumFractionDigits: 2, maximumFractionDigits: 2 });

let selectedAddressId = null;

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

async function removeFromCart(id, size) {
  const fd = new FormData(); fd.append('id_produto', id); fd.append('tamanho', size || '');
  try {
    const res = await fetch('api/remove_from_cart.php', { method: 'POST', body: fd });
    if (!res.ok) return false;
    const data = await res.json();
    return data && data.success;
  } catch (e) { console.error(e); return false; }
}

// Load saved addresses
async function loadAddresses() {
  console.log('loadAddresses: iniciando carregamento');
  const container = document.getElementById('saved-addresses');
  if (!container) {
    console.error('loadAddresses: elemento saved-addresses não encontrado');
    return;
  }
  container.innerHTML = '<p class="text-white/60 text-center py-4">Carregando endereços...</p>';
  
  try {
    console.log('loadAddresses: fazendo fetch para api/get_address.php');
    const res = await fetch('api/get_address.php');
    console.log('loadAddresses: response status:', res.status, res.ok);
    const data = await res.json();
    console.log('loadAddresses: dados recebidos:', data);
    
    if (res.ok && data.success) {
      const addresses = data.addresses || [];
      
      if (addresses.length === 0) {
        container.innerHTML = '<p class="text-white/60 text-center py-4">Nenhum endereço cadastrado. Adicione um novo endereço.</p>';
        return;
      }

      // Filter out empty addresses
      const validAddresses = addresses.filter(addr => 
        (addr.rua && addr.rua.trim()) || 
        (addr.numero) || 
        (addr.cidade && addr.cidade.trim())
      );

      if (validAddresses.length === 0) {
        container.innerHTML = '<p class="text-white/60 text-center py-4">Nenhum endereço cadastrado. Adicione um novo endereço.</p>';
        return;
      }

      container.innerHTML = validAddresses.map((addr, index) => `
        <label class="flex items-start gap-3 p-4 rounded-lg border border-white/10 cursor-pointer hover:border-roxa/50 transition address-option ${index === 0 ? 'border-roxa' : ''}">
          <input type="radio" name="selected_address" value="${addr.id_endereco}" ${index === 0 ? 'checked' : ''} class="mt-1" />
          <div class="flex-1">
            <div class="font-medium">${addr.rua || ''}, ${addr.numero || ''}</div>
            <div class="text-sm text-white/60">${addr.bairro ? addr.bairro + ' - ' : ''}${addr.cidade || ''} - ${addr.estado || ''}</div>
          </div>
        </label>
      `).join('');

      // Set first address as selected by default
      if (validAddresses.length > 0) {
        selectedAddressId = validAddresses[0].id_endereco;
        await chooseAddress(selectedAddressId);
      }

      // Attach radio change listeners
      document.querySelectorAll('input[name="selected_address"]').forEach(radio => {
        radio.addEventListener('change', async (e) => {
          selectedAddressId = e.target.value;
          await chooseAddress(selectedAddressId);
          
          // Update border styling
          document.querySelectorAll('.address-option').forEach(opt => opt.classList.remove('border-roxa'));
          e.target.closest('.address-option').classList.add('border-roxa');
        });
      });
    } else {
      console.error('loadAddresses: resposta não OK ou sem success', data);
      container.innerHTML = '<p class="text-red-400 text-center py-4">Erro ao carregar endereços. Verifique o console.</p>';
    }
  } catch (e) {
    console.error('loadAddresses: exceção capturada:', e);
    container.innerHTML = '<p class="text-red-400 text-center py-4">Erro de conexão. Verifique o console.</p>';
  }
}

// Initialize address form handlers (called when checkout section is shown)
function initAddressHandlers() {
  console.log('initAddressHandlers: configurando listeners');
  
  const addBtn = document.getElementById('add-new-address-btn');
  const cancelBtn = document.getElementById('cancel-new-address');
  const formContainer = document.getElementById('new-address-form-container');
  const addressForm = document.getElementById('new-address-form');
  
  if (!addBtn || !cancelBtn || !formContainer || !addressForm) {
    console.error('initAddressHandlers: elementos não encontrados', {addBtn, cancelBtn, formContainer, addressForm});
    return;
  }
  
  // Remove old listeners by cloning elements
  const newAddBtn = addBtn.cloneNode(true);
  addBtn.parentNode.replaceChild(newAddBtn, addBtn);
  
  const newCancelBtn = cancelBtn.cloneNode(true);
  cancelBtn.parentNode.replaceChild(newCancelBtn, cancelBtn);
  
  const newForm = addressForm.cloneNode(true);
  addressForm.parentNode.replaceChild(newForm, addressForm);
  
  // Show/hide new address form
  newAddBtn.addEventListener('click', () => {
    console.log('Botão Novo Endereço clicado');
    document.getElementById('new-address-form-container').classList.remove('hidden');
  });

  newCancelBtn.addEventListener('click', () => {
    console.log('Botão Cancelar clicado');
    document.getElementById('new-address-form-container').classList.add('hidden');
    document.getElementById('new-address-form').reset();
  });

  // Add new address
  newForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    console.log('Form novo endereço submetido');
    
    const form = e.target;
    if (!(form instanceof HTMLFormElement)) {
      console.error('Submit event target is not a form', form);
      return;
    }
    
    const formData = new FormData(form);
    const submitBtn = form.querySelector('button[type="submit"]');
    
    submitBtn.disabled = true;
    submitBtn.textContent = 'Salvando...';

    try {
      const res = await fetch('api/add_address.php', { method: 'POST', body: formData });
      const data = await res.json();
      console.log('Resposta add_address:', data);

      if (res.ok && data.success) {
        if (window.srShowToast) window.srShowToast('Endereço adicionado', 'success');
        document.getElementById('new-address-form-container').classList.add('hidden');
        form.reset();
        await loadAddresses(); // Reload addresses
      } else {
        alert(data.error || 'Erro ao adicionar endereço');
      }
    } catch (err) {
      console.error('Error adding address:', err);
      alert('Erro de conexão');
    } finally {
      submitBtn.disabled = false;
      submitBtn.textContent = 'Salvar';
    }
  });
}

// Choose address (mark as selected in session)
async function chooseAddress(addressId) {
  try {
    const fd = new FormData();
    fd.append('address_id', addressId);
    await fetch('api/choose_address.php', { method: 'POST', body: fd });
  } catch (e) {
    console.error('Error choosing address:', e);
  }
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
  
  // switch views
  gsap.to('#cart-section', { duration: 0.35, opacity: 0, pointerEvents: 'none', onComplete: () => {
    document.getElementById('cart-section').classList.add('hidden');
    document.getElementById('checkout-section').classList.remove('hidden');
    gsap.fromTo('#checkout-section', { opacity: 0, y: 20 }, { opacity: 1, y: 0 });
    
    // Initialize address handlers and load addresses after checkout section is visible
    initAddressHandlers();
    loadAddresses();
  }});
  
  // update progress visuals
  document.querySelector('#step-cart div')?.classList?.add('text-white/50');
  document.getElementById('step-cart').querySelector('div')?.classList?.remove('bg-roxa');
  document.getElementById('step-address').querySelector('div').classList.remove('bg-white/6');
  document.getElementById('step-address').querySelector('div').classList.add('bg-roxa');
});

// Confirm order: send checkout data to server with selected address and payment
document.getElementById('confirm-order').addEventListener('click', async () => {
  const selectedAddress = document.querySelector('input[name="selected_address"]:checked');
  const selectedPayment = document.querySelector('input[name="payment_method"]:checked');
  
  if (!selectedAddress) {
    alert('Por favor, selecione um endereço de entrega');
    return;
  }
  
  if (!selectedPayment) {
    alert('Por favor, selecione um método de pagamento');
    return;
  }

  const btn = document.getElementById('confirm-order');
  btn.disabled = true;
  btn.textContent = 'Processando...';

  try {
    const fd = new FormData();
    fd.append('address_id', selectedAddress.value);
    fd.append('payment_method', selectedPayment.value);

    const res = await fetch('api/checkout.php', { method: 'POST', body: fd });
    const data = await res.json();
    
    console.log('Checkout response:', data); // Debug log
    
    if (res.ok && data && data.success) {
      // Register payment is now done by checkout.php, no need for separate call
      
      // show modal
      const modal = document.getElementById('modal'); 
      modal.classList.remove('hidden'); 
      modal.classList.add('flex');
      gsap.fromTo('#modal > div', { scale: 0.96, opacity: 0 }, { scale: 1, opacity: 1, duration: 0.35 });
      
      // update progress to payment step
      document.getElementById('step-address').querySelector('div').classList.remove('bg-roxa');
      document.getElementById('step-address').querySelector('div').classList.add('bg-white/6');
      document.getElementById('step-pay').querySelector('div').classList.remove('bg-white/6');
      document.getElementById('step-pay').querySelector('div').classList.add('bg-roxa');
    } else {
      console.error('Checkout error:', data);
      const errorMsg = data?.error || 'Erro desconhecido';
      if (window.srShowToast) {
        window.srShowToast(errorMsg, 'error');
      } else {
        alert('Erro ao finalizar pedido: ' + errorMsg);
      }
    }
  } catch (e) {
    console.error('Checkout exception:', e);
    if (window.srShowToast) {
      window.srShowToast('Erro de conexão: ' + e.message, 'error');
    } else {
      alert('Erro de conexão: ' + e.message);
    }
  } finally {
    btn.disabled = false;
    btn.textContent = 'Confirmar Pedido';
  }
});

document.getElementById('close-modal').addEventListener('click', () => {
  const modal = document.getElementById('modal');
  gsap.to('#modal > div', { scale: 0.96, opacity: 0, duration: 0.2, onComplete: () => { 
    modal.classList.add('hidden'); 
    modal.classList.remove('flex');
    // Redirect to home or orders page
    window.location.href = 'index.php';
  }});
});

// initialize
loadCart();

// small entrance animation
window.addEventListener('load', () => { gsap.from('main h1, main h2', { y: 8, opacity: 0, stagger: 0.06, duration: 0.6 }); });
