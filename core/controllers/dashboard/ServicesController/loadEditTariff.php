public function loadEditTariff(){

    $data = $this->model->users_tariffs->find("id=?", [$_POST['id']]);

    return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('services/load-edit-tariff.tpl')]);

}