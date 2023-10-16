<?php

namespace App\adms\Controllers;

if(!defined('CL1K3B1T35')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página Dashboard
 * @author Marcos Valenga <marcosvalenga360@gmail.com>
 */
class Dashboard
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW*/
    private array|string|null $data;

    /**
     * Instanciar a classe responsável em carregar a view e enviar os dados para view
     *  @return void
     */
    public function index():void
    {
        $countUsersTotal = new \App\adms\Models\AdmsDashboard();
        $countUsersTotal->countUsers("(SELECT id FROM alunos UNION ALL SELECT id FROM nutricionistas UNION ALL SELECT id FROM adms_users) AS combined_tables");
        
        $countUsersStudent = new \App\adms\Models\AdmsDashboard();
        $countUsersStudent->countUsers("(SELECT id FROM alunos) AS combined_tables");
        
        $countUsersNutri = new \App\adms\Models\AdmsDashboard();
        $countUsersNutri->countUsers("(SELECT id FROM nutricionistas) AS combined_tables");
        
        $countUsersAdm = new \App\adms\Models\AdmsDashboard();
        $countUsersAdm->countUsers("(SELECT id FROM adms_users) AS combined_tables");
        
        if ($countUsersTotal->getResult() && $countUsersStudent->getResult() && $countUsersNutri->getResult() && $countUsersAdm->getResult()) {
            $this->data['countUsersTotal'] = $countUsersTotal->getResultBd();
            $this->data['countUsersStudent'] = $countUsersStudent->getResultBd();
            $this->data['countUsersNutri'] = $countUsersNutri->getResultBd();
            $this->data['countUsersAdm'] = $countUsersAdm->getResultBd();
        } else {
            $this->data['countUsers'] = false;
        }
        


        $this->data['sidebarActive'] = "dashboard";

        $loadView = new \Core\ConfigView("adms/Views/dashboard/dashboard", $this->data);
        $loadView->loadView();
    }
}