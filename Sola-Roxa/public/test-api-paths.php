<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Teste de APIs</title>
  <style>
    body { font-family: monospace; padding: 20px; background: #111; color: #0f0; }
    .success { color: #0f0; }
    .error { color: #f00; }
    .testing { color: #ff0; }
    pre { background: #222; padding: 10px; margin: 5px 0; }
  </style>
</head>
<body>
  <h1>Teste de Caminhos das APIs</h1>
  <div id="results"></div>

  <script>
    const apis = [
      { name: 'Auth - Login Usuario', path: 'api/auth/login_usuario.php' },
      { name: 'Auth - Logout', path: 'api/auth/logout.php' },
      { name: 'Products - Get Products', path: 'api/products/get_products.php' },
      { name: 'Products - Get Product', path: 'api/products/get_product.php?id=1' },
      { name: 'Cart - Get Cart', path: 'api/cart/get_cart.php' },
      { name: 'Favorites - Get Favorites', path: 'api/favorites/get_favorites.php' },
      { name: 'Address - Get Address', path: 'api/address/get_address.php' },
      { name: 'User - Update Profile', path: 'api/user/update_profile.php' }
    ];

    const results = document.getElementById('results');

    async function testAPI(api) {
      const div = document.createElement('div');
      div.innerHTML = `<span class="testing">⏳ Testando: ${api.name}</span>`;
      results.appendChild(div);

      try {
        const response = await fetch(api.path);
        const text = await response.text();
        
        if (response.ok || response.status === 401 || response.status === 400) {
          div.innerHTML = `<span class="success">✓ ${api.name}</span> - Status: ${response.status}`;
          const pre = document.createElement('pre');
          pre.textContent = text.substring(0, 200);
          div.appendChild(pre);
        } else if (response.status === 404) {
          div.innerHTML = `<span class="error">✗ ${api.name}</span> - ARQUIVO NÃO ENCONTRADO (404)`;
        } else {
          div.innerHTML = `<span class="error">✗ ${api.name}</span> - Status: ${response.status}`;
        }
      } catch (error) {
        div.innerHTML = `<span class="error">✗ ${api.name}</span> - Erro: ${error.message}`;
      }
    }

    async function runTests() {
      for (const api of apis) {
        await testAPI(api);
        await new Promise(resolve => setTimeout(resolve, 100));
      }
    }

    runTests();
  </script>
</body>
</html>
