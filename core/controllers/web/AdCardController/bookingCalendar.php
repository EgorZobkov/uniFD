public function bookingCalendar(){

    $content = [];
    $dates_disabled = [];

    if($_POST["id"]){

        $ad = $this->component->ads->getAd($_POST["id"]);

        if($ad){

            $content = $this->component->ads->getBookingPricesDate($ad, $_POST['date']);

        }

        $getDates = $this->model->booking_dates->getAll("ad_id=?", [$ad->id]);

        if($getDates){
            foreach ($getDates as $key => $value) {
                $dates_disabled[] = date("d/m/Y", strtotime($value["date"]));
            }
        }

    }

    return json_answer(["content"=>$content, "dates_disabled"=>$dates_disabled]);
    
}