public function updateCount(){   

    $total_price = 0;
    $total_price_old = 0;
    $count = $_POST['count'] ? abs(intval($_POST['count'])) : 1;

    if($_POST['service_id']){

        $getService = $this->model->ads_services->find("id=?", [$_POST['service_id']]);

        if($getService){

            $total_price = $count * $getService->price;

            if($getService->old_price){
                $total_price_old = $count * $getService->old_price;
            }

            return json_answer(["price_now"=>$this->system->amount($total_price), "price_old"=>$this->system->amount($total_price_old), "count"=> translate("tr_1f6c150ae7fba44b3897f51c51c4ca47") . ' ' . $count . ' ' . endingWord($count, translate("tr_48e438a146f96b54bbe9d5046ffc3a2b"), translate("tr_0871eeafdf38726742fa5affa8a5d6eb"), translate("tr_c183655a02377815e6542875555b1340"))]);

        }

    }

}