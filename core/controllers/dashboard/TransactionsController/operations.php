public function operations()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/transactions.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_6f99d23532d69316b48a8bd20bf2b085")=>$this->router->getRoute("dashboard-transactions"),translate("tr_1ec0db83a649974785419afafde20176")=>null]]]);

    return $this->view->preload('transactions/operations', ["title"=>translate("tr_1ec0db83a649974785419afafde20176")]);

}