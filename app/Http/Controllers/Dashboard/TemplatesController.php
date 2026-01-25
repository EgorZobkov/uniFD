<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Http\Controllers\Dashboard;

 use App\Systems\Controller;

 class TemplatesController extends Controller
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
    }else{
        $_POST['alias'] = $_POST['name'];
    }

    $filename = md5(uniqid());

    if(empty($answer)){

        if(_file_put_contents($this->config->resource->view->web->path.'/'.$filename.'.tpl', $this->component->templates->defaultTplBody())){
            $insert_id = $this->model->template_pages->insert(["status"=>(int)$_POST['status'], "name"=>$_POST['name'], "template_name"=>$filename, 'alias'=>slug($_POST['alias']), "edit_status"=>1]);
            $this->model->seo_content->insert(["page_id"=>$insert_id]);
            return json_answer(["status"=>true, "redirect"=>$this->router->getRoute("dashboard-template-view-page", [$insert_id])]); 
        }else{
            return json_answer(["status"=>false, "type_show"=>"notice", "type_answer"=>"error", "answer"=>translate("tr_2465d68db9bbf3d1960c0262503e8a22")]); 
        }

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }

           
}

public function css()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/templates.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_74ff549c01bf978d89857d678258a717")=>$this->router->getRoute("dashboard-templates")],"route_name"=>"dashboard-templates","page_name"=>translate("tr_74ff549c01bf978d89857d678258a717")]]);

    return $this->view->preload('templates/css', ["title"=>translate("tr_74ff549c01bf978d89857d678258a717")]);

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
        $this->model->seo_content->delete("page_id=?", [$_POST['id']]);
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
    }else{
        $_POST['alias'] = $_POST['name'];
    }

    if(empty($answer)){

        $this->model->template_pages->update(["status"=>(int)$_POST['status'], "name"=>$_POST['name'], 'alias'=>slug($_POST['alias'])], (int)$_POST['id']);
        
        return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("save_successfully")]);

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }

           
}

public function js()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/templates.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_74ff549c01bf978d89857d678258a717")=>$this->router->getRoute("dashboard-templates")],"route_name"=>"dashboard-templates","page_name"=>translate("tr_74ff549c01bf978d89857d678258a717")]]);

    return $this->view->preload('templates/js', ["title"=>translate("tr_74ff549c01bf978d89857d678258a717")]);

}

public function loadEditPage()
{

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $data = $this->model->template_pages->find("id=?", [$_POST['id']]);

    return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('templates/load-edit-page.tpl')]);

}

public function main()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/templates.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_74ff549c01bf978d89857d678258a717")=>$this->router->getRoute("dashboard-templates")],"route_name"=>"dashboard-templates","page_name"=>translate("tr_74ff549c01bf978d89857d678258a717"),"page_icon"=>"ti-template","favorite_status"=>true]]);

    return $this->view->preload('templates/pages', ["title"=>translate("tr_74ff549c01bf978d89857d678258a717")]);

}

public function save()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    if($this->settings->testdrive){
        return json_answer(["status"=>false, "type_show"=>"notice", "type_answer"=>"error", "answer"=>"В тестовом режиме редактирование ограничено"]);
    }

    $template_body = htmlspecialchars_decode(urldecode($_POST["template_body"]));

    if($_POST["section"] == "page"){

        if($_POST["id"]){
            $getTpl = $this->model->template_pages->find("id=?", [$_POST["id"]]);
            if($getTpl){
                if(_file_put_contents($this->config->resource->view->web->path.'/'.$getTpl->template_name.'.tpl', $this->clean->phpCode($template_body))){
                    return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("save_successfully")]); 
                }else{
                    return json_answer(["status"=>false, "type_show"=>"notice", "type_answer"=>"error", "answer"=>translate("tr_fbd01e115e08ce45beb48a3748012392")]); 
                }
            }
        }

    }elseif($_POST["section"] == "css"){
        
        if(file_exists($this->config->resource->assets->web->css.'/'.$_POST["name"].'.css')){
            if(_file_put_contents($this->config->resource->assets->web->css.'/'.$_POST["name"].'.css', $this->clean->phpCode($template_body))){
                return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("save_successfully")]); 
            }else{
                return json_answer(["status"=>false, "type_show"=>"notice", "type_answer"=>"error", "answer"=>translate("tr_434b7d95a4183a81265ad3e3a6567bcc")]); 
            }
        }else{
            return json_answer(["status"=>false, "type_show"=>"notice", "type_answer"=>"error", "answer"=>translate("tr_2d46f36e5b6490dbc8b78f6e8dd5f122")." ".$_POST["name"].".css".translate("tr_5075a7c6c714a179a8f066d2c372e48f")]);
        }

    }elseif($_POST["section"] == "js"){
        
        if(file_exists($this->config->resource->assets->web->js.'/'.$_POST["name"].'.js')){
            if(_file_put_contents($this->config->resource->assets->web->js.'/'.$_POST["name"].'.js', $this->clean->phpCode($template_body))){
                return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("save_successfully")]); 
            }else{
                return json_answer(["status"=>false, "type_show"=>"notice", "type_answer"=>"error", "answer"=>translate("tr_ba4c89b48eb1b266a4709a1a3bff4503")]); 
            }
        }else{
            return json_answer(["status"=>false, "type_show"=>"notice", "type_answer"=>"error", "answer"=>translate("tr_2d46f36e5b6490dbc8b78f6e8dd5f122")." ".$_POST["name"].".css".translate("tr_5075a7c6c714a179a8f066d2c372e48f")]);
        }

    }
    
}

