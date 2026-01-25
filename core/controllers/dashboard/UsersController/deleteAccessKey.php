public function deleteAccessKey(){

    if(!$this->user->setUserId($_POST['user_id'])->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->model->auth_access_key->delete("user_id=?", [$_POST['user_id']]);   

    $this->session->setNotifyDashboard('success', code_answer("delete_successfully"));

    return json_answer(["status"=>true]);

}