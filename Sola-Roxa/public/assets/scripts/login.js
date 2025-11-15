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

// Real auth handlers
loginForm.addEventListener("submit", async (e) => {
  e.preventDefault();
  const email = loginForm.querySelector('input[type="email"]').value;
  const password = loginForm.querySelector('input[type="password"]').value;
  const btn = loginForm.querySelector('button[type="submit"]');
  
  btn.disabled = true;
  btn.textContent = "Entrando...";
  
  try {
    const formData = new FormData();
    formData.append('email', email);
    formData.append('password', password);
    
    const response = await fetch('api/login_usuario.php', {
      method: 'POST',
      body: formData
    });
    
    const data = await response.json();
    
    if (response.ok && data.success) {
      gsap.to(btn, { scale: 0.98, duration: 0.08, yoyo: true, repeat: 1 });
      alert("Login realizado com sucesso!");
      window.location.href = 'index.php';
    } else {
      alert(data.error || "Erro no login");
    }
  } catch (error) {
    alert("Erro ao conectar: " + error.message);
  } finally {
    btn.disabled = false;
    btn.textContent = "Entrar";
  }
});

registerForm.addEventListener("submit", async (e) => {
  e.preventDefault();
  const name = registerForm.querySelector('input[type="text"]').value;
  const email = registerForm.querySelector('input[type="email"]').value;
  const password = registerForm.querySelectorAll('input[type="password"]')[0].value;
  const confirmPassword = registerForm.querySelectorAll('input[type="password"]')[1].value;
  const btn = registerForm.querySelector('button[type="submit"]');
  
  if (password !== confirmPassword) {
    alert("As senhas não coincidem!");
    return;
  }
  
  btn.disabled = true;
  btn.textContent = "Cadastrando...";
  
  try {
    const formData = new FormData();
    formData.append('name', name);
    formData.append('email', email);
    formData.append('password', password);
    
    const response = await fetch('api/register_usuario.php', {
      method: 'POST',
      body: formData
    });
    
    let data;
    try {
      data = await response.json();
    } catch (e) {
      // fallback to text if server returned non-json or empty
      const txt = await response.text();
      data = { error: txt || 'Invalid server response' };
    }

    if (response.ok && data.success) {
      alert("Cadastro realizado! Faça login agora.");
      showLogin();
    } else {
      alert(data.error || "Erro no cadastro");
    }
  } catch (error) {
    alert("Erro ao conectar: " + error.message);
  } finally {
    btn.disabled = false;
    btn.textContent = "Cadastrar";
  }
});

// Sticky header transparency on scroll
const header = document.querySelector("#site-header");
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
