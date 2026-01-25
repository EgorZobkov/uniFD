<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Http\Controllers\Dashboard;

 use App\Systems\Controller;

 class SearchController extends Controller
 {

 public function __construct($app){
 parent::__construct($app); 
 }

 public function keywordAdd()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $category_id = 0;
    $answer = [];
    $link = "";

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }

    if($_POST['goal_type'] == 1){

        if($this->validation->requiredField($_POST['link'])->status == false){
            $answer['link'] = $this->validation->error;
        }else{
            $link = trim(clearHostInURI($_POST['link']), "/");
        }        

    }elseif($_POST['goal_type'] == 2){

        if($this->validation->requiredField($_POST['category_id'])->status == false){
            $answer['category_id'] = $this->validation->error;
        }else{
            $category_id = $_POST['category_id'];
        }        

    }elseif($_POST['goal_type'] == 3){

        if($this->validation->requiredField($_POST['filter_link'])->status == false){
            $answer['filter_link'] = $this->validation->error;
        }else{

            if(strpos($_POST['filter_link'], "?") !== false){
                $params = explode("?", $_POST['filter_link']);
                $link = trim(str_replace("&amp;", "&", urldecode($params[1])), "/");
            }else{
                if(strpos($_POST['filter_link'], "filter") === false){
                    $answer['filter_link'] = translate("tr_1ec283fe025a82c2f23df24a964f48bb");
                }
            }

        }

        if($this->validation->requiredField($_POST['filter_category_id'])->status == false){
            $answer['filter_category_id'] = $this->validation->error;
        }else{
            $category_id = $_POST['filter_category_id'];
        }        

    }else{

        if($this->validation->requiredField($_POST['goal_type'])->status == false){
            $answer['goal_type'] = $this->validation->error;
        }        
        
    }

    if(empty($answer)){

        $this->model->search_keywords->insert(["name"=>$_POST['name'], "link"=>$link ?: null,"category_id"=>(int)$category_id, "tags"=>$_POST['tags'] ?: null, "geo_link_status"=>(int)$_POST['geo_link_status'], "goal_type"=>(int)$_POST['goal_type']]);

        $this->session->setNotifyDashboard('success', code_answer("add_successfully"));

        return json_answer(["status"=>true]);

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }    

}

public function keywordDelete()
{
    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->model->search_keywords->delete("id=?", [$_POST['id']]);

    $this->session->setNotifyDashboard('success', code_answer("delete_successfully"));

    return json_answer(["status"=>true]);
}

public function keywordEdit()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $data = $this->model->search_keywords->find('id=?', [$_POST['id']]);

    if(!$data) return json_answer(["status"=>false, "answer"=>code_answer("record_not_found")]);

    $category_id = 0;
    $answer = [];
    $link = "";

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }

    if($_POST['goal_type'] == 1){

        if($this->validation->requiredField($_POST['link'])->status == false){
            $answer['link'] = $this->validation->error;
        }else{
            $link = trim(clearHostInURI($_POST['link']), "/");
        }        

    }elseif($_POST['goal_type'] == 2){

        if($this->validation->requiredField($_POST['category_id'])->status == false){
            $answer['category_id'] = $this->validation->error;
        }else{
            $category_id = $_POST['category_id'];
        }        

    }elseif($_POST['goal_type'] == 3){

        if($this->validation->requiredField($_POST['filter_link'])->status == false){
            $answer['filter_link'] = $this->validation->error;
        }else{

            if(strpos($_POST['filter_link'], "?") !== false){
                $params = explode("?", $_POST['filter_link']);
                $link = trim(str_replace("&amp;", "&", urldecode($params[1])), "/");
            }else{
                if(strpos($_POST['filter_link'], "filter") === false){
                    $answer['filter_link'] = translate("tr_1ec283fe025a82c2f23df24a964f48bb");
                }
            }

        }

        if($this->validation->requiredField($_POST['filter_category_id'])->status == false){
            $answer['filter_category_id'] = $this->validation->error;
        }else{
            $category_id = $_POST['filter_category_id'];
        }        

    }else{

        if($this->validation->requiredField($_POST['goal_type'])->status == false){
            $answer['goal_type'] = $this->validation->error;
        }        

    }

    if(empty($answer)){

        $this->model->search_keywords->update(["name"=>$_POST['name'], "link"=>$link ?: null,"category_id"=>(int)$category_id, "tags"=>$_POST['tags'] ?: null, "geo_link_status"=>(int)$_POST['geo_link_status'], "goal_type"=>(int)$_POST['goal_type']], $_POST['id']);

        return json_answer(["status"=>true, "type_answer"=>"success", "type_show"=>"notice", "answer"=>code_answer("save_successfully")]);

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }

}

public function keywords()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/search.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_83dc72c7b853982cd4d3cbddf0254061")=>$this->router->getRoute("dashboard-search-keywords")],"route_name"=>$this->router->currentRoute->name,"page_name"=>translate("tr_83dc72c7b853982cd4d3cbddf0254061"),"page_icon"=>"ti-search","favorite_status"=>true]]);

    return $this->view->preload('search/keywords', ["title"=>translate("tr_83dc72c7b853982cd4d3cbddf0254061")]);

}

public function loadEditKeyword()
{

    $data = $this->model->search_keywords->find("id=?", [$_POST['id']]);

    return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('search/load-edit-keyword.tpl')]);

}

public function requests()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/search.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_8c30814d7386c118467c16883720ba89")=>$this->router->getRoute("dashboard-search-requests")],"route_name"=>$this->router->currentRoute->name,"page_name"=>translate("tr_8c30814d7386c118467c16883720ba89"),"page_icon"=>"ti-search","favorite_status"=>true]]);

    return $this->view->preload('search/requests', ["title"=>translate("tr_8c30814d7386c118467c16883720ba89")]);

}

public function requestsClear()
{
    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->model->search_requests->truncate();

    $this->session->setNotifyDashboard('success', code_answer("delete_successfully"));

    return json_answer(["status"=>true]);
}



 }