public function tariffs(){

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/services.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_a49106cadab8ae1ff6a37e7ccea9c665")=>$this->router->getRoute("dashboard-services-tariffs")],"route_name"=>"dashboard-services-tariffs","page_name"=>translate("tr_a49106cadab8ae1ff6a37e7ccea9c665"),"page_icon"=>"ti-brand-cashapp","favorite_status"=>true]]);

    return $this->view->preload('services/tariffs', ["title"=>translate("tr_a49106cadab8ae1ff6a37e7ccea9c665")]);

}