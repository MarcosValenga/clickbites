<?php

namespace App\adms\Models;

if(!defined('CL1K3B1T35')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Editar a senha do perfil do usuario no banco de dados
 *
 * @author Celke
 */
class AdmsEditProfilePassword
{

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result = false;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

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
        return $this->resultBd;
    }

    public function viewProfile(string $tipo): void
    {
        $viewUser = new \App\adms\Models\helper\AdmsRead();
        if($tipo === 'administrador') {
            
            $viewUser->fullRead(
                "SELECT id, 'administrador' AS tipo
                FROM adms_users 
                WHERE id = :id 
                LIMIT :limit",
                "id=".$_SESSION['user_id']."&limit=1"
            );
            //var_dump("veio aqui");
            
        }else {
            // Tipo de usuário inválido
            $this->result = false;
            return;
        }

        // Adicione var_dump para depuração

        
        $this->resultBd = $viewUser->getResult();
        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Perfil não encontrado!</p>";
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
        unset($this->data['tipo_usr']);


        $this->data['password'] = password_hash($this->data['password'], PASSWORD_DEFAULT);
        $this->data['modified'] = date("Y-m-d H:i:s");
        $upUser = new \App\adms\Models\helper\AdmsUpdate();
        $upUser->exeUpdate("$table", $this->data, "WHERE id=:id", "id=". $_SESSION['user_id']);

        if($upUser->getResult()){
            $_SESSION['msg'] = "<p style='color: green;'>Senha editada com sucesso!</p>";
            $this->result = true;
        }else{
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Senha não editada com sucesso!</p>";
            $this->result = false;
        }
    }
}

