public function getWhomUserOrders($user_id=0){   
    global $app;

    $content = '';

    $getOrders = $app->model->transactions_deals->pagination(true)->page($_GET['page'])->output(10)->sort("time_update desc")->getAll("whom_user_id=?", [$user_id]);

    if($getOrders){
        foreach ($getOrders as $key => $value) {
           
            $value = $app->component->transaction->getDataDealByValue($value);

            $content .= $app->view->setParamsComponent(['value'=>(object)$value])->includeComponent('items/order-list.tpl');

        }
    }

    return $content;
    
}