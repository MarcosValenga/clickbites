<?php

namespace App\adms\Models;

if(!defined('CL1K3B1T35')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Editar a senha do usuário no banco de dados
 *
 * @author Marcos <marcosvalenga360@gmail.com> 
 */
class AdmsEditUserPassword
{

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result = false;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var int|string|null $id Recebe o id do registro*/
    private int|string|null $id;

    /** @var array|null $data Recebe as informações do formulário */
    private array|null $data;


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
        //var_dump($this->resultBd);
        return $this->resultBd;
    }

    public function viewUser(int $id, string $tipo): void
    {

        $this->id = $id;
        $viewUser = new \App\adms\Models\helper\AdmsRead();

        if ($tipo === 'aluno') {
            // Consulta para obter detalhes do aluno
            $viewUser->fullRead(
                "SELECT id, 'aluno' AS tipo
                FROM alunos
                WHERE id=:id 
                LIMIT :limit",
                "id={$this->id}&limit=1"
            );
        } elseif ($tipo === 'nutricionista') {
            // Consulta para obter detalhes do nutricionista com INNER JOIN
            $viewUser->fullRead(
                "SELECT id, 'nutricionista' AS tipo
                FROM nutricionistas
                WHERE id = :id 
                LIMIT :limit",
                "id={$this->id}&limit=1"
            );

        } elseif ($tipo === 'administrador') {
            // Consulta para obter detalhes do administrador com INNER JOIN
            $viewUser->fullRead(
                "SELECT id, 'administrador' AS tipo
                FROM adms_users
                WHERE id = :id 
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
            //var_dump($this->resultBd);
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Usuário não encontrado!</p>";
            $this->result = false;
        }
    }

    public function update(array $data = null): void
    {
        $this->data = $data;

        $valEmptyField = new \App\adms\Models\helper\AdmsValEmptyField();
        $valEmptyField->valField($this->data);
        if ($valEmptyField->getResult()) {
            $this->valInput();
        } else {
            $this->result = false;
        }
    }

    /** 
     * Instanciar o helper "AdmsValPassword" para validar a senha
     * Retorna FALSE quando houve algum erro
     * 
     * @return void
     */
    private function valInput(): void
    {
        $valPassword = new \App\adms\Models\helper\AdmsValPassword();
        $valPassword->validatePassword($this->data['password']);

        if ($valPassword->getResult()) {
             // Determine a tabela com base no tipo de usuário
             $table = "";
             if ($this->data['tipo_usr'] === 'aluno') {
                $table = "alunos";
             } elseif ($this->data['tipo_usr'] === 'nutricionista') {
                $table = "nutricionistas";
             } elseif ($this->data['tipo_usr'] === 'administrador') {
                $table = "adms_users";
             }
             
             // Inserir dados na tabela determinada
             $this->edit($table);
             
         } else {
             $this->result = false;
         }
    }

    private function edit(string $table): void
    {   
        $tipo_usr = $this->data['tipo_usr'];
        var_dump($tipo_usr);
        unset($this->data['tipo_usr']);

        $this->data['password'] = password_hash($this->data['password'], PASSWORD_DEFAULT);
        $this->data['modified'] = date("Y-m-d H:i:s");
        $upUser = new \App\adms\Models\helper\AdmsUpdate();
        //var_dump($upUser);
        $upUser->exeUpdate("$table", $this->data, "WHERE id=:id", "id={$this->data['id']}");

        if($upUser->getResult()){
            $_SESSION['msg'] = "<p style='color: green;'>A senha foi editada com sucesso!</p>";
            $this->result = true;
        }else{
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: A senha não foi editada com sucesso!</p>";
            $this->result = false;
        }
    }
}

