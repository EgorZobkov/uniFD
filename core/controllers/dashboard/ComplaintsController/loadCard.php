public function loadCard()
{   

    if(!$this->user->verificationAccess('view')->status){
        return json_answer(["access"=>false]);
    }
    
    $data = $this->model->complaints->find("id=?", [$_POST['id']]);

    if($data->item_id){
        $data->ad = $this->component->ads->getAd($data->item_id);
    }

    $data->from_user = $this->model->users->findById($data->from_user_id);
    $data->whom_user = $this->model->users->findById($data->whom_user_id);

    return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('complaints/load-card.tpl')]);

}