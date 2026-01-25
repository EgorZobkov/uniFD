public function shopsByCategories($alias)
{   

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/shops.js\" type=\"module\" ></script>"]);

    $data = (object)[];

    $data->category = $this->component->ads_categories->getCategoryByAlias($alias, true);

    if(!$data->category){
        abort(404);
    }

    return $this->view->render('shops', ["data"=>(object)$data, "seo"=>(object)["meta_title"=>$data->category["name"], "h1"=>$data->category["name"]]]);

}