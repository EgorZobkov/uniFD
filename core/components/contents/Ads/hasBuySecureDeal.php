public function hasBuySecureDeal($data=[]){
    global $app;

    $payment = $app->component->transaction->getServiceSecureDeal();

    if($payment){

        if($data->status == 1){
            if($data->price && !$data->price_gratis_status && !$data->booking_status && ($app->component->ads_categories->categories[$data->category_id]["type_goods"] == "physical_goods" || $app->component->ads_categories->categories[$data->category_id]["type_goods"] == "electronic_goods" || $app->component->ads_categories->categories[$data->category_id]["type_goods"] == "services")){

                if($data->price < $payment->secure_deal_min_amount){
                    return false;
                }

                if($payment->secure_deal_max_amount){
                    if($data->price > $payment->secure_deal_max_amount){
                        return false;
                    }
                }

                if($app->component->ads_categories->categories[$data->category_id]["type_goods"] == "realty" && !$app->component->ads_categories->categories[$data->category_id]["booking_status"]){
                    return false;
                }

                if($app->component->ads_categories->categories[$data->category_id]["type_goods"] == "transport" && !$app->component->ads_categories->categories[$data->category_id]["booking_status"]){
                    return false;
                }

                if($app->component->ads_categories->categories[$data->category_id]["secure_status"]){
                    return true;
                }

            }
        }

    }

    return false;

}