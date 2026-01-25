public function outInfoPaymentsOrderDeal($order_id=0, $user_id=0){
    global $app;

    $getPayment = $app->model->transactions_deals_payments->find("order_id=? and whom_user_id=?", [$order_id, $user_id]);

    if($getPayment){
        if($getPayment->status_processing == "awaiting_payment"){

            return $app->system->amount($getPayment->amount).' '.translate("tr_e583db0168523757a8bc054e9a2db4e9"); 

        }elseif($getPayment->status_processing == "done"){

            return $app->system->amount($getPayment->amount) . ' ' . translate("tr_95231d935ffb9f48fd901c46e92676f7");

        }elseif($getPayment->status_processing == "no_score"){

            return translate("tr_ca6482e97550b5bd24f16d04d7e711a5").' <div><button class="btn-custom-mini button-color-scheme5 mt10" data-bs-target="#addPaymentScoreModal" data-bs-toggle="modal" >'.translate("tr_dcaa92e2ddc6a6305e3592910fee8df6").'</button> </div>';

        }elseif($getPayment->status_processing == "payment_error"){

            if($getPayment->comment && $getPayment->user_show_error){
                return $getPayment->comment; 
            }else{
                return $app->system->amount($getPayment->amount).' '.translate("tr_e583db0168523757a8bc054e9a2db4e9"); 
            }

        }
    }

}