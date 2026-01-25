public function main()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/seo.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_67a30d0847a390ae56549987bb2d469a")=>$this->router->getRoute("dashboard-seo")],"route_name"=>"dashboard-seo","page_name"=>translate("tr_67a30d0847a390ae56549987bb2d469a"),"page_icon"=>"ti-template","favorite_status"=>true]]);

    return $this->view->preload('seo/seo', ["title"=>translate("tr_67a30d0847a390ae56549987bb2d469a")]);

}