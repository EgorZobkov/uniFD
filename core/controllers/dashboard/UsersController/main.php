public function main()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/users.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_b8c4e70da7bea88961184a1c1be9cb13")=>$this->router->getRoute("dashboard-users")],"route_name"=>$this->router->currentRoute->name,"page_name"=>translate("tr_b8c4e70da7bea88961184a1c1be9cb13"),"page_icon"=>"ti-users","favorite_status"=>true]]);

    return $this->view->preload('users/users', ["title"=>translate("tr_b8c4e70da7bea88961184a1c1be9cb13")]);

}