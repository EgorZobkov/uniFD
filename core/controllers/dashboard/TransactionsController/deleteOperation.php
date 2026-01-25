public function deleteOperation()
{
    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->model->transactions_operations->delete("id=?", [$_POST['id']]);

    $this->session->setNotifyDashboard('success', code_answer("delete_successfully"));

    return json_answer(["status"=>true]);
}