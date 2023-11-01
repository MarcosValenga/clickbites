<?php

namespace App\adms\Models;

if (!defined('CL1K3B1T35')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Listar os usuários do banco de dados
 *
 * @author Marcos <marcosvalenga360@gmail.com>
 */
class AdmsListUsers
{

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;


    /** @var int $page Recebe o número da página*/
    private int $page;

    /** @var string|int|null $limitResult Recebe a quantidade de registros que deve retornar do banco de dados*/
    private int $limitResult = 12;

    /** @var string|null $page Recebe a paginaçao*/
    private string|null $resultPg;
    private array $listRegistryAdd;

    /** @var string|null $searchName Recebe o nome do usuário*/
    private string|null $searchName;

    /** @var string|null $searchEmail Recebe o email do usuario*/
    private string|null $searchEmail;
    private string|null $searchTipo;
    private string|null $searchSitUser;

    /** @var string|null $searchNameValue Recebe o nome do usuário*/
    private string|null $searchNameValue;

    /** @var string|null $searchEmailValue Recebe o email do usuario*/
    private string|null $searchEmailValue;
    private string|null $searchTipoValue;
    private string|null $searchSitUserValue;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    /**
     * @return bool Retorna os registros do BD
     */
    function getResultBd(): array|null
    {
        return $this->resultBd;
    }

    /**
     * @return bool Retorna os registros do BD
     */
    function getResultPg(): string|null
    {
        return $this->resultPg;
    }

    public function listUsers(int $page = null): void
    {
        $this->page = (int) $page ? $page : 1;

        $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-users/index');
        $pagination->condition($this->page, $this->limitResult);
        $pagination->pagination("SELECT COUNT(*) AS num_result
                                FROM (
                                    SELECT id FROM alunos
                                    UNION ALL
                                    SELECT id FROM nutricionistas
                                    UNION ALL
                                    SELECT id FROM adms_users
                                ) AS combined_tables
                                ");
        $this->resultPg = $pagination->getResult();

        $listUsers = new \App\adms\Models\helper\AdmsRead();
        $listUsers->fullRead("SELECT id, nome, email, 'aluno' AS tipo FROM alunos 
        UNION 
        SELECT id, nome, email, 'nutricionista' AS tipo FROM nutricionistas
        UNION
        SELECT id, nome, email, 'administrador' AS tipo FROM adms_users
        ORDER BY id DESC
        LIMIT :limit OFFSET :offset", "limit={$this->limitResult}&offset={$pagination->getOffset()}");


        $this->resultBd = $listUsers->getResult();

        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum usuário encontrado!</p>";
            $this->result = false;
        }
    }

    public function listSelect(): array
    {
        $list = new \App\adms\Models\helper\AdmsRead();
        $list->fullRead("SELECT id id_sit, nome_sit FROM sists_usuarios ORDER BY nome_sit ASC");
        $registry['sit'] = $list->getResult();

        $this->listRegistryAdd = ['sit' => $registry['sit']];

        return $this->listRegistryAdd;
    }

    public function listSearchUsers(int $page = null, string|null $searchName, string|null $searchEmail, string|null $searchTipo, string|null $searchSitUser): void
    {
        $this->page = (int) $page ? $page : 1;

        $this->searchName = trim($searchName);
        $this->searchEmail = trim($searchEmail);
        $this->searchTipo = trim($searchTipo);
        $this->searchSitUser = trim($searchSitUser);
        $this->searchNameValue = "%" . $this->searchName . "%";
        $this->searchEmailValue = "%" . $this->searchEmail . "%";
        $this->searchTipoValue = "%" . $this->searchTipo . "%";
        $this->searchSitUserValue = "%" . $this->searchSitUser . "%";


        if ((!empty($this->searchName)) and (!empty($this->searchEmail))) {
            $this->searchUserNameEmail();
        } elseif ((!empty($this->searchName)) and (empty($this->searchEmail))) {
            $this->searchUserName();
        } elseif ((empty($this->searchName)) and (!empty($this->searchEmail))) {
            $this->searchUserEmail();
        } elseif (!empty($this->searchTipo)) {
            $this->searchUserTipo(); // Chama a função de pesquisa por tipo de usuário
        } elseif (!empty($this->searchSitUser)) {
            $this->searchUserSitUser(); // Chama a função de pesquisa por situação do usuário
        } else {
            $this->listUsers(); // Lista todos os usuários se nenhum filtro for aplicado
        }
    }

    public function searchUserNameEmail(): void
    {
        $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-users/index', "?searchName={$this->searchName}&searchEmail={$this->searchEmail}");
        $pagination->condition($this->page, $this->limitResult);
        $pagination->pagination("SELECT COUNT(*) AS num_result
        FROM (
            SELECT id, nome, email FROM alunos
            UNION ALL
            SELECT id, nome, email FROM nutricionistas
            UNION ALL
            SELECT id, nome, email FROM adms_users
        ) AS combined_tables
        WHERE nome LIKE :searchName
        OR email LIKE :searchEmail
        ", "searchName={$this->searchNameValue}&searchEmail={$this->searchEmailValue}");
        $this->resultPg = $pagination->getResult();

        $listUsers = new \App\adms\Models\helper\AdmsRead();
        $listUsers->fullRead("
        (SELECT id, nome, email, 'aluno' AS tipo FROM alunos WHERE nome LIKE :searchName OR email LIKE :searchEmail)
        UNION 
        (SELECT id, nome, email, 'nutricionista' AS tipo FROM nutricionistas WHERE nome LIKE :searchName OR email LIKE :searchEmail)
        UNION
        (SELECT id, nome, email, 'administrador' AS tipo FROM adms_users WHERE nome LIKE :searchName OR email LIKE :searchEmail)
        ORDER BY id DESC
        LIMIT :limit OFFSET :offset", "searchName={$this->searchNameValue}&searchEmail={$this->searchEmailValue}&limit={$this->limitResult}&offset={$pagination->getOffset()}");
        $this->resultBd = $listUsers->getResult();

        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum usuário encontrado!</p>";
            $this->result = false;
        }
    }

    public function searchUserName(): void
    {
        $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-users/index', "?searchName={$this->searchName}&searchEmail={$this->searchEmail}");
        $pagination->condition($this->page, $this->limitResult);
        $pagination->pagination("SELECT COUNT(*) AS num_result
        FROM (
            SELECT id, nome, email FROM alunos
            UNION ALL
            SELECT id, nome, email FROM nutricionistas
            UNION ALL
            SELECT id, nome, email FROM adms_users
        ) AS combined_tables
        WHERE nome LIKE :searchName", "searchName={$this->searchNameValue}");
        $this->resultPg = $pagination->getResult();

        $listUsers = new \App\adms\Models\helper\AdmsRead();
        $listUsers->fullRead("
        (SELECT id, nome, email, 'aluno' AS tipo FROM alunos WHERE nome LIKE :searchName)
        UNION 
        (SELECT id, nome, email, 'nutricionista' AS tipo FROM nutricionistas WHERE nome LIKE :searchName)
        UNION
        (SELECT id, nome, email, 'administrador' AS tipo FROM adms_users WHERE nome LIKE :searchName)
        ORDER BY id DESC
        LIMIT :limit OFFSET :offset", "searchName={$this->searchNameValue}&limit={$this->limitResult}&offset={$pagination->getOffset()}");
        $this->resultBd = $listUsers->getResult();

        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum usuário encontrado!</p>";
            $this->result = false;
        }
    }

    public function searchUserEmail(): void
    {
        $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-users/index', "?searchName={$this->searchName}&searchEmail={$this->searchEmail}");
        $pagination->condition($this->page, $this->limitResult);
        $pagination->pagination("SELECT COUNT(*) AS num_result
        FROM (
            SELECT id, nome, email FROM alunos
            UNION ALL
            SELECT id, nome, email FROM nutricionistas
            UNION ALL
            SELECT id, nome, email FROM adms_users
        ) AS combined_tables
        WHERE email LIKE :searchEmail
        ", "searchEmail={$this->searchEmailValue}");
        $this->resultPg = $pagination->getResult();

        $listUsers = new \App\adms\Models\helper\AdmsRead();
        $listUsers->fullRead("
        (SELECT id, nome, email, 'aluno' AS tipo FROM alunos WHERE email LIKE :searchEmail)
        UNION 
        (SELECT id, nome, email, 'nutricionista' AS tipo FROM nutricionistas WHERE email LIKE :searchEmail)
        UNION
        (SELECT id, nome, email, 'administrador' AS tipo FROM adms_users WHERE email LIKE :searchEmail)
        ORDER BY id DESC
        LIMIT :limit OFFSET :offset", "searchEmail={$this->searchEmailValue}&limit={$this->limitResult}&offset={$pagination->getOffset()}");
        $this->resultBd = $listUsers->getResult();

        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum usuário encontrado!</p>";
            $this->result = false;
        }
    }

    public function searchUserTipo(): void
    {
        $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-users/index', "?searchTipo={$this->searchTipo}");
        $pagination->condition($this->page, $this->limitResult);
        if ($this->searchTipo === 'aluno') {
            $pagination->pagination("SELECT COUNT(*) AS num_result FROM (SELECT id FROM alunos) AS combined_tables");

        } elseif ($this->searchTipo === 'nutricionista') {
            $pagination->pagination("SELECT COUNT(*) AS num_result FROM (SELECT id FROM nutricionistas) AS combined_tables");
                
        } elseif ($this->searchTipo === 'administrador') {
            $pagination->pagination("SELECT COUNT(*) AS num_result FROM (SELECT id FROM adms_users) AS combined_tables");

        } else {
            $pagination->pagination("SELECT COUNT(*) AS num_result
                FROM (
                    SELECT id, nome, email FROM alunos
                    UNION ALL
                    SELECT id, nome, email FROM nutricionistas
                    UNION ALL
                    SELECT id, nome, email FROM adms_users
                ) AS combined_tables");
        }

        $this->resultPg = $pagination->getResult();
    
        $listUsers = new \App\adms\Models\helper\AdmsRead();
    
        if ($this->searchTipo === 'aluno') {
            $listUsers->fullRead("
                SELECT id, nome, email, 'aluno' AS tipo FROM alunos
                WHERE id
                ORDER BY id DESC
                LIMIT :limit OFFSET :offset",
                "limit={$this->limitResult}&offset={$pagination->getOffset()}"
            );
        } elseif ($this->searchTipo === 'nutricionista') {
            $listUsers->fullRead("
                SELECT id, nome, email, 'nutricionista' AS tipo FROM nutricionistas
                WHERE id
                ORDER BY id DESC
                LIMIT :limit OFFSET :offset",
                "limit={$this->limitResult}&offset={$pagination->getOffset()}"
            );
        } elseif ($this->searchTipo === 'administrador') {
            $listUsers->fullRead("
                SELECT id, nome, email, 'administrador' AS tipo FROM adms_users
                WHERE id
                ORDER BY id DESC
                LIMIT :limit OFFSET :offset",
                "limit={$this->limitResult}&offset={$pagination->getOffset()}"
            );
        } else {
            $this->listUsers();
            return;
        }
    
        $this->resultBd = $listUsers->getResult();
    
        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum usuário encontrado!</p>";
            $this->result = false;
        }
    }
    

    public function searchUserSitUser(): void
    {
        $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-users/index', "?searchSitUser={$this->searchSitUser}");
        $pagination->condition($this->page, $this->limitResult);
        $pagination->pagination("SELECT COUNT(*) AS num_result
            FROM (
                SELECT id, nome, email, 'aluno' AS tipo, fk_sits_usuario FROM alunos
                UNION ALL
                SELECT id, nome, email, 'nutricionista' AS tipo, fk_sits_usuario FROM nutricionistas
                UNION ALL
                SELECT id, nome, email, 'administrador' AS tipo, fk_sits_usuario FROM adms_users
            ) AS combined_tables
            INNER JOIN sists_usuarios ON combined_tables.fk_sits_usuario = sists_usuarios.id
            WHERE sists_usuarios.id LIKE :searchSitUser", "searchSitUser={$this->searchSitUserValue}");
        $this->resultPg = $pagination->getResult();
        
        $listUsers = new \App\adms\Models\helper\AdmsRead();
        $listUsers->fullRead(
            "SELECT id, nome, email, tipo FROM (
                SELECT id, nome, email, 'aluno' AS tipo, fk_sits_usuario FROM alunos
                UNION ALL
                SELECT id, nome, email, 'nutricionista' AS tipo, fk_sits_usuario FROM nutricionistas
                UNION ALL
                SELECT id, nome, email, 'administrador' AS tipo, fk_sits_usuario FROM adms_users
            ) AS combined_tables
            WHERE combined_tables.fk_sits_usuario LIKE :searchSitUser
            ORDER BY id DESC
            LIMIT :limit OFFSET :offset",
            "searchSitUser={$this->searchSitUserValue}&limit={$this->limitResult}&offset={$pagination->getOffset()}"
        );
        
        $this->resultBd = $listUsers->getResult();

        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum usuário encontrado!</p>";
            $this->result = false;
        }
    }
}
