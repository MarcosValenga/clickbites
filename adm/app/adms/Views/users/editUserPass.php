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

<h1>Editar Senha</h1>

<?php
if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}
?>
<span id="msg"></span>

<form method="POST" action="" id="form-edit-user-pass">

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
    <label>Senha:<span style='color: #f00;'>*</span></label>
    <input type="password" name="password" id="password" placeholder="Digite a nova senha" onkeyup="passwordStrength()" autocomplete="on" value="<?php echo $password; ?>" required><br>
    <span id="msgViewStrength"><br></span>
    <span style='color: #f00;'>* Campo Obrigatório</span><br><br>

    <?php
    $tipo = "";
    if (isset($valorForm['tipo'])){
        $tipo = $valorForm['tipo'];
    }
    ?>
    <input type="hidden" name="tipo_usr" value="<?php echo $tipo; ?>">

    
    <button type="submit" name="SendEditUserPass" value="Salvar">Salvar</button>
</form>

