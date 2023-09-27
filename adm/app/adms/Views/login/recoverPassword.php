<?php
if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}
?>

<h1>Recuperar Senha</h1>

<?php
if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}
?>
<span id="msg"></span>

<form method="POST" action="" id="form-recover-pass">

    <?php
    $email = "";
    if (isset($valorForm['email'])) {
        $email = $valorForm['email'];
    }
    ?>
    <label>E-mail: </label>
    <input type="email" name="email" id="email" placeholder="Digite o seu e-mail" value="<?php echo $email; ?>" required><br><br>

    <button type="submit" name="SendRecoverPass" value="Recuperar">Recuperar</button>
</form>

<p><a href="<?php echo URLADM; ?>">Clique aqui</a> para acessar</p>