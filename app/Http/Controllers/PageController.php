<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Http\Controllers;

 use App\Systems\Controller;

 class PageController extends Controller
 {

 public function __construct($app){
 parent::__construct($app); 
 }

 public function main()
{   

    $data = $this->model->template_pages->find("alias=?", [clearRequestURI()]);

    if(!$data){
        abort(404);
    }else{
        if(!$data->status){
            if(!$this->user->isAdminAuth()){
                abort(404);
            }
        }
    }

    $seo = $this->component->seo->content([],$data->id);

    return $this->view->render($data->template_name, ["seo"=>$seo]);

}



 }