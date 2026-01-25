public function getTotalTransactions(){   
    global $app;

    return $app->model->transactions->count();

}