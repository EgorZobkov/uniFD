<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Http\Controllers\Dashboard;

 use App\Systems\Controller;

 class ImportExportController extends Controller
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
    $resultUpload = [];
    $filename = "";

    if($this->validation->isUserName($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['action'])->status == false){
        $answer['action'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['table'])->status == false){
        $answer['table'] = $this->validation->error;
    }

    if($_POST['action'] == "import"){

        if($this->validation->requiredField($_POST['source'])->status == false){
            $answer['source'] = $this->validation->error;
        }else{
            if($_POST['source'] == "link"){
                if($this->validation->requiredField($_POST['link_file'])->status == false){
                    $answer['link_file'] = $this->validation->error;
                }else{
                    if(!_file_get_contents($_POST['link_file'])){
                        $answer['link_file'] = translate("tr_44d131d7f690cf69de83ec59f7e1f9cd");
                    }
                }
                if($this->validation->requiredField($_POST['link_file_format'])->status == false){
                    $answer['link_file_format'] = $this->validation->error;
                }
            }elseif($_POST['source'] == "file"){
                if($this->validation->required(true)->setExt(['xlsx', 'csv'])->isFile($_FILES['file'])->status == false){
                    $answer['file'] = $this->validation->error;
                }
            }
        }

    }elseif($_POST['action'] == "export"){

        if($this->validation->requiredField($_POST['export_format'])->status == false){
            $answer['export_format'] = $this->validation->error;
        }

    }

    if(empty($answer)){

        if($_POST['action'] == "import"){
            if($_POST['source'] == "file"){
                $resultUpload = $this->storage->files($_FILES['file'])->type('file')->path('files-import-export')->extList(['xlsx', 'csv'])->upload();
                if(!$resultUpload){
                    return json_answer(["status"=>false, "type_show"=>"alert", "type_answer"=>"warning", "answer"=>translate("tr_6b0c7b766f6ccb046389ed29c9dfe1e3")." ".$this->config->storage->files_import_export]);
                }
                $filename = $resultUpload['name'];
            }elseif($_POST['source'] == "link"){
                $filename = md5(time().'-'.uniqid()).'.'.$_POST['link_file_format'];
                $data = _file_get_contents($_POST['link_file']);
                _file_put_contents($this->config->storage->files_import_export . '/' . $filename, $data);
            }
        }elseif($_POST['action'] == "export"){
            $filename = 'export_'.$_POST['table'].'_'.md5(time().'-'.uniqid()).'.'.$_POST['export_format'];
        }

        $insert_id = $this->model->import_export->insert(["name"=>$_POST['name'],"filename"=>$filename, "action"=>$_POST['action'], "table"=>$_POST['table'], "time_create"=>$this->datetime->getDate(), "status"=>$_POST['action'] == "export" ? 2 : 0,"export_format"=>$_POST['export_format']?:null, "source"=>$_POST['source'], "link_file"=>$_POST['link_file']?:null, "link_file_format"=>$_POST['link_file_format']?:null]);

        if($_POST['action'] == "import"){
            return json_answer(["status"=>true, "redirect"=>$this->router->getRoute("dashboard-import-card", [$insert_id])]);                
        }elseif($_POST['action'] == "export"){
            $this->session->setNotifyDashboard('success', translate("tr_3460e4fb9ae9a0c15f02954eb51a7ae8"));
            return json_answer(["status"=>true, "redirect"=>$this->router->getRoute("dashboard-import-export")]);                
        }

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }

}

public function addFeed()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['feed_format'])->status == false){
        $answer['feed_format'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['shop_title'])->status == false){
        $answer['shop_title'] = $this->validation->error;
    }

    if($_POST['feed_format'] == "yandex_yml"){

        if($this->validation->requiredField($_POST['shop_company_name'])->status == false){
            $answer['shop_company_name'] = $this->validation->error;
        }

        if($this->validation->requiredField($_POST['shop_contact_phone'])->status == false){
            $answer['shop_contact_phone'] = $this->validation->error;
        }

    }

    if($this->validation->requiredField($_POST['count_upload_items'])->status == false){
        $answer['count_upload_items'] = $this->validation->error;
    }

    if(empty($answer)){

        if($_POST['feed_format'] == "json"){
            $filename = generateCode(30).".json";
        }else{
            $filename = generateCode(30).".xml";
        }

        $insert_id = $this->model->import_export_feeds->insert(["name"=>$_POST['name'], "shop_title"=>$_POST['shop_title']?:null, "shop_company_name"=>$_POST['shop_company_name']?:null, "shop_contact_phone"=>$_POST['shop_contact_phone']?:null, "category_id"=>(int)$_POST['category_id'], "filename"=>$filename, "feed_format"=>$_POST['feed_format'], "count_upload_items"=>(int)$_POST['count_upload_items'], "autoupdate"=>(int)$_POST['autoupdate'], "utm_data"=>$_POST['utm_data']?:null, "out_filters_status"=>(int)$_POST['out_filters_status']]);

        $this->component->import_export->buildFeed($insert_id);

        $this->session->setNotifyDashboard('success', code_answer("add_successfully"));

        return json_answer(["status"=>true]);

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }

}

