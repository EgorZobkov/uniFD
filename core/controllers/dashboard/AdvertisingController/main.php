public function main()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/advertising.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_becb26beb045da0432304943659c57b2")=>$this->router->getRoute("dashboard-advertising")],"route_name"=>$this->router->currentRoute->name,"page_name"=>translate("tr_becb26beb045da0432304943659c57b2"),"page_icon"=>"ti-ad","favorite_status"=>true]]);

    return $this->view->preload('advertising/advertising', ["title"=>translate("tr_becb26beb045da0432304943659c57b2")]);

}