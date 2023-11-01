<?php

if(!defined('CL1K3B1T35')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}

?>




<?php
if (isset($this->data['form'][0])) {
    $valorForm = $this->data['form'][0];
}


?>
<!-- Inicio do conteudo do administrativo -->
<div class="wrapper">
    <div class="row">
        <div class="top-list">
            <span class="title-content">Editar Perfil</span>
            <div class="top-list-right">
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
            <form method="POST" action="" id="form-edit-profile" class="form-adm">
                <div class="row-input">
                    <div class="column">
                        <?php
                        $id = "";
                        if (isset($valorForm['id'])) {
                            $id = $valorForm['id'];
                        }
                        ?>
                        <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
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
                        $user = "";
                        if (isset($valorForm['user'])) {
                            $user = $valorForm['user'];
                        }
                        ?>
                        <label class="title-input">Usuário: </label>
                        <input type="text" name="user" id="user" class="input-adm" placeholder="Digite o usuário" value="<?php echo $user; ?>">
                    </div>
                </div>

                <div class="row-input">
                    <div class="column">
                            </select>
                            <?php
                            $tipo = "";
                            if (isset($valorForm['tipo'])){
                                $tipo = $valorForm['tipo'];
                            }elseif (isset($valorForm['tipo_usr']))
                                $tipo = $valorForm['tipo_usr'];

                            ?>
                            <input type="hidden" name="tipo_usr" id="tipo_usr" value="<?php echo $tipo; ?>">
                        </select>
                    </div>
                </div>

                <button type="submit" name="SendEditProfile" value="Salvar" class="btn-success">Salvar</button>
            </form>
        </div>
    </div>
</div>
<!-- Fim do conteudo do administrativo -->

