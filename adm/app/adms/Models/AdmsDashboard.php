<?php

namespace App\adms\Models;

if(!defined('CL1K3B1T35')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Pagina inicial do sistema administrativo "dashboard"
 *
 * @author Celke
 */
class AdmsDashboard
{

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result = false;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    /**
     * @return array|null Retorna os dados
     */
    function getResultBd(): array|null
    {
        return $this->resultBd;
    }

    public function countUsers(string $tableName): void
    {
        $countUsers = new \App\adms\Models\helper\AdmsRead();
        $countUsers->fullRead("SELECT COUNT(*) AS num_result FROM $tableName");

        if ($countUsers->getResult()) {
            $this->resultBd = $countUsers->getResult();
            $this->result = true;
        } else {
            $this->result = false;
        }
    }

}

