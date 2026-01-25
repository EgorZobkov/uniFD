public function delete($id=0){
    global $app;

    $parentIds = $this->getParentIds($id);

    if($parentIds){
        foreach (explode(",", $parentIds) as $key => $value) {
           $app->model->ads_categories->cacheKey(["id"=>$value])->delete("id=?", [$value]);
        }
    }

    $app->model->ads_categories->cacheKey(["id"=>$id])->delete("id=?", [$id]);

    $key = $app->caching->buildKey($this->table, $cacheKey);

    $app->caching->delete($app->caching->buildKey("uni_ads_categories", ["all_categories"]));

}