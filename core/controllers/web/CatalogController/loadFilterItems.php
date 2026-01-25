public function loadFilterItems(){

    $filters = parse_url($_POST['filters']);

    return json_answer(["content"=>$this->component->ads_filters->getFiltersParentByCatalog($filters["query"], $_POST["filter_id"],$_POST["item_id"])]);

}