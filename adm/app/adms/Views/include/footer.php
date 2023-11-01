<?php 
    if(!defined('CL1K3B1T35')){
        header("Location: /");
        die("Erro: Página não encontrada<br>");
    }
?>    
    
<head>
    <link rel="stylesheet" href="custom_adm.css">
</head>

</div>

<footer>
    <div class='container'>
    <div class='row'>
        <div class='col-md-12'>
            <ul>
                <p><?php echo date('Y'); ?> &copy; Click Bites</p>
            </ul>
        </div>
    </div>
    </div>
</footer>
    
    <script src="<?php echo URLADM; ?>app/adms/assets/js/custom_adms.js"></script>    
    </body>
</html>