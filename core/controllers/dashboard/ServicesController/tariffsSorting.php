public function tariffsSorting(){

    if($_POST["ids"]){
        foreach (explode(",", $_POST["ids"]) as $key => $id) {
            $this->model->users_tariffs->cacheKey(["id"=>$id])->update(["sorting"=>$key], $id);
        }
    }

    return json_answer(["status"=>true]);

}