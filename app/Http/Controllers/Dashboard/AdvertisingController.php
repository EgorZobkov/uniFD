<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Http\Controllers\Dashboard;

 use App\Systems\Controller;

 class AdvertisingController extends Controller
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

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['type'])->status == false){
        $answer['type'] = $this->validation->error;
    }else{
        if($_POST['type'] == "banner"){
            if($this->validation->requiredField($_POST['manager_image'])->status == false){
                $answer['manager_image'] = $this->validation->error;
            }
            if($this->validation->requiredField($_POST['link'])->status == false){
                $answer['link'] = $this->validation->error;
            } 
        }elseif($_POST['type'] == "code"){
            if($this->validation->requiredField($_POST['code'])->status == false){
                $answer['code'] = $this->validation->error;
            }                
        }
    }

    if($_POST['time_start']){
        $time_start = $this->datetime->convert($_POST['time_start']);
    }else{
        $time_start = $this->datetime->getDate();
    }

    if($_POST['time_end']){
        $time_end = $this->datetime->convert($_POST['time_end']);
    }else{
        $time_end = null;
    }

    if($time_start && $time_end){
        if($time_start > $time_end){
            $answer['time_start'] = translate("tr_feb976fdbf742dd5e301f0d56316a94b");
        }elseif($time_end < $time_start){
            $answer['time_end'] = translate("tr_7a04a1ce0291bfbe0e527bc6f02fd143");
        }
    }

    if(!$_POST['lang_all']){
        $lang_iso = $_POST['lang_iso'] ?: null;
    }else{
        $lang_iso =  null;
    }

    if(!$_POST['geo_all']){
        $geo = $_POST['geo'] ? _json_encode($_POST['geo']) : null;
    }else{
        $geo = null;
    }

    if($_POST['category_all']){
        $_POST['category_id'] = 0;
    }

    if(empty($answer)){

        if(!$_POST['uniq_code']){
            $uniq_code = generateNumberCode(12);
        }else{
            $uniq_code = $_POST['uniq_code'];
        }
        
        $this->model->advertising->insert(["name"=>$_POST['name'], "image"=>$_POST['manager_image'] ?: null, "code"=>$_POST['code'] ?: null, "type"=>$_POST['type'], "status"=>(int)$_POST['status'], "uniq_code"=>$uniq_code, "time_start"=>$time_start, "time_end"=>$time_end, "link"=>$_POST['link'] ?: null, "lang_iso"=>$lang_iso, "geo"=>$geo, "position"=>$_POST['position'], "result_index"=>(int)$_POST['result_index'], "result_view"=>$_POST['result_view'],"category_id"=>(int)$_POST['category_id']]);

        $this->session->setNotifyDashboard('success', code_answer("add_successfully"));

        return json_answer(["status"=>true, "position"=>$_POST['position'], "answer"=>"{{ \$template->component->advertising->outByCode(".$uniq_code.") }}"]);

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }    

}

public function delete()
{
    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->component->advertising->delete($_POST['id']);

    $this->session->setNotifyDashboard('success', code_answer("delete_successfully"));

    return json_answer(["status"=>true]);
}

public function edit()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $data = $this->model->advertising->find('id=?', [$_POST['id']]);

    if(!$data) return json_answer(["status"=>false, "answer"=>code_answer("record_not_found")]);

    $answer = [];

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['type'])->status == false){
        $answer['type'] = $this->validation->error;
    }else{
        if($_POST['type'] == "banner"){
            if($this->validation->requiredField($_POST['manager_image'])->status == false){
                $answer['manager_image'] = $this->validation->error;
            }
            if($this->validation->requiredField($_POST['link'])->status == false){
                $answer['link'] = $this->validation->error;
            }
        }elseif($_POST['type'] == "code"){
            if($this->validation->requiredField(urldecode($_POST['code']))->status == false){
                $answer['code'] = $this->validation->error;
            }                
        }
    }

    if($_POST['time_start']){
        $time_start = $this->datetime->convert($_POST['time_start']);
    }else{
        $time_start = $this->datetime->getDate();
    }

    if($_POST['time_end']){
        $time_end = $this->datetime->convert($_POST['time_end']);
    }else{
        $time_end = null;
    }

    if($time_start && $time_end){
        if($time_start > $time_end){
            $answer['time_start'] = translate("tr_feb976fdbf742dd5e301f0d56316a94b");
        }elseif($time_end < $time_start){
            $answer['time_end'] = translate("tr_7a04a1ce0291bfbe0e527bc6f02fd143");
        }
    }

    if(!$_POST['lang_all']){
        $lang_iso = $_POST['lang_iso'] ?: null;
    }else{
        $lang_iso = null;
    }

    if(!$_POST['geo_all']){
        $geo = $_POST['geo'] ? _json_encode($_POST['geo']) : null;
    }else{
        $geo = null;
    }

    if($_POST['category_all']){
        $_POST['category_id'] = 0;
    }

    if(empty($answer)){

        $this->model->advertising->update(["name"=>$_POST['name'], "image"=>$_POST['manager_image'] ?: null, "code"=>$_POST['code'] ?: null, "type"=>$_POST['type'], "status"=>(int)$_POST['status'], "time_start"=>$time_start, "time_end"=>$time_end, "link"=>$_POST['link'] ?: null, "lang_iso"=>$lang_iso, "geo"=>$geo, "position"=>$_POST['position'], "result_index"=>(int)$_POST['result_index'], "result_view"=>$_POST['result_view'],"category_id"=>(int)$_POST['category_id']], $_POST['id']);

        return json_answer(["status"=>true, "type_answer"=>"success", "type_show"=>"notice", "answer"=>code_answer("save_successfully")]);

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }

}

public function geoSearch()
{   

    return $this->component->geo->advertisingSearchCombined($_POST['query']);

}

public function loadDataChartMonth(){

    return $this->component->advertising->getStatisticsTransitionsByMonthChart();

}

public function loadEdit()
{

    $data = $this->model->advertising->find("id=?", [$_POST['id']]);

    return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('advertising/load-edit.tpl')]);

}

public function main()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/advertising.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_becb26beb045da0432304943659c57b2")=>$this->router->getRoute("dashboard-advertising")],"route_name"=>$this->router->currentRoute->name,"page_name"=>translate("tr_becb26beb045da0432304943659c57b2"),"page_icon"=>"ti-ad","favorite_status"=>true]]);

    return $this->view->preload('advertising/advertising', ["title"=>translate("tr_becb26beb045da0432304943659c57b2")]);

}

public function sliderLoadAdd()
{

    $data = $this->model->advertising->find("id=?", [$_POST['id']]);

    return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('advertising/slider-load-add.tpl')]);

}



 }