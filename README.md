
## Planejamento do Desenvolvimento do Frontend

### Linguagem Base
O frontend do projeto será desenvolvido utilizando **HTML**, **CSS** e **JavaScript**, garantindo suporte nativo, alta compatibilidade e facilidade na manutenção e evolução das telas.

### Bibliotecas e Frameworks
Será utilizado **TailwindCSS** para estilização do layout e responsividade. Caso o projeto exija futuramente, poderá ser considerado o uso de alguma biblioteca adicional.

### Integração com Backend
A comunicação com o backend será feita por **API REST**.
O consumo dos dados será feito utilizando **Fetch API**, trabalhando com envio e retorno de dados no formato **JSON**.

**Fluxo resumido:**
Frontend → Fetch → Endpoint API → Backend → JSON → Renderização no HTML

### Controle de Versão
O versionamento do código será feito utilizando **GitHub**.
Repositório oficial do projeto:

https://github.com/KaioDK/Projeto-SW-BD

### Organização do Código
```
/frontend      -> arquivos do cliente (HTML, CSS, JS)
/backend       -> API e regras de negócio
/assets        -> imagens / logos / fontes
index.html     -> página inicial do frontend
```
Cada tela terá seu próprio arquivo .js responsável por manipulação, requisições e renderização local.
Componentes e funções serão separados por responsabilidade para facilitar manutenção.
