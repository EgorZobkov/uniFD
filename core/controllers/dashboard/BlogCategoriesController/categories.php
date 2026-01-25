public function categories()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/blog-categories.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_4c239493d16523d932847244c80c028a")=>$this->router->getRoute("dashboard-blog-categories")],"route_name"=>$this->router->currentRoute->name,"page_name"=>translate("tr_4c239493d16523d932847244c80c028a"),"page_icon"=>"ti-article","favorite_status"=>true]]);

    return $this->view->preload('blog/categories', ["title"=>translate("tr_4c239493d16523d932847244c80c028a")]);

}