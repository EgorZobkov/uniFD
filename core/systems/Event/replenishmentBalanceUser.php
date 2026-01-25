public function replenishmentBalanceUser($data = []){
    global $app;
    
    $app->notify->params((array)$data)->userId($data["user_id"])->code("user_balance_replenishment")->addWaiting();

}