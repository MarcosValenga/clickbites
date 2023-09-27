<?php
if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}

?>

<?php
if (isset($this->data['form'][0])) {
    $valorForm = $this->data['form'][0];
}


?>

<h1>Editar Usuário</h1>

<?php
if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}
?>
<span id="msg"></span>

<form method="POST" action="" id="form-add-user">

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
    <label>Nome: </label>
    <input type="text" name="nome" id="nome" placeholder="Digite o nome completo" value="<?php echo $name; ?>"><br><br>
    
    <?php
    $email = "";
    if (isset($valorForm['email'])) {
        $email = $valorForm['email'];
    }
    ?>
    <label>E-mail: </label>
    <input type="text" name="email" id="email" placeholder="Digite o seu melhor e-mail" value="<?php echo $email; ?>"><br><br>

    <?php
    $user = "";
    if (isset($valorForm['user'])) {
        $user = $valorForm['user'];
    }
    ?>
    <label>Usuário: </label>
    <input type="text" name="user" id="user" placeholder="Digite o usuário para acessar o administrativo" value="<?php echo $user; ?>"><br><br>

        <?php
    $tipo = "";
    if (isset($valorForm['tipo'])){
        $tipo = $valorForm['tipo'];
    }
    ?>
    <input type="hidden" name="tipo_usr" value="<?php echo $tipo; ?>">

    
    <button type="submit" name="SendEditUser" value="Salvar">Salvar</button>
</form>

