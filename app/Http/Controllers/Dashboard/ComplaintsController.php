<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Http\Controllers\Dashboard;

 use App\Systems\Controller;

 class ComplaintsController extends Controller
 {

 public function __construct($app){
 parent::__construct($app); 
 }

 public function confirm()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->model->complaints->update(["status"=>1],$_POST['id']);

    $this->session->setNotifyDashboard("success", code_answer("action_successfully"));

    return json_answer(["status"=>true]);

}

public function delete()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->model->complaints->delete("id=?", [$_POST['id']]);

    $this->session->setNotifyDashboard("success", code_answer("delete_successfully"));

    return json_answer(["status"=>true]);

}

public function loadCard()
{   

    if(!$this->user->verificationAccess('view')->status){
        return json_answer(["access"=>false]);
    }
    
    $data = $this->model->complaints->find("id=?", [$_POST['id']]);

    if($data->item_id){
        $data->ad = $this->component->ads->getAd($data->item_id);
    }

    $data->from_user = $this->model->users->findById($data->from_user_id);
    $data->whom_user = $this->model->users->findById($data->whom_user_id);

    return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('complaints/load-card.tpl')]);

}

public function main()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/complaints.js\" type=\"module\" ></script>"]);
    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/board/ads.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_0a60111d2b41f343bed6a257a4c13d0d")=>$this->router->getRoute("dashboard-complaints")],"route_name"=>$this->router->currentRoute->name,"page_name"=>translate("tr_0a60111d2b41f343bed6a257a4c13d0d"),"page_icon"=>"ti-alert-triangle","favorite_status"=>true]]);

    return $this->view->preload('complaints/complaints', ["data"=>(object)$data, "title"=>translate("tr_0a60111d2b41f343bed6a257a4c13d0d")]);

}



 }