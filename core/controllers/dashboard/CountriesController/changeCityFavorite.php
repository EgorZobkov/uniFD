public function changeCityFavorite()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $find = $this->model->geo_cities->find("id=?", [$_POST["id"]]);

    if($find->favorite){
        $this->model->geo_cities->cacheKey(["id"=>$_POST["id"]])->update(["favorite"=>0], $_POST["id"]);
        return json_answer(["status"=>false]);
    }else{
        $this->model->geo_cities->cacheKey(["id"=>$_POST["id"]])->update(["favorite"=>1], $_POST["id"]);
        return json_answer(["status"=>true]);
    }

}