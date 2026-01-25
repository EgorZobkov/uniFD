public function main()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/import-export.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_20ee8ea20203fd1ea3fbc9d120467ec5")=>$this->router->getRoute("dashboard-import-export")],"route_name"=>$this->router->currentRoute->name,"page_name"=>translate("tr_20ee8ea20203fd1ea3fbc9d120467ec5"),"page_icon"=>"ti-database-export","favorite_status"=>true]]);

    return $this->view->preload('import-export/import-export', ["title"=>translate("tr_20ee8ea20203fd1ea3fbc9d120467ec5")]);

}