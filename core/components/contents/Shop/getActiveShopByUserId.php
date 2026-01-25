public function getActiveShopByUserId($user_id=0){
    global $app;

    return $app->model->shops->find("user_id=? and status=?", [$user_id, "published"]);

}