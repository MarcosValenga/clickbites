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

<h1>Editar Imagem</h1>

<?php
if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}
?>
<span id="msg"></span>

<form method="POST" action="" id="form-edit-prof-img" enctype="multipart/form-data">


    <label>Foto de Perfil: </label>
    <input type="file" name="new_image" id="new_image" onchange="inputFileValImg()"><br><br>

    <?php
    $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '';
    if(!empty($valorForm['imagem']) and (file_exists("app/adms/assets/image/users/$tipo/".$_SESSION['user_id']."/".$valorForm['imagem']))){
        $old_image = URLADM."app/adms/assets/image/users/$tipo/".$_SESSION['user_id']."/".$valorForm['imagem'];
    } else {
        $old_image = URLADM."app/adms/assets/image/users/$tipo/not_found_img.png";
    } 
    ?>
    <span id="preview-img">
        <img src="<?php echo $old_image; ?>" alt="Imagem" style="width: 100px; height: 100px">
    </span><br><br>

    <?php
    $tipo = "";
    if (isset($valorForm['tipo'])){
        $tipo = $valorForm['tipo'];
    }
    ?>
    <input type="hidden" name="tipo_usr" value="<?php echo $tipo; ?>">

    
    <button type="submit" name="SendEditProfImage" value="Salvar">Salvar</button>
</form>

