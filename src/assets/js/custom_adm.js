// Sidebar Toggle / bars
let sidebar = document.querySelector(".sidebar");
let bars = document.querySelector(".bars");

bars.addEventListener("click", () => {
    sidebar.classList.contains("active") ? sidebar.classList.remove("active") : sidebar.classList.add("active");
});

window.matchMedia("(max-width: 768px)").matches ? sidebar.classList.remove("active") : sidebar.classList.add("active");



// Função para listar registros do arquivo JSON simulado
function listarRegistros() {
    // Realize uma solicitação AJAX para buscar os registros do arquivo JSON simulado
    fetch('./dados.json') // Substitua pelo caminho correto para o seu arquivo JSON
      .then((response) => response.json())
      .then((dados) => {
        // Limpe a tabela antes de exibir os resultados
        const tabela = document.querySelector('.list-body');
        tabela.innerHTML = '';
  
        // Itere sobre os dados do arquivo JSON e adicione-os à tabela
        dados.forEach((registro) => {
          const novaLinha = document.createElement('tr');
          novaLinha.innerHTML = `
            <td class="list-body-content">${registro.id}</td>
            <td class="list-body-content">${registro.nome}</td>
            <td class="list-body-content">${registro.email}</td>
            <td class="list-body-content">${registro.tipoUser}</td>
            <td class="list-body-content">${registro.situacaoUser}</td>
          `;
          tabela.appendChild(novaLinha);
        });
      })
      .catch((error) => {
        console.error('Erro ao buscar registros do arquivo JSON:', error);
      });
  }
  
  // Adicionar eventos de clique para o botão de pesquisa
  document.querySelector('.btn-info').addEventListener('click', listarRegistros);
  


