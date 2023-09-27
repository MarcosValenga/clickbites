<?php
echo "<h2>Detalhes do Usuário</h2>";

                
echo "<a href='" . URLADM . "list-users/index' class='btn-info'>Listar</a><br><br>";

if (!empty($this->data['viewUser'])) {
    $firstElement = reset($this->data['viewUser']); // Obtém o primeiro elemento do array multidimensional

    if (isset($firstElement['tipo'])) {
        $tipo = $firstElement['tipo'];
        $id = $firstElement['id'];
        echo "<a href='".URLADM."edit-user/index/$id/?tipo=$tipo'>Editar</a><br><br>";
        echo "<a href='".URLADM."delete-user/index/$id/?tipo=$tipo' onclick='return confirm(\"Tem certeza que deseja excluir este registro?\")'>Apagar</a><br><br>";
    } else {
        echo "<p>A chave 'tipo' não está definida no array.</p>";
    }
}



                

if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}

if (!empty($this->data['viewUser'])) {
    $user = $this->data['viewUser'][0];
    extract($user);

    echo "Imagem: $imagem<br>";
    echo "ID: $id <br>";
    echo "Nome: $nome <br>";
    echo "E-mail: $email <br>";
    
    if ($tipo === 'aluno') {
        echo "Tipo: Aluno<br>";
        // Adicione aqui qualquer informação específica do aluno que desejar imprimir.
    } elseif ($tipo === 'nutricionista') {
        echo "Tipo: Nutricionista<br>";
        
        if (isset($certificado_nut) && !is_null($certificado_nut)) {
            echo "Certificado Nutricionista: $certificado_nut <br>";
            // Você pode adicionar qualquer outra lógica para exibir o certificado aqui.
        }
    } elseif ($tipo === 'administrador') {
        echo "Tipo: Administrador<br>";
        
    } else {
        echo "Tipo de usuário desconhecido<br>";
    }

    echo "Situação do Usuário: $nome_sit<br>";
    echo "Cadastrado: ".date('d/m/Y H:i:s', strtotime($created))."<br>";
    echo "Editado: ";
    if(!empty($modified)){
        echo date('d/m/Y H:i:s', strtotime($modified));
    }
    echo "<br>";
}
