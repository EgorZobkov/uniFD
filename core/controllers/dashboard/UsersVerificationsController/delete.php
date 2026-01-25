public function delete()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $data = $this->model->users_verifications->find("id=?", [$_POST['id']]);

    $this->storage->clearAttachFiles(_json_decode($data->media));

    $this->model->users_verifications->delete("id=?", [$_POST['id']]);

    $this->session->setNotifyDashboard('success', code_answer("delete_successfully"));

    return json_answer(["status"=>true]);

}