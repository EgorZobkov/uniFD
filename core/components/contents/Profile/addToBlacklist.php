public function addToBlacklist($from_user_id=0, $whom_user_id=0, $channel_id=0){
    global $app;

    $getWhomUser = $app->model->users->find("id=?", [$whom_user_id]);

    if(!$getWhomUser){
        return false;
    }

    if($channel_id){
        $get = $app->model->users_blacklist->find("from_user_id=? and whom_user_id=? and channel_id=?", [$from_user_id, $whom_user_id, $channel_id]);
    }else{
        $get = $app->model->users_blacklist->find("from_user_id=? and whom_user_id=?", [$from_user_id, $whom_user_id]);
    }

    if($get){

        $app->model->users_blacklist->delete("id=?", [$get->id]);

        return false;

    }else{

        $app->model->users_blacklist->insert(["from_user_id"=>$from_user_id, "whom_user_id"=>$whom_user_id, "channel_id"=>(int)$channel_id]);

        return true;

    }

}