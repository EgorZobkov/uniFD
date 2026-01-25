public function statistics()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/transactions-statistics.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_6f99d23532d69316b48a8bd20bf2b085")=>$this->router->getRoute("dashboard-transactions"),translate("tr_5e3753ce80a1394ad160591140abb966")=>null],"route_name"=>$this->router->currentRoute->name,"page_name"=>translate("tr_7c6cbc6fd88e2e3ab9c86c7dc6ef6fd9"),"page_icon"=>"ti-timeline","favorite_status"=>true]]);

    return $this->view->preload('transactions/transactions-statistics', ["title"=>translate("tr_7c6cbc6fd88e2e3ab9c86c7dc6ef6fd9")]);

}