public function createLoadFilterItems(){

    return json_answer(["content"=>$this->component->ads_filters->getFiltersParentInAdCreate($_POST["filter_id"],$_POST["item_id"])]);

}