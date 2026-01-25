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