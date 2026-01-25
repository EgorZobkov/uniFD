<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Http\Controllers\Dashboard;

 use App\Systems\Controller;

 class ReviewsController extends Controller
 {

 public function __construct($app){
 parent::__construct($app); 
 }

 public function confirm()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->component->reviews->changeStatus($_POST['id']);

    $this->session->setNotifyDashboard("success", code_answer("action_successfully"));

    return json_answer(["status"=>true]);

}

public function delete()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->component->reviews->delete($_POST['id']);

    $this->session->setNotifyDashboard("success", code_answer("delete_successfully"));

    return json_answer(["status"=>true]);

}

public function edit()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    $data = $this->model->reviews->find('id=?', [$_POST['id']]);

    if(!$data) return json_answer(["status"=>true, "type_answer"=>"error", "type_show"=>"notice", "answer"=>code_answer("record_not_found")]);

    if($this->validation->requiredField($_POST['text'])->status == false){
        $answer['text'] = $this->validation->error;
    }
 
    if(empty($answer)){

        $this->model->reviews->update(["text"=>$_POST['text']], $_POST['id']);

        return json_answer(["status"=>true, "answer"=>code_answer("save_successfully")]);

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }

}

public function loadCard()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }
    
    $data = $this->model->reviews->find("id=?", [$_POST['id']]);

    if($data->item_id){
        $data->ad = $this->component->ads->getAd($data->item_id);
    }

    $data->from_user = $this->model->users->findById($data->from_user_id);
    $data->whom_user = $this->model->users->findById($data->whom_user_id);

    $data->media = $data->media ? _json_decode($data->media) : null;

    return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('reviews/load-card.tpl')]);

}

public function loadEdit()
{

    $data = $this->model->reviews->find("id=?", [$_POST['id']]);

    return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('reviews/load-edit.tpl')]);

}

public function main()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/reviews.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_1c3fea01a64e56bd70c233491dd537aa")=>$this->router->getRoute("dashboard-reviews")],"route_name"=>$this->router->currentRoute->name,"page_name"=>translate("tr_1c3fea01a64e56bd70c233491dd537aa"),"page_icon"=>"ti-message","favorite_status"=>true]]);

    return $this->view->preload('reviews/reviews', ["data"=>(object)$data, "title"=>translate("tr_1c3fea01a64e56bd70c233491dd537aa")]);

}



 }