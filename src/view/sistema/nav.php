<?php
    session_start();
    require("conecta.php");
  
    if((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true))
    {
        unset($_SESSION['email']);
        unset($_SESSION['senha']);
        header('Location: login.php');
    }
    $usuario = $_SESSION['email'];

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link href="css/styles.css" type="text/css" rel="stylesheet" />      
     <!-- ICONSCOUT CDN-->
     <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
       <!-- GOOGLE FONTS (MONTSERRAT)-->
     <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" 
     rel="stylesheet">     
     <title>CLICKBITES ADMINISTAÇÃO</title>      
</head>
<body>
    <nav>
        <div class="container nav_container">
            <a href="index.php" class="nav_logo">CLICKBITES ADMINISTAÇÃO</a>
            <ul class="nav_itens">
                <li><a href="Livros.php">Livros</a></li>
                <li><a href="Autores.php">Autores</a></li>  
                <a href="sair.php" class="btn danger">Sair</a>                                           
            </ul>                       
        </div>
        <h5 class="direita">Bem-vindo, <u><?php  echo $usuario; ?></u>!</h5>
    </nav>
    
       <!--============================== END OF NAV =======================================-->