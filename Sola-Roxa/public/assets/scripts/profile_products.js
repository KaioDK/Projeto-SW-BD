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
    document.querySelectorAll('.edit-btn').forEach(btn => {
      btn.addEventListener('click', async (e) => {
        e.stopPropagation();
        const id = btn.getAttribute('data-id');
        const title = prompt('Novo título (deixe em branco para manter):');
        const price = prompt('Novo preço (ex: 199.90) (deixe em branco para manter):');
        const size = prompt('Novo tamanho (deixe em branco para manter):');
        if (!title && !price && !size) return;
        const fd = new FormData();
        fd.append('id', id);
        if (title) fd.append('nome', title);
        if (price) fd.append('valor', price);
        if (size) fd.append('tamanho', size);
        try {
          const r = await fetch('api/update_product.php', { method: 'POST', body: fd });
          const text = await r.text();
          let j;
          try {
            j = JSON.parse(text);
          } catch {
            console.error('Resposta não é JSON:', text);
            alert('Erro: servidor respondeu com formato inválido');
            return;
          }
          if (j && j.success) {
            alert('Produto atualizado.');
            loadSellerProducts(sellerId);
          } else {
            alert(j.error || 'Erro ao atualizar');
          }
        } catch (err) {
          alert('Erro de conexão: ' + err.message);
        }
      });
    });

    document.querySelectorAll('.delete-btn').forEach(btn => {
      btn.addEventListener('click', async (e) => {
        e.stopPropagation();
        const id = btn.getAttribute('data-id');
        if (!confirm('Tem certeza que deseja excluir este produto?')) return;
        const fd = new FormData();
        fd.append('id', id);
        try {
          const r = await fetch('api/delete_product.php', { method: 'POST', body: fd });
          const text = await r.text();
          let j;
          try {
            j = JSON.parse(text);
          } catch {
            console.error('Resposta não é JSON:', text);
            alert('Erro: servidor respondeu com formato inválido');
            return;
          }
          if (j && j.success) {
            alert('Produto excluído.');
            loadSellerProducts(sellerId);
          } else {
            alert(j.error || 'Erro ao deletar');
          }
        } catch (err) {
          alert('Erro de conexão: ' + err.message);
        }
      });
    });

  } catch (err) {
    container.innerHTML = '<div class="col-span-full text-center text-red-400 py-8">Erro ao carregar produtos.</div>';
    console.error('Failed loadSellerProducts', err);
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

