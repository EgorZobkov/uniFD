public function getBanners($shop_id=0){
    global $app;

    $result = [];

    $banners = $app->model->shops_banners->sort("id desc")->getAll("shop_id=?", [$shop_id]);
    if($banners){
        foreach ($banners as $key => $value) {
            
            $result[] = ["id"=>$value["id"], "image"=>$app->storage->name($value["image"])->get()];

        }
    }

    return $result;

}