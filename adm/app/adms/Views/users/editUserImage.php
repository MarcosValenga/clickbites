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
            <span class="title-content">Editar Imagem do Usuário</span>
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
            <form method="POST" action="" id="form-edit-user-img" enctype="multipart/form-data" class="form-adm">
                <div class="row-input">
                    <div class="column">
                        <?php
                        $id = "";
                        if (isset($valorForm['id'])) {
                            $id = $valorForm['id'];
                        }
                        ?>
                        <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
                        <label class="title-input">Foto de Perfil: </label>
                        <input type="file" name="new_image" id="new_image" onchange="inputFileValImg()" >
                    </div>
                </div>
                <div class="row-input">
                    <div class="column">
                        <?php
                        $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '';
                        if(!empty($valorForm['imagem']) and (file_exists("app/adms/assets/image/users/$tipo/".$valorForm['id']."/".$valorForm['imagem']))){
                            $old_image = URLADM."app/adms/assets/image/users/$tipo/".$valorForm['id']."/".$valorForm['imagem'];
                        } else {
                            $old_image = URLADM."app/adms/assets/image/users/not_found_img.png";
                        } 
                        ?>
                        <span id="preview-img">
                            <img src="<?php echo $old_image; ?>" alt="Imagem" style="width: 100px; height: 100px">
                        </span>
                    </div>
                </div>


                <div class="row-input">
                    <div class="column">
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

                <button type="submit" name="SendEditUserImage" value="Salvar" class="btn-success">Salvar</button>
            </form>
        </div>
    </div>
</div>
<!-- Fim do conteudo do administrativo -->

