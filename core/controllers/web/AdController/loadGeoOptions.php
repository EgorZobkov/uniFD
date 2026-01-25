public function loadGeoOptions(){

    return json_answer(["status"=>true, "answer"=>$this->component->ads->outMapAndOptionsInAdCreate($_POST['city_id'])]);
    
}