<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Http\Controllers\Dashboard;

 use App\Systems\Controller;

 class SeoController extends Controller
 {

 public function __construct($app){
 parent::__construct($app); 
 }

 public function addPage()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['alias'])->status == true){
        $find = $this->model->template_pages->find("alias=?", [$_POST['alias']]);
        if($find){
            $answer['alias'] = translate("tr_36103ff759652e3b17f5fb189a1173f7");
        }
    }

    $filename = md5(uniqid());

    if(empty($answer)){

        if(_file_put_contents($this->config->resource->view->web->path.'/'.$filename.'.tpl', $this->component->templates->defaultTplBody())){
            $insert_id = $this->model->template_pages->insert(["status"=>(int)$_POST['status'], "name"=>$_POST['name'], "template_name"=>$filename, 'alias'=>slug($_POST['alias'])]);
            return json_answer(["status"=>true, "redirect"=>$this->router->getRoute("dashboard-template-view-page", [$insert_id])]); 
        }else{
            return json_answer(["status"=>false, "type_show"=>"notice", "type_answer"=>"error", "answer"=>translate("tr_2465d68db9bbf3d1960c0262503e8a22")]); 
        }

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }

           
}

public function card($id)
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();

    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/seo.js\" type=\"module\" ></script>"]);

    $data = $this->model->template_pages->find("id=?", [$id]);

    if(!$data){
        abort(404);
    }

    if($_POST['iso']){
        $data->lang_iso = $_POST['iso'];
    }else{
        $data->lang_iso = $this->settings->default_language;
    }

    $data->content = $this->component->seo->getContent($id, $data->lang_iso);

    $this->view->setParamsComponent(["data"=>(object)$data, "breadcrumbs"=>["chain"=>[translate("tr_67a30d0847a390ae56549987bb2d469a")=>$this->router->getRoute("dashboard-seo")],"route_name"=>"dashboard-seo","page_name"=>translate("tr_67a30d0847a390ae56549987bb2d469a"),"page_icon"=>"ti-template","favorite_status"=>true]]);

    $this->view->setParamsPreload(["id"=>$id]);

    return $this->view->preload('seo/card', ["title"=>translate("tr_67a30d0847a390ae56549987bb2d469a"), "data"=>(object)$data]);

}

public function deletePage()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $find = $this->model->template_pages->find("id=?", [$_POST['id']]);

    if(!$find->freeze){
        _unlink($this->config->resource->view->web->path.'/'.$find->template_name.'.tpl');
        $this->model->template_pages->delete("id=?", [$_POST['id']]);
    }

    return json_answer(["status"=>true]);
           
}

public function editPage()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    $getPage = $this->model->template_pages->find('id=?', [$_POST['id']]);

    if(!$getPage) return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"notice", "answer"=>code_answer("record_not_found")]);

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['alias'])->status == true){
        $find = $this->model->template_pages->find("alias=? and id!=?", [$_POST['alias'],$_POST['id']]);
        if($find){
            $answer['alias'] = translate("tr_36103ff759652e3b17f5fb189a1173f7");
        }
    }

    if(empty($answer)){

        $this->model->template_pages->update(["status"=>(int)$_POST['status'], "name"=>$_POST['name'], 'alias'=>slug($_POST['alias'])], $_POST['id']);
        
        return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("action_successfully")]);

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }

           
}

public function main()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/seo.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_67a30d0847a390ae56549987bb2d469a")=>$this->router->getRoute("dashboard-seo")],"route_name"=>"dashboard-seo","page_name"=>translate("tr_67a30d0847a390ae56549987bb2d469a"),"page_icon"=>"ti-template","favorite_status"=>true]]);

    return $this->view->preload('seo/seo', ["title"=>translate("tr_67a30d0847a390ae56549987bb2d469a")]);

}

public function save()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    parse_str(urldecode($_POST['content']), $_POST);

    $data = $this->model->seo_content->find("page_id=?", [$_POST["id"]]);

    if($data){

        if(trim($data->content) && _json_decode($data->content)){
            $content = array_merge(_json_decode($data->content), $_POST['content']);
        }else{
            $content = $_POST['content'];
        }

        $this->model->seo_content->update(["content"=>_json_encode($content)], ["page_id=?", [$_POST['id']]]);
        
    }else{
        $this->model->seo_content->insert(["page_id"=>$_POST['id'], "content"=>_json_encode($_POST['content'])]);
    }

    return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("save_successfully")]);
    
}



 }