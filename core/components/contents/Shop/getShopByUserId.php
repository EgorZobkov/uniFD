public function getShopByUserId($user_id=0){
    global $app;

    return $app->model->shops->find("user_id=?", [$user_id]);

}