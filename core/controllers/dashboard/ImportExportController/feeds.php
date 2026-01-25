public function feeds()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/import-export.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_20ee8ea20203fd1ea3fbc9d120467ec5")=>$this->router->getRoute("dashboard-import-export"), translate("tr_f87bd387ab8ed79f1af55bbb3a644b86")=>null]]]);

    return $this->view->preload('import-export/feeds', ["title"=>translate("tr_f87bd387ab8ed79f1af55bbb3a644b86")]);

}