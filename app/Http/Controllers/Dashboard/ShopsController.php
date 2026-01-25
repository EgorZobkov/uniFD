<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Http\Controllers\Dashboard;

 use App\Systems\Controller;

 class ShopsController extends Controller
 {

 public function __construct($app){
 parent::__construct($app); 
 }

 public function changeStatus()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $data = $this->model->shops->find("id=?", [$_POST['id']]);

    $this->model->shops->update(["status"=>$_POST['status'], "comment"=>null],$_POST['id']);

    $this->event->changeStatusShop(["user_id"=>$data->user_id, "status"=>$_POST['status'], "shop_id"=>$_POST['id'], "shop_link"=>$this->component->shop->linkToShopCard($data->alias)]);

    $this->session->setNotifyDashboard('success', code_answer("action_successfully"));

    return json_answer(["status"=>true]);

}

public function delete()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->component->shop->delete($_POST['id']);

    $this->session->setNotifyDashboard('success', code_answer("delete_successfully"));

    return json_answer(["status"=>true]);

}

public function edit()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    $data = $this->model->shops->find('id=?', [$_POST['id']]);

    if(!$data) return json_answer(["status"=>true, "type_answer"=>"error", "type_show"=>"notice", "answer"=>code_answer("record_not_found")]);

    if($this->validation->requiredField($_POST['title'])->status == false){
        $answer['title'] = $this->validation->error;
    }

    $alias = slug($_POST['alias']);

    if($this->validation->requiredField($alias)->status == false){
        $answer['alias'] = $this->validation->error;
    }else{
        $check = $this->model->shops->find("alias=? and id!=?", [$alias,$_POST['id']]);
        if($check){
            $answer['alias'] = "Идентификатор уже используется";
        }            
    }
 
    if(empty($answer)){

        $this->model->shops->update(["title"=>$_POST['title'], "text"=>$_POST['text'], "alias"=>$alias, "category_id"=>(int)$_POST['category_id']], $_POST['id']);

        return json_answer(["status"=>true, "answer"=>code_answer("save_successfully")]);

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }

}

public function loadCard()
{   
    
    $data = $this->model->shops->find("id=?", [$_POST['id']]);

    $data->user = $this->model->users->findById($data->user_id);

    return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('shops/load-card.tpl')]);

}

public function loadEdit()
{

    $data = $this->model->shops->find("id=?", [$_POST['id']]);

    return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('shops/load-edit.tpl')]);

}

public function main()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/shops.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_cfb8af01cc910b08e8796e03cf662f5f")=>$this->router->getRoute("dashboard-shops")],"route_name"=>$this->router->currentRoute->name,"page_name"=>translate("tr_cfb8af01cc910b08e8796e03cf662f5f"),"page_icon"=>"ti-shopping-bag","favorite_status"=>true]]);

    return $this->view->preload('shops/shops', ["data"=>(object)$data, "title"=>translate("tr_cfb8af01cc910b08e8796e03cf662f5f")]);

}

public function saveCommentStatus()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    $data = $this->model->shops->find("id=?", [$_POST['id']]);

    if($this->validation->requiredField($_POST['reason_comment'])->status == false){
        $answer['reason_comment'] = $this->validation->error;
    }

    if(empty($answer)){

        $this->model->shops->update(["status"=>"rejected", "comment"=>$_POST['reason_comment']],$_POST['id']);

        $this->event->changeStatusShop(["user_id"=>$data->user_id, "status"=>"rejected", "text"=>$_POST['reason_comment'], "shop_id"=>$_POST['id'], "shop_link"=>$this->component->shop->linkToShopCard($data->alias)]);

        $this->session->setNotifyDashboard('success', code_answer("action_successfully"));

        return json_answer(["status"=>true]);

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }

}



 }