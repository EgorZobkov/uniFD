public function createShop($data = []){
    global $app;

    $app->notify->params((array)$data)->code("system_open_shop")->addWaiting();

}