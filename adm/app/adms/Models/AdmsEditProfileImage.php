<?php

namespace App\adms\Models;

if(!defined('CL1K3B1T35')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Editar a imagem do perfil do usuario no banco de dados
 *
 * @author Marcos <marcosvalenga360@gmail.com>
 */
class AdmsEditProfileImage
{

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result = false;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var array|null $data Recebe as informações do formulário */
    private array|null $data;

    /** @var array|null $dataImagem Recebe os dados da imagem */
    private array|null $dataImage;

    /** @var string $directory Recebe o endereço de upload da imagem */
    private string $directory;

    /** @var string $delImg Recebe o endereço da imagem que deve ser excluida */
    private string $delImg;
    /** @var string $nameImg Recebe o slug/nome da imagem */
    private string $nameImg;
    private string $tipo_usrs;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    /**
     * @return array|null Retorna os detalhes do registro
     */
    function getResultBd(): array|null
    {
        return $this->resultBd;
    }

    public function viewProfile(string $tipo): bool
    {
        $viewUser = new \App\adms\Models\helper\AdmsRead();
        
        if($tipo === 'administrador') {
            
            $viewUser->fullRead(
                "SELECT id, imagem, 'administrador' AS tipo
                FROM adms_users 
                WHERE id = :id 
                LIMIT :limit",
                "id=".$_SESSION['user_id']."&limit=1"
            );
            //var_dump("veio aqui");
            
        }else {
            // Tipo de usuário inválido
            $this->result = false;
            return false;
        }
        
        $this->resultBd = $viewUser->getResult();
        if ($this->resultBd) {
            $this->result = true;
            return true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Perfil não encontrado!</p>";
            $this->result = false;
            return false;
        }
    }

    public function update(array $data = null): void
    {
        $this->data = $data;

        $this->dataImage = $this->data['new_image'];
        unset($this->data['new_image']);

        $valEmptyField = new \App\adms\Models\helper\AdmsValEmptyField();
        $valEmptyField->valField($this->data);
        if ($valEmptyField->getResult()) {
            if (!empty($this->dataImage['name'])) {
                //$this->result = false;
                $this->valInput();
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem!</p>";
                $this->result = false;
            }
        } else {
            $this->result = false;
        }
    }

       /** 
     * Verificar se existe o usuário com ID logado
     * Retorna FALSE quando houve algum erro
     * 
     * @return void
     */
    private function valInput(): void
    {
        $valExtImg = new \App\adms\Models\helper\AdmsValExtImg();
        $valExtImg->validateExtImg($this->dataImage['type']);
        if ($this->viewProfile($this->data['tipo_usr']) and ($valExtImg->getResult())) {
            $table = "";
            if ($this->data['tipo_usr'] === 'aluno') {
               $table = "alunos";
            } elseif ($this->data['tipo_usr'] === 'nutricionista') {
               $table = "nutricionistas";
            } elseif ($this->data['tipo_usr'] === 'administrador') {
               $table = "adms_users";
            }
            $this->result = true;
            $this->upload($table);
        }else{
            $this->result = false;

        }
    }

    private function upload($table): void
    {
        $slugImg = new \App\adms\Models\helper\AdmsSlug();
        $this->nameImg = $slugImg->slug($this->dataImage['name']);
        
        $this->directory = "app/adms/assets/image/users/".$this->data['tipo_usr']."/".$_SESSION['user_id']."/";
        
        //$uploadImg = new \App\adms\Models\helper\AdmsUpload();
        //$uploadImg->upload($this->directory, $this->dataImage['tmp_name'], $this->nameImg);

        $uploadImgRes = new \App\adms\Models\helper\AdmsUploadImgRes();
        $uploadImgRes->upload($this->dataImage, $this->directory, $this->nameImg, 300, 300);
        
        if (($uploadImgRes->getResult())) {
            // Determine a tabela com base no tipo de usuário
            $table = "";
            if ($this->data['tipo_usr'] === 'aluno') {
               $table = "alunos";
            } elseif ($this->data['tipo_usr'] === 'nutricionista') {
               $table = "nutricionistas";
            } elseif ($this->data['tipo_usr'] === 'administrador') {
               $table = "adms_users";
            }
            
            // Inserir dados na tabela determinada
            $this->edit($table);
            
        } else {
            $this->result = false;
        }

        
    }

    private function edit(string $table): void
    {   
        $this->tipo_usrs = $this->data['tipo_usr']; // Armazene $tipo_usr como uma propriedade
        //var_dump($tipo_usr);
        unset($this->data['tipo_usr']);

        $this->data['imagem'] =  $this->nameImg;
        $this->data['modified'] = date("Y-m-d H:i:s");
        $upUser = new \App\adms\Models\helper\AdmsUpdate();
        //var_dump($upUser);
        $upUser->exeUpdate("$table", $this->data, "WHERE id=:id", "id=".$_SESSION['user_id']);

        if($upUser->getResult()){
            $_SESSION['user_imagem'] = $this->nameImg;
            $this->deleteImage();
        }else{
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Imagem não editada com sucesso!</p>";
            $this->result = false;
        }
    }

    private function deleteImage(): void
    {
        $image = $this->resultBd[0]['imagem'] ?? null;
        $this->delImg = "app/adms/assets/image/users/{$this->tipo_usrs}/".$_SESSION['user_id']."/$image";
    
        //var_dump($this->delImg); // Adicione esta linha para depuração
    
        if ($image !== null && file_exists($this->delImg) && is_file($this->delImg)) {
            unlink($this->delImg);
        } 
        $_SESSION['msg'] = "<p class='alert-success'>Imagem editada com sucesso!</p>";
        $this->result = true;
    }
}



