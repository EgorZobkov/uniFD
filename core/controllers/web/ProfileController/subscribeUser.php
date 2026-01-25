public function subscribeUser()
{   

    $get = $this->model->users_subscriptions->find("whom_user_id=? and user_id=?", [$_POST['id'], $this->user->data->id]);

    if($get){

        $this->model->users_subscriptions->delete("id=?", [$get->id]);

        return json_answer(["status"=>false, "answer"=>translate("tr_638599971fc418274ea865e6fd9f758a"), "label"=>translate("tr_3b1913989f1a538261b8abf5ffc88d4b")]);

    }else{

        $user = $this->model->users->findById($_POST['id']);

        if($user && !$user->delete){
            $params = ["user_id"=>$this->user->data->id, "whom_user_id"=>$_POST['id'], "time_create"=>$this->datetime->getDate()];

            $this->model->users_subscriptions->insert($params);

            $this->event->subscribeUser(["from_user_id"=>$this->user->data->id, "whom_user_id"=>$_POST['id']]);

            return json_answer(["status"=>true, "answer"=>translate("tr_38b7895643fca9471f5710bca2270601"), "label"=>translate("tr_d2023e4c921d1cc5865f230480442d3c")]);                
        }else{
            return json_answer(["status"=>false, "answer"=>translate("tr_e9aacbf73724cdc9294d4eed84b700a3")]);
        }

    }
    
}