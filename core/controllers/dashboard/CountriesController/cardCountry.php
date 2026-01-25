public function cardCountry($id)
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/countries.js\" type=\"module\" ></script>"]);

    $data = $this->model->geo_countries->find('id=?',[$id]);

    if(!$data){
        abort(404);
    }

    $this->view->setParamsComponent(["data"=>(object)$data, "breadcrumbs"=>["chain"=>[translate("tr_f492287bd5434c17eca5eac67c5ad4c4")=>$this->router->getRoute("dashboard-countries"),$data->name=>null]]]);

    $this->view->setParamsPreload(["country_id"=>$id]);

    return $this->view->preload('countries/country-card', ["data"=>(object)$data, "title"=>$data->name]);

}