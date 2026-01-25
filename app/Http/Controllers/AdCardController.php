<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Http\Controllers;

 use App\Systems\Controller;

 class AdCardController extends Controller
 {

 public function __construct($app){
 parent::__construct($app); 
 }

 public function addComplaint(){

    if($this->validation->requiredField($_POST['text'])->status == false){
        return json_answer(["status"=>false, "answer"=>translate("tr_c5f9d5595eb159c22ec1fed1bf239aa5")]);
    }else{

        $data = $this->component->ads->getAd($_POST["id"]);

        if($data && !$data->delete){

            if(!$this->model->complaints->find("from_user_id=? and item_id=? and status=?", [$this->user->data->id,$_POST["id"],0])){
                $this->model->complaints->insert(["from_user_id"=>$this->user->data->id,"text"=>$_POST["text"],"item_id"=>$_POST["id"],"whom_user_id"=>$data->user_id,"time_create"=>$this->datetime->getDate()]);
                $this->event->addComplaintAd(["from_user_id"=>$this->user->data->id, "whom_user_id"=>$data->user_id, "text"=>$_POST["text"], "item_id"=>$_POST["id"]]);
            }

        }

    } 

    return json_answer(["status"=>true, "answer"=>translate("tr_9ce23934d783d857c38fc685eb0b5049")]);
    
}

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

public function card($aliases, $ad_alias, $ad_id){   

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/ad_card.js\" type=\"module\" ></script>"]);

    $data = $this->component->ads->getAd($ad_id);

    if(!$data || !$data->user){
        abort(404);
    }else{

        $chain = $this->component->ads_categories->chainCategory($data->category_id);

        $aliases = explode("/", $aliases);

        if($this->translate->getChangeLang() == $aliases[0]){
            unset($aliases[0]);
            $aliases = array_values($aliases);
        }            

        if($data->geo){
            if($data->geo->alias != $aliases[0] || $chain->chain_build_alias_dash != $aliases[1] || $data->alias != $ad_alias){
                abort(404);
            }                
        }else{
            if($chain->chain_build_alias_dash != $aliases[0] || $data->alias != $ad_alias){
                abort(404);
            }                 
        }

    }

    $data->owner = $data->user_id == $this->user->data->id ? true : false;

    $this->session->setNestedSubarray("ad-contact", $data->id, $data->id);

    $data->in_favorites = $this->component->profile->inFavorite($data->id, $this->user->data->id);

    $property = $this->component->ads_filters->outPropertyAd($data->id);
    if($property){
        $data->property = $property;
    }

    if(!$data->owner){
        $this->component->ads->fixView($data->id, $this->user->data->id);
    }

    $data->count_reviews = $this->component->reviews->countByAdId($data);

    $data->similar_items = $this->component->ads->getSimilarItems($data);

    $seo = $this->component->seo->content($data);

    return $this->view->render('ad-card', ["data"=>(object)$data, "seo"=>$seo]);
}

public function changeStatusPublication(){

    $this->model->ads_data->update(["status"=>3], ["id=? and user_id=?", [$_POST['id'], $this->user->data->id]]);

    return json_answer(["status"=>true]);
    
}

public function changeStatusSold(){

    $this->model->ads_data->update(["status"=>7], ["id=? and user_id=?", [$_POST['id'], $this->user->data->id]]);

    return json_answer(["status"=>true]);
    
}

public function delete(){

    $this->component->ads->delete($_POST["id"], $this->user->data->id);

    return json_answer(["status"=>true, "redirect"=>outRoute("profile")]);
    
}

public function extend(){

    $this->component->ads->extend($_POST["id"], $this->user->data->id);

    $this->session->setNotify("success", translate("tr_6b4ee3c71b62d2b91f2f8374eb3aba57"));

    return json_answer(["status"=>true]);
    
}

public function goPartnerLink(){

    if($this->settings->board_card_who_transition_partner_link == "auth"){

        if(!$this->user->isAuth()){
            return json_answer(["auth"=>false]);
        }

    }

    $ad = $this->model->ads_data->find("id=?", [$_POST['id']]);

    if($ad){
        if($ad->partner_link){
            $this->event->goPartnerLink(["from_user_id"=>$this->user->data->id, "ad_id"=>$_POST['id']]);
            return json_answer(["link"=>$ad->partner_link]);
        }
    }
    
}

