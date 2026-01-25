public function deleteCountry()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->model->geo_countries->delete('id=?', [$_POST['id']]);
    $this->model->geo_regions->delete('country_id=?', [$_POST['id']]);
    $this->model->geo_cities->delete('country_id=?', [$_POST['id']]);

    $this->component->geo->updateActiveCountries();

    $this->session->setNotifyDashboard('success', code_answer("delete_successfully"));

    return json_answer(["status"=>true]);

}