// Simple DOM helpers
const qs = (s) => document.querySelector(s);
const qsa = (s) => document.querySelectorAll(s);

// Insert current year
qs("#year").textContent = new Date().getFullYear();

// GSAP hero animations
window.addEventListener("load", () => {
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
});

// Featured carousel controls
const featured = qs("#featured");
qs("#feat-left").addEventListener("click", () =>
  featured.scrollBy({ left: -320, behavior: "smooth" })
);
qs("#feat-right").addEventListener("click", () =>
  featured.scrollBy({ left: 320, behavior: "smooth" })
);

// show/hide left/right on overflow
function updateFeatButtons() {
  const left = qs("#feat-left");
  const right = qs("#feat-right");
  if (!featured) return;
  const maxScroll = featured.scrollWidth - featured.clientWidth;
  if (featured.scrollLeft > 20) left.style.display = "block";
  else left.style.display = "none";
  if (featured.scrollLeft < maxScroll - 20) right.style.display = "block";
  else right.style.display = "none";
}
featured && featured.addEventListener("scroll", updateFeatButtons);
window.addEventListener("resize", updateFeatButtons);
updateFeatButtons();

// Sticky header transparency on scroll
const header = qs("#site-header");
window.addEventListener("scroll", () => {
  const y = window.scrollY;
  if (y > 40) {
    header.firstElementChild.classList.add(
      "bg-black/70",
      "backdrop-blur-md",
      "glass-blur",
      "rounded"
    );
  } else {
    header.firstElementChild.classList.remove(
      "bg-black/70",
      "backdrop-blur-md",
      "glass-blur",
      "rounded"
    );
  }
});

// enlarge on hover for interactive elements
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

// Lazy-loading note: images use loading="lazy" attributes already.

// small accessibility: allow keyboard focus for carousel
featured && featured.setAttribute("tabindex", "0");
