public function openDisputeDeal($data = []){
    global $app;

    $app->notify->params((array)$data)->code("system_open_dispute_deal")->addWaiting();

}