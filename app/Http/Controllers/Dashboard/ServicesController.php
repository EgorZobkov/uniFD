<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Http\Controllers\Dashboard;

 use App\Systems\Controller;

 class ServicesController extends Controller
 {

 public function __construct($app){
 parent::__construct($app); 
 }

 public function addTariff(){

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['text'])->status == false){
        $answer['text'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['price'])->status == false){
        $answer['price'] = $this->validation->error;
    }

    if($this->validation->requiredFieldArray($_POST['items'])->status == false){
        $answer['items'] = $this->validation->error;
    }

    if($_POST['old_price']){
        if($_POST['old_price'] < $_POST['price']){
            $_POST['old_price'] = 0;
        }
    }

    if($_POST["count_day_fixed"]){
        if($this->validation->requiredField($_POST['count_day'])->status == false){
            $answer['count_day'] = $this->validation->error;
        }
    }

    if(empty($answer)){

        $this->model->users_tariffs->insert(["status"=>(int)$_POST["status"], "image"=>$_POST["manager_image"] ?: null, "name"=>$_POST["name"], "text"=>$_POST["text"], "price"=>$_POST["price"], "old_price"=>$_POST["old_price"], "count_day"=>$_POST["count_day"], "count_day_fixed"=>(int)$_POST["count_day_fixed"], "recommended"=>(int)$_POST["recommended"], "items_id"=>$_POST["items"] ? _json_encode($_POST["items"]) : null, "onetime"=>(int)$_POST["onetime"]]);
        
        return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("add_successfully")]);

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }

}

public function deleteTariff(){

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->model->users_tariffs->delete("id=?", [$_POST['id']]);

    $this->session->setNotifyDashboard('success', code_answer("delete_successfully"));

    return json_answer(["status"=>true]);

}

public function editService(){

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    $get = $this->model->ads_services->find('id=?', [$_POST['id']]);

    if(!$get) return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"notice", "answer"=>code_answer("record_not_found")]);

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['text'])->status == false){
        $answer['text'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['price'])->status == false){
        $answer['price'] = $this->validation->error;
    }

    if($_POST['old_price']){
        if($_POST['old_price'] < $_POST['price']){
            $_POST['old_price'] = 0;
        }
    }

    if($_POST["count_day_fixed"]){
        if($this->validation->requiredField($_POST['count_day'])->status == false){
            $answer['count_day'] = $this->validation->error;
        }
    }

    if(empty($answer)){

        $this->model->ads_services->update(["status"=>(int)$_POST["status"], "image"=>$_POST["manager_image"] ?: null, "name"=>$_POST["name"], "text"=>$_POST["text"], "price"=>$_POST["price"], "old_price"=>$_POST["old_price"], "count_day"=>$_POST["count_day"], "count_day_fixed"=>$_POST["count_day_fixed"], "recommended"=>(int)$_POST["recommended"]], (int)$_POST['id']);
        
        return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("save_successfully")]);

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }

}

public function editTariff(){

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    $get = $this->model->users_tariffs->find('id=?', [$_POST['id']]);

    if(!$get) return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"notice", "answer"=>code_answer("record_not_found")]);

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['text'])->status == false){
        $answer['text'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['price'])->status == false){
        $answer['price'] = $this->validation->error;
    }

    if($this->validation->requiredFieldArray($_POST['items'])->status == false){
        $answer['items'] = $this->validation->error;
    }

    if($_POST['old_price']){
        if($_POST['old_price'] < $_POST['price']){
            $_POST['old_price'] = 0;
        }
    }

    if($_POST["count_day_fixed"]){
        if($this->validation->requiredField($_POST['count_day'])->status == false){
            $answer['count_day'] = $this->validation->error;
        }
    }

    if(empty($answer)){

        $this->model->users_tariffs->update(["status"=>(int)$_POST["status"], "image"=>$_POST["manager_image"] ?: null, "name"=>$_POST["name"], "text"=>$_POST["text"], "price"=>$_POST["price"], "old_price"=>$_POST["old_price"], "count_day"=>$_POST["count_day"], "count_day_fixed"=>(int)$_POST["count_day_fixed"], "recommended"=>(int)$_POST["recommended"], "items_id"=>$_POST["items"] ? _json_encode($_POST["items"]) : null, "onetime"=>(int)$_POST["onetime"]], (int)$_POST['id']);
        
        return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("save_successfully")]);

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }

}

public function editTariffItems(){

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    if($_POST['tariff_items']){

        foreach ($_POST['tariff_items'] as $id => $value) {
            
            $this->model->users_tariffs_items->update(["name"=>$value["name"], "text"=>$value["text"]], $id);

        }

    }

    $this->session->setNotifyDashboard('success', code_answer("action_successfully"));

    return json_answer(["status"=>true]);

}

public function loadDataChartMonth(){

    return $this->component->ad_paid_services->getStatisticsServicesByMonthChart();

}

public function loadDataChartMonthTariffs(){

    return $this->component->service_tariffs->getStatisticsTariffsByMonthChart();

}

public function loadEditService(){

    $data = $this->model->ads_services->find("id=?", [$_POST['id']]);

    return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('services/load-edit.tpl')]);

}

public function loadEditTariff(){

    $data = $this->model->users_tariffs->find("id=?", [$_POST['id']]);

    return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('services/load-edit-tariff.tpl')]);

}

public function main(){

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/services.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_f8719e3fdc6916a0d389c645f4a7d0bb")=>$this->router->getRoute("dashboard-services")],"route_name"=>"dashboard-services","page_name"=>translate("tr_f8719e3fdc6916a0d389c645f4a7d0bb"),"page_icon"=>"ti-cash","favorite_status"=>true]]);

    return $this->view->preload('services/services', ["title"=>translate("tr_f8719e3fdc6916a0d389c645f4a7d0bb")]);

}

public function servicesSorting(){

    if($_POST["ids"]){
        foreach (explode(",", $_POST["ids"]) as $key => $id) {
            $this->model->ads_services->cacheKey(["id"=>$id])->update(["sorting"=>$key], $id);
        }
    }

    return json_answer(["status"=>true]);

}

public function tariffs(){

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/services.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_a49106cadab8ae1ff6a37e7ccea9c665")=>$this->router->getRoute("dashboard-services-tariffs")],"route_name"=>"dashboard-services-tariffs","page_name"=>translate("tr_a49106cadab8ae1ff6a37e7ccea9c665"),"page_icon"=>"ti-brand-cashapp","favorite_status"=>true]]);

    return $this->view->preload('services/tariffs', ["title"=>translate("tr_a49106cadab8ae1ff6a37e7ccea9c665")]);

}

public function tariffsSorting(){

    if($_POST["ids"]){
        foreach (explode(",", $_POST["ids"]) as $key => $id) {
            $this->model->users_tariffs->cacheKey(["id"=>$id])->update(["sorting"=>$key], $id);
        }
    }

    return json_answer(["status"=>true]);

}



 }