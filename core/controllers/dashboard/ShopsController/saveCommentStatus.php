public function saveCommentStatus()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    $data = $this->model->shops->find("id=?", [$_POST['id']]);

    if($this->validation->requiredField($_POST['reason_comment'])->status == false){
        $answer['reason_comment'] = $this->validation->error;
    }

    if(empty($answer)){

        $this->model->shops->update(["status"=>"rejected", "comment"=>$_POST['reason_comment']],$_POST['id']);

        $this->event->changeStatusShop(["user_id"=>$data->user_id, "status"=>"rejected", "text"=>$_POST['reason_comment'], "shop_id"=>$_POST['id'], "shop_link"=>$this->component->shop->linkToShopCard($data->alias)]);

        $this->session->setNotifyDashboard('success', code_answer("action_successfully"));

        return json_answer(["status"=>true]);

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }

}