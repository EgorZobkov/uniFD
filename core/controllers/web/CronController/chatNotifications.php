public function chatNotifications(){

    $users_list = [];

    $total = $this->model->chat_messages->count("user_id=? and whom_user_id=? and status=? and delete_status=? and channel_id=? and notification_status=?", [0,0,0,0,1,0]);

    if($total){

        $text = translate("tr_2ce93b17414903790430a4ee3b19565d") . " " . $total . " " . endingWord($total, translate("tr_846ff7b29e169d829b8aa500fff5eb73"), translate("tr_f94bbcd6ef85e15581e7f132472a31a4"), translate("tr_f94bbcd6ef85e15581e7f132472a31a4"));

        $notifications = $this->model->users_notify_list->getAll("action_code=?", ["system_chat_new_message"]);

        if($notifications){
            foreach ($notifications as $item) {

                $this->notify->params(["count"=>$total, "text"=>$text])->userId($item["user_id"])->code("system_chat_new_message")->sendByUser();

            }
        }

    }

    $getUsers = $this->model->users->getAll("status=? and admin=?",[1,0]);

    if($getUsers){
        foreach ($getUsers as $key => $value) {

            $total = $this->component->chat->updateCountMessages($value["id"], true);
            if($total["count"]){
                $text = translate("tr_2ce93b17414903790430a4ee3b19565d") . " " . $total["count"] . " " . endingWord($total["count"], translate("tr_846ff7b29e169d829b8aa500fff5eb73"), translate("tr_f94bbcd6ef85e15581e7f132472a31a4"), translate("tr_f94bbcd6ef85e15581e7f132472a31a4"));
                $this->notify->params(["count"=>$total["count"], "text"=>$text])->userId($value["id"])->code("chat_new_message")->sendByUser();
                $this->notify->sendMessageFirebase(["token"=>$value["firebase_token"], "title"=>$this->settings->api_app_project_name, "text"=>$text]);
            }

        }
    }

    $this->model->chat_messages->updateQuery("notification_status=?", [1]);

}