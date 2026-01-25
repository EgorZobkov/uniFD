public function main()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/deals.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_9a3dc867f2fd583f53c561442ecf34b0")=>$this->router->getRoute("dashboard-deals")],"route_name"=>$this->router->currentRoute->name,"page_name"=>translate("tr_9a3dc867f2fd583f53c561442ecf34b0"),"page_icon"=>"ti-briefcase","favorite_status"=>true]]);

    return $this->view->preload('deals/deals', ["title"=>translate("tr_9a3dc867f2fd583f53c561442ecf34b0")]);

}