public function main()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/reviews.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_1c3fea01a64e56bd70c233491dd537aa")=>$this->router->getRoute("dashboard-reviews")],"route_name"=>$this->router->currentRoute->name,"page_name"=>translate("tr_1c3fea01a64e56bd70c233491dd537aa"),"page_icon"=>"ti-message","favorite_status"=>true]]);

    return $this->view->preload('reviews/reviews', ["data"=>(object)$data, "title"=>translate("tr_1c3fea01a64e56bd70c233491dd537aa")]);

}