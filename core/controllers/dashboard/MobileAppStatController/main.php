public function main()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/mobile-app.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_b6d9a92c222a2bb8feb67b43f50b118b")=>$this->router->getRoute("dashboard-mobile-app-stat")],"route_name"=>$this->router->currentRoute->name,"page_name"=>translate("tr_b6d9a92c222a2bb8feb67b43f50b118b"),"page_icon"=>"ti-device-mobile","favorite_status"=>true]]);

    return $this->view->preload('mobile-app/mobile-app-statistics', ["title"=>translate("tr_b6d9a92c222a2bb8feb67b43f50b118b")]);

}