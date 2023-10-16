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
            <span class="title-content">Lista de Usuários</span>
            <div class="top-list-right">
                <?php
                echo "<a href='" . URLADM . "add-users/index' class='btn-success'>Cadastrar</a>";
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
        <table class="table-list">
            <thead class="list-head">
                <tr>
                    <th class="list-head-content">ID</th>
                    <th class="list-head-content">Nome</th>
                    <th class="list-head-content table-sm-none">E-mail</th>
                    <th class="list-head-content table-sm-none">Tipo</th>
                    <th class="list-head-content">Ações</th>
                </tr>
            </thead>
            <tbody class="list-body">
                <?php
                foreach ($this->data['listUsers'] as $user) {
                    extract($user);
                ?>
                    <tr>
                        <td class="list-body-content"><?php echo $id; ?></td>
                        <td class="list-body-content"><?php echo $nome; ?></td>
                        <td class="list-body-content table-sm-none"><?php echo $email; ?></td>
                        <td class="list-body-content table-sm-none"><?php if ($tipo === 'aluno') {
                                                                        echo "Aluno<br>";
                                                                        // Adicione aqui qualquer informação específica do aluno que desejar imprimir.
                                                                    } elseif ($tipo === 'nutricionista') {
                                                                        echo "Nutricionista<br>";
                                                                        // Adicione aqui qualquer informação específica do nutricionista que desejar imprimir.
                                                                    } elseif ($tipo === 'administrador') {
                                                                        echo "Administrador<br>";
                                                                    }; ?></td>
                        <td class="list-body-content-action">
                            <button type="button" class="btn-primary" onclick="window.location.href='<?php echo URLADM; ?>view-user/index/<?php echo $id; ?>/?tipo=<?php echo $tipo; ?>'">
                                <i class="fa-solid fa-eye"></i>
                            </button>

                            <button type="button" class="btn-warning" onclick="window.location.href='<?php echo URLADM; ?>edit-user/index/<?php echo $id; ?>/?tipo=<?php echo $tipo; ?>'">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>

                            <button type="button" class="btn-danger" onclick="if (confirm('Tem certeza que deseja excluir este registro?')) window.location.href='<?php echo URLADM; ?>delete-user/index/<?php echo $id; ?>/?tipo=<?php echo $tipo; ?>'">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>

        <?php echo $this->data['pagination']; ?>
    </div>
</div>
<!-- Fim do conteudo do administrativo -->