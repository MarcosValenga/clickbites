<?php

namespace App\adms\Controllers;

/**
 * Controller da página visualizar usuarios
 * @author Marcos Valenga <marcosvalenga360@gmail.com>
 */
class ViewUser
{
    
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW*/
    private array $data;

     /** @var int|string|null $id Recebe o id do registro*/
     private int|string|null $id;

     /**
     * Instanciar a classe responsável em carregar a view e enviar os dados para view
     *  @return void
     */
    public function index(int|string|null $id = null, string $tipo = ''): void
    {   

        $tipo = $_GET['tipo'] ?? ''; // Obter o valor de $tipo da query string
        
        //var_dump($tipo); // Certifique-se de que o valor de $tipo está correto
        if (!empty($id)) {
            $this->id = (int) $id;
            

            // Verifica se o tipo é válido (aluno ou nutricionista)
            if (!empty($tipo) && ($tipo === 'aluno' || $tipo === 'nutricionista' || $tipo === 'administrador')) {
                // Define o tipo diretamente antes de chamar o método viewUser
                $viewUser = new \App\adms\Models\AdmsViewUser();
                
                // Adicione saída de depuração para verificar o tipo antes de chamar viewUser
                //var_dump("Entrou na verificação do tipo");
    
                // Passa o tipo como parâmetro
                $viewUser->viewUser($this->id, $tipo);
                //var_dump($viewUser);
                if ($viewUser->getResult()) {
                    $this->data['viewUser'] = $viewUser->getResultBd();
                    $this->viewUser();
                    
                } else {
                    $_SESSION['msg'] = "<p style='color: #f00;'>Usuário não encontrado!</p>";
                    $urlRedirect = URLADM . "list-users/index";
                    header("Location: $urlRedirect");
                }

            } 
            
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>ID de usuário inválido!</p>";
            $urlRedirect = URLADM . "list-users/index";
            header("Location: $urlRedirect");
        }
    }
    
    
    

    private function viewUser(): void
    {
        $loadView = new \Core\ConfigView("adms/Views/users/viewUser", $this->data);
        $loadView->loadView();
    }
}