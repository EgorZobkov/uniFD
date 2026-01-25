public function uniApi(){

    $result = $this->system->uniApi("check-auth");
    if($result){
        if($result["status"]){
            $this->model->settings->update(_json_encode($result["data"]),"uniid_data");
        }else{
            $this->model->settings->update("","uniid_token");
            $this->model->settings->update("","uniid_data");
        }
    }else{
        $this->model->settings->update("","uniid_token");
        $this->model->settings->update("","uniid_data");
    }


    $apiNotifications = $this->system->uniApi("notifications");

    $this->model->settings->update(_json_encode($apiNotifications),"uni_api_last_notifications");

}