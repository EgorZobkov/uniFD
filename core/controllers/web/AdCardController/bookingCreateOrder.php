public function bookingCreateOrder(){

    $answer = [];
    $price = 0;
    $dates = [];

    $ad = $this->component->ads->getAd($_POST["id"]);

    if(!$ad || $ad->delete){
        return json_answer(["status"=>false]);
    }

    if(!$_POST['date_start'] || !$_POST['date_end']){
        return json_answer(["status"=>false]);
    }

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }

    if($this->validation->isPhone($_POST['phone'])->status == false){
        $answer['phone'] = $this->validation->error;
    }

    if($this->validation->isEmail($_POST['email'])->status == false){
        $answer['email'] = $this->validation->error;
    }

    if($this->component->ads_categories->categories[$ad->category_id]["booking_action"] == "booking"){
        if($this->validation->requiredField($_POST['guests'])->status == false){
            $answer['guests'] = $this->validation->error;
        }
    }

    if($this->validation->requiredField($_POST['time'])->status == false){
        $answer['time'] = $this->validation->error;
    }

    if(empty($answer)){

        $date_start = $_POST['date_start'] . " " . $_POST['time'];
        $date_end = $_POST['date_end'] . " " . $_POST['time'];

        $count_days = $this->datetime->getDaysDiff($date_start, $date_end);

        if($ad->booking->min_days){
            if($count_days < $ad->booking->min_days){
                return json_answer(["status"=>false]);
            }
        }elseif($ad->booking->max_days){
            if($count_days > $ad->booking->max_days){
                return json_answer(["status"=>false]);
            }
        }

        if($count_days > 360){
            return json_answer(["status"=>false]);
        }

        if($count_days){

            $listDates = $this->datetime->getDaysBetweenDates($date_start, $date_end);
            $priceDates = $this->component->ads->getBookingPricesDate($ad, null, $listDates);

            foreach (array_slice($listDates, 0, $count_days) as $value) {

                if($priceDates[$value]){
                    $price += $priceDates[$value]["price"];
                }else{
                    $price += $ad->price;
                }
                
            }

            foreach ($listDates as $key => $value) {
                $dates[] = "'$value'";
            }

            if($this->model->booking_dates->count("ad_id=? and date IN(".implode(",", $dates).")", [$ad->id])){
                return json_answer(["status"=>false, "answer"=>translate("tr_86c3bdbfc09c1e10e13a6bbf05a98f08")]);
            }

            if($_POST['order_additional_services']){
                foreach ($_POST['order_additional_services'] as $key => $value) {
                    $price += $ad->booking->additional_services[$key]["price"];
                }
            }

            if($ad->booking->full_payment_status){
                $total_price = $price;
            }else{
                $total_price = calculatePercent($price, $ad->booking->prepayment_percent);
            }
            
            $order_id = $this->component->transaction->createDeal(["amount"=>$total_price, "from_user_id"=>$this->user->data->id, "whom_user_id"=>$ad->user_id, "status_payment"=>0, "status_processing"=>"awaiting_confirmation", "item_id"=>$ad->id, "count"=>1, "price"=>$total_price, "time_completed"=>$date_start]);

            if($order_id){

                $this->model->booking_orders->insert(["ad_id"=>$ad->id, "user_id"=>$this->user->data->id,"amount"=>$price,"count_days"=>$count_days,"user_email"=>encrypt($_POST['email']), "user_phone"=>encrypt($this->clean->phone($_POST['phone'])), "user_name"=>$_POST['name'], "time_create"=>$this->datetime->format("Y-m-d")->getDate(),"additional_services"=>$_POST['order_additional_services'] ? _json_encode($_POST['order_additional_services']) : null, "count_guests"=>(int)$_POST['guests'], "date_start"=>$date_start, "date_end"=>$date_end, "order_id"=>$order_id]);

                foreach (array_slice($listDates, 0, $count_days) as $key => $value) {
                    $this->model->booking_dates->insert(["ad_id"=>$ad->id,"date"=>$value, "order_id"=>$order_id]);
                }

                $this->component->transaction->addHistoryDeal(["order_id"=>$order_id, "action_code"=>"create_booking"]);

                $this->event->createOrderBooking(["item_id"=>$ad->id, "from_user_id"=>$this->user->data->id, "whom_user_id"=>$ad->user_id,"amount"=>$price,"count_days"=>$count_days,"user_email"=>$_POST['email'], "user_phone"=>$this->clean->phone($_POST['phone']), "user_name"=>$_POST['name'], "count_guests"=>(int)$_POST['guests'], "date_start"=>$date_start, "date_end"=>$date_end, "order_id"=>$order_id, "external_content"=>$ad->external_content]);

            }
            
            return json_answer(["status"=>true, "link"=>getHost(true).'/order/card/'.$order_id]);

        }

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }
    
}