public function storiesMakeCollage(){

    $data = $this->model->stories_waiting_make_collage->getAll();

    if($data){
        foreach ($data as $key => $value) {
            $this->model->stories_waiting_make_collage->delete("id=?", [$value["id"]]);
            $this->component->stories->makeCollageItemAndPublication($value["item_id"], $value["count_day"]);
        }
    }  

}