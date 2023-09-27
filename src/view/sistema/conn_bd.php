


<?php 
$host = "localhost";
$user = "root";
$pass = "1234";
$dbname = "cardapio_ofc";
$port  = "3306";

try{
    $conn = new PDO("mysql:host=$host; port=$port; dbname=". $dbname, $user, $pass);
    //echo "Conexão com o banco de dados realizado com sucesso";
}catch(PDOException $err){
    echo  "Erro: conexão com banco de dados não foi realizado com sucesso. Erro gerado". $err->getMessage();
}
?>