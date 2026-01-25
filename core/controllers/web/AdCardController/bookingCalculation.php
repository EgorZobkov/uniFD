public function bookingCalculation(){

    $content = [];
    $endingWord = "";
    $dates = [];

    if($_POST["id"]){

        $ad = $this->component->ads->getAd($_POST["id"]);

        if($ad && !$ad->delete){

            if($_POST['date_start'] && $_POST['date_end']){

                $count_days = $this->datetime->getDaysDiff($_POST['date_start'], $_POST['date_end']);
                $listDates = $this->datetime->getDaysBetweenDates($_POST['date_start'], $_POST['date_end']);
                $priceDates = $this->component->ads->getBookingPricesDate($ad, null, $listDates);

                if($ad->booking->min_days){
                    if($count_days < $ad->booking->min_days){
                        $content = '<span class="btn-custom button-color-scheme7 width100 mt20 mb10" >'.translate("tr_e48e095a7af2a4101945ea7a3e21da70").' '.$ad->booking->min_days.' '.$this->component->ads->outBookingEndingWord($ad->booking->min_days, $ad->category_id).'</span>';
                        return json_answer(["content"=>$content]);
                    }
                }elseif($ad->booking->max_days){
                    if($count_days > $ad->booking->max_days){
                        $content = '<span class="btn-custom button-color-scheme7 width100 mt20 mb10" >'.translate("tr_8d853f422a28157b49a576d46e7a73e5").' '.$ad->booking->max_days.' '.$this->component->ads->outBookingEndingWord($ad->booking->max_days, $ad->category_id).'</span>';
                        return json_answer(["content"=>$content]);
                    }
                }

                if($count_days > 360){
                    $content = '<span class="btn-custom button-color-scheme7 width100 mt20 mb10" >'.translate("tr_9fd5c4cfe52bd59f562157cc00624455").'</span>';
                    return json_answer(["content"=>$content]);
                }

                foreach ($listDates as $key => $value) {
                    $dates[] = "'$value'";
                }

                if($this->model->booking_dates->count("ad_id=? and date IN(".implode(",", $dates).")", [$ad->id])){
                    $content = '<span class="btn-custom button-color-scheme7 width100 mt20 mb10" >'.translate("tr_3793c58c4a81b14f116e7d11aba59416").'</span>';
                    return json_answer(["content"=>$content]);
                }

                if($count_days){

                    foreach (array_slice($this->datetime->getDaysBetweenDates($_POST['date_start'], $_POST['date_end']), 0, $count_days) as $value) {

                        if($priceDates[$value]){
                            $price += $priceDates[$value]["price"];
                        }else{
                            $price += $ad->price;
                        }
                        
                    }

                    if($this->component->ads_categories->categories[$ad->category_id]["booking_action"] == "booking"){

                        $content = '<span class="btn-custom button-color-scheme7 width100 mt20 mb10 ad-card-booking-button-order actionOpenStaticModal" data-modal-target="bookingOrder" data-modal-params="'.buildAttributeParams(["id"=>$_POST["id"], "date_start"=>$_POST['date_start'], "date_end"=>$_POST['date_end'], "total_price"=>$price, "count_days"=>$count_days]).'" >'.$count_days.' '.$this->component->ads->outBookingEndingWord($count_days, $ad->category_id).', '.$this->system->amount($price).' <br> '.translate("tr_cd55f578846d46ff5faf9c6fd9a13da5").'</span>';

                    }else{

                        $content = '<span class="btn-custom button-color-scheme7 width100 mt20 mb10 ad-card-booking-button-order actionOpenStaticModal" data-modal-target="bookingOrder" data-modal-params="'.buildAttributeParams(["id"=>$_POST["id"], "date_start"=>$_POST['date_start'], "date_end"=>$_POST['date_end'], "total_price"=>$price, "count_days"=>$count_days]).'" >'.$count_days.' '.$this->component->ads->outBookingEndingWord($count_days, $ad->category_id).', '.$this->system->amount($price).' <br> '.translate("tr_2f085942ad27825ae84ca1855e410802").'</span>';

                    }

                }else{
                    $content = '<span class="btn-custom button-color-scheme7 width100 mt20 mb10" >'.translate("tr_8451e9509832d0c5d778ea3333902b06").'</span>';
                }

            }else{
                $content = '<span class="btn-custom button-color-scheme7 width100 mt20 mb10" >'.translate("tr_8451e9509832d0c5d778ea3333902b06").'</span>';
            }

        }

    }

    return json_answer(["content"=>$content]);
    
}