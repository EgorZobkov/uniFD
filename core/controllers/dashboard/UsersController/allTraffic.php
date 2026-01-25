public function allTraffic()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/users.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_befd5878a9365dcdc4306c77b413c3e8")=>$this->router->getRoute("dashboard-users-traffic")],"route_name"=>$this->router->currentRoute->name,"page_name"=>translate("tr_befd5878a9365dcdc4306c77b413c3e8"),"page_icon"=>"ti-users-group","favorite_status"=>true]]);

    return $this->view->preload('users/traffic', ["title"=>translate("tr_befd5878a9365dcdc4306c77b413c3e8")]);

}