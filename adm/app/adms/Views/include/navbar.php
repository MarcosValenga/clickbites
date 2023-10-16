 <!-- Inicio Navbar -->
 <nav class="navbar">
        <div class="navbar-content">
            <div class="bars">
                <i class="fa-solid fa-bars"></i>
            </div>
            <img src="<?php echo URLADM; ?>app/adms/assets/logos/logo2.png" alt="Celke" class="logo">
        </div>

        <div class="navbar-content">
            <div class="avatar">
                <?php 
                if(!empty($_SESSION['user_imagem']) and (file_exists("app/adms/assets/image/users/administrador/".$_SESSION['user_id']."/".$_SESSION['user_imagem']))){
                    echo "<img src='".URLADM."app/adms/assets/image/users/administrador/".$_SESSION['user_id']."/".$_SESSION['user_imagem']."' width='40' height='40'>";
                } else {
                    echo "<img src='".URLADM."app/adms/assets/image/users/not_found_img.png' width='40' height='40'>";
                }
                ?>
                <div class="dropdown-menu setting">
                    <a href="<?php echo URLADM; ?>view-profile/index" class="item">
                        <span class="fa-solid fa-user"></span> Perfil
                    </a>
                    
                    <a href="<?php echo URLADM; ?>edit-profile/index/<?php echo $_SESSION['user_id']; ?>/?tipo=<?php echo $_SESSION['user_tipo']; ?>" class="item">
                        <span class="fa-solid fa-gear"></span> Configuração
                    </a>

                    <a href="<?php echo URLADM; ?>logout/index" class="item">
                        <span class="fa-solid fa-arrow-right-from-bracket"></span> Sair
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <!-- Fim Navbar -->
