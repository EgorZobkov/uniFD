public function servicesSorting(){

    if($_POST["ids"]){
        foreach (explode(",", $_POST["ids"]) as $key => $id) {
            $this->model->ads_services->cacheKey(["id"=>$id])->update(["sorting"=>$key], $id);
        }
    }

    return json_answer(["status"=>true]);

}