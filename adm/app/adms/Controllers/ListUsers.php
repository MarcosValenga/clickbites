<?php

namespace App\adms\Controllers;

if(!defined('CL1K3B1T35')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}
class ListUsers
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW*/
    private array|string|null $data;

    /** @var array|string|null $page Recebe o número da página*/
    private string|int|null $page;

    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;
    /** @var string|null $searchName Recebe o nome do usuário*/
    private string|null $searchName;

    /** @var string|null $searchEmail Recebe o email do usuario*/
    private string|null $searchEmail;

    /** @var string|null $searchTipo Recebe o nome do usuário*/
    private string|null $searchTipo;

    /** @var string|null $searchSitUser Recebe o email do usuario*/
    private string|null $searchSitUser;


    /**
     * Summary of index
     * @return void
     */
    public function index(string|int|null $page = null)
    {
        $this->page = (int) $page ? $page : 1;

        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        $this->searchName = filter_input(INPUT_GET, 'searchName', FILTER_DEFAULT);
        $this->searchEmail = filter_input(INPUT_GET, 'searchEmail', FILTER_DEFAULT);
        $this->searchTipo = filter_input(INPUT_GET, 'searchTipo', FILTER_DEFAULT);
        $this->searchSitUser = filter_input(INPUT_GET, 'searchSitUser', FILTER_DEFAULT);


        if(!empty($this->dataForm['SendSearchUser'])){
            $this->page = 1;
            $listSearchUsers = new \App\adms\Models\AdmsListUsers();
            $listSearchUsers->listSearchUsers($this->page, $this->dataForm['searchName'], $this->dataForm['searchEmail'], $this->dataForm['searchTipo'], $this->dataForm['searchSitUser']);
            if($listSearchUsers->getResult()){
                $this->data['listUsers'] = $listSearchUsers->getResultBd();
                $this->data['pagination'] = $listSearchUsers->getResultPg();
            }else{
                $this->data['listUsers'] = [];
                $this->data['pagination'] = "";
            }
            $this->data['form'] = $this->dataForm;
        }elseif((!empty($this->searchName)) or (!empty($this->searchEmail)) or (!empty($this->searchTipo)) or (!empty($this->searchSitUser))){
            $listSearchUsers = new \App\adms\Models\AdmsListUsers();
            $listSearchUsers->listSearchUsers($this->page, $this->searchName, $this->searchEmail, $this->searchTipo, $this->searchSitUser);
            if($listSearchUsers->getResult()){
                $this->data['listUsers'] = $listSearchUsers->getResultBd();
                $this->data['pagination'] = $listSearchUsers->getResultPg();
            }else{
                $this->data['listUsers'] = [];
                $this->data['pagination'] = "";
            }
            $this->data['form']['searchName'] = $this->searchName;
            $this->data['form']['searchEmail'] = $this->searchEmail;
            $this->data['form']['searchTipo'] = $this->searchTipo;
            $this->data['form']['searchSitUser'] = $this->searchSitUser;

        }else{
            $listUsers = new \App\adms\Models\AdmsListUsers();
            $listUsers->listUsers($this->page);
            if($listUsers->getResult()){
                $this->data['listUsers'] = $listUsers->getResultBd();
                $this->data['pagination'] = $listUsers->getResultPg();
            }else{
                $this->data['listUsers'] = [];
                $this->data['pagination'] = "";

            }
        }



        $this->data['sidebarActive'] = "list-users";
        $listSelect = new \App\adms\Models\AdmsListUsers();
        $this->data['select'] = $listSelect->listSelect();


        $loadView = new \Core\ConfigView("adms/Views/users/listUsers", $this->data);
        $loadView->loadView();
    }
}