<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Http\Controllers\Dashboard;

 use App\Systems\Controller;

 class StoriesController extends Controller
 {

 public function __construct($app){
 parent::__construct($app); 
 }

 public function changeStatus()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->component->stories->changeStatus($this->request->get('id'));

    $this->session->setNotifyDashboard('success', code_answer("action_successfully"));

    return json_answer(["status"=>true]);

}

public function delete()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->component->stories->delete($this->request->get('id'));

    $this->session->setNotifyDashboard('success', code_answer("delete_successfully"));

    return json_answer(["status"=>true]);

}

public function loadStory()
{   

    $result = $this->component->stories->loadInDashboard($this->request->get('id'));
    return json_answer(["content"=>$result]);

}

public function main()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/stories.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_b84af1c46baa36df4513d427a6e0715a")=>$this->router->getRoute("dashboard-stories")],"route_name"=>$this->router->currentRoute->name,"page_name"=>translate("tr_b84af1c46baa36df4513d427a6e0715a"),"page_icon"=>"ti-movie","favorite_status"=>true]]);

    return $this->view->preload('stories/stories', ["data"=>(object)$data, "title"=>translate("tr_b84af1c46baa36df4513d427a6e0715a")]);

}



 }