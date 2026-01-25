public function deleteTariff()
{   

    if(!$this->user->verificationAccess('control')->status){
        return $this->view->accessDenied();
    }

    if($_POST['user_id']){

        $this->model->users_tariffs_orders->delete("user_id=?", [$_POST['user_id']]);
        $this->model->users->update(["tariff_id"=>0], $_POST['user_id']);

    }

    $this->session->setNotifyDashboard('success', code_answer("action_successfully"));

    return json_answer(["status"=>true]);

}