public function editShop($data = []){
    global $app;

    $app->notify->params((array)$data)->code("system_edit_shop")->addWaiting();
}