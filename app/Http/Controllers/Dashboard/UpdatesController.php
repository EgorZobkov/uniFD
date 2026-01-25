<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Http\Controllers\Dashboard;

 use App\Systems\Controller;

 class UpdatesController extends Controller
 {

 public function __construct($app){
 parent::__construct($app); 
 }

 public function main()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/updates.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_222de3e53064abcb73b5a826d4150d2c")=>$this->router->getRoute("dashboard-updates")],"route_name"=>$this->router->currentRoute->name,"page_name"=>translate("tr_222de3e53064abcb73b5a826d4150d2c"),"page_icon"=>"ti-refresh-alert","favorite_status"=>true]]);

    return $this->view->preload('updates/updates', ["title"=>translate("tr_222de3e53064abcb73b5a826d4150d2c")]);

}



 }