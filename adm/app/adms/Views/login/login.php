<?php
if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];

} 
?>



<h1>Área Restrita</h1>

<?php
    if(isset($_SESSION['msg'])){
        echo $_SESSION['msg'];
        unset ($_SESSION['msg']);
    }
?>

<form method="POST" action="" id="form-login">
    <?php
    $user = "";
    if (isset($valorForm['user'])) {
        $user = $valorForm['user'];
    }
    ?>
    <label>Usuário: </label>
    <input type="text" name="user" id="user" placeholder="Digite o usuário" value="<?php echo $user; ?>" required><br><br>

    <?php
    $password = "";
    if (isset($valorForm['password'])) {
        $password = $valorForm['password'];
    }
    ?>
    <label>Senha: </label>
    <input type="password" name="password" id="password" placeholder="Digite a senha" autocomplete="on" value="<?php echo $password; ?>" required><br><br>

    <button type="submit" name="SendLogin" value="Acessar">Acessar</button>
</form>
<p><a href="<?php echo URLADM; ?>new-user/index">Cadastrar</a></p>