public function main()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/promo-banners.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_369c5894a00530143785ee61375995ea")=>$this->router->getRoute("dashboard-promo-banners")],"route_name"=>$this->router->currentRoute->name,"page_name"=>translate("tr_369c5894a00530143785ee61375995ea"),"page_icon"=>"ti-photo","favorite_status"=>true]]);

    return $this->view->preload('promo-banners/banners', ["data"=>(object)$data, "title"=>translate("tr_369c5894a00530143785ee61375995ea")]);

}