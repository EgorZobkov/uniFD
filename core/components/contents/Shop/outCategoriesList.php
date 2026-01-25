public function outCategoriesList($shop_id=0){   
    global $app;

    $shop = $app->model->shops->find("id=?", [$shop_id]);

    $categories = $this->buildCategories($shop->user_id);

    return $this->outRecursionCategories($categories,0,0,$shop->alias);
    
}