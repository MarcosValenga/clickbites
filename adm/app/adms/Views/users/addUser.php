<?php
if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}
?>

<h1>Novo Usuário</h1>

<?php
if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}
?>
<span id="msg"></span>

<form method="POST" action="" id="form-add-user">
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
    <input type="email" name="email" id="email" placeholder="Digite o seu melhor e-mail" value="<?php echo $email; ?>"><br><br>

    <?php
    $password = "";
    if (isset($valorForm['password'])) {
        $password = $valorForm['password'];
    }
    ?>
    <label>Senha: </label>
    <input type="password" name="password" id="password" placeholder="Digite a senha" onkeyup="passwordStrength()" autocomplete="on" value="<?php echo $password; ?>">
    <span id="msgViewStrength"><br><br></span>

    <?php
    $tipo = "";
    if (isset($valorForm['tipo'])){
        $tipo = $valorForm['tipo'];
    }
    ?>
    <p>Selecione o tipo de usuário:</p>
    <select name="tipo_usr" id="slc_tipo">
        <option value="">Selecione</option>
        <option value="aluno" <?php echo ($tipo === 'aluno') ? 'selected' : ''; ?>>Aluno</option>
        <option value="nutricionista" <?php echo ($tipo === 'nutricionista') ? 'selected' : ''; ?>>Nutricionista</option>
        <option value="administrador" <?php echo ($tipo === 'administrador') ? 'selected' : ''; ?>>Administrador</option>
    </select>
    <br><br>
    
    <button type="submit" name="SendAddUser" value="Cadastrar">Cadastrar</button>
</form>
<p><a href="<?php echo URLADM; ?>">Clique aqui</a> para acessar</p>

