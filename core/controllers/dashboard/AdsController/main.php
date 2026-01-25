public function main()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/ads.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_083ab3d9a9221cf6a1641c2c7c5f0d3c")=>$this->router->getRoute("dashboard-ads")],"route_name"=>$this->router->currentRoute->name,"page_name"=>translate("tr_083ab3d9a9221cf6a1641c2c7c5f0d3c"),"page_icon"=>"ti-barcode","favorite_status"=>true]]);

    return $this->view->preload('board/ads', ["title"=>translate("tr_083ab3d9a9221cf6a1641c2c7c5f0d3c")]);

}