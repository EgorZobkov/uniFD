public function getTotalDeals(){   
    global $app;

    return $app->model->transactions_deals->count();

}