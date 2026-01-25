public function deleteCityMetro()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->model->geo_cities_metro->delete('id=?', [$_POST['id']]);
    $this->model->geo_cities_metro->delete('parent_id=?', [$_POST['id']]);

    $this->session->setNotifyDashboard('success', code_answer("delete_successfully"));

    return json_answer(["status"=>true]);

}