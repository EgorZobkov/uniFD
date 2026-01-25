public function deals(){

    $getDeals = $this->model->transactions_deals->getAll("unix_timestamp(time_create) + 86400 <= unix_timestamp(now()) and (status_processing=? or status_processing=?) and status_completed=?", ["awaiting_confirmation","confirmed_order",0]);

    if($getDeals){
        foreach ($getDeals as $value) {

            if($value["status_processing"] == "awaiting_confirmation"){
                $this->component->transaction->cancelDeal($value["order_id"], $value["whom_user_id"]);
            }elseif($value["status_processing"] == "confirmed_order"){
                if(!$value["status_payment"]){
                    $this->component->transaction->cancelDeal($value["order_id"], $value["whom_user_id"]);
                }
            }
            
        }
    }


    $getDeals = $this->model->transactions_deals->getAll("DATE_ADD(`time_create`, INTERVAL ".$this->settings->secure_deal_auto_closing_time." DAY) <= now() and status_payment=? and status_completed=?", [1,0]);
    
    if($getDeals){
        foreach ($getDeals as $value) {

            if($value["status_processing"] == "access_open" || $value["status_processing"] == "confirmed_transfer" || $value["status_processing"] == "confirmed_completion_service"){
                $this->component->transaction->changeStatusDeal($value["order_id"], $value["from_user_id"], "completed_order");
            }
            
        }
    }

    $getBookingOrders = $this->model->transactions_deals->getAll("now() >= time_completed and status_payment=? and status_completed=? and status_processing=?", [1,0,"booked"]);
    
    if($getBookingOrders){
        foreach ($getBookingOrders as $value) {

            $this->component->transaction->changeStatusDeal($value["order_id"], $value["from_user_id"], "completed_order");
            
        }
    }

    $service = $this->component->transaction->getServiceSecureDeal();

    if($service){
        if ($service->secure_deal_status) {
            
            $getPayments = $this->model->transactions_deals_payments->sort("id asc limit 100")->getAll("status_processing=?", ["awaiting_payment"]);
            if($getPayments){
                foreach ($getPayments as $key => $value) {
                    
                    $this->component->transaction->createPayout($value, $service->alias);

                }
            }

        }
    }

}