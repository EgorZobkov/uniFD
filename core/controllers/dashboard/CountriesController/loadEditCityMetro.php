public function loadEditCityMetro()
{

    $data = $this->model->geo_cities_metro->find('id=?', [$_POST['id']]);
    if($data){
        return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('countries/load-edit-city-metro.tpl')]);
    }

}