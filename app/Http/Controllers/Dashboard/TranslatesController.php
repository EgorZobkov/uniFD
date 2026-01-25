<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Http\Controllers\Dashboard;

 use App\Systems\Controller;

 class TranslatesController extends Controller
 {

 public function __construct($app){
 parent::__construct($app); 
 }

 public function addLanguage()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['iso'])->status == false){
        $answer['iso'] = $this->validation->error;
    }else{
        $check = $this->model->languages->find("iso=?", [$_POST['iso']]);
        if($check){
            $answer['iso'] = translate("tr_121989c6f00cf39786cde16b709f5d00");
        }            
    }

    if($this->validation->requiredField($_POST['locale'])->status == false){
        $answer['locale'] = $this->validation->error;
    }

    if(empty($answer)){

        if(_mkdir($this->config->storage->translations . '/' . $_POST['iso'], 0777)){

            if(_file_put_contents($this->config->storage->translations . '/' . $_POST['iso'] . '/content.tr', _file_get_contents($this->config->storage->translations . '/default.tr')) && _file_put_contents($this->config->storage->translations . '/' . $_POST['iso'] . '/js.tr', _file_get_contents($this->config->storage->translations . '/js.tr')) && _file_put_contents($this->config->storage->translations . '/' . $_POST['iso'] . '/app.tr', _file_get_contents($this->config->storage->translations . '/app.tr'))){

                $this->model->languages->insert(["name"=>$_POST['name'], "iso"=>$_POST['iso'], "locale"=>$_POST['locale'], "image"=>$_POST["manager_image"] ?: null, "status"=>(int)$_POST['status']]);

                $this->component->translate->insertColumnTables($_POST['iso']);

                $this->session->setNotifyDashboard('success', code_answer("add_successfully"));
                return json_answer(["status"=>true]);

            }else{

                return json_answer(["status"=>false, "type_show"=>"notice", "type_answer"=>"error", "answer"=>translate("tr_0e8dbf20de9a97f7fbf4abf591daf382") . " storage/translations/" . $_POST['iso']]);

            }

        }else{
            return json_answer(["status"=>false, "type_show"=>"notice", "type_answer"=>"error", "answer"=>translate("tr_31ff0706c2c6111d99bf20d5a2422125") . " storage/translations"]);
        }

        

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }    

}

public function deleteLanguage()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $data = $this->model->languages->find('id=?', [$_POST['id']]);

    if($data->iso){
    
        deleteFolder($this->config->storage->translations.'/'.$data->iso, "*.tr");

        $this->model->languages->delete("id=?", [$_POST['id']]);

        $this->component->translate->deleteColumnTables($data->iso);

    }

    $this->session->setNotifyDashboard('success', code_answer("delete_successfully"));

    return json_answer(["status"=>true]);

}

public function editContent()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $data = urldecode($_POST["data"]);

    parse_str(htmlspecialchars_decode($data), $data);

    $this->component->translate->editContent($data['content'], $data['iso'], $data['view']);

    return json_answer(["status"=>true, "type_answer"=>"success", "type_show"=>"notice", "answer"=>code_answer("save_successfully")]);

}

public function editLanguage()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    $data = $this->model->languages->find('id=?', [$_POST['id']]);

    if(!$data) return json_answer(["status"=>true, "type_answer"=>"error", "type_show"=>"notice", "answer"=>code_answer("record_not_found")]);

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['locale'])->status == false){
        $answer['locale'] = $this->validation->error;
    }

    if(empty($answer)){

        $this->model->languages->update(["name"=>$_POST['name'], "locale"=>$_POST['locale'], "image"=>$_POST["manager_image"] ?: null, "status"=>(int)$_POST['status']], $_POST['id']);

        return json_answer(["status"=>true, "type_answer"=>"success", "type_show"=>"notice", "answer"=>code_answer("save_successfully")]);

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }    

}

public function loadEditLanguage()
{

    if(!$this->user->verificationAccess('view')->status){
        return json_answer(["access"=>false]);
    }

    $data = $this->model->languages->find("id=?", [$_POST['id']]);

    return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('translates/load-edit-language.tpl')]);

}

public function main()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/translates.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_02352af147a444a4418aff32b5e6cc41")=>$this->router->getRoute("dashboard-translates")],"route_name"=>$this->router->currentRoute->name,"page_name"=>translate("tr_02352af147a444a4418aff32b5e6cc41"),"page_icon"=>"ti-language","favorite_status"=>true]]);

    $this->view->setParamsPreload(["iso"=>$_GET["iso"]]);

    return $this->view->preload('translates/translates', ["title"=>translate("tr_02352af147a444a4418aff32b5e6cc41")]);

}

public function updateContent()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = '';

    $this->translate->updateTables();
    $result = $this->translate->updateContent();
    
    $answer = translate("tr_3730f24523f306465f053d44d1c5dadd") . ' ' . $result["added"] . ', ' . translate("tr_49aa33d713bc42ce830521c598405b97") . ' ' . $result["errors"]."\n";

    if($result["errors_answer"]){
        foreach ($result["errors_answer"] as $value) {
            $answer .= translate("tr_9942c0ae6ea91f45c97d8b56e76c5764").' '.$value."\n";
        }
    }
    
    return json_answer(["status"=>true, "answer"=>$answer]);

}



 }