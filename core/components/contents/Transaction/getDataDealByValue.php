public function getDataDealByValue($value=[]){
    global $app;

    $getItems = $app->model->transactions_deals_items->find("order_id=?", [$value["order_id"]]);

    $value["item"] = $app->component->ads->getAd($getItems->item_id);

    return (object)$value;

}