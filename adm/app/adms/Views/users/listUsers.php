<?php
echo "<h2>Listar Usuários</h2>";
echo "View - Página listar usuário!<br><br>";

echo "<a href='" .URLADM. "add-users/index'>Cadastrar</a><br><br>";

if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}

foreach ($this->data['listUsers'] as $user) {
    extract($user);
    echo "ID: $id <br>";
    echo "Nome: $nome <br>";
    echo "E-mail: $email <br>";
    
    if ($tipo === 'aluno') {
        echo "Tipo: Aluno<br>";
        // Adicione aqui qualquer informação específica do aluno que desejar imprimir.
    } elseif ($tipo === 'nutricionista') {
        echo "Tipo: Nutricionista<br>";
        // Adicione aqui qualquer informação específica do nutricionista que desejar imprimir.
    } elseif ($tipo === 'administrador') {
        echo "Tipo: Administrador<br>";
    }
    
    // Modifique o link "Visualizar" para incluir o tipo do usuário na URL
    echo "<a href='".URLADM."view-user/index/$id/?tipo=$tipo'>Visualizar</a><br>";
    echo "<a href='".URLADM."edit-user/index/$id/?tipo=$tipo'>Editar</a><br>";
    echo "<a href='".URLADM."delete-user/index/$id/?tipo=$tipo' onclick='return confirm(\"Tem certeza que deseja excluir este registro?\")'>Apagar</a><br>";


    echo "<hr>";
}

