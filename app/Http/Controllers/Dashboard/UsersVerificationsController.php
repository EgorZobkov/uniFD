<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Http\Controllers\Dashboard;

 use App\Systems\Controller;

 class UsersVerificationsController extends Controller
 {

 public function __construct($app){
 parent::__construct($app); 
 }

 public function changeStatus()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $data = $this->model->users_verifications->find("id=?", [$_POST['id']]);

    $user = $this->model->users->find("id=?", [$data->user_id]);

    if(!$user) return json_answer(["status"=>true, "type_answer"=>"error", "type_show"=>"notice", "answer"=>code_answer("record_not_found")]);

    $this->model->users_verifications->update(["status"=>$_POST['status'], "comment"=>null],$_POST['id']);

    if($_POST['status'] == "verified"){
        $this->model->users->update(["verification_status"=>1],$data->user_id);
        $this->storage->clearAttachFiles(_json_decode($data->media));
    }else{
        $this->model->users->update(["verification_status"=>0],$data->user_id);
    }

    $this->event->changeStatusUserVerification(["user_id"=>$data->user_id, "status"=>$_POST['status']]);

    $this->session->setNotifyDashboard('success', code_answer("action_successfully"));

    return json_answer(["status"=>true]);

}

public function delete()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $data = $this->model->users_verifications->find("id=?", [$_POST['id']]);

    $this->storage->clearAttachFiles(_json_decode($data->media));

    $this->model->users_verifications->delete("id=?", [$_POST['id']]);

    $this->session->setNotifyDashboard('success', code_answer("delete_successfully"));

    return json_answer(["status"=>true]);

}

public function loadCard()
{   

    if(!$this->user->verificationAccess('view')->status){
        return json_answer(["access"=>false]);
    }
    
    $data = $this->model->users_verifications->find("id=?", [$_POST['id']]);

    $data->user = $this->model->users->findById($data->user_id);

    return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('users-verifications/load-card.tpl')]);

}

public function main()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/users-verifications.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_8ecdca2684eeafef74b7def14baa0a69")=>$this->router->getRoute("dashboard-users-verifications")],"route_name"=>$this->router->currentRoute->name,"page_name"=>translate("tr_8ecdca2684eeafef74b7def14baa0a69"),"page_icon"=>"ti-alert-triangle","favorite_status"=>true]]);

    return $this->view->preload('users-verifications/verifications', ["data"=>(object)$data, "title"=>translate("tr_8ecdca2684eeafef74b7def14baa0a69")]);

}

public function saveCommentStatus()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    $data = $this->model->users_verifications->find("id=?", [$_POST['id']]);

    $user = $this->model->users->find("id=?", [$data->user_id]);

    if(!$user) return json_answer(["status"=>true, "type_answer"=>"error", "type_show"=>"notice", "answer"=>code_answer("record_not_found")]);

    if($this->validation->requiredField($_POST['reason_comment'])->status == false){
        $answer['reason_comment'] = $this->validation->error;
    }

    if(empty($answer)){

        $this->model->users_verifications->update(["status"=>"rejected", "comment"=>$_POST['reason_comment']],$_POST['id']);

        $this->model->users->update(["verification_status"=>0],$data->user_id);

        $this->storage->clearAttachFiles(_json_decode($data->media));

        $this->event->changeStatusUserVerification(["user_id"=>$data->user_id, "status"=>"rejected", "text"=>$_POST['reason_comment']]);

        $this->session->setNotifyDashboard('success', code_answer("action_successfully"));

        return json_answer(["status"=>true]);

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }

}



 }