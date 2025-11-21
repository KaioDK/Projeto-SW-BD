lucide.createIcons();

// Carrega os produtos do vendedor logado e renderiza em #seller-products-container
async function loadSellerProducts(sellerId) {
  const container = document.getElementById('seller-products-container');
  if (!container) return;
  container.innerHTML = '<div class="col-span-full text-center text-white/60 py-8">Carregando produtos...</div>';
  try {
    const res = await fetch(`api/get_products.php?seller=${sellerId}`);
    const data = await res.json();
    if (!data || !data.products) {
      container.innerHTML = '<div class="col-span-full text-center text-white/60 py-8">Nenhum produto encontrado.</div>';
      return;
    }
    if (data.products.length === 0) {
      container.innerHTML = '<div class="col-span-full text-center text-white/60 py-8">Você ainda não publicou produtos.</div>';
      return;
    }
    container.innerHTML = '';
    data.products.forEach(p => {
      const card = document.createElement('div');
      card.className = 'bg-white/[0.02] rounded-lg overflow-hidden border border-white/10 hover:border-white/20 transition-all duration-300';
      const img = p.imagem_url ? p.imagem_url : 'assets/img/placeholder.png';
      card.innerHTML = `
        <img src="${escapeHtml(img)}" alt="${escapeHtml(p.nome)}" class="w-full h-48 object-cover" />
        <div class="p-4">
          <h4 class="font-semibold text-white">${escapeHtml(p.nome)}</h4>
          <p class="text-sm text-white/60 mt-1">R$ ${formatPrice(p.valor)}</p>
          ${p.tamanho ? `<p class="text-xs text-white/50 mt-1">Tamanho: ${escapeHtml(p.tamanho)}</p>` : ''}
          <div class="mt-4 flex gap-2">
            <button data-id="${p.id_produto}" class="edit-btn flex-1 px-3 py-2 rounded bg-roxa/20 text-roxa text-sm hover:bg-roxa/30 transition">Editar</button>
            <button data-id="${p.id_produto}" class="delete-btn flex-1 px-3 py-2 rounded bg-red-500/20 text-red-400 text-sm hover:bg-red-500/30 transition">Excluir</button>
          </div>
        </div>
      `;
      container.appendChild(card);
    });

    // attach handlers
    // attach handlers for edit and delete buttons
    document.querySelectorAll('.edit-btn').forEach(btn => {
      btn.addEventListener('click', (e) => {
        e.stopPropagation();
        const id = btn.getAttribute('data-id');
        // open edit modal and populate
        const modal = document.getElementById('sr-edit-product-modal');
        if (!modal) return;
        const form = modal.querySelector('form');
        form.reset();
        form.querySelector('input[name="id"]').value = id;
        // try to pull current values from the card
        const card = btn.closest('div');
        if (card) {
          const nome = card.querySelector('h4') ? card.querySelector('h4').textContent.trim() : '';
          // preço: procura parágrafo que contenha 'R$'
          const priceP = Array.from(card.querySelectorAll('p')).find(p => p.textContent && p.textContent.includes('R$')) || null;
          const valor = priceP ? priceP.textContent.replace(/[R$\s]/g, '').replace(',', '.') : '';
          // tamanho: procura parágrafo que contenha 'Tamanho:'
          const tamanhoEl = Array.from(card.querySelectorAll('p')).find(p => p.textContent && p.textContent.includes('Tamanho:')) || null;
          const tamanho = tamanhoEl ? tamanhoEl.textContent.replace('Tamanho:', '').trim() : '';
          if (nome) form.querySelector('input[name="nome"]').value = nome;
          if (valor) form.querySelector('input[name="valor"]').value = valor;
          if (tamanho) form.querySelector('input[name="tamanho"]').value = tamanho;
        }
        modal.classList.remove('hidden');
        const first = form.querySelector('input[name="nome"]');
        if (first) first.focus();
      });
    });

    
    // Delete button handler
    document.querySelectorAll('.delete-btn').forEach(btn => {
      btn.addEventListener('click', (e) => {
        e.stopPropagation();
        const id = btn.getAttribute('data-id');
        const modal = document.getElementById('sr-delete-product-modal');
        if (!modal) return;
        modal.classList.remove('hidden');
        const confirmBtn = document.getElementById('sr-delete-product-confirm');
        confirmBtn.dataset.id = id;
        confirmBtn.focus();
      });
    });

    // Edit modal submit handler
    const editModal = document.getElementById('sr-edit-product-modal');
    if (editModal) {
      const editForm = editModal.querySelector('form');
      editForm.addEventListener('submit', async (ev) => {
        ev.preventDefault();
        const btn = editForm.querySelector('button[type="submit"]');
        btn.disabled = true;
        btn.setAttribute('aria-busy', 'true');
        const fd = new FormData(editForm);
        try {
          const r = await fetch('api/update_product.php', { method: 'POST', body: fd });
          const text = await r.text();
          let j;
          try { j = JSON.parse(text); } catch (err) { console.error('Invalid JSON', text, err); if (window.srShowToast) window.srShowToast('Resposta inválida do servidor', 'error'); return; }
          if (j && j.success) {
            if (window.srShowToast) window.srShowToast('Produto atualizado.', 'success');
            editModal.classList.add('hidden');
            loadSellerProducts(sellerId);
          } else {
            if (window.srShowToast) window.srShowToast(j.error || 'Erro ao atualizar', 'error');
          }
        } catch (err) {
          if (window.srShowToast) window.srShowToast('Erro de conexão: ' + err.message, 'error');
        } finally {
          btn.disabled = false;
          btn.removeAttribute('aria-busy');
        }
      });
    }

    // Delete confirm handler
    const deleteModal = document.getElementById('sr-delete-product-modal');
    if (deleteModal) {
      const confirmBtn = document.getElementById('sr-delete-product-confirm');
      confirmBtn.addEventListener('click', async () => {
        const id = confirmBtn.dataset.id;
        if (!id) return;
        confirmBtn.disabled = true;
        confirmBtn.setAttribute('aria-busy', 'true');
        const fd = new FormData(); fd.append('id', id);
        try {
          const r = await fetch('api/delete_product.php', { method: 'POST', body: fd });
          const text = await r.text();
          let j; try { j = JSON.parse(text); } catch (err) { console.error('Invalid JSON', text, err); if (window.srShowToast) window.srShowToast('Resposta inválida do servidor', 'error'); return; }
          if (j && j.success) {
            if (window.srShowToast) window.srShowToast('Produto excluído.', 'success');
            deleteModal.classList.add('hidden');
            loadSellerProducts(sellerId);
          } else {
            if (window.srShowToast) window.srShowToast(j.error || 'Erro ao deletar', 'error');
          }
        } catch (err) {
          if (window.srShowToast) window.srShowToast('Erro de conexão: ' + err.message, 'error');
        } finally {
          confirmBtn.disabled = false;
          confirmBtn.removeAttribute('aria-busy');
        }
      });
    }

  } catch (err) {
    container.innerHTML = '<div class="col-span-full text-center text-red-400 py-8">Erro ao carregar produtos. <button id="sr-retry-products" class="ml-3 px-3 py-1 bg-roxa rounded text-sm">Tentar novamente</button></div>';
    console.error('Failed loadSellerProducts', err);
    const retry = document.getElementById('sr-retry-products');
    if (retry) {
      retry.addEventListener('click', () => loadSellerProducts(sellerId));
    }
    if (window.srShowToast) window.srShowToast('Erro ao carregar seus produtos', 'error');
  }
}

function formatPrice(v) {
  if (v === null || v === undefined || v === '') return '—';
  return parseFloat(v).toFixed(2).replace('.', ',');
}

function escapeHtml(unsafe) {
  if (!unsafe) return '';
  return String(unsafe)
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&#039;');
}

// Inicializa se houver CURRENT_SELLER_ID no escopo global
window.addEventListener('DOMContentLoaded', () => {
  console.log('DOMContentLoaded: CURRENT_SELLER_ID =', typeof CURRENT_SELLER_ID !== 'undefined' ? CURRENT_SELLER_ID : 'undefined');
  if (typeof CURRENT_SELLER_ID !== 'undefined' && CURRENT_SELLER_ID) {
    console.log('Iniciando loadSellerProducts com ID:', CURRENT_SELLER_ID);
    loadSellerProducts(CURRENT_SELLER_ID);
  } else {
    console.log('CURRENT_SELLER_ID não definido ou falso');
  }
});

