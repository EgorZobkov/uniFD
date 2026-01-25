public function main()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerCss(["view"=>"dashboard", "name"=>"<link rel=\"stylesheet\" href=\"{assets_path}/vendors/codemirror/codemirror.css\" />"]);
    $this->asset->registerCss(["view"=>"dashboard", "name"=>"<link rel=\"stylesheet\" href=\"{assets_path}/vendors/minicolors/jquery.minicolors.css\" />"]);
    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/vendors/codemirror/codemirror.js\" ></script>"]);
    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/settings.js\" type=\"module\" ></script>"]);
    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/vendors/minicolors/jquery.minicolors.min.js\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_c919d65bd95698af8f15fa8133bf490d")=>$this->router->getRoute("dashboard-settings")],"route_name"=>"dashboard-settings","page_name"=>translate("tr_c919d65bd95698af8f15fa8133bf490d"),"page_icon"=>"ti-settings","favorite_status"=>true]]);

    return $this->view->preload('settings', ["title"=>translate("tr_c919d65bd95698af8f15fa8133bf490d")]);

}