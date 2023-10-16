<?php

namespace App\adms\Controllers;
use App\adms\Models\AdmsEditUser;

if(!defined('CL1K3B1T35')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página editar usuário
 * @author 
 */
class EditUser
{

    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data = [];

    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;

    /** @var int|string|null $id Recebe o id do registro*/
    private int|string|null $id;

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * Quando o usuário clicar no botão "cadastrar" do formulário da página novo usuário. Acessa o IF e instância a classe "AdmsAddUsers" responsável em cadastrar o usuário no banco de dados.
     * Usuário cadastrado com sucesso, redireciona para a página listar registros.
     * Senão, instância a classe responsável em carregar a View e enviar os dados para View.
     * 
     * @return void
     */
    public function index(int|string|null $id = null, string $tipo = ''): void
    {
        $tipo = $_GET['tipo'] ?? ''; // Obter o valor de $tipo da query string
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        //var_dump($tipo); // Certifique-se de que o valor de $tipo está correto
        if ((!empty($id)) and (empty($this->dataForm['SendEditUser']))) {
            $this->id = (int) $id;
            $viewUser = new \App\adms\Models\AdmsEditUser();
            $viewUser->viewUser($this->id, $tipo);
            if($viewUser->getResult()){
                $this->data['form'] = $viewUser->getResultBd();
                $this->viewEditUser();
            } else{
                $urlRedirect = URLADM . "list-users/index";
                header("Location: $urlRedirect");
            }
        }else {
            $this->editUser();
        }
    }

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewEditUser(): void
    {
        $listSelect = new \App\adms\Models\AdmsEditUser();
        $this->data['select'] = $listSelect->listSelect();

        $loadView = new \Core\ConfigView("adms/Views/users/editUser", $this->data);
        $loadView->loadView();
    }

        /**
     * Editar usuario.
     * Se o usuário clicou no botão, instancia a MODELS responsável em receber os dados e editar no banco de dados.
     * Verifica se editou corretamente o usuário no banco de dados.
     * Se o usuário não clicou no botão redireciona para página listar usuarios.
     *
     * @return void
     */
    private function editUser(string $tipo = ''): void
    {
        $tipo = $_GET['tipo'] ?? '';
        
        if (!empty($this->dataForm['SendEditUser'])) {
            unset($this->dataForm['SendEditUser']);
            $editUser = new \App\adms\Models\AdmsEditUser();
            $editUser->update($this->dataForm);
            if($editUser->getResult()){
                $urlRedirect = URLADM . "view-user/index/" . $this->dataForm['id']."/?tipo=$tipo";
                header("Location: $urlRedirect");
            }else{
                $this->data['form'] = $this->dataForm;
                $this->viewEditUser();
            }
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Usuário não encontrado!</p>";
            $urlRedirect = URLADM . "list-users/index";
            header("Location: $urlRedirect");
        }
    }
}
