<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Http\Controllers\Api;

use App\Systems\Controller;

class BookingController extends Controller {

    public function __construct($app){
        parent::__construct($app); 
    }

    public function getData(){

        if(!$this->api->verificationAuth($_GET['token'], $_GET['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $price = 0;
        $result = [];
        $busy_dates = [];
        $additional_services_list = [];
        $count_days = null;

        $_GET["additional_services"] = $_GET["additional_services"] ? _json_decode(html_entity_decode($_GET["additional_services"])) : [];

        if(!intval($_GET['ad_id'])){
            return json_answer(null);
        }

        $ad = $this->component->ads->getAd($_GET['ad_id']);

        if(!$ad || $ad->delete || $ad->status != 1 || !$ad->booking_status){
            return json_answer(["status"=>false, "answer"=>translate("tr_980279c7b33de4b5dc119d3acd68d981")]);
        }

        $dates = $this->model->booking_dates->getAll("ad_id=?", [$ad->id]);

        if($dates){
            foreach ($dates as $value) {
                $busy_dates[date('d.m.Y', strtotime($value['date']))] = $value['date'];
            }
        }

        if($_GET['date_start'] && $_GET['date_end']){

            $count_days = $this->datetime->getDaysDiff($_GET['date_start'], $_GET['date_end']);

            if($count_days >= 180){
                return json_answer(["status"=>false, "answer"=>translate("tr_8c5b5526ecabfbfc625ea9081d038239")]);
            }

            if(!$count_days){
                return json_answer(["status"=>false, "answer"=>translate("tr_ea249cc3d956558d20fb8b6c14fca2e5")]);
            }

            $listDates = $this->datetime->getDaysBetweenDates($_GET['date_start'], $_GET['date_end']);
            $priceDates = $this->component->ads->getBookingPricesDate($ad, null, $listDates);

            foreach (array_slice($listDates, 0, $count_days) as $value) {

                if($priceDates[$value]){
                    $price += $priceDates[$value]["price"];
                }else{
                    $price += $ad->price;
                }
                
            }

        }else{

            $listDates = $this->datetime->getDaysBetweenDates(date("Y-m-d"), date("Y-m-d", strtotime('+6 month', time())));
            $priceDates = $this->component->ads->getBookingPricesDate($ad, null, $listDates);

        }

        if($_GET['additional_services']){
            foreach ($_GET['additional_services'] as $key => $value) {
                $price += $ad->booking->additional_services[$value["key"]]["price"];
            }
        }

        if($ad->booking->additional_services){
            foreach ($ad->booking->additional_services as $key => $value) {
                $additional_services_list[] = ["key"=>$key, "name"=>$value["name"], "price"=>$this->system->amount($value["price"])];
            }
        }

        $result = [
            "variant" => $this->component->ads_categories->categories[$ad->category_id]["booking_action"],
            "variant_name" => $this->component->ads_categories->categories[$ad->category_id]["booking_action"] == "booking" ? translate("tr_543c872407d0aa834e734f713afdcf33") : translate("tr_9f0bba0dacad1eacd3a9fcd80e8bd00a"),
            "max_guests" => $ad->booking->max_guests ?: 30,
            "min_days" => $ad->booking->min_days,
            "max_days" => $ad->booking->max_days,
            "price" => $this->system->amount($price),
            "ad" => [
                "id"=>$ad->id,
                "title"=>$ad->title,
                "image"=>$ad->media->images->first,
                "status"=>$ad->status,
                "status_name"=>$this->api->statusNameAd($ad->status),
            ],
            "days"=>$count_days ? $count_days . " " . endingWord($count_days, translate("tr_48e438a146f96b54bbe9d5046ffc3a2b"), translate("tr_0871eeafdf38726742fa5affa8a5d6eb"), translate("tr_c183655a02377815e6542875555b1340")) : null,
            "total_amount"=>$this->system->amount($price-calculatePercent($price, $ad->booking->prepayment_percent)),
            "prepayment_amount"=>$this->system->amount(calculatePercent($price, $ad->booking->prepayment_percent)),
            "deposit_amount"=>$this->system->amount($ad->booking->deposit_amount),
            "full_payment_status"=>$ad->booking->full_payment_status ? true : false,
            "additional_services_list"=>$additional_services_list ?: null,
            "busy_dates"=>$busy_dates ?: null,
            "deposit_status"=>$ad->booking->deposit_status ? true : false,
            "price_dates"=>$priceDates ?: null,
            "max_calendar_days"=>180,
        ];


        return json_answer(["data"=>$result, "status"=> true, "auth"=>true]);
    }    

    public function createOrder(){

        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $_POST["additional_services"] = $_POST["additional_services"] ? _json_decode(html_entity_decode($_POST["additional_services"])) : [];

        $answer = [];
        $price = 0;
        $dates = [];
        $additional_services = [];

        $ad = $this->component->ads->getAd($_POST["ad_id"]);

        if(!$ad || $ad->delete){
            return json_answer(null);
        }

        if(!$_POST['date_start'] || !$_POST['date_end']){
            return json_answer(null);
        }else{
            $_POST['date_start'] = $_POST['date_start'] ? date("Y-m-d", strtotime($_POST['date_start'])) : '';
            $_POST['date_end'] = $_POST['date_end'] ? date("Y-m-d", strtotime($_POST['date_end'])) : '';
        }

        if($this->validation->requiredField($_POST['name'])->status == false){
            $answer[] = translate("tr_ba62cf7772e8443da976d44c4df76989");
        }

        if($this->validation->isPhone($_POST['phone'])->status == false){
            $answer[] = translate("tr_524283064f10cdddf715075cb1f5a2bb");
        }

        if($this->validation->isEmail($_POST['email'])->status == false){
            $answer[] = translate("tr_3e3b7d9fb90cbdb9146fcff444b8ebe3");
        }

        if($this->component->ads_categories->categories[$ad->category_id]["booking_action"] == "booking"){
            if($this->validation->requiredField($_POST['guests'])->status == false){
                $answer['guests'] = translate("tr_b6492f0e6e8adc8d3fa50fb9d082374f");
            }
            if($this->validation->requiredField($_POST['time'])->status == false){
                $answer[] = translate("tr_e0649e0c001697b6855e3020a856e606");
            }
        }else{
            if($this->validation->requiredField($_POST['time'])->status == false){
                $answer[] = translate("tr_1d6cbc62a069593005cd5f8403a14a6a");
            }            
        }

        if(empty($answer)){

            $date_start = $_POST['date_start'] . " " . $_POST['time'];
            $date_end = $_POST['date_end'] . " " . $_POST['time'];

            $count_days = $this->datetime->getDaysDiff($date_start, $date_end);

            if($ad->booking->min_days){
                if($count_days < $ad->booking->min_days){
                    return json_answer(null);
                }
            }elseif($ad->booking->max_days){
                if($count_days > $ad->booking->max_days){
                    return json_answer(null);
                }
            }

            if($count_days >= 180){
                return json_answer(null);
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

                if($_POST['additional_services']){
                    foreach ($_POST['additional_services'] as $key => $value) {
                        $price += $ad->booking->additional_services[$value["key"]]["price"];
                        $additional_services[$value["key"]] = $value;
                    }
                }

                if($ad->booking->full_payment_status){
                    $total_price = $price;
                }else{
                    $total_price = calculatePercent($price, $ad->booking->prepayment_percent);
                }
                
                $order_id = $this->component->transaction->createDeal(["amount"=>$total_price, "from_user_id"=>$_POST['user_id'], "whom_user_id"=>$ad->user_id, "status_payment"=>0, "status_processing"=>"awaiting_confirmation", "item_id"=>$ad->id, "count"=>1, "price"=>$total_price, "time_completed"=>$date_start]);

                if($order_id){

                    $this->model->booking_orders->insert(["ad_id"=>$ad->id, "user_id"=>$_POST['user_id'],"amount"=>$price,"count_days"=>$count_days,"user_email"=>encrypt($_POST['email']), "user_phone"=>encrypt($this->clean->phone($_POST['phone'])), "user_name"=>$_POST['name'], "time_create"=>$this->datetime->format("Y-m-d")->getDate(),"additional_services"=>$additional_services ? _json_encode($additional_services) : null, "count_guests"=>(int)$_POST['guests'], "date_start"=>$date_start, "date_end"=>$date_end, "order_id"=>$order_id]);

                    foreach (array_slice($listDates, 0, $count_days) as $key => $value) {
                        $this->model->booking_dates->insert(["ad_id"=>$ad->id,"date"=>$value, "order_id"=>$order_id]);
                    }

                    $this->component->transaction->addHistoryDeal(["order_id"=>$order_id, "action_code"=>"create_booking"]);

                    $this->event->createOrderBooking(["item_id"=>$ad->id, "from_user_id"=>$_POST['user_id'], "whom_user_id"=>$ad->user_id,"amount"=>$price,"count_days"=>$count_days,"user_email"=>$_POST['email'], "user_phone"=>$this->clean->phone($_POST['phone']), "user_name"=>$_POST['name'], "count_guests"=>(int)$_POST['guests'], "date_start"=>$date_start, "date_end"=>$date_end, "order_id"=>$order_id, "external_content"=>$ad->external_content]);

                }
                
                return json_answer(["status"=>true, "auth"=>true, "order_id"=>$order_id]);

            }

        }else{
            return json_answer(["status"=>false, "auth"=>true, "answer"=>implode("\n", $answer)]);
        }
        
    }

}
