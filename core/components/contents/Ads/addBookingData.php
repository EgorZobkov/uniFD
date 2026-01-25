 public function addBookingData($params=[], $ad_id=0){
    global $app;

    $booking_additional_services = [];
    $booking_week_days_price = [];
    $booking_special_days = [];

    if(!$params["booking_full_payment_status"]){
        if(intval($params["booking_prepayment_percent"]) > 100){
            $params["booking_prepayment_percent"] = 100;
        }
    }

    $app->model->ads_booking_data->delete("ad_id=?", [$ad_id]);

    if($app->component->ads_categories->categories[$params['category_id']]["booking_status"]){

        if(is_array($params['booking_additional_services'])){
            foreach (array_slice($params['booking_additional_services'], 0, 30) as $key => $value) {
                if(trim($value["name"]) && intval($value["price"])){
                    $booking_additional_services[$key] = ["name"=>trim($value["name"]),"price"=>formattedPrice($value["price"])];
                }
            }
        }
        
        if(is_array($params['booking_week_days_price'])){
            foreach ($params['booking_week_days_price'] as $key => $value) {
                if(trim($value)){
                    $booking_week_days_price[$key] = trim($value);
                }
            }
        }

        if(is_array($params['booking_special_days'])){
            foreach (array_slice($params['booking_special_days'], 0, 30) as $key => $value) {
                if(trim($value["date"]) && intval($value["price"])){
                    $booking_special_days[$key] = ["date"=>date("Y-m-d", strtotime($value["date"])),"price"=>formattedPrice($value["price"])];
                }
            }
        }

        $app->model->ads_booking_data->insert(["deposit_status"=>(int)$params['booking_deposit_status'], "full_payment_status"=>(int)$params['booking_full_payment_status'], "deposit_amount"=>round($params['booking_deposit_amount']?:0,2), "prepayment_percent"=>(int)$params['booking_prepayment_percent'], "max_guests"=>(int)$params['booking_max_guests'], "min_days"=>(int)$params['booking_min_days'], "max_days"=>(int)$params['booking_max_days'], "week_days_price"=>$booking_week_days_price ? _json_encode($booking_week_days_price) : null, "additional_services"=>$booking_additional_services ? _json_encode($booking_additional_services) : null, "special_days"=>$booking_special_days ? _json_encode($booking_special_days) : null, "ad_id"=>$ad_id]);

    }

}