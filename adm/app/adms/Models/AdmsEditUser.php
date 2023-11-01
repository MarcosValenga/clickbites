<?php

namespace App\adms\Models;

if(!defined('CL1K3B1T35')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Editar o usuário no banco de dados
 *
 * @author Marcos <marcosvalenga360@gmail.com> 
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
    
    private array $listRegistryAdd;


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
                "SELECT id, nome, email, user, fk_sits_usuario, 'aluno' AS tipo
                FROM alunos
                WHERE id=:id 
                LIMIT :limit",
                "id={$this->id}&limit=1"
            );
        } elseif ($tipo === 'nutricionista') {
            // Consulta para obter detalhes do nutricionista com INNER JOIN
            $viewUser->fullRead(
                "SELECT id, nome, email, user, certificado_nut, fk_sits_usuario, 'nutricionista' AS tipo
                FROM nutricionistas
                WHERE id = :id 
                LIMIT :limit",
                "id={$this->id}&limit=1"
            );

        } elseif ($tipo === 'administrador') {
            // Consulta para obter detalhes do administrador com INNER JOIN
            $viewUser->fullRead(
                "SELECT id, nome, email, user, fk_sits_usuario, 'administrador' AS tipo
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
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Usuário não encontrado!</p>";
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

        $valEmailSingle = new \App\adms\Models\helper\AdmsValEmailSingle();
        $valEmailSingle->validateEmailSingle($this->data['email'], true, $this->data['id']);

        $valUserSingle = new \App\adms\Models\helper\AdmsValUserSingle();
        $valUserSingle->validateUserSingle($this->data['user'], true, $this->data['id']);

        if (($valEmail->getResult()) && ($valEmailSingle->getResult() && $valUserSingle->getResult())) {
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
        //var_dump($upUser);
        $upUser->exeUpdate("$table", $this->data, "WHERE id=:id", "id={$this->data['id']}");

        if($upUser->getResult()){
            $_SESSION['msg'] = "<p class='alert-success'>Usuário editado com sucesso!</p>";
            $this->result = true;
        }else{
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Usuário não editado com sucesso!</p>";
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
}

