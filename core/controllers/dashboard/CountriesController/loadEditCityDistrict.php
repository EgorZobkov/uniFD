public function loadEditCityDistrict()
{

    $data = $this->model->geo_cities_districts->find('id=?', [$_POST['id']]);
    if($data){
        return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('countries/load-edit-city-district.tpl')]);
    }

}