public function showContacts(){  

    $contacts_items = "";
    $messengers_items = "";
    $messengers = "";
    $ad_contact = $this->session->get("ad-contact");

    if(!$ad_contact[$_POST["id"]]){
        return;
    }

    $data = $this->component->ads->getAd($_POST["id"]);

    if($data->status != 1 || $data->block_forever_status){
         return;
    }

    $data->contacts->name = $data->contacts->name ?: $data->user->name;
    $data->contacts->phone = $data->contacts->phone ?: $data->user->phone;

    if($data){

        if($data->contact_method == "all" || $data->contact_method == "call"){

            if($data->contacts->phone){

                if($this->settings->phone_add_plus_status){
                    $data->contacts->phone = "+" . trim($data->contacts->phone, "+");
                }

                $contacts_items .= '
                    <a class="card-contact-user-item-box" href="tel:'.$data->contacts->phone.'" target="_blank" >
                        <img src="'.$this->storage->name("9aa2c959051f186bf1f74435227f2a1a.webp")->path('images')->get().'" />
                        '.$data->contacts->phone.'
                    </a>
                ';
            }

            if($data->contacts->email && $this->settings->board_publication_required_email){
                $contacts_items .= '
                    <a class="card-contact-user-item-box" href="mailto:'.$data->contacts->email.'" target="_blank" >
                        <img src="'.$this->storage->name("ad4223f1837394992a75515fb489a3e4.webp")->path('images')->get().'" />
                        '.$data->contacts->email.'
                    </a>
                ';
            }

            if($data->contacts->max && $this->settings->board_publication_required_contact_max){
                $messengers_items .= '
                    <a class="card-contact-user-item-box" href="https://max.ru/'.$data->contacts->max.'" target="_blank" >
                        <img src="'.$this->storage->name("social/max.png")->path('images')->get().'" />
                        Max
                    </a>
                ';
            }

            if($data->contacts->telegram && $this->settings->board_publication_required_contact_telegram){
                $messengers_items .= '
                    <a class="card-contact-user-item-box" href="https://t.me/'.$data->contacts->telegram.'" target="_blank" >
                        <img src="'.$this->storage->name("social/tg.png")->path('images')->get().'" />
                        Telegram
                    </a>
                ';
            }

            if($data->contacts->whatsapp && $this->settings->board_publication_required_contact_whatsapp){
                $messengers_items .= '
                    <a class="card-contact-user-item-box" href="https://wa.me/'.$this->clean->phone($data->contacts->whatsapp).'" target="_blank" >
                        <img src="'.$this->storage->name("social/wa.png")->path('images')->get().'" />
                        WhatsApp
                    </a>
                ';
            }

            if($messengers_items){
                $messengers = '
                <div class="card-contact-user-item" >
                    <p>'.translate("tr_68c83fa9d2124c69367bcaae051a83dc").'</p>

                    '.$messengers_items.'

                </div>
                ';
            }

            $content = '
            <div class="card-contact-user" >

                <div class="card-contact-user-item" >
                <p>'.translate("tr_d38d6d925c80a2267031f3f03d0a9070").'</p>
                <h4>'.$data->contacts->name.'</h4>
                </div>

                <div class="card-contact-user-item" >
                    <p>'.translate("tr_75768c49c24662cc4465237b0731e1ce").'</p>

                    '.$contacts_items.'

                </div>

                '.$messengers.'

            </div>';

            if($this->settings->board_card_who_phone_view == "all"){

                if($this->user->isAuth()){
                    $this->event->showAdContacts(["ad_id"=>$_POST["id"], "from_user_id"=>$this->user->data->id]);
                }

                return json_answer(["content"=>$content]);

            }elseif($this->settings->board_card_who_phone_view == "auth"){

                if($this->user->isAuth()){

                    if($this->component->profile->checkVerificationPermissions($this->user->data->id, "view_contacts")){

                        $this->event->showAdContacts(["ad_id"=>$_POST["id"], "from_user_id"=>$this->user->data->id]);

                        return json_answer(["content"=>$content]);

                    }else{
                        return json_answer(["verification"=>false]);
                    }

                }else{
                    return json_answer(["auth"=>false]);
                }

            }

        }

    }

}



 }