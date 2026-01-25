public function deleteChannel()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->model->chat_channels->delete("id=?", [$_POST['id']]);
    $this->model->chat_messages->delete("channel_id=?", [$_POST['id']]);

    $this->session->setNotifyDashboard("success", code_answer("delete_successfully"));

    return json_answer(["status"=>true]);

}