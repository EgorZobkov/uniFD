public function notifications(){

    $getNotifications = $this->model->users_waiting_notifications->getAll();
    if($getNotifications){
        foreach ($getNotifications as $key => $value) {

            $params = _json_decode($value["params"]);

            if($value["user_id"]){

                $this->notify->params($params)->userId($value["user_id"])->code($value["action_code"])->sendByUser();

            }else{

                $notifications = $this->model->users_notify_list->getAll("action_code=?", [$value["action_code"]]);

                if($notifications){
                    foreach ($notifications as $item) {

                        $this->notify->params($params)->userId($item["user_id"])->code($value["action_code"])->sendByUser();

                    }
                }                        

            }

            $this->model->users_waiting_notifications->delete("id=?", [$value["id"]]);

        }
    }

}