public function writedownBalanceUser($data = []){
    global $app;
    
    $app->notify->params((array)$data)->userId($data["user_id"])->code("user_balance_write_downs")->addWaiting();

}