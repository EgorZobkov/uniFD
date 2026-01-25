public function loadCard()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }
    
    $data = $this->model->reviews->find("id=?", [$_POST['id']]);

    if($data->item_id){
        $data->ad = $this->component->ads->getAd($data->item_id);
    }

    $data->from_user = $this->model->users->findById($data->from_user_id);
    $data->whom_user = $this->model->users->findById($data->whom_user_id);

    $data->media = $data->media ? _json_decode($data->media) : null;

    return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('reviews/load-card.tpl')]);

}