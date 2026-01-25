public function getShopByAlias($alias=null){
    global $app;

    return $app->model->shops->find("alias=?", [$alias]);

}