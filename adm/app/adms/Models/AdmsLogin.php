<?php

namespace App\adms\Models;

if(!defined('CL1K3B1T35')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Validar os dados do login
 *
 * @author Marcos <marcosvalenga360@gmail.com>
 */
class AdmsLogin
{

    /** @var array|null $data Recebe as informações do formulário */
    private array|null $data;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    /** 
     * Recebe os valores do formulário.
     * Recupera as informações do usuário no banco de dados
     * Quando encontrar o usuário no banco de dados instanciar o método "valPassword" para validar a senha 
     * Retorna FALSE quando não encontrar usuário no banco de dados
     * 
     * @param array $data Recebe as informações do formulário
     * 
     * @return void
     */
    public function login(array $data = null): void
    {
        $this->data = $data;

        $viewUser = new \App\adms\Models\helper\AdmsRead();
        $viewUser->fullRead("SELECT id, nome, email, password, imagem, 'administrador' AS tipo, fk_sits_usuario FROM adms_users WHERE user =:user OR email =:email LIMIT :limit", "user={$this->data['user']}&email={$this->data['user']}&limit=1");

        $this->resultBd = $viewUser->getResult();
        //var_dump($this->resultBd);
        if ($this->resultBd) {
            $this->valEmailPerm();
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Usuário ou a senha incorreta!</p>";
            $this->result = false;
        }
    }

    private function valEmailPerm(): void
    {
        if ($this->resultBd[0]['fk_sits_usuario'] == 1) {
            $this->valPassword();
        } elseif ($this->resultBd[0]['fk_sits_usuario'] == 3) {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Necessário confirmar o e-mail, solicite novo link <a href='".URLADM."new-conf-email/index'>Clique aqui</a>!</p>";
            $this->result = false;
        } elseif ($this->resultBd[0]['fk_sits_usuario'] == 5) {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: E-mail descadastrado, entre em contato com a empresa!</p>";
            $this->result = false;
        } elseif ($this->resultBd[0]['fk_sits_usuario'] == 2) {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: E-mail inativo, entre em contato com a empresa!</p>";
            $this->result = false;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: E-mail inativo, entre em contato com a empresa!</p>";
            $this->result = false;
        }
    }


    /** 
     * Compara a senha enviado pelo usuário com a senha que está salva no banco de dados
     * Retorna TRUE quando os dados estão corretos e salva as informações do usuário na sessão
     * Retorna FALSE quando a senha está incorreta
     * 
     * @return void
     */
    private function valPassword(): void
    {
        if (password_verify($this->data['password'], $this->resultBd[0]['password'])) {
            $_SESSION['user_id'] = $this->resultBd[0]['id'];
            $_SESSION['user_nome'] = $this->resultBd[0]['nome'];
            $_SESSION['user_email'] = $this->resultBd[0]['email'];
            $_SESSION['user_imagem'] = $this->resultBd[0]['imagem'];
            $_SESSION['user_tipo'] = $this->resultBd[0]['tipo'];
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Usuário ou a senha incorreta!</p>";
            $this->result = false;
        }
    }
}
