public function main()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/shops.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_cfb8af01cc910b08e8796e03cf662f5f")=>$this->router->getRoute("dashboard-shops")],"route_name"=>$this->router->currentRoute->name,"page_name"=>translate("tr_cfb8af01cc910b08e8796e03cf662f5f"),"page_icon"=>"ti-shopping-bag","favorite_status"=>true]]);

    return $this->view->preload('shops/shops', ["data"=>(object)$data, "title"=>translate("tr_cfb8af01cc910b08e8796e03cf662f5f")]);

}