public function card($id)
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/import-export.js\" type=\"module\" ></script>"]);

    $data = $this->model->import_export->find("id=?", [$id]);

    if(!$data){
        abort(404);
    }

    $data->params = $data->params ? _json_decode($data->params) : [];

    if($data->params){
        if($data->params["user_id"]){
            $data->user = $this->model->users->find("id=?", [$data->params["user_id"]]);
        }
        if($data->params["city_id"]){
            $data->city = $this->model->geo_cities->find("id=?", [$data->params["city_id"]]);
        }
    }

    if($data->source == "file"){

        $data->document = $this->component->import_export->getHeaderFile($data);
        $data->fields = $this->component->import_export->fieldsTable($data->table);

        $this->view->setParamsComponent(["data"=>(object)$data, "breadcrumbs"=>["chain"=>[translate("tr_20ee8ea20203fd1ea3fbc9d120467ec5")=>$this->router->getRoute("dashboard-import-export"), translate("tr_c9ad0ce001bcb5bb2f5b46ce5038dc65")=>null]]]);

        return $this->view->preload('import-export/import-export-card', ["title"=>translate("tr_20ee8ea20203fd1ea3fbc9d120467ec5"),"data"=>(object)$data]);

    }else{

        if($data->link_file_format == "csv"){
            $data->document = $this->component->import_export->getHeaderFile($data);
            $data->fields = $this->component->import_export->fieldsTable($data->table);
        }

        $this->view->setParamsComponent(["data"=>(object)$data, "breadcrumbs"=>["chain"=>[translate("tr_20ee8ea20203fd1ea3fbc9d120467ec5")=>$this->router->getRoute("dashboard-import-export"), translate("tr_c9ad0ce001bcb5bb2f5b46ce5038dc65")=>null]]]);

        return $this->view->preload('import-export/import-export-link-card', ["title"=>translate("tr_20ee8ea20203fd1ea3fbc9d120467ec5"),"data"=>(object)$data]);

    }

}

public function delete()
{
    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->component->import_export->delete($_POST['id']);

    unlink($this->config->storage->logs.'/import_'.md5($_POST['id']).'.txt');

    $this->session->setNotifyDashboard('success', code_answer("delete_successfully"));

    return json_answer(["status"=>true]);
}

public function deleteFeed()
{
    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->component->import_export->deleteFeed($_POST['id']);

    $this->session->setNotifyDashboard('success', code_answer("delete_successfully"));

    return json_answer(["status"=>true]);
}

public function editFeed()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    $data = $this->model->import_export_feeds->find('id=?', [$_POST['id']]);

    if(!$data) return json_answer(["status"=>true, "type_answer"=>"error", "type_show"=>"notice", "answer"=>code_answer("record_not_found")]);

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['shop_title'])->status == false){
        $answer['shop_title'] = $this->validation->error;
    }

    if($data->feed_format == "yandex_yml"){

        if($this->validation->requiredField($_POST['shop_company_name'])->status == false){
            $answer['shop_company_name'] = $this->validation->error;
        }

        if($this->validation->requiredField($_POST['shop_contact_phone'])->status == false){
            $answer['shop_contact_phone'] = $this->validation->error;
        }

    }

    if($this->validation->requiredField($_POST['count_upload_items'])->status == false){
        $answer['count_upload_items'] = $this->validation->error;
    }

    if(empty($answer)){

        $this->model->import_export_feeds->update(["name"=>$_POST['name'], "shop_title"=>$_POST['shop_title']?:null, "shop_company_name"=>$_POST['shop_company_name']?:null, "shop_contact_phone"=>$_POST['shop_contact_phone']?:null, "category_id"=>(int)$_POST['category_id'], "count_upload_items"=>(int)$_POST['count_upload_items'], "autoupdate"=>(int)$_POST['autoupdate'], "utm_data"=>$_POST['utm_data']?:null, "out_filters_status"=>(int)$_POST['out_filters_status']], $_POST['id']);

        $this->component->import_export->buildFeed($_POST['id']);

        return json_answer(["status"=>true, "answer"=>code_answer("save_successfully")]);

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }

}

