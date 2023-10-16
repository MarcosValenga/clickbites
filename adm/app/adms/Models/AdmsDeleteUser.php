<?php

namespace App\adms\Models;

if(!defined('CL1K3B1T35')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Classe para apagar o usuário no banco de dados
 */
class AdmsDeleteUser
{
    private bool $result = false;
    private int|string|null $id;
    private string $delDirectory;
    private string $delImg;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    public function getResult(): bool
    {
        return $this->result;
    }

    public function deleteUser(int $id, string $tipo = ''): void
    {
        $this->id = (int) $id;
        

        
        if($this->viewUser($tipo)){        

            // Verifica o valor de $tipo e define a tabela correta
            if ($tipo === 'aluno') {
                $table = 'alunos';
            } elseif ($tipo === 'nutricionista') {
                $table = 'nutricionistas';
            } elseif ($tipo === 'administrador') {
                $table = 'adms_users';
            } else {
                // Tipo inválido, trate isso de acordo com suas necessidades
                return;
            }
            $deleteUser = new \App\adms\Models\helper\AdmsDelete();
            var_dump($deleteUser);
            $deleteUser->exeDelete($table, "WHERE id = :id", "id={$this->id}");
        
            if ($deleteUser->getResult()) {
                $this->deleteImg();
                $_SESSION['msg'] = "<p class='alert-success'>Usuário apagado com sucesso!</p>";
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Usuário não apagado com sucesso!</p>";
                $this->result = false;
            }
        }else{
            //$_SESSION['msg'] = "<p class='alert-danger'>Erro: Usuário não apagado com sucesso!</p>";
            $this->result = false;

        }


    }
    
    private function viewUser(string $tipo): bool
    {
        $viewUser = new \App\adms\Models\helper\AdmsRead();
        var_dump($tipo);
    
        if ($tipo === 'aluno') {
            $viewUser->fullRead(
                "SELECT id,  imagem, 'aluno' AS tipo
                FROM alunos 
                WHERE id=:id 
                LIMIT :limit",
                "id={$this->id}&limit=1"
            );
        } elseif ($tipo === 'nutricionista') {
            $viewUser->fullRead(
                "SELECT id, imagem, 'nutricionista' AS tipo
                FROM nutricionistas 
                WHERE id = :id 
                LIMIT :limit",
                "id={$this->id}&limit=1"
            );
    
        } elseif ($tipo === 'administrador') {
            $viewUser->fullRead(
                "SELECT id, imagem, 'administrador' AS tipo
                FROM adms_users 
                WHERE id = :id 
                LIMIT :limit",
                "id={$this->id}&limit=1"
            );
            
        } else {
            // Tipo de usuário inválido
            $this->result = false;
            return false;
        }
    
        if ($viewUser->getResult()) {
            $this->resultBd = $viewUser->getResult();
            var_dump($this->resultBd);
            $this->result = true;
            return true; // Retorne true para indicar que o usuário foi encontrado
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Usuário não encontrado!</p>";
            $this->result = false;
            return false; // Retorne false para indicar que o usuário não foi encontrado
        }
    }
    

    private function deleteImg(): void
    {
        var_dump($this->resultBd[0]);
        if((!empty($this->resultBd[0]['imagem'])) or (!empty($this->resultBd[0]['imagem'] != null))){
            $this->delDirectory = "app/adms/assets/image/users/".$this->resultBd[0]['tipo']."/".$this->resultBd[0]['id']."/";
            $this->delImg = $this->delDirectory . "/". $this->resultBd[0]['imagem'];

            if(file_exists($this->delImg)){
                unlink($this->delImg);
            }

            if(file_exists($this->delDirectory)){
                rmdir($this->delDirectory);
            }
        }
    }
}

