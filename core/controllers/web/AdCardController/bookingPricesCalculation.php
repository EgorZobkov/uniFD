public function bookingPricesCalculation(){

    $content = "";

    $ad = $this->component->ads->getAd($_POST["id"]);

    if(!$ad || $ad->delete){
        return json_answer(["content"=>""]);
    }

    $count_days = $this->datetime->getDaysDiff($_POST['date_start'], $_POST['date_end']);

    if($count_days > 360){
        return json_answer(["content"=>""]);
    }

    if($count_days){

        $listDates = $this->datetime->getDaysBetweenDates($_POST['date_start'], $_POST['date_end']);
        $priceDates = $this->component->ads->getBookingPricesDate($ad, null, $listDates);

        foreach (array_slice($listDates, 0, $count_days) as $value) {

            if($priceDates[$value]){
                $price += $priceDates[$value]["price"];
            }else{
                $price += $ad->price;
            }
            
        }

        if($_POST['order_additional_services']){
            foreach ($_POST['order_additional_services'] as $key => $value) {
                $price += $ad->booking->additional_services[$key]["price"];
            }
        }

        $content = '
          <li>
            <span class="list-points-title">'.translate("tr_bd4cff11ef068d53f12becf7fc98f517").'</span>
            <span class="list-points-chapter">'.$this->system->amount($price).'</span>
          </li>
        ';

        if(!$ad->booking->full_payment_status){
            $content .= '
              <li>
                <span class="list-points-title">'.translate("tr_f1d0076b2267f5559b482d28106b33a1").'</span>
                <span class="list-points-chapter">'.$this->system->amount(calculatePercent($price, $ad->booking->prepayment_percent)).'</span>
              </li>
            ';                
        }

        if($ad->booking->deposit_status){
            $content .= '
              <li>
                <span class="list-points-title">'.translate("tr_c7bb13829f0c52a28e01bedd29bdfe0d").'</span>
                <span class="list-points-chapter">'.$this->system->amount($ad->booking->deposit_amount).'</span>
              </li>
            ';                
        }

        if(!$ad->booking->full_payment_status){
            $content = '
              <li>
                <span class="list-points-title">'.translate("tr_9a6054b1258786529c4dd909ec032383").'</span>
                <span class="list-points-chapter">'.$this->system->amount($price-calculatePercent($price, $ad->booking->prepayment_percent)).'</span>
              </li>
            ';
        }

    }

    return json_answer(["content"=>$content]);
    
}