<?php

namespace App\adms\Models;

if(!defined('CL1K3B1T35')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Listar os usuários do banco de dados
 *
 * @author Celke
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
    private int $limitResult = 4;

    /** @var string|null $page Recebe a paginaçao*/
    private string|null $resultPg;

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

    public function listUsers(int $page = null):void
    {   
        $this->page = (int) $page ? $page : 1;

        $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-users/index', "?pesquisar=marcos");
        $pagination->condition($this->page, $this->limitResult);
        $pagination->pagination("SELECT COUNT(*) AS num_result
                                FROM (
                                    SELECT id FROM alunos
                                    UNION ALL
                                    SELECT id FROM nutricionistas
                                    UNION ALL
                                    SELECT id FROM adms_users
                                ) AS combined_tables
                                ", null);
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
         
        if($this->resultBd){   
            $this->result = true;
        }else{
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Nenhum usuário encontrado!</p>";
            $this->result = false;
        }
    }

    
}
