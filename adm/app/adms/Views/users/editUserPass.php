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
            <span class="title-content">Editar Senha do Usuário</span>
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
            <form method="POST" action="" id="form-edit-user" class="form-adm">
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
                        $password = "";
                        if (isset($valorForm['password'])) {
                            $password = $valorForm['password'];
                        }
                        ?>
                        <label class="title-input">Senha:<span style='color: #f00;'>*</span></label>
                        <input type="password" name="password" id="password" class="input-adm" placeholder="Digite a nova senha" onkeyup="passwordStrength()" autocomplete="on" value="<?php echo $password; ?>" required><br>
                        <span id="msgViewStrength"></span>
                        <?php
                            $tipo = "";
                            if (isset($valorForm['tipo'])){
                                $tipo = $valorForm['tipo'];
                            }elseif (isset($valorForm['tipo_usr']))
                                $tipo = $valorForm['tipo_usr'];

                        ?>
                        <input type="hidden" name="tipo_usr" value="<?php echo $tipo; ?>">
                    </div>
                </div>
                <button type="submit" name="SendEditUserPass" value="Salvar" class="btn-success">Salvar</button>
            </form>
        </div>
    </div>
</div>
<!-- Fim do conteudo do administrativo -->



