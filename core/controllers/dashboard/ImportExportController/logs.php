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