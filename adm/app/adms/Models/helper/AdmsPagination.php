<?php

namespace App\adms\Models\helper;

if(!defined('CL1K3B1T35')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}



/**
 * Classe gernérica para paginar os registros do banco de dados
 *
 * @author Celke
 */
class AdmsPagination
{
    private int $page;
    private int $limitResult;
    private int $offset;
    private string $query;
    private string|null $parseString;
    private array $resultBd;
    private string|null $result;
    private int $totalPages;
    private int $maxLinks = 2;
    private string $link;
    private string|null $var;

    function getOffset():int{
        return $this->offset;
    }

    function getResult():string|null{
        return $this->result;
    }

    function __construct(string $link, string|null $var = null)
    {
        $this->link = $link;
        $this->var = $var;
    }

    public function condition(int $page, int $limitResult): void
    {
        $this->page = (int) $page ? $page :1;
        $this->limitResult = (int)  $limitResult;
        $this->offset = (int)($this->page * $this->limitResult) - $this->limitResult;
    }

    public function pagination(string $query, string|null $parseString): void
    {
        $this->query = (string) $query;
        $this->parseString = (string) $parseString;
        //var_dump($this->query);

        $count = new \App\adms\Models\helper\AdmsRead();
        $count->fullRead($this->query, $this->parseString);
        $this->resultBd = $count->getResult();
        $this->pageInstruction();
    }

    private function pageInstruction(): void
    {
        if (!empty($this->resultBd[0]['num_result'])) {
            $totalRecords = (int)$this->resultBd[0]['num_result'];
            $this->totalPages = ceil($totalRecords / $this->limitResult);
            if($this->totalPages >= $this->page){
                $this->layoutPagination();
            }else{
                header("Location: {$this->link}");
            }
        } else {
            $this->totalPages = 1;
        }
    }
    private function layoutPagination():void
    {
        $this->result = "<div class='content-pagination'>";
        $this->result .= "<div class='pagination'>";

        $this->result .="<a href='{$this->link}{$this->var}'>&laquo;</a>";

        for($beforePage = $this->page - $this->maxLinks; $beforePage <= $this->page - 1; $beforePage++){
            if($beforePage >= 1){
                $this->result .="<a href='{$this->link}/$beforePage{$this->var}'>$beforePage</a>";
            }
        }

        $this->result .="<a href='#' class='active'>{$this->page}</a>";

        for($afterPage = $this->page + 1; $afterPage <= $this->page + $this->maxLinks; $afterPage++){
            if($afterPage <= $this->totalPages){
                $this->result .="<a href='{$this->link}/$afterPage{$this->var}'>$afterPage</a>";
            }
        }

        $this->result .="<a href='{$this->link}/{$this->totalPages}{$this->var}'>&raquo;</a>";

        $this->result .= "</div>";
        $this->result .= "</div>";
    }
}
