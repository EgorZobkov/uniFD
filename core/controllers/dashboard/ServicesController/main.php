public function main(){

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/services.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_f8719e3fdc6916a0d389c645f4a7d0bb")=>$this->router->getRoute("dashboard-services")],"route_name"=>"dashboard-services","page_name"=>translate("tr_f8719e3fdc6916a0d389c645f4a7d0bb"),"page_icon"=>"ti-cash","favorite_status"=>true]]);

    return $this->view->preload('services/services', ["title"=>translate("tr_f8719e3fdc6916a0d389c645f4a7d0bb")]);

}