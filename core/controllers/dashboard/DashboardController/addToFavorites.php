public function addToFavorites(){

    $find = $this->model->system_favorites->find("user_id=? and route_name=?", [$this->user->data->id,$_POST["route_name"]]);

    if($find){
        $this->model->system_favorites->delete("id=?", [$find->id]);
        return json_answer(["status"=>"delete", "favorites"=>$this->system->getSystemFavorites()]);
    }else{
        $this->model->system_favorites->insert(["user_id"=>$this->user->data->id, "route_name"=>$_POST["route_name"], "page_name"=>$_POST["page_name"], "page_icon"=>$_POST["page_icon"]]);
        return json_answer(["status"=>"added", "favorites"=>$this->system->getSystemFavorites()]);
    }

}