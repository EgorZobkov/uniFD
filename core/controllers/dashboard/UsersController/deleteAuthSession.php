public function deleteAuthSession()
{

    if(!$this->user->setUserId($_POST['user_id'])->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->model->auth->delete('id=? and user_id=?', [$_POST['auth_id'],$_POST['user_id']]);

    $this->session->setNotifyDashboard('success', code_answer("delete_successfully"));

    return json_answer(["status"=>true]);

}