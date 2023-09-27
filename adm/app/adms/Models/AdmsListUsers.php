<?php

namespace App\adms\Models;

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

    public function listUsers():void
    {
        $listUsers = new \App\adms\Models\helper\AdmsRead();
        $listUsers->fullRead("SELECT id, nome, email, 'aluno' AS tipo FROM alunos 
        UNION 
        SELECT id, nome, email, 'nutricionista' AS tipo FROM nutricionistas
        UNION
        SELECT id, nome, email, 'administrador' AS tipo FROM adms_users");
        

        $this->resultBd = $listUsers->getResult();  
         
        if($this->resultBd){   
            $this->result = true;
        }else{
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Nenhum usuário encontrado!</p>";
            $this->result = false;
        }
    }

    
}
