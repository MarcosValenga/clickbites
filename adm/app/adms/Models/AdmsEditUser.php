<?php

namespace App\adms\Models;

/**
 * Editar o usuário no banco de dados
 *
 * @author 
 */
class AdmsEditUser
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
        return $this->resultBd;
    }

    public function viewUser(int $id, string $tipo): void
    {
        $this->id = $id;
        $viewUser = new \App\adms\Models\helper\AdmsRead();

        if ($tipo === 'aluno') {
            // Consulta para obter detalhes do aluno
            $viewUser->fullRead(
                "SELECT id, nome, email, user, 'aluno' AS tipo
                FROM alunos
                WHERE id=:id 
                LIMIT :limit",
                "id={$this->id}&limit=1"
            );
        } elseif ($tipo === 'nutricionista') {
            // Consulta para obter detalhes do nutricionista com INNER JOIN
            $viewUser->fullRead(
                "SELECT id, nome, email, user, certificado_nut, 'nutricionista' AS tipo
                FROM nutricionistas
                WHERE id = :id 
                LIMIT :limit",
                "id={$this->id}&limit=1"
            );

        } elseif ($tipo === 'administrador') {
            // Consulta para obter detalhes do administrador com INNER JOIN
            $viewUser->fullRead(
                "SELECT id, nome, email, user, 'administrador' AS tipo
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
     * Instanciar o helper "AdmsValEmail" para verificar se o e-mail válido
     * Instanciar o helper "AdmsValEmailSingle" para verificar se o e-mail não está cadastrado no banco de dados, não permitido cadastro com e-mail duplicado
     * Instanciar o helper "validatePassword" para validar a senha
     * Instanciar o helper "validateUserSingleLogin" para verificar se o usuário não está cadastrado no banco de dados, não permitido cadastro com usuário duplicado
     * Instanciar o método "add" quando não houver nenhum erro de preenchimento 
     * Retorna FALSE quando houve algum erro
     * 
     * @return void
     */
    private function valInput(): void
    {
        $valEmail = new \App\adms\Models\helper\AdmsValEmail();
        $valEmail->validateEmail($this->data['email']);

        if (($valEmail->getResult())) {
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

        $this->data['modified'] = date("Y-m-d H:i:s");
        $upUser = new \App\adms\Models\helper\AdmsUpdate();
        $upUser->exeUpdate("$table",$this->data, "WHERE id=:id", "id={$this->data['id']}");

        if($upUser->getResult()){
            $_SESSION['msg'] = "<p style='color: green;'>Usuário editado com sucesso!</p>";
            $this->result = true;
        }else{
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário não editado com sucesso!</p>";
            $this->result = false;
        }
    }
}

