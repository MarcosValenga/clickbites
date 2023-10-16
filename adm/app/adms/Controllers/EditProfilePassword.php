<?php

namespace App\adms\Controllers;
use App\adms\Models\AdmsEditUser;

if(!defined('CL1K3B1T35')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página editar senha do perfil
 * @author 
 */
class EditProfilePassword
{

    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data = [];

    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * Quando o usuário clicar no botão "cadastrar" do formulário da página novo usuário. Acessa o IF e instância a classe "AdmsAddUsers" responsável em cadastrar o usuário no banco de dados.
     * Usuário cadastrado com sucesso, redireciona para a página listar registros.
     * Senão, instância a classe responsável em carregar a View e enviar os dados para View.
     * 
     * @return void
     */
    public function index(string $tipo = ''): void
    {   
        $tipo = $_GET['tipo'] ?? ''; // Obter o valor de $tipo da query string
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        //var_dump($tipo); // Certifique-se de que o valor de $tipo está correto
        if (!empty($this->dataForm['SendEditProfPass'])) {
            $this->editProfPass();
        }else {
            $viewProfPass = new \App\adms\Models\AdmsEditProfilePassword();
            $viewProfPass->viewProfile($tipo);
            if ($viewProfPass->getResult()){
                $this->data['form'] = $viewProfPass->getResultBd();
                $this->viewEditProfPass();
            } else {
                $urlRedirect = URLADM. "login/index";
                header("Location: $urlRedirect");
            }
                

        }
    }

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewEditProfPass(): void
    {
        $loadView = new \Core\ConfigView("adms/Views/users/editProfilePassword", $this->data);
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
    private function editProfPass(string $tipo = ''): void
    {
        $tipo = $_GET['tipo'] ?? '';
        if (!empty($this->dataForm['SendEditProfPass'])) {

            unset($this->dataForm['SendEditProfPass']);
            $editProfPass = new \App\adms\Models\AdmsEditProfilePassword();
            $editProfPass->update($this->dataForm);
            var_dump($editProfPass->getResult());
            if($editProfPass->getResult()){   
                $urlRedirect = URLADM . "view-profile/index/" . $_SESSION['user_id']."/?tipo=$tipo";
                header("Location: $urlRedirect");
            }else{
                $this->data['form'] = $this->dataForm;
                $this->viewEditProfPass();
            }
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Perfil não encontrado!</p>";
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");
        }
    }
}
