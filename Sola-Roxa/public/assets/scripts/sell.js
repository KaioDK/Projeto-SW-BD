lucide.createIcons();

// Controle dos passos do onboarding (wizard)
// - Cada painel tem `data-panel` correspondendo ao número do passo
// - `showStep(n)` exibe o painel `n`, atualiza a barra de progresso e o indicador
// - Variáveis: `current` (passo atual), `total` (número total de painéis)
const steps = Array.from(document.querySelectorAll(".step"));
const panels = Array.from(document.querySelectorAll(".panel"));
let current = 1;
const total = panels.length;
function showStep(n) {
  current = n;
  document.getElementById("current-step").textContent = n;
  panels.forEach((p) =>
    p.dataset.panel == n
      ? p.classList.remove("hidden")
      : p.classList.add("hidden")
  );
  steps.forEach((s) => {
    s.classList.toggle("step-active", Number(s.dataset.step) === n);
  });
  document.getElementById("progress-bar").style.width = (n / total) * 100 + "%";
}
steps.forEach((s) =>
  s.addEventListener("click", () => showStep(Number(s.dataset.step)))
);
document
  .getElementById("next-btn")
  .addEventListener("click", () => showStep(Math.min(total, current + 1)));
document
  .getElementById("prev-btn")
  .addEventListener("click", () => showStep(Math.max(1, current - 1)));

// Contador de caracteres da descrição
const desc = document.getElementById("description");
const descCount = document.getElementById("desc-count");
if (desc) {
  desc.addEventListener(
    "input",
    () => (descCount.textContent = desc.value.length)
  );
}

// Campo de tags (chips)
const tagsInput = document.getElementById("tags-input");
const tagsArea = document.getElementById("tags");
let tags = [];
tagsInput.addEventListener("keydown", (e) => {
  if (e.key === "Enter" && tagsInput.value.trim()) {
    e.preventDefault();
    addTag(tagsInput.value.trim());
    tagsInput.value = "";
  }
  if (e.key === "Backspace" && !tagsInput.value) {
    tags.pop();
    renderTags();
  }
});
function addTag(t) {
  if (tags.length >= 12) return;
  tags.push(t);
  renderTags();
}
function removeTag(i) {
  tags.splice(i, 1);
  renderTags();
}
function renderTags() {
  tagsArea.innerHTML = "";
  tags.forEach((t, i) => {
    const chip = document.createElement("div");
    chip.className =
      "px-3 py-1 bg-gray-100 rounded-full text-sm flex items-center gap-2";
    chip.innerHTML = `<span>${t}</span><button data-i="${i}" class="text-xs">×</button>`;
    tagsArea.appendChild(chip);
    chip.querySelector("button").addEventListener("click", () => removeTag(i));
  });
}

// Upload de imagens (drag & drop + miniaturas)
const drop = document.getElementById("drop-zone");
const fileInput = document.getElementById("file-input");
const thumbs = document.getElementById("thumbs");
let files = [];
drop.addEventListener("click", () => fileInput.click());
fileInput.addEventListener("change", (e) => handleFiles(e.target.files));
drop.addEventListener("dragover", (e) => {
  e.preventDefault();
  drop.classList.add("bg-white/60");
});
drop.addEventListener("dragleave", () => drop.classList.remove("bg-white/60"));
drop.addEventListener("drop", (e) => {
  e.preventDefault();
  drop.classList.remove("bg-white/60");
  handleFiles(e.dataTransfer.files);
});

function handleFiles(list) {
  const arr = Array.from(list).slice(0, 6 - files.length);
  arr.forEach((file) => {
    if (!file.type.startsWith("image/")) return;
    const reader = new FileReader();
    reader.onload = (ev) => {
      files.push({ name: file.name, src: ev.target.result });
      renderThumbs();
    };
    reader.readAsDataURL(file);
  });
}
function renderThumbs() {
  thumbs.innerHTML = "";
  files.forEach((f, i) => {
    const el = document.createElement("div");
    el.className = "relative group";
    el.innerHTML = `<img src="${f.src}" class="w-full h-32 object-cover rounded-md"><button class='absolute top-2 right-2 bg-white/80 rounded-full p-1 text-sm'>×</button>`;
    thumbs.appendChild(el);
    el.querySelector("button").addEventListener("click", () => {
      files.splice(i, 1);
      renderThumbs();
    });
  });
}

