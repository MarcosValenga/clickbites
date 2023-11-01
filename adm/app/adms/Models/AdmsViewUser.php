<?php

namespace App\adms\Models;

if(!defined('CL1K3B1T35')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Visualizar o usuário no banco de dados
 *
 * @author Marcos <marcosvalenga360@gmail.com>
 */
class AdmsViewUser
{

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result = false;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var int|string|null $id Recebe o id do registro*/
    private int|string|null $id;

    


    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    /**
     * @return array|null Retorna os detalhes do registro
     */
    function getResultBd(): array|null
    {
        return $this->resultBd;
    }

    public function viewUser(int $id, string $tipo): void
    {
        $this->id = $id;
        $viewUser = new \App\adms\Models\helper\AdmsRead();

        if ($tipo === 'aluno') {
            // Consulta para obter detalhes do aluno
            $viewUser->fullRead(
                "SELECT usr.id, usr.nome, usr.email, usr.user, usr.imagem, NULL AS certificado_nut, 'aluno' AS tipo, usr.created, usr.modified, usr.fk_sits_usuario, sit.nome_sit AS nome_sit
                FROM alunos usr
                INNER JOIN sists_usuarios as sit ON sit.id=usr.fk_sits_usuario
                WHERE usr.id=:id 
                LIMIT :limit",
                "id={$this->id}&limit=1"
            );
        } elseif ($tipo === 'nutricionista') {
            // Consulta para obter detalhes do nutricionista com INNER JOIN
            $viewUser->fullRead(
                "SELECT n.id, n.nome, n.email, n.user, n.certificado_nut, n.imagem, 'nutricionista' AS tipo, n.created, n.modified, n.fk_sits_usuario, sit.nome_sit AS nome_sit
                FROM nutricionistas AS n
                INNER JOIN sists_usuarios AS sit ON sit.id=n.fk_sits_usuario
                WHERE n.id = :id 
                LIMIT :limit",
                "id={$this->id}&limit=1"
            );

        } elseif ($tipo === 'administrador') {
            // Consulta para obter detalhes do administrador com INNER JOIN
            $viewUser->fullRead(
                "SELECT au.id, au.nome, au.email, au.user, NULL AS certificado_nut, au.imagem, 'administrador' AS tipo, au.created, au.modified, au.fk_sits_usuario, sit.nome_sit AS nome_sit
                FROM adms_users AS au
                INNER JOIN sists_usuarios AS sit ON sit.id=au.fk_sits_usuario
                WHERE au.id = :id 
                LIMIT :limit",
                "id={$this->id}&limit=1"
            );
            
        }else {
            // Tipo de usuário inválido
            $this->result = false;
            return;
        }

        if ($viewUser->getResult()) {
            $this->resultBd = $viewUser->getResult();
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Usuário não encontrado!</p>";
            $this->result = false;
        }
    }
}

