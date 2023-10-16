<?php

if (!defined('CL1K3B1T35')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}
?>

<!-- Inicio do conteudo do administrativo -->
<div class="wrapper">
    <div class="row">
        <div class="top-list">
            <span class="title-content">Detalhes do Usuário</span>
            <div class="top-list-right">
                <?php
                echo "<a href='" . URLADM . "list-users/index' class='btn-info'>Listar</a> ";

                if (!empty($this->data['viewUser'])) {
                    $firstElement = reset($this->data['viewUser']); 

                    if (isset($firstElement['tipo'])) {
                        $tipo = $firstElement['tipo'];
                        $id = $firstElement['id'];
                        echo "<a href='" . URLADM . "edit-user/index/$id/?tipo=$tipo' class='btn-warning'>Editar</a> ";
                        echo "<a href='" . URLADM . "edit-user-password/index/$id/?tipo=$tipo' class='btn-warning'>Editar Senha</a> ";
                        echo "<a href='" . URLADM . "edit-user-image/index/$id/?tipo=$tipo' class='btn-warning'>Editar Imagem</a> ";
                        echo "<a href='" . URLADM . "delete-user/index/$id/?tipo=$tipo' onclick='return confirm(\"Tem certeza que deseja excluir este registro?\")' class='btn-danger'>Apagar</a> ";
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
            if (!empty($this->data['viewUser'])) {
                $usuario = $this->data['viewUser'][0];
                extract($usuario);
            ?>
                <div class="view-det-adm">
                    <span class="view-adm-title">Foto:</span>
                    <span class="view-adm-info"><?php if (!empty($imagem) and (file_exists("app/adms/assets/image/users/$tipo/$id/$imagem"))) {
                                                    echo "<img src='" . URLADM . "app/adms/assets/image/users/$tipo/$id/$imagem' width='100' height='100'>";
                                                } else {
                                                    echo "<img src='" . URLADM . "app/adms/assets/image/users/not_found_img.png' width='100' height='100'>";
                                                } ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">ID:</span>
                    <span class="view-adm-info"><?php echo $id; ?></span>
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
                    <span class="view-adm-info">
                        <?php
                        if ($tipo === 'aluno') {
                            echo "Aluno<br>";
                        } elseif ($tipo === 'nutricionista') {
                            echo "Nutricionista<br>";
                        } elseif ($tipo === 'administrador') {
                            echo "Administrador<br>";
                        }
                        ?>
                    </span>
                </div>
                <?php
                    if ($tipo === 'nutricionista' && isset($certificado_nut) && !is_null($certificado_nut)) {
                ?>
                <div class="view-det-adm">
                    <span class="view-adm-title">Certificado Nutricionista: </span>
                    <span class="view-adm-info"><?php echo $certificado_nut; ?></span>
                </div>
                <?php
                }
                ?>

                <?php
                if ($tipo === 'administrador') {
                    echo "Administrador";
                }
                ?>
                <div class="view-det-adm"> 
                    <span class="view-adm-title">Situação do Usuário: </span>
                    <span class="view-adm-info"><?php echo $nome_sit; ?></span>
                </div>
                <div class="view-det-adm">
                    <span class="view-adm-title">Cadastrado: </span>
                    <span class="view-adm-info"><?php echo date('d/m/Y H:i:s', strtotime($created)) ?></span>
                </div>
                <div class="view-det-adm">
                    <span class="view-adm-title">Editado: </span>
                    <span class="view-adm-info"><?php if (!empty($modified)) {
                                                    echo date('d/m/Y H:i:s', strtotime($modified));
                                                } ?></span>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>
<!-- Fim do conteudo do administrativo -->



