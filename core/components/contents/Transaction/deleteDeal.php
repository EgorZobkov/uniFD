public function deleteDeal($order_id=0){   
    global $app;

    $app->model->transactions_deals->delete("order_id=?", [$order_id]);
    $app->model->transactions_deals_items->delete("order_id=?", [$order_id]);
    $app->model->transactions_deals_payments->delete("order_id=?", [$order_id]);
    $app->model->transactions_deals_history->delete("order_id=?", [$order_id]);

}