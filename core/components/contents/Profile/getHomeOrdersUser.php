public function getHomeOrdersUser($user_id=0){   
    global $app;

    $content = '';

    $getOrders = $app->model->transactions_deals->sort("time_update desc limit 4")->getAll("from_user_id=? or whom_user_id=?", [$user_id,$user_id]);

    if($getOrders){
        foreach ($getOrders as $key => $value) {
           
            $value = $app->component->transaction->getDataDealByValue($value);

            $content .= $app->view->setParamsComponent(['value'=>(object)$value])->includeComponent('items/order-grid.tpl');

        }
    }

    return $content;
    
}