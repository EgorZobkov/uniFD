public function loadCard()
{   

    if(!$this->user->verificationAccess('view')->status){
        return json_answer(["access"=>false]);
    }
    
    $data = $this->model->users_verifications->find("id=?", [$_POST['id']]);

    $data->user = $this->model->users->findById($data->user_id);

    return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('users-verifications/load-card.tpl')]);

}