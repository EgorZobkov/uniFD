public function getBookingPricesDate($ad=[], $current_date=null, $list_dates=[]){
    global $app;

    $content = [];
    $dates = [];

    if($ad->booking->week_days_price){

        if($current_date){
            $y = date("Y", strtotime($current_date));
            $m = date("m", strtotime($current_date));
        }else{
            $y = date("Y");
            $m = date("m");                        
        }

        if($list_dates){
            foreach ($list_dates as $key => $value) {
                $dates[date("m", strtotime($value))] = $value;
            }
        }

        if($dates){
            foreach ($dates as $key => $value) {
                foreach ($app->datetime->getDaysInYearMonth(date("Y", strtotime($value)), date("m", strtotime($value))) as $date) {

                    $number_day_week = date("w",strtotime($date)) == 0 ? 7 : date("w",strtotime($date));

                    if($ad->booking->week_days_price[$number_day_week]){

                        $price = $ad->booking->week_days_price[$number_day_week];

                        $content[$date] = ["date"=>$date, "price_str"=>$app->system->amount($price), "price"=>$price];

                    }

                }
            }
        }else{
            foreach ($app->datetime->getDaysInYearMonth($y, $m) as $date) {

                $number_day_week = date("w",strtotime($date)) == 0 ? 7 : date("w",strtotime($date));

                if($ad->booking->week_days_price[$number_day_week]){

                    $price = $ad->booking->week_days_price[$number_day_week];

                    $content[$date] = ["date"=>$date, "price_str"=>$app->system->amount($price), "price"=>$price];

                }

            }
        }

    }

    if($ad->booking->special_days){
        foreach ($ad->booking->special_days as $key => $value) {
            $content[$value["date"]] = ["date"=>$value["date"], "price_str"=>$app->system->amount($value["price"]), "price"=>$value["price"]];
        }
    }

    return $content;        

}