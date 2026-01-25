public function getDealByItemId($item_id=0, $user_id=0){
    global $app;

    $getItem = $app->model->transactions_deals_items->find("item_id=? and from_user_id=?", [$item_id,$user_id]);

    if($getItem){
        return $app->model->transactions_deals->find("status_completed=? and order_id=?", [0,$getItem->order_id]);
    }

    return [];

}