 public function requests()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/search.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_8c30814d7386c118467c16883720ba89")=>$this->router->getRoute("dashboard-search-requests")],"route_name"=>$this->router->currentRoute->name,"page_name"=>translate("tr_8c30814d7386c118467c16883720ba89"),"page_icon"=>"ti-search","favorite_status"=>true]]);

    return $this->view->preload('search/requests', ["title"=>translate("tr_8c30814d7386c118467c16883720ba89")]);

}