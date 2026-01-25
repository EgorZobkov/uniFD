public function deleteFilterLink()
{
    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->model->ads_filters_links->delete("id=?", [$_POST['id']]);

    $this->session->setNotifyDashboard('success', code_answer("delete_successfully"));

    return json_answer(["status"=>true]);
}