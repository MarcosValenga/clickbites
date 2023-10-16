<?php

if(!defined('CL1K3B1T35')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}
?>

<!-- Inicio do conteudo do administrativo -->
<div class="wrapper">
    <div class="row">
        <div class="top-list">
            <span class="title-content">Perfil</span>
            <div class="top-list-right">
                <?php
                echo "<a href='" . URLADM . "list-users/index' class='btn-info'>Listar</a> ";

                if (!empty($this->data['viewProfile'])) {
                    $firstElement = reset($this->data['viewProfile']); // Obtém o primeiro elemento do array multidimensional
                
                    if (isset($firstElement['tipo'])) {
                        $tipo = $firstElement['tipo'];
                        echo "<a href='".URLADM."edit-profile/index/".$_SESSION['user_id']."/?tipo=$tipo' class='btn-warning'>Editar</a> ";
                        echo "<a href='".URLADM."edit-profile-password/index/".$_SESSION['user_id']."/?tipo=$tipo' class='btn-warning'>Editar Senha</a> ";
                        echo "<a href='".URLADM."edit-profile-image/index/".$_SESSION['user_id']."/?tipo=$tipo' class='btn-warning'>Editar Imagem</a> ";
                        //echo "<a href='".URLADM."delete-user/index/$id/?tipo=$tipo' onclick='return confirm(\"Tem certeza que deseja excluir este registro?\")'>Apagar</a><br><br>";
                    } else {
                        echo "<p>A chave 'tipo' não está definida no array.</p>";
                    }
                }
                ?>
            </div>
        </div>
        <div class="content-adm">
            <?php
            if (isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
            ?>
        </div>
        <div class="content-adm">
            <?php
                if (!empty($this->data['viewProfile'])) {
                    $usuario = $this->data['viewProfile'][0];
                    extract($usuario);
            ?>
                <div class="view-det-adm">
                    <span class="view-adm-title">Foto:</span>
                    <span class="view-adm-info"><?php if (!empty($imagem) and (file_exists("app/adms/assets/image/users/$tipo/".$_SESSION['user_id']."/$imagem"))) {
                                                    echo "<img src='" . URLADM . "app/adms/assets/image/users/$tipo/".$_SESSION['user_id']."/$imagem' width='100' height='100'>";
                                                } else {
                                                    echo "<img src='" . URLADM . "app/adms/assets/image/users/not_found_img.png' width='100' height='100'>";
                                                } ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Nome: </span>
                    <span class="view-adm-info"><?php echo $nome; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">E-mail: </span>
                    <span class="view-adm-info"><?php echo $email; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Usuário: </span>
                    <span class="view-adm-info"><?php echo $user; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Tipo: </span>
                    <span class="view-adm-info"><?php if ($tipo === 'aluno') {
                                                    echo "Aluno<br>";
                                                } elseif ($tipo === 'nutricionista') {
                                                    echo "Nutricionista<br>"; ?>
                            <span class="view-adm-title">Certificado Nutricionista: </span>
                            <?php
                                                    if (isset($certificado_nut) && !is_null($certificado_nut)) {
                            ?>
                                <span class="view-adm-info"><?php echo $certificado_nut; ?></span><?php }
                                                                                            } elseif ($tipo === 'administrador') {
                                                                                                echo "Administrador";
                                                                                            } else {
                                                                                                echo "Tipo de usuário desconhecido";
                                                                                            } ?></span>

                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>
<!-- Fim do conteudo do administrativo -->