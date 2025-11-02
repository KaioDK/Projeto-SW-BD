const loginForm = document.getElementById("login-form");
const registerForm = document.getElementById("register-form");
const toRegister = document.getElementById("to-register");
const toLogin = document.getElementById("to-login");
const title = document.getElementById("form-title");

function showRegister() {
  // animate out login
  gsap.to(loginForm, {
    duration: 0.4,
    opacity: 0,
    y: -20,
    pointerEvents: "none",
  });
  // animate in register
  gsap.to(registerForm, {
    duration: 0.5,
    opacity: 1,
    y: 0,
    pointerEvents: "auto",
    delay: 0.15,
  });
  title.textContent = "Crie sua conta na Sola Roxa";
}

function showLogin() {
  gsap.to(registerForm, {
    duration: 0.35,
    opacity: 0,
    y: 20,
    pointerEvents: "none",
  });
  gsap.to(loginForm, {
    duration: 0.5,
    opacity: 1,
    y: 0,
    pointerEvents: "auto",
    delay: 0.12,
  });
  title.textContent = "Bem-vindo de volta à Sola Roxa";
}

toRegister.addEventListener("click", (e) => {
  e.preventDefault();
  showRegister();
});
toLogin.addEventListener("click", (e) => {
  e.preventDefault();
  showLogin();
});

// small entrance animation
window.addEventListener("load", () => {
  gsap.from(".glass", { duration: 0.8, opacity: 0, y: 20 });
  gsap.from("#login-form > *", {
    stagger: 0.06,
    duration: 0.6,
    opacity: 0,
    y: 10,
  });
});

// Simple form handlers (no real auth) — prevent submit reload
[loginForm, registerForm].forEach((f) =>
  f.addEventListener("submit", (e) => {
    e.preventDefault();
    const btn = f.querySelector('button[type="submit"]');
    gsap.to(btn, { scale: 0.98, duration: 0.08, yoyo: true, repeat: 1 });
    alert("Usuario logado.");
  })
);

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
