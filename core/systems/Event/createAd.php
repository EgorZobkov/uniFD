public function createAd($data = []){
    global $app;

    $app->notify->params((array)$data)->code("system_create_ad")->addWaiting();

}