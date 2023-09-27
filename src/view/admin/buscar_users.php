<?php
include "../../view/sistema/conn_bd.php";

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <title>Celke - Like</title>
    <link rel="shortcut icon" href="images/favicon.ico" />
</head>

<body>
    
    <h2>Listar Usuários</h2>

    <?php
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    ?>

    <form method="POST" action="">

        <?php
        $texto_pesquisar = "";
        if (isset($dados['texto_pesquisar'])) {
            $texto_pesquisar = $dados['texto_pesquisar'];
        }
        ?>
        <label>Pesquisar</label>
        <input type="text" name="texto_pesquisar" value="<?php echo $texto_pesquisar; ?>" placeholder="Pesquisar pelo termo?"><br><br>

        <input type="submit" value="Pesquisar" name="PesqUsuario"><br><br>
    </form>

    <?php

    if (!empty($dados['PesqUsuario'])) {
        $nome = "%" . $dados['texto_pesquisar'] . "%";
        $query_usuario = "SELECT id, nome, email
                        FROM alunos 
                        
                        WHERE nome LIKE :nome 
                        ORDER BY id DESC";
        $result_usuarios = $conn->prepare($query_usuario);
        $result_usuarios->bindParam(':nome', $nome, PDO::PARAM_STR);
        $result_usuarios->execute();

        while ($row_usuario = $result_usuarios->fetch(PDO::FETCH_ASSOC)) {
            extract($row_usuario);
            echo "ID: $id <br>";
            echo "Nome: $nome <br>";
            echo "E-mail: $email <br>";
            echo "<hr>";
        }
    }


    ?>
     </div>


</body>

</html>