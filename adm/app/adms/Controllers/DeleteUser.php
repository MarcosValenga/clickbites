<?php

namespace App\adms\Controllers;

if(!defined('CL1K3B1T35')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller para apagar usuário
 */
class DeleteUser
{
    private int|string|null $id;

    /**
     * Método para apagar um usuário
     *
     * @param int|string|null $id
     * @return void
     */
    public function index(int|string|null $id = null): void
    {   
        $tipo = $_GET['tipo'] ?? ''; // Obter o valor de $tipo da query string
        if (!empty($id)) {
            $this->id = (int) $id;
            // Verifica se o tipo é válido (aluno ou nutricionista)
            if (!empty($tipo) && ($tipo === 'aluno' || $tipo === 'nutricionista' || $tipo === 'administrador')){
                $deleteUser = new \App\adms\Models\AdmsDeleteUser();
                $deleteUser->deleteUser($this->id, $tipo);
                $deleteUser->getResult();
            }
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Necessário selecionar um usuário!</p>";
        }

        $urlRedirect = URLADM . "list-users/index";
        header("Location: $urlRedirect");
    }
}
