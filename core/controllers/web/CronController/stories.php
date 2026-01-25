public function stories(){

    $getStories = $this->model->stories_media->sort("id desc limit 100")->getAll("now() >= time_expiration and status=?", [1]);
    
    if($getStories){

        foreach ($getStories as $key => $value) {
            $this->component->stories->delete($value["id"]);
        }

    }        

}