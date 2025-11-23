// Helpers simples de DOM
const qs = (s) => document.querySelector(s);
const qsa = (s) => document.querySelectorAll(s);

// Insere o ano atual (rodapé)
const yearEl = qs("#year");
if (yearEl) {
  yearEl.textContent = new Date().getFullYear();
}

// Animações GSAP do hero da página inicial
window.addEventListener("load", () => {
  if (typeof gsap !== "undefined") {
    const tl = gsap.timeline({
      defaults: { duration: 1, ease: "power3.out" },
    });
    tl.to("#hero-title", {
      y: 0,
      opacity: 1,
      delay: 0.1,
      duration: 1.1,
      transform: "none",
    });
    tl.to("#hero-sub", { y: 0, opacity: 1 }, "-=0.8");
    tl.to("#hero-ctas", { y: 0, opacity: 1 }, "-=0.6");
  }
});

// Controles do carrossel de itens em destaque (scroll suave)
const featured = qs("#featured");
const featLeft = qs("#feat-left");
const featRight = qs("#feat-right");

if (featLeft && featured) {
  featLeft.addEventListener("click", () =>
    featured.scrollBy({ left: -320, behavior: "smooth" })
  );
}

if (featRight && featured) {
  featRight.addEventListener("click", () =>
    featured.scrollBy({ left: 320, behavior: "smooth" })
  );
}

// Exibe/oculta botões esquerdo/direito do carrossel conforme overflow
function updateFeatButtons() {
  if (!featured || !featLeft || !featRight) return;
  const maxScroll = featured.scrollWidth - featured.clientWidth;
  if (featured.scrollLeft > 20) featLeft.style.display = "block";
  else featLeft.style.display = "none";
  if (featured.scrollLeft < maxScroll - 20) featRight.style.display = "block";
  else featRight.style.display = "none";
}
if (featured) {
  featured.addEventListener("scroll", updateFeatButtons);
  updateFeatButtons();
}
window.addEventListener("resize", updateFeatButtons);

// Header behavior:
// - On index (homepage) header starts transparent and becomes translucent on scroll
// - On other pages header starts with the translucent background by default
const header = qs("#site-header");
if (header) {
  const classes = ["bg-black/70", "backdrop-blur-md", "glass-blur", "rounded"];
  const path = window.location.pathname.toLowerCase();
  const isIndex = path.endsWith('/index.php') || path === '/' || path.endsWith('/sola-roxa/') || path.endsWith('/sola-roxa');

  function applyHeaderWithBg() {
    header.classList.add(...classes);
    const headerChild = header.firstElementChild;
    if (headerChild) headerChild.classList.add(...classes);
  }

  function removeHeaderBg() {
    header.classList.remove(...classes);
    const headerChild = header.firstElementChild;
    if (headerChild) headerChild.classList.remove(...classes);
  }

  if (isIndex) {
    // homepage: toggle on scroll
    function updateHeaderOnScroll() {
      const y = window.scrollY;
      if (y > 40) applyHeaderWithBg();
      else removeHeaderBg();
    }
    window.addEventListener("scroll", updateHeaderOnScroll);
    window.addEventListener("load", updateHeaderOnScroll);
    document.addEventListener('DOMContentLoaded', updateHeaderOnScroll);
  } else {
    // other pages: ensure header has background immediately
    applyHeaderWithBg();
  }
}

// Efeito de cursor aumentado ao passar sobre elementos interativos
const cursor = qs(".cursor");
if (cursor) {
  ["a", "button", "input", "label"].forEach((sel) => {
    qsa(sel).forEach((el) => {
      el.addEventListener("mouseenter", () => {
        cursor.style.transform = "translate(-50%,-50%) scale(2)";
        cursor.style.backgroundColor = "rgba(139,92,246,0.95)";
      });
      el.addEventListener("mouseleave", () => {
        cursor.style.transform = "translate(-50%,-50%) scale(1)";
        cursor.style.backgroundColor = "rgba(255,255,255,0.6)";
      });
    });
  });
}

// Observação sobre lazy-loading: imagens usam `loading="lazy"` no HTML.

// small accessibility: allow keyboard focus for carousel
if (featured) {
  featured.setAttribute("tabindex", "0");
}

// Toast system (global)
(function () {
  function createContainer() {
    let c = document.getElementById('sr-toasts');
    if (c) return c;
    c = document.createElement('div');
    c.id = 'sr-toasts';
    c.setAttribute('aria-live', 'polite');
    c.setAttribute('aria-atomic', 'true');
    c.style.position = 'fixed';
    c.style.right = '1rem';
    c.style.bottom = '1rem';
    c.style.zIndex = '9999';
    c.style.display = 'flex';
    c.style.flexDirection = 'column';
    c.style.gap = '0.5rem';
    document.body.appendChild(c);
    return c;
  }

  function makeToastEl(message, type) {
    const el = document.createElement('div');
    el.className = 'sr-toast ' + (type || 'info');
    el.style.background = type === 'error' ? 'rgba(220,38,38,0.95)' : (type === 'success' ? 'rgba(16,185,129,0.95)' : 'rgba(55,65,81,0.95)');
    el.style.color = 'white';
    el.style.padding = '0.6rem 0.9rem';
    el.style.borderRadius = '0.5rem';
    el.style.boxShadow = '0 6px 18px rgba(0,0,0,0.4)';
    el.style.fontSize = '0.95rem';
    el.textContent = message;
    return el;
  }

  function showToast(message, type = 'info', duration = 3500) {
    const c = createContainer();
    const el = makeToastEl(message, type);
    c.appendChild(el);
    setTimeout(() => {
      el.style.transition = 'opacity 240ms, transform 240ms';
      el.style.opacity = '0';
      el.style.transform = 'translateX(12px)';
      setTimeout(() => el.remove(), 260);
    }, duration);
    return el;
  }

  // expose globally
  window.srShowToast = showToast;
})();

// Atualiza badge do carrinho no header
async function srUpdateCartCount() {
  const el = qs('#cart-count');
  if (!el) return;
  try {
    const res = await fetch('api/cart/get_cart.php');
    const data = await res.json();
    const count = data.items_count || 0;
    el.textContent = count;
    el.style.display = count > 0 ? 'flex' : 'none';
  } catch (e) {
    el.textContent = '0';
    el.style.display = 'none';
  }
}
window.srUpdateCartCount = srUpdateCartCount;
// Atualiza ao carregar página
window.addEventListener('DOMContentLoaded', srUpdateCartCount);
