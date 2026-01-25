 public function keywords()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/search.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_83dc72c7b853982cd4d3cbddf0254061")=>$this->router->getRoute("dashboard-search-keywords")],"route_name"=>$this->router->currentRoute->name,"page_name"=>translate("tr_83dc72c7b853982cd4d3cbddf0254061"),"page_icon"=>"ti-search","favorite_status"=>true]]);

    return $this->view->preload('search/keywords', ["title"=>translate("tr_83dc72c7b853982cd4d3cbddf0254061")]);

}