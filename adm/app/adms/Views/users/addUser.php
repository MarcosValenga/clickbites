<?php

if (!defined('CL1K3B1T35')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}
?>

<!-- Inicio do conteudo do administrativo -->
<div class="wrapper">
    <div class="row">
        <div class="top-list">
            <span class="title-content">Adicionar Usuário</span>
            <div class="top-list-right">
                <?php
                    echo "<a href='" . URLADM . "list-users/index' class='btn-info'>Listar</a> ";
                ?>
            </div>
        </div>
        <div class="content-adm">
            <?php
            if (isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
            ?>
            <span id="msg"></span>
        </div>
        <div class="content-adm">
            <form method="POST" action="" id="form-add-user" class="form-adm">
                <div class="row-input">
                    <div class="column">
                        <?php
                            $name = "";
                            if (isset($valorForm['nome'])) {
                                $name = $valorForm['nome'];
                            }
                        ?>
                        <label class="title-input">Nome: </label>
                        <input type="text" name="nome" id="nome" class="input-adm" placeholder="Digite o nome completo" value="<?php echo $name; ?>">
                    </div>

                </div>
                <div class="row-input">
                    <div class="column">
                        <?php
                            $email = "";
                            if (isset($valorForm['email'])) {
                                $email = $valorForm['email'];
                            }
                        ?>
                        <label class="title-input">E-mail: </label>
                        <input type="email" name="email" id="email" class="input-adm" placeholder="Digite o seu melhor e-mail" value="<?php echo $email; ?>">
                    </div>
                </div>

                <div class="row-input">
                    <div class="column">
                        <?php
                        $password = "";
                        if (isset($valorForm['password'])) {
                            $password = $valorForm['password'];
                        }
                        ?>
                        <label class="title-input">Senha: </label>
                        <input type="password" name="password" id="password" class="input-adm" placeholder="Digite a senha" onkeyup="passwordStrength()" autocomplete="on" value="<?php echo $password; ?>">
                        <span id="msgViewStrength"></span>
                    </div>
                </div>

                <div class="row-input">
                    <div class="column">
                        <label for="" class="title-input">Situação:</label> 
                        <select name="fk_sits_usuario" id="fk_sits_usuario" class="input-adm">
                            <option value="">Selecione</option>
                            <?php
                            foreach ($this->data['select']['sit'] as $sit) {
                                extract($sit);
                                if ((isset($valorForm['fk_sits_usuario'])) and ($valorForm['fk_sits_usuario'] == $id_sit)) {
                                    echo " <option value='$id_sit' selected>$nome_sit</option>";
                                } else {
                                    echo " <option value='$id_sit' >$nome_sit</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="column">
                        <?php
                        $tipo = "";
                        if (isset($valorForm['tipo'])){
                            $tipo = $valorForm['tipo'];
                        }elseif (isset($valorForm['tipo_usr']))
                            $tipo = $valorForm['tipo_usr'];

                        ?>
                        <label class="title-input">Selecione o tipo de usuário:</label>
                        <select name="tipo_usr" id="tipo_usr" class="input-adm">
                            <option value="">Selecione</option>
                            <option value="aluno" <?php echo ($tipo === 'aluno') ? 'selected' : ''; ?>>Aluno</option>
                            <option value="nutricionista" <?php echo ($tipo === 'nutricionista') ? 'selected' : ''; ?>>Nutricionista</option>
                            <option value="administrador" <?php echo ($tipo === 'administrador') ? 'selected' : ''; ?>>Administrador</option>
                        </select>
                    </div>
                </div>

                <button type="submit" name="SendAddUser" value="Cadastrar" class="btn-success">Cadastrar</button>
            </form>
        </div>
    </div>
</div>
<!-- Fim do conteudo do administrativo -->


