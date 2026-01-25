public function loadCard()
{   
    
    $data = $this->model->shops->find("id=?", [$_POST['id']]);

    $data->user = $this->model->users->findById($data->user_id);

    return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('shops/load-card.tpl')]);

}