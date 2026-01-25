public function logoutUniId()
{

    $this->model->settings->update("","uniid_token");
    $this->model->settings->update("","uniid_data");
    return json_answer(["status"=>true]);

}