public function viewCss($template_name)
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerCss(["view"=>"dashboard", "name"=>"<link rel=\"stylesheet\" href=\"{assets_path}/vendors/codemirror/codemirror.css\" />"]);
    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/vendors/codemirror/codemirror.js\" ></script>"]);
    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/templates.js\" type=\"module\" ></script>"]);

    if(!$this->component->templates->fileExists($template_name, "css")){
        abort(404);
    }

    $data = (object)[];

    $data->template_name = $template_name;
    $data->content = $this->component->templates->include($template_name, "css");
    $data->filepath = getRelativePath($this->config->resource->assets->web->css.'/'.$template_name.'.css');
    $data->filename = $template_name.'.css';

    $this->view->setParamsComponent(["data"=>(object)$data, "breadcrumbs"=>["chain"=>[translate("tr_74ff549c01bf978d89857d678258a717")=>$this->router->getRoute("dashboard-templates"), $template_name=>null],"route_name"=>"dashboard-templates","page_name"=>translate("tr_74ff549c01bf978d89857d678258a717")]]);

    return $this->view->preload('templates/view-css', ["title"=>translate("tr_74ff549c01bf978d89857d678258a717"),"data"=>(object)$data]);

}

public function viewJs($template_name)
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerCss(["view"=>"dashboard", "name"=>"<link rel=\"stylesheet\" href=\"{assets_path}/vendors/codemirror/codemirror.css\" />"]);
    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/vendors/codemirror/codemirror.js\" ></script>"]);
    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/templates.js\" type=\"module\" ></script>"]);

    if(!$this->component->templates->fileExists($template_name, "js")){
        abort(404);
    }

    $data = (object)[];

    $data->template_name = $template_name;
    $data->content = $this->component->templates->include($template_name, "js");
    $data->filepath = getRelativePath($this->config->resource->assets->web->js.'/'.$template_name.'.js');
    $data->filename = $template_name.'.js';

    $this->view->setParamsComponent(["data"=>(object)$data, "breadcrumbs"=>["chain"=>[translate("tr_74ff549c01bf978d89857d678258a717")=>$this->router->getRoute("dashboard-templates"), $template_name=>null],"route_name"=>"dashboard-templates","page_name"=>translate("tr_74ff549c01bf978d89857d678258a717")]]);

    return $this->view->preload('templates/view-js', ["title"=>translate("tr_74ff549c01bf978d89857d678258a717"),"data"=>(object)$data]);

}

public function viewPage($id)
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerCss(["view"=>"dashboard", "name"=>"<link rel=\"stylesheet\" href=\"{assets_path}/vendors/codemirror/codemirror.css\" />"]);
    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/vendors/codemirror/codemirror.js\" ></script>"]);
    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/templates.js\" type=\"module\" ></script>"]);

    $data = (object)[];

    $data = $this->model->template_pages->find("id=?", [$id]); 

    if(!$data || !$this->component->templates->fileExists($data->template_name, "pages")){
        abort(404);
    }

    $data->content = $this->component->templates->include($data->template_name, "pages");
    $data->filepath = getRelativePath($this->config->resource->view->web->path.'/'.$data->template_name.'.tpl');
    $data->filename = $data->template_name.'.tpl';

    if($data->alias){
        $data->link = $data->freeze == 0 ? getHost(true) . '/' . $data->alias : null;
    }else{
        $data->link = null;
    }

    $this->view->setParamsComponent(["data"=>(object)$data, "breadcrumbs"=>["chain"=>[translate("tr_74ff549c01bf978d89857d678258a717")=>$this->router->getRoute("dashboard-templates"), translateField($data->name)=>null],"route_name"=>"dashboard-templates","page_name"=>translate("tr_74ff549c01bf978d89857d678258a717")]]);

    return $this->view->preload('templates/view-page', ["title"=>translate("tr_74ff549c01bf978d89857d678258a717"),"data"=>(object)$data]);

}



 }