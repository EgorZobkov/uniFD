public function deleteRegion()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->model->geo_regions->delete('id=?', [$_POST['id']]);
    $this->model->geo_cities->delete('region_id=?', [$_POST['id']]);

    $this->session->setNotifyDashboard('success', code_answer("delete_successfully"));

    return json_answer(["status"=>true]);

}