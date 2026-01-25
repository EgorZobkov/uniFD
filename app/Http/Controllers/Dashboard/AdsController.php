<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Http\Controllers\Dashboard;

 use App\Systems\Controller;

 class AdsController extends Controller
 {

 public function __construct($app){
 parent::__construct($app); 
 }

 public function approve()
{
    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->component->ads->approve($_POST['id']);

    $this->session->setNotifyDashboard('success', translate("tr_2133642cd2cd569e5d5e3961d52d5750"));

    return json_answer(["status"=>true]);
}

public function changeMultiStatus()
{
    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->component->ads->changeMultiStatus($_POST['ids_selected'],$_POST['status']);

    $this->session->setNotifyDashboard('success', translate("tr_2133642cd2cd569e5d5e3961d52d5750"));

    return json_answer(["status"=>true]);
}

public function changeStatus()
{
    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->component->ads->changeStatus($_POST['id'],$_POST['status']);

    $this->session->setNotifyDashboard('success', translate("tr_2133642cd2cd569e5d5e3961d52d5750"));

    return json_answer(["status"=>true]);
}

public function delete()
{
    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->component->ads->delete($_POST['id']);

    $this->session->setNotifyDashboard('success', translate("tr_6f9811271936b72e0d9c1f08d2dca0f4"));

    return json_answer(["status"=>true]);
}

public function loadCard()
{

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }
    
    $data = $this->component->ads->getAd($_POST['id']);
    return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('board/ads/load-card.tpl')]);
}

public function loadDataChartMonth()
{

    return $this->component->ads->getStatisticsAdsByMonthChart();

}

public function main()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/ads.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_083ab3d9a9221cf6a1641c2c7c5f0d3c")=>$this->router->getRoute("dashboard-ads")],"route_name"=>$this->router->currentRoute->name,"page_name"=>translate("tr_083ab3d9a9221cf6a1641c2c7c5f0d3c"),"page_icon"=>"ti-barcode","favorite_status"=>true]]);

    return $this->view->preload('board/ads', ["title"=>translate("tr_083ab3d9a9221cf6a1641c2c7c5f0d3c")]);

}

public function multiDelete()
{
    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->component->ads->deleteMulti($_POST['ids_selected']);

    $this->session->setNotifyDashboard('success', translate("tr_6f9811271936b72e0d9c1f08d2dca0f4"));

    return json_answer(["status"=>true]);
}

public function multiExtend()
{
    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->component->ads->extendMulti($_POST['ids_selected']);

    $this->session->setNotifyDashboard('success', translate("tr_16491016e0261108a14a0c1810e73c8c"));

    return json_answer(["status"=>true]);
}

public function saveCommentStatus()
{
    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];
    $reason_code = $_POST['reason_code'];

    if($this->validation->requiredField($_POST['reason_code'])->status == false){
        $answer['reason_code'] = $this->validation->error;
    }else{
        if($reason_code == "other"){
            if($this->validation->requiredField($_POST['reason_comment'])->status == false){
                $answer['reason_comment'] = $this->validation->error;
            }
        }
    }

    if(empty($answer)){

        if($reason_code == "other"){
            $reason_code = $this->system->addReasonBlocking($_POST['reason_comment']);
        }

        $this->component->ads->changeStatus($_POST['id'],$_POST['status'],$reason_code,$_POST['block_forever_status']);

        $this->session->setNotifyDashboard('success', translate("tr_2133642cd2cd569e5d5e3961d52d5750"));

        return json_answer(["status"=>true]);

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    } 

}



 }