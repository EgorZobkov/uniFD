public function cardCityMetro($id)
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/countries.js\" type=\"module\" ></script>"]);

    $data = $this->model->geo_cities->find('id=?',[$id]);

    if(!$data){
        abort(404);
    }

    $data->country = $this->model->geo_countries->find('id=?',[$data->country_id]);

    $this->view->setParamsComponent(["data"=>(object)$data, "breadcrumbs"=>["chain"=>[translate("tr_f492287bd5434c17eca5eac67c5ad4c4")=>$this->router->getRoute("dashboard-countries"),$data->country->name=>$this->router->getRoute("dashboard-country-card", [$data->country->id]),$data->name=>null]]]);

    $this->view->setParamsPreload(["city_id"=>$id,"country_id"=>$data->country_id]);

    return $this->view->preload('countries/metro-card', ["data"=>(object)$data, "title"=>$data->name]);

}