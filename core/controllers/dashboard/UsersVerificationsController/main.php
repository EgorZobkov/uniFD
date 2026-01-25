public function main()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/users-verifications.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_8ecdca2684eeafef74b7def14baa0a69")=>$this->router->getRoute("dashboard-users-verifications")],"route_name"=>$this->router->currentRoute->name,"page_name"=>translate("tr_8ecdca2684eeafef74b7def14baa0a69"),"page_icon"=>"ti-alert-triangle","favorite_status"=>true]]);

    return $this->view->preload('users-verifications/verifications', ["data"=>(object)$data, "title"=>translate("tr_8ecdca2684eeafef74b7def14baa0a69")]);

}