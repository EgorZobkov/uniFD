public function buildToken($params=[]){

    if($params["ad_id"]){
        $build[] = $params["ad_id"];
    }

    if($params["channel_id"]){
        $build[] = $params["channel_id"];
    }

    $build[] = $params["from_user_id"] ?: 0;

    $build[] = $params["whom_user_id"] ?: 0;

    return md5(implode(".", $build));

}