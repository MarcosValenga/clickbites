<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="images/icon/favicon.ico">
    <!-- Incluir os icones do font-awesome da CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="/clickbites/src/styles/custom_adm.css">
    <title>Adm - Celke</title>
</head>

<body>
    <!-- inicio NavBar -->

    <nav class="navbar">
        <div class="navbar-content">
            
            <div class="bars">
                <i class="fa-solid fa-bars fa-2xl"></i>
            </div>
            <img src="/clickbites/src/assets/logos/fino.png" alt="Erro ao carregar" class="logo">
            <div class="titulo">
                <h1>Área do Administrador</h1>
            </div>
        </div>

        <div class="navbar-content">
            <div class="outlogon">
                <a href="login.html"><i class="fa-solid fa-right-from-bracket fa-2xl"></i></a>
            </div>
        </div>
    </nav>

    <!-- fim NavBar -->

    <!-- Inicio Conteudo -->
    <div class="content">
        <!-- Inicio da Sidebar -->
        <div class="sidebar">
            <a href="index.html" class="sidebar-nav"><i class="icon fa-solid fa-house"></i><span>Dashboard</span></a>

            <a href="listar.html" class="sidebar-nav active"><i class="icon fa-solid fa-users"></i><span>Listar</span></a>

            <a href="formulario.html" class="sidebar-nav"><i class="icon fa-solid fa-file-lines"></i><span>Formulário</span></a>

            <a href="visualizar.html" class="sidebar-nav"><i class="icon fa-solid fa-eye"></i><span>Visualizar</span></a>

            <a href="alert.html" class="sidebar-nav"><i class="icon fa-solid fa-triangle-exclamation"></i><span>Alerta</span></a>

            <a href="gerar_relatorios.html" class="sidebar-nav"><i class="icon fa-solid fa-file-lines"></i><span>Relatórios</span></a>

            <a href="config.html" class="sidebar-nav"><i class="icon fa-solid fa-gear fa-arrow-right-from-bracket"></i><span>Configurações</span></a>
        </div>
        <!-- Fim da Sidebar -->
        <!-- Inicio do conteudo do administrativo -->

        <div class="wrapper">
            <div class="row">
                <div class="top-list">
                    <span class="title-content">Listar</span>
                    <div class="top-list-right">
                        <a href="formulario.html" class="btn-success">Cadastrar</a>
                    </div>
                </div>

                <div class="top-list">
                    <div class="row-input-search">
                        <div class="column">
                            <label class="title-input-search">ID: </label>
                            <input type="number" name="pesq_id" id="pesq_id" class="input-search">
                        </div>

                        <div class="column">
                            <label class="title-input-search">Nome: </label>
                            <input type="text" name="pesq_nome" id="pesq_nome" class="input-search" placeholder="Pesquisar pelo nome">

                        </div>

                        <div class="column">
                            <label class="title-input-search">E-mail: </label>
                            <input type="text" name="pesq_email" id="pesq_email" class="input-search" placeholder="Pesquisar pelo e-mail">
                        </div>

                        <div class="column">
                            <label class="title-input-search">Tipo de Usuário: </label>
                            <select name="pesq_tipoUser" id="pesq_tipoUser" class="input-search">
                                <option value="">Selecione</option>
                                <option value="">Aluno</option>
                                <option value="">Nutricionista</option>
                            </select>                        
                        </div>

                        <div class="column">
                            <label class="title-input-search">Situação do Usuário: </label>
                            <select name="pesq_situacaoUser" id="pesq_situacaoUser" class="input-search">
                                <option value="">Selecione</option>
                                <option value="">Ativo</option>
                                <option value="">Inativo</option>
                                <option value="">Aguardando Confirmação</option>
                            </select>                        
                        </div>

                        <div class="column margin-top-search">
                            <button type="button" class="btn-info">Pesquisar</button>
                        </div>

                    </div>
                </div>


                <table class="table-list">
                    <thead class="list-head">
                        <tr>
                            <th class="list-head-content">ID</th>
                            <th class="list-head-content">Nome</th>
                            <th class="list-head-content">E-mail</th>
                            <th class="list-head-content">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="list-body">
                        <tr>
                            <td class="list-body-content">1</td>
                            <td class="list-body-content">Cesar</td>
                            <td class="list-body-content">cesar@celke.com.br</td>
                            <td class="list-body-content">
                                <a href="visualizar.html" class="btn-primary">Visualizar</a>
                                <a href="formulario.html" class="btn-warning">Editar</a>
                                <button type="button" class="btn-danger">Apagar</button>
                            </td>
                            
                        </tr>
                        <tr>
                            <td class="list-body-content">2</td>
                            <td class="list-body-content">Cesar 2</td>
                            <td class="list-body-content">cesar2@celke.com.br</td>
                            <td class="list-body-content">
                                <a href="visualizar.html" class="btn-primary">Visualizar</a>
                                <a href="formulario.html" class="btn-warning">Editar</a>
                                <button type="button" class="btn-danger">Apagar</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="list-body-content">3</td>
                            <td class="list-body-content">Cesar 3</td>
                            <td class="list-body-content">cesar3@celke.com.br</td>
                            <td class="list-body-content">
                                <a href="visualizar.html" class="btn-primary">Visualizar</a>
                                <a href="formulario.html" class="btn-warning">Editar</a>
                                <button type="button" class="btn-danger">Apagar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="content-pagination">
                    <div class="pagination">
                        <a href="#">&laquo;</a>
                        
                        <a href="#" class="active">1</a>

                        <a href="#">&raquo;</a>
                    </div>
                </div>

            </div>
        </div>
        <!-- Fim do conteudo do administrativo -->
    </div>
    <!-- Fim Conteudo -->

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const btnPesquisar = document.querySelector(".btn-info");
            const tableBody = document.querySelector(".list-body");

            btnPesquisar.addEventListener("click", function () {
                const pesq_id = document.getElementById("pesq_id").value;
                const pesq_nome = document.getElementById("pesq_nome").value.toLowerCase();
                const pesq_email = document.getElementById("pesq_email").value.toLowerCase();
                const pesq_tipoUser = document.getElementById("pesq_tipoUser").value.toLowerCase();
                const pesq_situacaoUser = document.getElementById("pesq_situacaoUser").value.toLowerCase();

                const rows = tableBody.getElementsByTagName("tr");

                for (let i = 0; i < rows.length; i++) {
                    const row = rows[i];
                    const rowData = row.getElementsByClassName("list-body-content");
                    const id = rowData[0].textContent.trim();
                    const nome = rowData[1].textContent.trim().toLowerCase();
                    const email = rowData[2].textContent.trim().toLowerCase();
                    const tipoUser = pesq_tipoUser === "" ? true : tipoUser === rowData[3].textContent.trim().toLowerCase();
                    const situacaoUser = pesq_situacaoUser === "" ? true : situacaoUser === rowData[4].textContent.trim().toLowerCase();

                    if (id.includes(pesq_id) &&
                        nome.includes(pesq_nome) &&
                        email.includes(pesq_email) &&
                        tipoUser &&
                        situacaoUser) {
                        row.style.display = "table-row";
                    } else {
                        row.style.display = "none";
                    }
                }
           
            });

            tableBody.addEventListener("click", function (event) {
                if (event.target.classList.contains("btn-danger")) {
                    const row = event.target.closest("tr");
                    if (row) {
                        row.remove();
                    }
                }
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const btnPesquisar = document.querySelector(".btn-info");
            const tableBody = document.querySelector(".list-body");

            btnPesquisar.addEventListener("click", function () {
                // ... (código de pesquisa existente) ...
            });

            tableBody.addEventListener("click", function (event) {
                if (event.target.classList.contains("btn-warning")) {
                    const row = event.target.closest("tr");
                    if (row) {
                        // Aqui você pode redirecionar para a página de edição ou realizar outra ação de edição.
                        alert("Botão de Editar clicado para ID: " + row.querySelector(".list-body-content:first-child").textContent);
                    }
                }
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const btnPesquisar = document.querySelector(".btn-info");
            const tableBody = document.querySelector(".list-body");

            btnPesquisar.addEventListener("click", function () {
                // ... (código de pesquisa existente) ...
            });

            tableBody.addEventListener("click", function (event) {
                if (event.target.classList.contains("btn-primary")) {
                    const row = event.target.closest("tr");
                    if (row) {
                        // Aqui você pode redirecionar para a página de visualização ou realizar outra ação de visualização.
                        alert("Botão de Visualizar clicado para ID: " + row.querySelector(".list-body-content:first-child").textContent);
                    }
                }
            });
        });
    </script>

    <script src="../../assets/js/custom_adm.js"></script>

</body>

</html>