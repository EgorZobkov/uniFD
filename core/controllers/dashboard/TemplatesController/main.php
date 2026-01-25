public function main()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/templates.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_74ff549c01bf978d89857d678258a717")=>$this->router->getRoute("dashboard-templates")],"route_name"=>"dashboard-templates","page_name"=>translate("tr_74ff549c01bf978d89857d678258a717"),"page_icon"=>"ti-template","favorite_status"=>true]]);

    return $this->view->preload('templates/pages', ["title"=>translate("tr_74ff549c01bf978d89857d678258a717")]);

}