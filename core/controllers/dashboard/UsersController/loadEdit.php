public function loadEdit()
{

    if(!$this->user->setUserId($_POST['user_id'])->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $data = $this->model->users->find("id=?", [$_POST['user_id']]);

    return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('users/load-edit.tpl')]);

}