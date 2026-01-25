public function loadEditCity()
{

    $data = $this->model->geo_cities->find('id=?', [$_POST['id']]);
    if($data){
        return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('countries/load-edit-city.tpl')]);
    }

}