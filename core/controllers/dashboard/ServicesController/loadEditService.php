public function loadEditService(){

    $data = $this->model->ads_services->find("id=?", [$_POST['id']]);

    return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('services/load-edit.tpl')]);

}