<?php

namespace App\adms\Controllers;

class ListUsers
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW*/
    private array|string|null $data;


    /**
     * Summary of index
     * @return void
     */
    public function index()
    {
        $listUsers = new \App\adms\Models\AdmsListUsers();
        $listUsers->listUsers();
        if($listUsers->getResult()){
            $this->data['listUsers'] = $listUsers->getResultBd();
        }else{
            $this->data['listUsers'] = [];
        }

        

        $loadView = new \Core\ConfigView("adms/Views/users/listUsers", $this->data);
        $loadView->loadView();
    }
}