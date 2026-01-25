public function loadEdit()
{

    $data = $this->model->reviews->find("id=?", [$_POST['id']]);

    return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('reviews/load-edit.tpl')]);

}