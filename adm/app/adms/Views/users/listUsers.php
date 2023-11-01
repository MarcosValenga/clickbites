<?php

if (!defined('CL1K3B1T35')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

if (isset($this->data['form'])){
    $valorForm = $this->data['form'];
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
        <div class="top-list">
            <form method="POST" action="" id="form-search-user">
                <div class="row-input-search">
                    <?php
                        $searchName = "";
                        if (isset($valorForm['searchName'])) {
                            $searchName = $valorForm['searchName'];
                        }
                    ?>
                    <div class="column">
                        <label class="title-input-search">Nome: </label>
                        <input type="text" name="searchName" id="searchName" class="input-search" placeholder="Pesquisar pelo nome..." value="<?php echo $searchName; ?>">
                    </div>

                    <?php
                        $searchEmail = "";
                        if (isset($valorForm['searchEmail'])) {
                            $searchEmail = $valorForm['searchEmail'];
                        }
                    ?>
                    <div class="column">
                        <label class="title-input-search">E-mail: </label>
                        <input type="text" name="searchEmail" id="searchEmail" class="input-search" placeholder="Pesquisar pelo e-mail..." value="<?php echo $searchEmail; ?>">
                    </div>

                    <?php
                        $searchTipo = "";
                        if (isset($valorForm['searchTipo'])) {
                            $searchTipo = $valorForm['searchTipo'];
                        }
                    ?>
                    <div class="column">
                        <label class="title-input-search">Selecione o tipo de usuário:</label>
                        <select name="searchTipo" id="searchTipo" class="input-search">
                            <option value="">Selecione</option>
                            <option value="aluno" <?php echo ($searchTipo === 'aluno') ? 'selected' : ''; ?>>Aluno</option>
                            <option value="nutricionista" <?php echo ($searchTipo === 'nutricionista') ? 'selected' : ''; ?>>Nutricionista</option>
                            <option value="administrador" <?php echo ($searchTipo === 'administrador') ? 'selected' : ''; ?>>Administrador</option>
                        </select>
                    </div>
                    
                    <?php
                        $searchSitUser = "";
                        if (isset($valorForm['searchSitUser'])) {
                            $searchSitUser = $valorForm['searchSitUser'];
                        }
                    ?>
                    <div class="column">
                    <label for="" class="title-input-search">Situação:</label> 
                        <select name="searchSitUser" id="searchSitUser" class="input-search">
                            <option value="">Selecione</option>
                            <?php
                            foreach ($this->data['select']['sit'] as $sit) {
                                extract($sit);
                                if ((isset($valorForm['searchSitUser'])) and ($valorForm['searchSitUser'] == $id_sit)) {
                                    echo " <option value='$id_sit' selected>$nome_sit</option>";
                                } else {
                                    echo " <option value='$id_sit' >$nome_sit</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="column margin-top-search">
                        <button type="submit" name="SendSearchUser" class="btn-info" value="Pesquisar">Pesquisar</button>
                    </div>
                </div>
            </form>
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
                    <tr class="list-row-content">
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