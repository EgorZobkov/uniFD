public function main()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/complaints.js\" type=\"module\" ></script>"]);
    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/board/ads.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_0a60111d2b41f343bed6a257a4c13d0d")=>$this->router->getRoute("dashboard-complaints")],"route_name"=>$this->router->currentRoute->name,"page_name"=>translate("tr_0a60111d2b41f343bed6a257a4c13d0d"),"page_icon"=>"ti-alert-triangle","favorite_status"=>true]]);

    return $this->view->preload('complaints/complaints', ["data"=>(object)$data, "title"=>translate("tr_0a60111d2b41f343bed6a257a4c13d0d")]);

}