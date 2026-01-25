public function addActionUser($params=[]){   
    global $app;

    if($params["from_user_id"] && $params["item_id"]){

        $ad = $app->model->ads_data->find("id=?", [$params["item_id"]]);

        if($ad){

            if(!$app->model->users_actions->find("from_user_id=? and whom_user_id=? and item_id=? and action_code=? and date(time_create)=?", [$params["from_user_id"], $ad->user_id, $params["item_id"], $params["action_code"], $app->datetime->format("Y-m-d")->getDate()])){

                $app->model->users_actions->insert(["time_create"=>$app->datetime->getDate(), "from_user_id"=>$params["from_user_id"], "whom_user_id"=>$ad->user_id, "action_code"=>$params["action_code"], "item_id"=>$params["item_id"]]);

            }

        }

    }       
    
}