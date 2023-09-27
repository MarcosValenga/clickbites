<!DOCTYPE html>
<html lang="pt-br">
<head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link href="styles.css" type="text/css" rel="stylesheet" /> 
     <title>CLICKBITES</title>          
</head>
<body>
<h1> Controle de Biblioteca </h1> 
<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
<select name="opcao">
<option value = "incluir"> Cadastrar Autores</option>
<option value = "alterar"> Alterar Autores</option>
<option value = "excluir"> Excluir Autores</option>
<option value = "listar">  Listar Autores</option>
</select>
<br>
<br>
<input type="submit" value="OK" id="ok"/></br>
</form>
<?php
if(isset($_POST['opcao'])){
   $op=$_POST['opcao'];
    if($op=="incluir")Header("Location:incluirAutores.php");
    elseif ($op=="alterar")Header("Location:alterarAutores.php");
    elseif ($op=="excluir")Header("Location:excluirAutores.php");
    else if ($op=="listar")Header("Location:listarAutores.php");
}
?>
</body>
</html>