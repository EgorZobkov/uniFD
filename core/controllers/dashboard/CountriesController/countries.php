public function countries()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/countries.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_f492287bd5434c17eca5eac67c5ad4c4")=>$this->router->getRoute("dashboard-countries")],"route_name"=>$this->router->currentRoute->name,"page_name"=>translate("tr_f492287bd5434c17eca5eac67c5ad4c4"),"page_icon"=>"ti-world","favorite_status"=>true]]);

    return $this->view->preload('countries/countries', ["data"=>(object)$data, "title"=>translate("tr_f492287bd5434c17eca5eac67c5ad4c4")]);

}