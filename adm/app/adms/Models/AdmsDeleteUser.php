<?php

namespace App\adms\Models;

/**
 * Classe para apagar o usuário no banco de dados
 */
class AdmsDeleteUser
{
    private bool $result = false;
    private int|string|null $id;
    private string $delDirectory;
    private string $delImg;

    public function getResult(): bool
    {
        return $this->result;
    }

    public function deleteUser(int $id, string $tipo = ''): void
    {
        $this->id = (int) $id;
    
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
        $deleteUser->exeDelete($table, "WHERE id = :id", "id={$this->id}");
    
        if ($deleteUser->getResult()) {
            //$this->deleteImg();
            $_SESSION['msg'] = "<p class='alert-success'>Usuário apagado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Usuário não apagado com sucesso!</p>";
            $this->result = false;
        }
    }
    

}

