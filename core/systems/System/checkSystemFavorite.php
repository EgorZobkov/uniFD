public function checkSystemFavorite($route_name=null){
    global $app;
    if(isset($route_name)){
        $check = $app->model->system_favorites->find("user_id=? and route_name=?", [$app->user->data->id,$route_name]);

        if($check){
            return (object)["status"=>true];
        }else{
            return (object)["status"=>false];
        }
    }
    return (object)["status"=>false];
}