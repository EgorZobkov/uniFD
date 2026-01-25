public function deleteFavorite(){

    $this->model->system_favorites->delete("user_id=? and id=?", [$this->user->data->id,$_POST["id"]]);

    return json_answer(["favorites"=>$this->system->getSystemFavorites()]);

}