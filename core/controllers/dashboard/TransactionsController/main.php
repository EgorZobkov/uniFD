public function main()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/transactions.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_6f99d23532d69316b48a8bd20bf2b085")=>$this->router->getRoute("dashboard-transactions")],"route_name"=>$this->router->currentRoute->name,"page_name"=>translate("tr_6f99d23532d69316b48a8bd20bf2b085"),"page_icon"=>"ti-timeline","favorite_status"=>true]]);

    return $this->view->preload('transactions/transactions', ["title"=>translate("tr_6f99d23532d69316b48a8bd20bf2b085")]);

}