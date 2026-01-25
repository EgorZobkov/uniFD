public function sorting(){

    if($_POST["ids"]){
        foreach (explode(",", $_POST["ids"]) as $key => $id) {
            $this->model->ads_categories->cacheKey(["id"=>$id])->update(["sorting"=>$key], $id);
        }
    }

    return json_answer(["status"=>true]);

}