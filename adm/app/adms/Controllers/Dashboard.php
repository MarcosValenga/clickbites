<?php

namespace App\adms\Controllers;
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
        $this->data = "Bem vindo";

        $loadView = new \Core\ConfigView("adms/Views/dashboard/dashboard", $this->data);
        $loadView->loadView();
    }
}