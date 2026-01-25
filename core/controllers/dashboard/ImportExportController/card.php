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