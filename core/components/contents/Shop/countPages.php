public function countPages($shop_id=0){   
    global $app;

    return $app->model->shops_pages->count("shop_id=?", [$shop_id]);
    
}