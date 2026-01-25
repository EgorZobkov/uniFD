public function addStories($data = []){
    global $app;

    $app->notify->params((array)$data)->code("system_add_stories")->addWaiting();

}