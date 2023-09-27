<?php

namespace Core;



/**
 * Carregar as páginas da view
 * 
 * @author Marcos Valenga <marcosvalenga360@gmail.com>
 */
class ConfigView
{   
    
    /**
     * Receber o endereço da VIEW e os dados
     * @param string $nameView Enderço da VIEW que deve ser carregada
     * @param array|string|null $data Dados que a VIEW deve receber
     */
    public function __construct(private string $nameView, private array|string|null $data)
    {
    }

    /**
     * Carregar a VIEW
     * Verificar se o arquivo existe, e carregar caso exista, não existindo para o carregamento
     * 
     * @return void
     */
    public function loadView():void
    {
        if(file_exists('app/' .$this->nameView . '.php')){
            include 'app/adms/Views/include/head.php';
            include 'app/adms/Views/include/menu.php';
            include 'app/' .$this->nameView . '.php';
            include 'app/adms/Views/include/footer.php';
        }else{
            die("Erro - 002: Por favor tente novamente. Caso o problema persista, entre em contato o administrador ". EMAILADM);
        }
        
    }

    /**
     * Carregar a VIEW login
     * Verificar se o arquivo existe, e carregar caso exista, não existindo para o carregamento
     * 
     * @return void
     */
    public function loadViewLogin():void
    {
        if(file_exists('app/' .$this->nameView . '.php')){
            include 'app/adms/Views/include/head.php';
         
            include 'app/' .$this->nameView . '.php';
            include 'app/adms/Views/include/footer.php';
        }else{
            die("Erro - 002: Por favor tente novamente. Caso o problema persista, entre em contato o administrador ". EMAILADM);
        }
        
    }

}