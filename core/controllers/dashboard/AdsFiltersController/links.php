public function links()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/filters.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_f7ac6fc5c5a477063add9c6d0701985d")=>$this->router->getRoute("dashboard-ads-filters"), translate("tr_9f58935eaf5d4cdda0f114e4f325ed0f")=>null],"route_name"=>$this->router->currentRoute->name,"page_name"=>translate("tr_9f58935eaf5d4cdda0f114e4f325ed0f"),"page_icon"=>"ti-filter","favorite_status"=>true]]);

    return $this->view->preload('board/ads-filters-links', ["title"=>translate("tr_9f58935eaf5d4cdda0f114e4f325ed0f")]);

}