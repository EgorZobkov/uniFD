<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Systems;

class Pagination
{

    public $totalItems = 0;
    public $totalPages = 0;

    public function page($page=0){
        $this->page = $page;
        return $this;
    }

    public function output($output=100){
        $this->output = $output;
        return $this;
    }

    public function total($total=0){
        $this->totalItems = $total;
        return $this;
    }

    public function pages(){
        $result = ceil($this->totalItems / $this->output);
        return $result?:1;
    }

    public function request($request){
        $this->request = $request;
        return $this;
    }

    public function init(){
        $this->totalPages = $this->pages();
    }

    public function offset(){
        if($this->page > $this->pages()) $this->page = $this->pages();
        if($this->page > 1) $start = ($this->page * $this->output) - $this->output; else $start = 0;      
        return "limit $start, ".$this->output;
    }

    public function offsetArray(){
        if($this->page > $this->pages()) $this->page = $this->pages();
        if($this->page > 1) $start = ($this->page * $this->output) - $this->output; else $start = 0;      
        return ["start"=>$start, "output"=>$this->output];
    }

    public function display($view=null){
        global $app;
        if($this->totalPages > 1){
            return str_replace(["{items}"],[$this->items()],$app->view->includeComponent('pagination.tpl'));
        }
        return '';
    }

    public function items(){

        $page = $this->page;
        $total = $this->totalPages;
        $page1left = '';
        $page2left = '';
        $page3left = '';
        $page1right = '';
        $page2right = '';
        $page3right = '';
        $first = '';
        $prev = '';
        $next = '';

        if($page <= 0) $page = 1;

        if($page - 3 > 0) $page3left = '<li class="page-item" ><a data-page="'.($page - 3).'" class="page-link waves-effect" href="'.requestBuildVars(["page"=>$page - 3],$this->request).'">'.($page - 3).'</a></li>';
        if($page - 2 > 0) $page2left = '<li class="page-item" ><a data-page="'.($page - 2).'" class="page-link waves-effect" href="'.requestBuildVars(["page"=>$page - 2],$this->request).'">'.($page - 2).'</a></li>';
        if($page - 1 > 0) $page1left = '<li class="page-item" ><a data-page="'.($page - 1).'" class="page-link waves-effect" href="'.requestBuildVars(["page"=>$page - 1],$this->request).'">'.($page - 1).'</a></li>';
        
        if($page + 3 <= $total) $page3right = '<li class="page-item" ><a data-page="'.($page + 3).'" class="page-link waves-effect" href="'.requestBuildVars(["page"=>$page + 3],$this->request).'">'.($page + 3).'</a></li>';
        if($page + 2 <= $total) $page2right = '<li class="page-item" ><a data-page="'.($page + 2).'" class="page-link waves-effect" href="'.requestBuildVars(["page"=>$page + 2],$this->request).'">'.($page + 2).'</a></li>';
        if($page + 1 <= $total) $page1right = '<li class="page-item" ><a data-page="'.($page + 1).'" class="page-link waves-effect" href="'.requestBuildVars(["page"=>$page + 1],$this->request).'">'.($page + 1).'</a></li>';
        
        if ($page > 4){
            $first = '<li class="page-item" ><a data-page="1" class="page-link waves-effect" href="'.requestBuildVars(["page"=>1],$this->request).'">1</a></li>';
        }
        
        if (($page + 3) < $total){
            $last = '<li class="page-item" ><a data-page="'.$total.'" class="page-link waves-effect" href="'.requestBuildVars(["page"=>$total],$this->request).'">'.$total.'</a></li>';
        }

        return $first.$page3left.$page2left.$page1left.'<li class="page-item active" ><a data-page="'.$page.'" class="page-link waves-effect" href="'.requestBuildVars(["page"=>$page],$this->request).'" >'.$page.'</a></li>'.$page1right.$page2right.$page3right.$last;
               
    }

    public function outPagination(){
        global $app;

        $pagination = "";

        if($this->totalItems){
            $pagination = '<div class="mt-4 text-muted" >Всего записей: <strong>'.$this->totalItems.'</strong>, страниц: <strong>'.$this->totalPages.'</strong></div>';
        }
        
        $pagination .= $this->display();

        return $pagination;
               
    }

}