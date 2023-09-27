<?php
include "../../view/sistema/conn_bd.php";
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <title>Celke - Formulario UPDATE</title>
    <link rel="shortcut icon" href="images/favicon.ico" />
</head>

<body>
    <h2>Editar Usuário</h2>
    <?php

    //Salvar as informações do usuário no banco de dados 
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    if (!empty($dados['SendUpUsuario'])) {
        //var_dump($dados);
        $query_up_usuario = "UPDATE alunos 
                    SET nome=:nome, email=:email, senha=:senha, sists_usuario_id=:sists_usuario_id, niveis_acesso_id=:niveis_acesso_id, modified = NOW()
                    WHERE id=:id";
        $up_usuario = $conn->prepare($query_up_usuario);
        $up_usuario->bindParam(':nome', $dados['nome'], PDO::PARAM_STR);
        $up_usuario->bindParam(':email', $dados['email'], PDO::PARAM_STR);
        $senha_cript = password_hash($dados['senha'], PASSWORD_DEFAULT);
        $up_usuario->bindParam(':senha', $senha_cript, PDO::PARAM_STR);
        $up_usuario->bindParam(':sists_usuario_id', $dados['sists_usuario_id'], PDO::PARAM_INT);
        $up_usuario->bindParam(':niveis_acesso_id', $dados['niveis_acesso_id'], PDO::PARAM_INT);
        $up_usuario->bindParam(':id', $dados['id'], PDO::PARAM_INT);

        if($up_usuario->execute()){
            echo "Usuário editado com sucesso!";
        }else{
            echo "Erro: Usuário não editado com sucesso!";
        }
    }

    //Receber o id pela URL utilizando o método GET
    //Ex: http://localhost/celke/index.php?id_usuario=4
    //$id = filter_input(INPUT_GET, "id_usuario", FILTER_SANITIZE_NUMBER_INT);

    //Id do usuário estático
    $id = 3;

    //Pesquisar as informações do usuário no banco de dados
    $query_usuario = "SELECT id, nome, email
                        FROM alunos 
                        WHERE id=:id 
                        LIMIT 1";
    $result_usuario = $conn->prepare($query_usuario);
    $result_usuario->bindParam(':id', $id, PDO::PARAM_INT);
    $result_usuario->execute();

    $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);
    //var_dump($row_usuario);


    ?>

    <form method="POST" action="">

        <?php
        $id = "";
        if (isset($row_usuario['id'])) {
            $id = $row_usuario['id'];
        }
        ?>
        <input type="hidden" name="id" value="<?php echo $id; ?>" required>

        <?php
        $nome = "";
        if (isset($row_usuario['nome'])) {
            $nome = $row_usuario['nome'];
        }
        ?>
        <label>Nome: </label>
        <input type="text" name="nome" placeholder="Nome completo" value="<?php echo $nome; ?>" required><br><br>

        <?php
        $email = "";
        if (isset($row_usuario['email'])) {
            $email = $row_usuario['email'];
        }
        ?>
        <label>E-mail: </label>
        <input type="email" name="email" placeholder="O melhor e-mail do usuario" value="<?php echo $email; ?>" required><br><br>

        <label>Senha: </label>
        <input type="password" name="senha" placeholder="Nova senha para o usuário" required><br><br>

        <?php
        $sists_usuario_id = "";
        if (isset($row_usuario['sists_usuario_id'])) {
            $sists_usuario_id = $row_usuario['sists_usuario_id'];
        }
        ?>
        <label>Situação: </label>
        <input type="number" name="sists_usuario_id" placeholder="Situação do usuario" value="<?php echo $sists_usuario_id; ?>" required><br><br>

        <?php
        $niveis_acesso_id = "";
        if (isset($row_usuario['niveis_acesso_id'])) {
            $niveis_acesso_id = $row_usuario['niveis_acesso_id'];
        }
        ?>
        <label>Nível de Acesso: </label>
        <input type="number" name="niveis_acesso_id" placeholder="Nível de acesso do usuario" value="<?php echo $niveis_acesso_id; ?>" required><br><br>

        <input type="submit" value="Salvar" name="SendUpUsuario"><br><br>

    </form>
</body>

</html>