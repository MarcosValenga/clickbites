<?php 
    if(!defined('CL1K3B1T35')){
        header("Location: /");
        die("Erro: Página não encontrada<br>");
    }

$sidebar_active = "";
if(isset($this->data['sidebarActive'])){
    $sidebar_active = $this->data['sidebarActive'];

}
?>  

<!-- inicio conteudo -->
<div class="content">
    <!-- inicio da side bar -->
    <div class="sidebar">
        
        <a href="<?php echo URLADM; ?>dashboard/index" class="sidebar-nav <?php if($sidebar_active == "dashboard") { echo "active";}?>"><i class="icon fa-solid fa-house"></i><span>Dashboard</span></a>

        <a href="<?php echo URLADM; ?>list-users/index" class="sidebar-nav <?php if($sidebar_active == "list-users") { echo "active";}?>"><i class="icon fa-solid fa-users"></i><span>Usuários</span></a>

        <a href="#" class="sidebar-nav <?php if($sidebar_active == "#") { echo "active";}?>"><i class="icon fa-solid fa-user-check"></i><span>Situações do Usuário</span></a>

        <a href="#" class="sidebar-nav <?php if($sidebar_active == "#") { echo "active";}?>"><i class="icon fa-solid fa-palette"></i><span>Cores</span></a>

        <a href="#" class="sidebar-nav <?php if($sidebar_active == "#") { echo "active";}?>"><i class="icon fa-solid fa-envelope"></i><span>Configurações de E-mail</span></a>

        <a href="#" class="sidebar-nav <?php if($sidebar_active == "#") { echo "active";}?>"><i class="icon fa-solid fa-file-lines"></i><span>Relatórios</span></a>
    </div>
    <!-- Fim da Sidebar -->

