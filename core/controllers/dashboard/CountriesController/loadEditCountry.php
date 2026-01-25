public function loadEditCountry()
{

    $data = $this->model->geo_countries->find('id=?', [$_POST['id']]);
    if($data){
        return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('countries/load-edit-country.tpl')]);
    }

}