public function loadEdit()
{

    $data = $this->model->shops->find("id=?", [$_POST['id']]);

    return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('shops/load-edit.tpl')]);

}