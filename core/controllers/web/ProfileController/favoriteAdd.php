public function favoriteAdd()
{   

    $get = $this->model->users_favorites->find("ad_id=? and user_id=?", [$_POST['id'], $this->user->data->id]);

    if($get){

        $this->model->users_favorites->delete("id=?", [$get->id]);

        return json_answer(["status"=>false]);

    }else{

        $ad = $this->component->ads->getAd($_POST['id']);

        if($ad && !$ad->delete){

            $params = ["user_id"=>$this->user->data->id, "ad_id"=>$_POST['id'], "time_create"=>$this->datetime->getDate()];

            $this->model->users_favorites->insert($params);

            $this->event->addToFavorite(["user_id"=>$this->user->data->id, "ad_id"=>$_POST['id']]);

        }

        return json_answer(["status"=>true]);

    }

}