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
