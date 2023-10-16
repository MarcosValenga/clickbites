<?php

if(!defined('CL1K3B1T35')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}
?>

<!-- Inicio do conteudo do administrativo -->
<div class="wrapper">
    <div class="row">
        <div class="box box-first">
            <span class="fa-solid fa-users"></span>
            <span>
            <?php 
                if (!empty($this->data['countUsersTotal'])){
                    echo $this->data['countUsersTotal'][0]['num_result'];
                }else{
                    echo 0;
                }
            ?>
            </span>
            <span>Total Usuários</span>
        </div>

        <div class="box box-second">
            <span class="fa-solid fa-graduation-cap"></span>
            <span>
            <?php 
                if (!empty($this->data['countUsersStudent'])){
                    echo $this->data['countUsersStudent'][0]['num_result'];
                }else{
                    echo 0;
                }
            ?>
            </span>
            <span>Alunos</span>
        </div>

        <div class="box box-third">
            <span class="fa-solid fa-person-breastfeeding"></span>
            <span>
            <?php 
                if (!empty($this->data['countUsersNutri'])){
                    echo $this->data['countUsersNutri'][0]['num_result'];
                }else{
                    echo 0;
                }
            ?>
            </span>
            <span>Nutricionistas</span>
        </div>

        <div class="box box-fourth">
            <span class="fa-solid fa-user-secret"></span>
            <span>
            <?php 
                if (!empty($this->data['countUsersAdm'])){
                    echo $this->data['countUsersAdm'][0]['num_result'];
                }else{
                    echo 0;
                }
            ?>
            </span>
            <span>Administradores</span>
        </div>
    </div>
</div>
<!-- Fim do conteudo do administrativo -->
