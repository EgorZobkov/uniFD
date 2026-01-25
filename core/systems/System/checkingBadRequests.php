public function checkingBadRequests($action=null, $user_id=0){
    global $app;

    if($action == "ad_create"){

        $getLastCountAds = $app->model->ads_data->count("time_create >= DATE_SUB(NOW(),INTERVAL 1 MINUTE) and user_id=?", [$user_id]);

        if($getLastCountAds >= 6){
            $app->model->users->update(["status"=>2, "reason_blocking_code"=>"flood", "time_expiration_blocking"=>$app->datetime->addHours(1)->getDate()], ["admin=? and id=?", [0,$user_id]]);
            return true;
        }

    }elseif($action == "chat"){

        $getLastCountMessages = $app->model->chat_messages->count("time_create >= DATE_SUB(NOW(),INTERVAL 1 MINUTE) and from_user_id=?", [$user_id]);

        if($getLastCountMessages >= 60){
            $app->model->users->update(["status"=>2, "reason_blocking_code"=>"spam", "time_expiration_blocking"=>$app->datetime->addHours(1)->getDate()], ["admin=? and id=?", [0,$user_id]]);
            $app->model->chat_messages->delete("time_create >= DATE_SUB(NOW(),INTERVAL 1 MINUTE) and from_user_id=?", [$user_id]);
            return true;
        }

        $getLastCountMessages = $app->model->chat_messages->count("time_create >= DATE_SUB(NOW(),INTERVAL 10 MINUTE) and from_user_id=? and has_contact_information=?", [$user_id,1]);

        if($getLastCountMessages >= 10){
            $app->model->users->update(["status"=>2, "reason_blocking_code"=>"spam", "time_expiration_blocking"=>$app->datetime->addHours(1)->getDate()], ["admin=? and id=?", [0,$user_id]]);
            $app->model->chat_messages->delete("time_create >= DATE_SUB(NOW(),INTERVAL 10 MINUTE) and from_user_id=? and has_contact_information=?", [$user_id,1]);
            return true;
        }

    }

    return false;
}