public function feeds()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/import-export.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_20ee8ea20203fd1ea3fbc9d120467ec5")=>$this->router->getRoute("dashboard-import-export"), translate("tr_f87bd387ab8ed79f1af55bbb3a644b86")=>null]]]);

    return $this->view->preload('import-export/feeds', ["title"=>translate("tr_f87bd387ab8ed79f1af55bbb3a644b86")]);

}

public function loadEditFeed()
{

    $data = $this->model->import_export_feeds->find("id=?", [$_POST['id']]);

    return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('import-export/load-edit-feed.tpl')]);

}

public function logs($id)
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/import-export.js\" type=\"module\" ></script>"]);

    $data = $this->model->import_export->find("id=?", [$id]);

    if(!$data){
        abort(404);
    }

    if(file_exists($this->config->storage->logs.'/import_'.md5($data->id).'.txt')){
        $data->logs = iconv('utf-8', 'utf-8', _file_get_contents($this->config->storage->logs.'/import_'.md5($data->id).'.txt'));
    }

    $this->view->setParamsComponent(["data"=>(object)$data, "breadcrumbs"=>["chain"=>[translate("tr_20ee8ea20203fd1ea3fbc9d120467ec5")=>$this->router->getRoute("dashboard-import-export"), translate("tr_488da74e92a79f42879650ac9df57efe")=>null]]]);

    return $this->view->preload('import-export/import-logs', ["title"=>translate("tr_488da74e92a79f42879650ac9df57efe"),"data"=>(object)$data]);

}

public function main()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/import-export.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_20ee8ea20203fd1ea3fbc9d120467ec5")=>$this->router->getRoute("dashboard-import-export")],"route_name"=>$this->router->currentRoute->name,"page_name"=>translate("tr_20ee8ea20203fd1ea3fbc9d120467ec5"),"page_icon"=>"ti-database-export","favorite_status"=>true]]);

    return $this->view->preload('import-export/import-export', ["title"=>translate("tr_20ee8ea20203fd1ea3fbc9d120467ec5")]);

}

public function saveEdit()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    if($this->validation->requiredFieldsImport($_POST['params']['fields'])->status == false){
        $answer['fields'] = $this->validation->error;
    }

    if(empty($answer)){
        $this->model->import_export->update(['params'=>_json_encode($_POST['params']), "autoupdate"=>(int)$_POST['autoupdate'], "update_interval"=>(int)$_POST['update_interval'], 'next_update'=>$this->datetime->addSeconds($_POST['update_interval'])->getDate()], $_POST['id']);

        return json_answer(["status"=>false, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("save_successfully")]);
    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }

}

public function searchCity()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $results = "";

    $result = $this->component->geo->importSearchCity($_POST['query']);

    return json_answer(["content"=>$result]);

}

public function searchUser()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $results = "";
    $items = [];

    $find = $this->model->users->search($_POST['query'])->sort("name asc limit 100")->getAll();

    if($find){
        foreach ($find as $key => $value) {
            $results .= '<span class="container-live-search-results-item container-live-search-results-item-user" data-id="'.$value["id"].'" data-user-name="'.$value["name"].'" ><strong>'.$this->user->name($value).'</strong> ('.$value["email"].')</span>';
        }
    }else{
        $results = '<div class="container-live-search-no-results" >'.translate("tr_8767f9ec282489d3e8e29021d0967187").'</div>';
    }

    return json_answer(["content"=>$results]);

}

public function start()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    if($this->settings->testdrive){
        return json_answer(["status"=>false, "type_show"=>"notice", "type_answer"=>"error", "answer"=>"В тестовом режиме импорт ограничен"]);
    }

    $data = $this->model->import_export->find("id=?",[$_POST['id']]);

    $answer = [];

    if($this->validation->requiredFieldsImport($_POST['params']['fields'])->status == false){
        $answer['fields'] = $this->validation->error;
    }

    if(empty($answer)){

        $this->model->import_export->update(['status'=>2, 'params'=>_json_encode($_POST['params']), 'next_update'=>$this->datetime->addSeconds($_POST['update_interval'])->getDate(), "update_interval"=>(int)$_POST['update_interval'], 'autoupdate'=>(int)$_POST['autoupdate']], $data->id);

        return json_answer(["status"=>true, "redirect"=>$this->router->getRoute("dashboard-import-export")]);

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }

}



 }