const loginForm = document.getElementById("login-form");
const registerForm = document.getElementById("register-form");
const toRegister = document.getElementById("to-register");
const toLogin = document.getElementById("to-login");
const title = document.getElementById("form-title");

function showRegister() {
  loginForm.style.display = 'none';
  registerForm.style.display = 'block';
  title.textContent = "Crie sua conta na Sola Roxa";
}

function showLogin() {
  registerForm.style.display = 'none';
  loginForm.style.display = 'block';
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

// Animação de entrada suave dos elementos do formulário
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
      if (window.srShowToast) window.srShowToast('Login realizado com sucesso!', 'success');
      else alert('Login realizado com sucesso!');
      window.location.href = 'index.php';
    } else {
      if (window.srShowToast) window.srShowToast(data.error || 'Erro no login', 'error');
      else alert(data.error || 'Erro no login');
    }
  } catch (error) {
    if (window.srShowToast) window.srShowToast('Erro ao conectar: ' + error.message, 'error');
    else alert('Erro ao conectar: ' + error.message);
  } finally {
    btn.disabled = false;
    btn.textContent = "Entrar";
  }
});

registerForm.addEventListener("submit", async (e) => {
  e.preventDefault();
  const name = document.getElementById('register-name').value;
  const email = document.getElementById('register-email').value;
  const password = document.getElementById('register-password').value;
  const confirmPassword = document.getElementById('register-password-confirm').value;
  const cpf = document.getElementById('register-cpf') ? document.getElementById('register-cpf').value : '';
  const btn = registerForm.querySelector('button[type="submit"]');
  
  if (password !== confirmPassword) {
    if (window.srShowToast) window.srShowToast('As senhas não coincidem!', 'error');
    else alert('As senhas não coincidem!');
    return;
  }
  
  btn.disabled = true;
  btn.textContent = "Cadastrando...";
  
  try {
    const formData = new FormData();
    formData.append('name', name);
    formData.append('email', email);
    formData.append('password', password);
    if (cpf) formData.append('cpf', cpf);
    
    const response = await fetch('api/register_usuario.php', {
      method: 'POST',
      body: formData
    });
    
    let data;
    try {
      data = await response.json();
    } catch (e) {
      // Em fallback: se o servidor não retornou JSON, tenta ler o texto bruto
      const txt = await response.text();
      data = { error: txt || 'Invalid server response' };
    }

    if (response.ok && data.success) {
      if (window.srShowToast) window.srShowToast('Cadastro realizado! Faça login agora.', 'success');
      else alert('Cadastro realizado! Faça login agora.');
      showLogin();
    } else {
      if (window.srShowToast) window.srShowToast(data.error || 'Erro no cadastro', 'error');
      else alert(data.error || 'Erro no cadastro');
    }
  } catch (error) {
    if (window.srShowToast) window.srShowToast('Erro ao conectar: ' + error.message, 'error');
    else alert('Erro ao conectar: ' + error.message);
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
