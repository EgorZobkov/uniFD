public function loadSubcategories(){

    $content = '';

    $content = $this->component->ads_categories->outReverseCategories($_POST["id"]);

    ob_start();

    echo $this->component->catalog->buildParamsForm([], $_POST["id"], false);

    $filters = ob_get_clean();

    return json_answer(["content"=>$content, "filters"=>$filters]);

}