// Botão de pré-visualização: monta um resumo com título, marca, categoria,
// descrição e tags. Avança para o passo de revisão (4).
document.getElementById("preview-btn").addEventListener("click", () => {
  const area = document.getElementById("review-area");
  area.innerHTML = `
          <h4 class="font-semibold">${
            document.getElementById("title").value || "—"
          }</h4>
          <div class='text-sm text-gray-600'>${
            document.getElementById("brand").value || ""
          } • ${document.getElementById("category").value || ""}</div>
          <p class='mt-3 text-gray-700'>${
            document.getElementById("description").value ||
            "<i>Sem descrição</i>"
          }</p>
          <div class='mt-3 flex gap-2'>${tags
            .map(
              (t) =>
                `<span class='px-2 py-1 bg-gray-100 rounded-full text-sm'>${t}</span>`
            )
            .join("")}</div>
        `;
  showStep(4);
});

// Publicar: valida campos básicos, monta um FormData e chama `api/create_product.php`.
// - Envia: nome (title), descricao (description), valor (price), estoque (stock), estado, imagem_url (opcional), tamanho (opcional)
// - Se o usuário preencher dados de seller-onboarding, esses campos são enviados
//   para que o backend possa criar/reutilizar um registro de vendedor.
document.getElementById("publish-btn").addEventListener("click", () => {
  // Basic validation
  const title = document.getElementById("title").value.trim();
  const price = document.getElementById("price").value;
  
  console.log('DEBUG: title =', title);
  console.log('DEBUG: price =', price);
  
  if (!title || !price) {
    if (window.srShowToast) window.srShowToast('Por favor preencha título e preço antes de publicar.', 'error');
    else alert('Por favor preencha título e preço antes de publicar.');
    showStep(2);
    return;
  }
  
  // create product via API
  const formData = new FormData();
  formData.append('nome', title);
  formData.append('descricao', document.getElementById('description').value.trim());
  formData.append('valor', price.trim());
  
  // Log FormData
  console.log('FormData entries:');
  for (let [key, value] of formData.entries()) {
    console.log(`  ${key}: ${value}`);
  }
  
  // include size/tamanho
  const sizeVal = document.getElementById('size') ? document.getElementById('size').value.trim() : '';
  if (sizeVal) formData.append('tamanho', sizeVal);
  // default stock to 1 (seller can update later)
  formData.append('estoque', 1);
  formData.append('estado', document.getElementById('condition').value || 'Novo');
  if (fileInput.files && fileInput.files[0]) {
    formData.append('image', fileInput.files[0]);
  }
  // optionally include seller onboarding data
  const sellerName = document.getElementById('seller-name').value.trim();
  const sellerDoc = document.getElementById('seller-doc').value.trim();
  if (sellerName) formData.append('seller_name', sellerName);
  if (sellerDoc) formData.append('seller_doc', sellerDoc);

  fetch('api/create_product.php', { method: 'POST', body: formData })
    .then(async (r) => {
      const text = await r.text();
      console.log('Response status:', r.status);
      console.log('Response text:', text);
      try {
        const data = text ? JSON.parse(text) : null;
        if (data && data.success) {
          document.getElementById('success-modal').classList.remove('hidden');
          document.getElementById('success-modal').classList.add('flex');
        } else {
          // Se o servidor retornou JSON com `error`, exibe a mensagem;
          // caso contrário, mostra o texto bruto recebido para ajudar a depurar.
          const msg = (data && data.error) ? (data.error + (data.details ? '\n' + data.details : '')) : ('Erro ao cadastrar produto. Resposta do servidor:\n' + text);
          if (window.srShowToast) window.srShowToast(msg, 'error');
          else alert(msg);
        }
      } catch (e) {
        // Resposta não-JSON: mostra texto bruto (útil em dev quando a API
        // retorna HTML/erro inesperado em vez de JSON). Em produção, a API
        // deve sempre retornar JSON previsível.
        if (window.srShowToast) window.srShowToast('Erro ao cadastrar produto. Resposta do servidor não é JSON.', 'error');
        else alert('Erro ao cadastrar produto. Resposta do servidor não é JSON:\n' + text);
      }
    })
    .catch((err) => {
      if (window.srShowToast) window.srShowToast('Erro ao conectar: ' + err.message, 'error');
      else alert('Erro ao conectar: ' + err.message);
    });
});
document.getElementById("close-success").addEventListener("click", () => {
  document.getElementById("success-modal").classList.add("hidden");
  document.getElementById("success-modal").classList.remove("flex");
});

// Initial state
showStep(1);
