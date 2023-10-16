<?php

namespace App\adms\Controllers;

if(!defined('CL1K3B1T35')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página visualizar perfil
 * @author Marcos Valenga <marcosvalenga360@gmail.com>
 */
class ViewProfile
{
    
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW*/
    private array $data;

     /**
     * Instanciar a classe responsável em carregar a view e enviar os dados para view
     *  @return void
     */
    public function index(string $tipo = ''): void
    {   

        $tipo = 'administrador'; // Obter o valor de $tipo da query string
        
        // Verifica se o tipo é válido (aluno ou nutricionista)
        if (!empty($tipo) && ($tipo === 'aluno' || $tipo === 'nutricionista' || $tipo === 'administrador')) {
            // Define o tipo diretamente antes de chamar o método viewUser
            $viewProfile = new \App\adms\Models\AdmsViewProfile();
            
            // Adicione saída de depuração para verificar o tipo antes de chamar viewUser
            //var_dump("Entrou na verificação do tipo");

            // Passa o tipo como parâmetro
            $viewProfile->viewProfile($tipo);
            //var_dump($viewUser);
            if ($viewProfile->getResult()) {
                $this->data['viewProfile'] = $viewProfile->getResultBd();
                $this->loadViewProfile();
            } else {
                $_SESSION['msg'] = "<p style='color: #f00;'>Usuário não encontrado!</p>";
                $urlRedirect = URLADM . "login/index";
                header("Location: $urlRedirect");
            }

        } 
        
    }
    
    
    

    private function loadViewProfile(): void
    {
        $loadView = new \Core\ConfigView("adms/Views/users/viewProfile", $this->data);
        $loadView->loadView();
    }
}