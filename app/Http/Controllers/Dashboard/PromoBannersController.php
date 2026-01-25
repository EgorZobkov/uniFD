<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Http\Controllers\Dashboard;

 use App\Systems\Controller;

 class PromoBannersController extends Controller
 {

 public function __construct($app){
 parent::__construct($app); 
 }

 public function add()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    if($this->validation->requiredField($_POST['title'])->status == false){
        $answer['title'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['link'])->status == false){
        $answer['link'] = $this->validation->error;
    }
 
    if(empty($answer)){

        $this->model->promo_banners->insert(["status"=>(int)$_POST['status'], "title"=>$_POST['title'], "image"=>$_POST["manager_image"] ?: null, "text"=>$_POST['subtitle'], "link"=>$_POST['link'], "bg_color"=>$_POST['bg_color']?:'white', "text_color"=>$_POST['text_color']?:'black', "page_show"=>$_POST['page_show'] ?: null, "category_id"=>(int)$_POST['category_id'], "geo_link_status"=>(int)$_POST['geo_link_status']]);

        $this->session->setNotifyDashboard('success', code_answer("add_successfully"));

        return json_answer(["status"=>true]);

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }

}

public function delete()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->model->promo_banners->delete("id=?", [$_POST['id']]);

    $this->session->setNotifyDashboard('success', code_answer("delete_successfully"));

    return json_answer(["status"=>true]);

}

public function edit()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    $data = $this->model->promo_banners->find('id=?', [$_POST['id']]);

    if(!$data) return json_answer(["status"=>true, "type_answer"=>"error", "type_show"=>"notice", "answer"=>code_answer("record_not_found")]);

    if($this->validation->requiredField($_POST['title'])->status == false){
        $answer['title'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['link'])->status == false){
        $answer['link'] = $this->validation->error;
    }

    if(!$_POST['page_show']){
        $_POST['category_id'] = 0;
    }
 
    if(empty($answer)){

        $this->model->promo_banners->update(["status"=>(int)$_POST['status'], "title"=>$_POST['title'], "image"=>$_POST["manager_image"] ?: null, "text"=>$_POST['subtitle'], "link"=>$_POST['link'], "bg_color"=>$_POST['bg_color']?:'white', "text_color"=>$_POST['text_color']?:'black', "page_show"=>$_POST['page_show'] ?: null, "category_id"=>(int)$_POST['category_id'], "geo_link_status"=>(int)$_POST['geo_link_status']], $_POST['id']);

        return json_answer(["status"=>true, "answer"=>code_answer("save_successfully")]);

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }

}

public function loadEdit()
{

    $data = $this->model->promo_banners->find("id=?", [$_POST['id']]);

    return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('promo-banners/load-edit.tpl')]);

}

public function main()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/promo-banners.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_369c5894a00530143785ee61375995ea")=>$this->router->getRoute("dashboard-promo-banners")],"route_name"=>$this->router->currentRoute->name,"page_name"=>translate("tr_369c5894a00530143785ee61375995ea"),"page_icon"=>"ti-photo","favorite_status"=>true]]);

    return $this->view->preload('promo-banners/banners', ["data"=>(object)$data, "title"=>translate("tr_369c5894a00530143785ee61375995ea")]);

}



 }