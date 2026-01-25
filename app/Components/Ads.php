<?php

/**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Components;

class Ads
{

 public $alias = "ads";

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

public function addFreePublications($ad_id=0, $user_id=0, $category_id=0){
    global $app;

    if($app->component->ads_categories->categories[$category_id]["paid_status"]){
        if($app->component->ads_categories->categories[$category_id]["paid_free_count"]){

            $getPublication = $app->model->ads_free_publications->find("user_id=? and category_id=? and ad_id=?", [$user_id,$category_id,$ad_id]);
            if(!$getPublication){

                if($this->getRemainedCountFreePublicationsByUser($user_id, $category_id)){
                    $app->model->ads_free_publications->insert(["ad_id"=>$ad_id, "user_id"=>$user_id, "category_id"=>$category_id]);
                }

            }

        }
    }

}

public function addGeoDistricts($ids=[], $ad_id=0){
    global $app;

    if($ad_id){
        $app->model->ads_city_districts_ids->delete("ad_id=?", [$ad_id]);

        if($ids){
            if(is_array($ids)){
                foreach (array_slice($ids, 0,10) as $id) {
                    if($id){
                        $app->model->ads_city_districts_ids->insert(["ad_id"=>$ad_id, "district_id"=>$id]);
                    }
                }
            }
        }
    }

}

public function addGeoMetro($ids=[], $ad_id=0){
    global $app;

    if($ad_id){
        $app->model->ads_city_metro_ids->delete("ad_id=?", [$ad_id]);

        if($ids){
            if(is_array($ids)){
                foreach (array_slice($ids, 0,10) as $id) {
                    if($id){
                        $app->model->ads_city_metro_ids->insert(["ad_id"=>$ad_id, "metro_id"=>$id]);
                    }
                }
            }
        }
    }        

}

public function allStatuses(){
    $statuses[0] = ["status"=>0, "name"=>translate("tr_d9d74d385363cf3fdf9c1e62b484acca"), "name_declension"=>translate("tr_d9d74d385363cf3fdf9c1e62b484acca"), "label"=>"warning"];
    $statuses[1] = ["status"=>1, "name"=>translate("tr_87a4286b7b9bf700423b9277ab24c5f1"), "name_declension"=>translate("tr_c83f7ab515c5cf6bed69213f55f917c7"), "label"=>"success"];
    $statuses[2] = ["status"=>2, "name"=>translate("tr_f279ae952a1d2ef597edd30b9a4044e8"), "name_declension"=>translate("tr_f279ae952a1d2ef597edd30b9a4044e8"), "label"=>"secondary"];
    $statuses[3] = ["status"=>3, "name"=>translate("tr_320386a36d375bcf1b05f292e4463e4b"), "name_declension"=>translate("tr_35c23b6749f66b6af463bba9ff7c3d85"), "label"=>"warning"];
    $statuses[4] = ["status"=>4, "name"=>translate("tr_06d1f50f12d3f3426428c3de06aac118"), "name_declension"=>translate("tr_c66d39d1b61b7676dee34d1e7d820add"), "label"=>"danger"];
    $statuses[5] = ["status"=>5, "name"=>translate("tr_08b34aaf8262e61457029c5141c19362"), "name_declension"=>translate("tr_81c4ec79f5c331b095add5d7b9685a79"), "label"=>"warning"];
    $statuses[6] = ["status"=>6, "name"=>translate("tr_204430ebf3bce6664d8e03e9fd1581ce"), "name_declension"=>translate("tr_1970f0a9f3f96659662ada213437fd48"), "label"=>"warning"];
    $statuses[7] = ["status"=>7, "name"=>translate("tr_5890c2583af9a6b327d4d51f828678e7"), "name_declension"=>translate("tr_af43d5369e953088e86102931ef6be20"), "label"=>"success"];
    $statuses[8] = ["status"=>8, "name"=>translate("tr_9e1ad28d8e86e5df9b53cb1f360e7114"), "name_declension"=>translate("tr_9e1ad28d8e86e5df9b53cb1f360e7114"), "label"=>"secondary"];
    return $statuses;
}

public function approve($ad_id=0){
    global $app;

    $data = $this->getAd($ad_id);

    if(!$data) return;

    $detect_status = $this->detectApproveStatus($ad_id, $data->user_id, $data->category_id);

    $expiration = $this->calculationTimeExpiration($data->publication_period);

    $app->model->ads_data->cacheKey(["id"=>$ad_id])->update(["status"=>$detect_status->status, "reason_blocking_code"=>null, "block_forever_status"=>0, "time_expiration"=>$expiration->date, "publication_period"=>$expiration->days], $ad_id);

    $app->component->ads_counter->updateCount($data->category_id, $data->city_id, $data->region_id, $data->country_id, $detect_status->status);

    $app->event->publicationAd($data);

}

public function buildAliasesAdCard($data=[]){
    global $app;

    $chain = $app->component->ads_categories->chainCategory($data->category_id);

    if($data->geo){
        return outLink($data->geo->alias . '/' . $chain->chain_build_alias_dash . '/' . $data->alias . '-' . $data->id);
    }else{
        return outLink($chain->chain_build_alias_dash . '/' . $data->alias . '-' . $data->id);
    }
    
}

public function buildContacts($params=[]){
    global $app;
    return encrypt(_json_encode(["name"=>$params["contact_name"],"email"=>$params["contact_email"],"phone"=>$app->clean->phone($params["contact_phone"]),"whatsapp"=>$params["contact_whatsapp"],"telegram"=>trim($params["contact_telegram"], "@"),"max"=>trim($params["contact_max"], "@")]));
}

public function buildSearchTags($params=[], $geo=[]){
    global $app;

    $filter_items = [];
    $result = [];

    $result[] = $params["article_number"];
    $result[] = $params["title"];
    $result[] = $params["price"];
    $result[] = $app->component->ads_categories->categories[$params['category_id']]["name"];

    if($geo){
        $result[] = $geo->name;
    }

    if($params["filter"]){

        foreach ($params["filter"] as $filter_id => $nested) {
            $getFilter = $app->model->ads_filters->find("id=? and status=?", [$filter_id,1]);
            if($getFilter){
                if($getFilter->view != "input" && $getFilter->view != "input_text"){
                    foreach ($nested as $key2 => $value) {
                        $filter_items[] = $value;
                    }
                }
            }
        }

        if($filter_items){
            
            $filters = $app->model->ads_filters_items->getAll("id IN(".implode(",",$filter_items).")");

            if($filters){
                foreach ($filters as $key => $value) {
                    $result[] = $value["name"];
                }
            }

        }

    }

    return implode(",", $result);
}

public function calculationTimeExpiration($day=0){
    global $app;

    if($day){
        if(compareValues(explode(",", $app->settings->board_publication_term_date_list), $day)){
            return (object)["date"=>$app->datetime->addDay($day)->getDate(), "days"=>$day];
        }
    }

    return (object)["date"=>$app->datetime->addDay($app->settings->board_publication_term_date_default ?: 30)->getDate(), "days"=>$app->settings->board_publication_term_date_default ?: 30];

}

public function changeMultiStatus($adIds=[], $status=0){
    global $app;

    if($adIds){
        foreach ($adIds as $key => $id) {

            $data = $this->getAd($id);

            $app->model->ads_data->cacheKey(["id"=>$id])->update(["status"=>$status, "reason_blocking_code"=>null], $id);

            if($data->status != $status){
            
                if($status == 1){

                    $expiration = $this->calculationTimeExpiration($data->publication_period);

                    $app->model->ads_data->update(["time_expiration"=>$expiration->date, "publication_period"=>$expiration->days], $id); 

                    $app->event->publicationAd($data);

                }elseif($status == 3){
                
                    $app->event->blockingAd($data);

                }

                $app->component->ads_counter->updateCount($data->category_id, $data->city_id, $data->region_id, $data->country_id, $status);

            }

        }
    }

}

public function changeStatus($ad_id=0, $status=0, $reason_code=null, $block_forever_status=0){
    global $app;

    $data = $this->getAd($ad_id);

    if(!$data) return;

    $app->model->ads_data->cacheKey(["id"=>$ad_id])->update(["status"=>$status, "reason_blocking_code"=>$reason_code?:null, "block_forever_status"=>$block_forever_status ? 1 : 0], $ad_id);

    if($data->status != $status){

        if($status == 1){

            $expiration = $this->calculationTimeExpiration($data->publication_period);

            $app->model->ads_data->cacheKey(["id"=>$ad_id])->update(["time_expiration"=>$expiration->date, "publication_period"=>$expiration->days], $ad_id); 

            $app->event->publicationAd($data);

        }elseif($status == 4){
            if(isset($reason_code)){
                $getReason = $app->system->getReasonBlocking($reason_code);
                $data->reason_text = $getReason->text;
            }
            $app->event->blockingAd($data); 
        }

        $app->component->ads_counter->updateCount($data->category_id, $data->city_id, $data->region_id, $data->country_id, $status);
    }

}

public function checkAvailable($item_id=0){
    global $app;

    $getAd = $app->model->ads_data->find("id=?", [$item_id]);

    if(!$getAd->not_limited){

        if($getAd->in_stock){
            return true;
        }else{
            return false;
        }

    }

    return true;

}

public function checkChangeAd($params=[], $ad=[]){

    if($ad->title != $params["title"]){
        return true;
    }

    $similar_text = similar_text($ad->text, $params["text"], $perc);

    if(intval($perc) != 100){
        return true;
    }

    if($ad->link_video != $params["link_video"]){
        return true;
    }

    if($params["media"]){

       $media = _json_decode($ad->media);

       foreach ($params["media"] as $key => $nested) {
           foreach ($nested as $type => $value) { 

              if(!$media["inline"][$value]){
                 return true;
              }

           }
       }

    }

    return false;

}

public function delete($id=0, $user_id=0){
    global $app;

    if($user_id){
        $getData = $app->model->ads_data->getRow("id=? and user_id=?", [$id, $user_id]);
    }else{
        $getData = $app->model->ads_data->getRow("id=?", [$id]);
    }

    if($getData){

        $app->model->ads_delete->insert(["user_id"=>$getData["user_id"], "ad_id"=>$id, "time_create"=>$app->datetime->getDate(), "data"=>_json_encode($getData)]);

        $this->deleteMedia(_json_decode($getData["media"]));

        $app->model->ads_data->delete("id=?", [$id]);
        $app->model->ads_filters_ids->delete("ad_id=?", [$id]);
        $app->model->ads_city_districts_ids->delete("ad_id=?", [$id]);
        $app->model->ads_city_metro_ids->delete("ad_id=?", [$id]);
        $app->model->ads_services_orders->delete("ad_id=?", [$id]);
        $app->model->ads_views->delete("ad_id=?", [$id]);
        $app->model->ads_booking_data->delete("ad_id=?", [$id]);
        $app->component->ads_counter->updateCount($getData["category_id"],$getData["city_id"],$getData["region_id"],$getData["country_id"]);
        
    }

}

public function deleteAllByUserId($user_id=0){
    global $app;

    $ads = $app->model->ads_data->getAll("user_id=?", [$user_id]);

    if($ads){

        foreach ($ads as $key => $value) {

            $app->model->ads_delete->insert(["user_id"=>$value["user_id"], "ad_id"=>$value["id"], "time_create"=>$app->datetime->getDate(), "data"=>_json_encode($value)]);

            $this->deleteMedia(_json_decode($value["media"]));

            $app->model->ads_data->delete("id=?", [$value["id"]]);
            $app->model->ads_filters_ids->delete("ad_id=?", [$value["id"]]);
            $app->model->ads_city_districts_ids->delete("ad_id=?", [$value["id"]]);
            $app->model->ads_city_metro_ids->delete("ad_id=?", [$value["id"]]);
            $app->model->ads_services_orders->delete("ad_id=?", [$value["id"]]);
            $app->model->ads_views->delete("ad_id=?", [$value["id"]]);
            $app->model->ads_booking_data->delete("ad_id=?", [$value["id"]]);
            $app->component->ads_counter->updateCount($value["category_id"],$value["city_id"],$value["region_id"],$value["country_id"]);

        }
   
    }

}

public function deleteByImport($id=0,$limit=null){
    global $app;

    if(isset($limit)){
       $getData = $app->model->ads_data->getAll("import_id=? limit $limit", [$id]); 
    }else{
       $getData = $app->model->ads_data->getAll("import_id=?", [$id]);
    }

    if($getData){

        foreach ($getData as $key => $value) {

            $this->deleteMedia(_json_decode($getData->media));

            $app->model->ads_data->delete("id=?", [$value["id"]]);

        }
      
    }

}

public function deleteMedia($media=null){
    global $app;

    if($media){

        foreach ($media["inline"] as $key => $value) {
            
            if($value["type"] == "image"){
                $app->storage->path('market-images')->name($value["folder"].'/'.$value["name"])->delete();
            }elseif($value["type"] == "video"){
                $app->storage->path('market-video')->name($value["folder"].'/'.$value["name"])->delete();
                $app->storage->path('market-images')->name($value["folder"].'/'.$value["preview"])->delete();
            }
            
        }
    }

}

public function deleteMulti($adIds=[]){
    global $app;

    if($adIds){
        foreach ($adIds as $key => $id) {

            $this->delete($id);

        }
    }

}

public function detectApproveStatus($ad_id=0, $user_id=0, $category_id=0){
      global $app;

      if($app->component->ads_categories->categories[$category_id]["type_goods"] == "partner_link"){

          $tariff = $app->component->service_tariffs->getOrderByUserId($user_id);

          if(!$tariff->items->partner_products && $app->settings->board_publication_partner_products_active_tariffs){
              return (object)["status" => 8, "reason_code" => null];
          }

      }

      if($app->component->ads_categories->categories[$category_id]["paid_status"]){

            $getOrder = $app->model->ads_paid_publications->find("user_id=? and category_id=? and ad_id=?", [$user_id,$category_id,$ad_id]);
            $getPublication = $app->model->ads_free_publications->find("user_id=? and category_id=? and ad_id=?", [$user_id,$category_id,$ad_id]);

            if(!$getOrder && !$getPublication){

                if($app->component->ads_categories->categories[$category_id]["paid_free_count"]){
                    if($this->getCountFreePublicationsByUser($user_id,$category_id) >= (int)$app->component->ads_categories->categories[$category_id]["paid_free_count"]){
                        return (object)["status" => 5, "reason_code" => null];
                    }
                }else{
                    return (object)["status" => 5, "reason_code" => null];
                }

            }

      }

      return (object)["status" => 1, "reason_code" => null];

}

public function detectRoute($params=[]){
    global $app;

    $ad_data = $this->getAd($params->ad_id);

    if($params->detect_status->status == 0){
        return $this->buildAliasesAdCard($ad_data);
    }elseif($params->detect_status->status == 1){
        if($app->settings->paid_services_status){
            return outRoute("ad-publication-success", [$params->ad_id]);
        }else{
            return $this->buildAliasesAdCard($ad_data);
        }
    }elseif($params->detect_status->status == 4){
        return $this->buildAliasesAdCard($ad_data);
    }elseif($params->detect_status->status == 5){
        return $this->buildAliasesAdCard($ad_data);
    }elseif($params->detect_status->status == 8){
        return $this->buildAliasesAdCard($ad_data);
    }

}

public function detectStatus($params=[], $user_id=0, $ad=[]){
      global $app;

      if($app->settings->board_publication_premoderation_status){

            if($app->settings->board_publication_forbidden_words){

                  $words = explode(",", trim($app->settings->board_publication_forbidden_words, ","));
                  if($words){
                      foreach ($words as $word) {
                        if($word){

                             if (preg_match('/\b'.mb_strtolower(trim((string)$word), "UTF-8").'\b/u', mb_strtolower($params["text"] . " " . $params["title"], "UTF-8"))) {
                                 return (object)["status" => 4, "reason_code" => "forbidden_words"];
                             }
         
                        }           
                      }
                  }

            } 

            if(compareValues($app->settings->board_publication_premoderation_conditions, "email")){

                  if(preg_match('/([A-Za-z0-9_\-]+\.)*[A-Za-z0-9_\-]+@([A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9]\.)+[A-Za-z]{2,4}/u',$params["text"] . " " . $params["title"])){
                      return (object)["status" => 4, "reason_code" => "сontact_information"];
                  }

            }

            if(compareValues($app->settings->board_publication_premoderation_conditions, "phone")){

                  foreach ($app->config->phone_codes as $phone) {
                      if(strpos($params["text"] . " " . $params["title"], "+".$phone->code) !== false){
                          return (object)["status" => 4, "reason_code" => "сontact_information"];
                      }
                  }

            }

            if(compareValues($app->settings->board_publication_premoderation_conditions, "link")){

                  foreach ($app->config->domain_zones as $zone) {
                      if(strpos($params["text"] . " " . $params["title"], $zone) !== false){
                          return (object)["status" => 4, "reason_code" => "сontact_information"];
                      }
                  }

                  if(strpos($params["text"] . " " . $params["title"], "://") !== false || strpos($params["text"] . " " . $params["title"], "www.") !== false || strpos($params["text"] . " " . $params["title"], "http") !== false){
                      return (object)["status" => 4, "reason_code" => "сontact_information"];
                  }

            }

      }

      if(!$ad){

          if($app->settings->board_publication_moderation_status){

                return (object)["status" => 0, "reason_code" => null];

          }else{

                if($app->settings->board_publication_smart_moderation_status){

                    if(!$this->smartModeration($user_id)){
                        return (object)["status" => 0, "reason_code" => null];
                    }

                }

          }

          if($app->component->ads_categories->categories[$params["category_id"]]["type_goods"] == "partner_link"){

              $tariff = $app->component->service_tariffs->getOrderByUserId($user_id);

              if(!$tariff->items->partner_products && $app->settings->board_publication_partner_products_active_tariffs){
                  return (object)["status" => 8, "reason_code" => null];
              }

          }

          if($app->component->ads_categories->categories[$params["category_id"]]["paid_status"]){

                if($app->component->ads_categories->categories[$params["category_id"]]["paid_free_count"]){
                    if($this->getCountFreePublicationsByUser($user_id,$params["category_id"]) >= (int)$app->component->ads_categories->categories[$params["category_id"]]["paid_free_count"]){
                        return (object)["status" => 5, "reason_code" => null];
                    }
                }else{
                    return (object)["status" => 5, "reason_code" => null];
                }

          }

          return (object)["status" => 1, "reason_code" => null];

      }else{

          if($this->checkChangeAd($params, $ad)){

               if($app->settings->board_publication_moderation_status){

                   return (object)["status" => 0, "reason_code" => null];

               }else{

                   if($app->settings->board_publication_smart_moderation_status){

                       if(!$this->smartModeration($user_id)){
                           return (object)["status" => 0, "reason_code" => null];
                       }

                   }

               }

          }

          if($ad->status == 4){
              return (object)["status" => 0, "reason_code" => null];
          }

          if($app->component->ads_categories->categories[$params["category_id"]]["type_goods"] == "partner_link"){

                $tariff = $app->component->service_tariffs->getOrderByUserId($user_id);

                if(!$tariff->items->partner_products && $app->settings->board_publication_partner_products_active_tariffs){
                    return (object)["status" => 8, "reason_code" => null];
                }

          }

          if($app->component->ads_categories->categories[$params["category_id"]]["paid_status"]){

                $getOrder = $app->model->ads_paid_publications->find("user_id=? and category_id=? and ad_id=?", [$user_id,$params["category_id"],$ad->id]);
                $getPublication = $app->model->ads_free_publications->find("user_id=? and category_id=? and ad_id=?", [$user_id,$params["category_id"],$ad->id]);

                if(!$getOrder && !$getPublication){

                    if($app->component->ads_categories->categories[$params["category_id"]]["paid_free_count"]){
                        if($this->getCountFreePublicationsByUser($user_id,$params["category_id"]) >= (int)$app->component->ads_categories->categories[$params["category_id"]]["paid_free_count"]){
                            return (object)["status" => 5, "reason_code" => null];
                        }
                    }else{
                        return (object)["status" => 5, "reason_code" => null];
                    }

                }

          }

          return (object)["status" => !$ad->status ? 0 : 1, "reason_code" => null];

      }

}

public function extend($id=0, $user_id=0){
    global $app;

    $ad = $app->model->ads_data->find("id=? and user_id=? and status=?", [$id, $user_id, 2]);

    if($ad){

        $expiration = $this->calculationTimeExpiration($ad->publication_period);

        $app->model->ads_data->cacheKey(["id"=>$id])->update(["status"=>1, "time_expiration"=>$expiration->date, "publication_period"=>$expiration->days], $id); 

    }

}

public function extendMulti($adIds=[]){
    global $app;

    if($adIds){
        foreach ($adIds as $key => $id) {

            $expiration = $this->calculationTimeExpiration();

            $app->model->ads_data->cacheKey(["id"=>$id])->update(["status"=>1, "time_expiration"=>$expiration->date, "publication_period"=>$expiration->days], $id);

        }
    }

}

public function fixView($ad_id=0, $user_id=0){
    global $app;

    if($user_id){

        $get = $app->model->ads_views->find("user_id=? and ad_id=?", [$user_id, $ad_id]);
        
        if(!$get){
            $app->model->ads_views->insert(["ad_id"=>$ad_id, "user_id"=>$user_id, "ip"=>getIp(), "time_create"=>$app->datetime->getDate()]);
        }

    }elseif(getIp()){

        if(isBot(getUserAgent())){
            return;
        }

        $get = $app->model->ads_views->find("ip=? and ad_id=? and date(time_create)=?", [getIp(), $ad_id, $app->datetime->format("Y-m-d")->getDate()]);

        if(!$get){
            $app->model->ads_views->insert(["ad_id"=>$ad_id, "ip"=>getIp(), "time_create"=>$app->datetime->getDate()]);
        }

    }
    
}

public function getAd($id=0, $user_id=0){
    global $app;

    if($user_id){
        $data = $app->model->ads_data->find("id=? and user_id=?", [$id,$user_id]);
    }else{
        $data = $app->model->ads_data->find("id=?", [$id]);
    }

    if($data){

        $data->category = (object)$app->component->ads_categories->categories[$data->category_id];
        $data->geo = $app->component->geo->getCityData($data->city_id);
        $data->user = $app->model->users->findById($data->user_id, true);
        $data->raw_media = $data->media ? _json_decode($data->media) : [];
        $data->media = $this->getMedia($data->media);
        $data->contacts = (object)_json_decode(decrypt($data->contacts));
        $data->external_content = $data->external_content ? decrypt($data->external_content) : null;
        if($data->reason_blocking_code){
            $data->reason = $app->system->getReasonBlocking($data->reason_blocking_code);
        }

        if($data->booking_status){
            $data->booking = $app->model->ads_booking_data->find("ad_id=?", [$id]);
            if($data->booking){
                $data->booking->week_days_price = $data->booking->week_days_price ? _json_decode($data->booking->week_days_price) : [];
                $data->booking->additional_services = $data->booking->additional_services ? _json_decode($data->booking->additional_services) : [];
                $data->booking->special_days = $data->booking->special_days ? _json_decode($data->booking->special_days) : [];
            }
        }
        
        return $data;
    }else{

        $data = (object)[];
        $get = $app->model->ads_delete->find("ad_id=?", [$id]);
        if($get){
            $data = arrayToObject(_json_decode($get->data));
            $data->title = $data->title . '(' . translate("tr_0c450c40f3e9bca781dd6f676691d793") . ')';
            $data->delete = true;
            $data->media = $this->getMedia();
            return $data;
        }

    }

    return [];

}

public function getAdsByDistance($params=[],$category_id=0,$not_ids=[]){
    global $app;

    $ids = [];
    $content = "";

    if(!$app->settings->board_ads_geo_distance) return;

    $geo = $app->session->get("geo");

    $build = $app->component->catalog->buildQuery($params, $category_id);

    if($geo){

        $coor = $app->geo->coordinatesByRadius($geo->latitude, $geo->longitude, $app->settings->board_ads_geo_distance);

        if($build && $geo->latitude && $geo->longitude){

            if($not_ids){
                $build["query"] = $build["query"] . " and id NOT IN(".implode(",", $not_ids).")";
            }

            $build["query"] = $build["query"] . " and ((`geo_latitude` BETWEEN ? AND ?) AND (`geo_longitude` BETWEEN ? AND ?))";

            $build["params"][] = $coor["min_lat"];
            $build["params"][] = $coor["max_lat"];
            $build["params"][] = $coor["min_lon"];
            $build["params"][] = $coor["max_lon"];

            $data = $app->model->ads_data->sort("id desc limit ".$app->settings->out_default_count_city_distance_items?:28)->getAll($build["query"], $build["params"]);

            if($data){
                foreach ($data as $key => $value) {

                    $value = $this->getDataByValue($value);

                    $ids[] = $value->id;

                    $content .= $app->view->setParamsComponent(['value'=>$value])->includeComponent('items/grid.tpl');

                }
                $app->component->catalog->updateCountDisplay($ids);    
            }    

        }

    }

    return $content;

}

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

public function getCityDistrictsByAd($ad_id=0){
    global $app;

    $ids = [];
    $data = [];

    $get = $app->model->ads_city_districts_ids->getAll("ad_id=?", [$ad_id]);
    if($get){
        foreach ($get as $key => $value) {
            $ids[] = $value["district_id"];
        }
        $data = $app->model->geo_cities_districts->getAll("id IN(".implode(",", $ids).")");
    }

    return (object)["ids"=>$ids, "data"=>$data];

}

public function getCityMetroByAd($ad_id=0){
    global $app;

    $ids = [];
    $data = [];

    $get = $app->model->ads_city_metro_ids->getAll("ad_id=?", [$ad_id]);
    if($get){
        foreach ($get as $key => $value) {
            $ids[] = $value["metro_id"];
        }
        $data = $app->model->geo_cities_metro->getAll("id IN(".implode(",", $ids).")");
    }

    return (object)["ids"=>$ids, "data"=>$data];

}

public function getContentAndOptions($data=[], $ad=[]){
     global $app;

     $data["price_currency_status"] = false;
     $data["term_date_status"] = false;
     $data["price_fixed_change_status"] = false;
     $data["price_gratis_status"] = false;
     $data["price_measurement_status"] = false;

     $data["filters"] = $app->component->ads_filters->outFiltersInAdCreate($data['category_id'], $ad ? $ad->id : 0);

     if($app->component->ads_categories->categories[$data['category_id']]["price_status"]){

        $priceName = $app->model->system_price_names->find("id=?", [$app->component->ads_categories->categories[$data['category_id']]["price_name_id"]]);

        if($priceName){
            $data["price_name"] = translateField($priceName->name);
        }else{
            $data["price_name"] = translate("tr_682fa8dbadd54fda355b27f124938c93");
        }

        if($app->component->ads_categories->categories[$data['category_id']]["price_measure_ids"]){
            $measurements = $app->model->system_measurements->getAll("id IN(".implode(",", _json_decode($app->component->ads_categories->categories[$data['category_id']]["price_measure_ids"])).")");
            if($measurements){
                foreach ($measurements as $measurement) {
                    $measurementsBuildUniSelectItems[] = ["item_name"=>translateField($measurement["name"]),"input_name"=>"price_measurement","input_value"=>$measurement["id"]];
                }
                $data["price_measurement_status"] = true;
                $data["price_measurement_items"] = $app->ui->buildUniSelect($measurementsBuildUniSelectItems, ["view"=>"radio", "selected"=>[ $ad ? $ad->price_measure_id : 0 ]]);
                $data["price_measurement_items_array"] = $measurements;
            }
        }

        if($app->component->ads_categories->categories[$data['category_id']]["price_fixed_change"]){
            $data["price_fixed_change_status"] = true;
        }

        if($app->component->ads_categories->categories[$data['category_id']]["gratis_status"] && !$app->component->ads_categories->categories[$data['category_id']]["price_required"]){
            $data["price_gratis_status"] = true;
        }

        if($app->settings->board_publication_currency_status && $app->settings->system_extra_currency){

            if($app->settings->system_extra_currency){

                foreach ($app->settings->system_extra_currency as $code) {
                    $currencyBuildUniSelectItems[] = ["item_name"=>$app->system->getCurrencyByCode($code)->symbol,"input_name"=>"price_currency_code","input_value"=>$app->system->getCurrencyByCode($code)->code];
                }

                $data["price_currency_items"] = $app->ui->buildUniSelect($currencyBuildUniSelectItems, ["view"=>"radio", "selected"=>[ $ad ? $ad->currency_code : $app->system->getDefaultCurrency()->code ]]);
                $data["price_currency_status"] = true;

            }

        }

    }

    if($app->settings->board_publication_term_date_status){

        if($app->settings->board_publication_term_date_list){

            foreach (explode(",", $app->settings->board_publication_term_date_list) as $day) {
                $termDateBuildUniSelectItems[] = ["item_name"=>$day.' '.endingWord($day, translate("tr_48e438a146f96b54bbe9d5046ffc3a2b"), translate("tr_0871eeafdf38726742fa5affa8a5d6eb"), translate("tr_c183655a02377815e6542875555b1340")),"input_name"=>"term_date_day","input_value"=>$day];
            }

            $data["term_date_items"] = $app->ui->buildUniSelect($termDateBuildUniSelectItems, ["view"=>"radio", "selected"=>[ $ad ? $ad->publication_period : $app->settings->board_publication_term_date_default ]]);
            $data["term_date_status"] = true;

        }

    }

    if($app->component->ads_categories->categories[$data['category_id']]["booking_status"]){
        return $app->view->setParamsComponent(['data'=>(object)$data, "ad"=>$ad ? (object)$ad : []])->includeComponent('ad-create-edit-booking-content.tpl');
    }else{
        return $app->view->setParamsComponent(['data'=>(object)$data, "ad"=>$ad ? (object)$ad : []])->includeComponent('ad-create-edit-content.tpl');
    }
    
}

public function getCountFreePublicationsByUser($user_id=0, $category_id=0){
    global $app;
    return $app->model->ads_free_publications->count("user_id=? and category_id=?", [$user_id,$category_id]);
}

public function getCurrencyCode($currency=""){
    global $app;

    if($currency){
        if(compareValues($app->settings->system_extra_currency, $currency)){
            return $currency;
        }
    }

    return $app->settings->system_default_currency;

}

public function getDataByValue($data=[]){
    global $app;

    $data["category"] = (object)$app->component->ads_categories->categories[$data["category_id"]];
    $data["geo"] = $app->component->geo->getCityData($data["city_id"]);
    $data["user"] = $app->model->users->findById($data["user_id"], false, true);
    $data["media"] = $this->getMedia($data["media"]);
    $data["contacts"] = (object)_json_decode(decrypt($data["contacts"]));

    return (object)$data;

}

public function getExtraStatCount($ad_id=0){
    global $app;

    $result = [];

    if($ad_id){

        $result["cart"] = $app->model->cart->count("item_id=?", [$ad_id]);
        $result["favorite"] = $app->model->users_favorites->count("ad_id=?", [$ad_id]);
        $result["view_contacts"] = $app->model->users_actions->count("item_id=? and action_code=?", [$ad_id, "view_ad_contacts"]);

    }

    return (object)$result;

}

public function getMedia($media=null){
    global $app;

    $gallery = [];
    $inline = [];
    $media = _json_decode($media);

    if(isset($media)){

        if($media["images"]){

            foreach ($media["images"] as $key => $value) { 

                if($value["link"]){
                    $gallery["images"][] = $value["link"];
                }elseif($value["name"]){
                    $gallery["images"][] = $app->storage->name($value["folder"].'/'.$value["name"])->path('market-images')->host(true)->get();
                }

            }               

        }

        if($media["video"]){

            foreach ($media["video"] as $key => $value) { 

                if($value["link"]){
                    $gallery["video"][] = $value["link"];
                }elseif($value["name"]){
                    $gallery["video"][] = $app->storage->name($value["folder"].'/'.$value["name"])->path('market-video')->host(true)->get();
                }

            }               

        }

        foreach ($media["inline"] as $key => $value) {
            if($value["type"] == "image"){
                 if($value["name"]){
                     $inline[] = ["link"=>$app->storage->name($value["folder"].'/'.$value["name"])->path('market-images')->host(true)->get(), "type"=>$value["type"], "name"=>$value["name"]];
                 }else{
                     $inline[] = ["link"=>$value["link"], "type"=>$value["type"], "name"=>null];
                 }
            }elseif($value["type"] == "video"){
                 if($value["name"]){
                    $inline[] = ["link"=>$app->storage->name($value["folder"].'/'.$value["name"])->path('market-video')->host(true)->get(), "preview"=>$app->storage->name($value["folder"].'/'.$value["preview"])->path('market-images')->host(true)->get(), "type"=>$value["type"], "name"=>$value["name"]];
                 }else{
                    $inline[] = ["link"=>$value["link"], "preview"=>$app->storage->noImage(), "type"=>$value["type"], "name"=>null];
                 }
            }
        }

    }

    return arrayToObject(["images"=>["first"=>$gallery["images"] ? $gallery["images"][0] : $app->storage->noImage(), "all"=>$gallery["images"] ?: []], "video"=>["all"=>$gallery["video"] ?: []], "inline"=>$inline ?: [], "count"=>count($inline)]);

}

public function getPriceMeasure($measure_id=0){
    global $app;

    $measure = $app->model->system_measurements->find("id=?", [$measure_id]);
    if($measure){
        return $measure_id;
    }

    return 0;

}

public function getRemainedCountFreePublicationsByUser($user_id=0, $category_id=0){
    global $app;
    $count = (int)$app->component->ads_categories->categories[$category_id]["paid_free_count"] - $app->model->ads_free_publications->count("user_id=? and category_id=?", [$user_id,$category_id]);
    if(abs($count)){
        return $count;
    }
    return 0;
}

public function getSimilarItems($data=[]){
    global $app;

    $content = '';

    if($data->user->service_tariff->items->hiding_competitors_ads){
        $data = $app->model->ads_data->pagination($_GET['page'],100)->sort("id desc")->getAll("user_id=? and status=? and id!=?", [$data->user_id,1,$data->id]);
    }else{
        $data = $app->model->ads_data->pagination($_GET['page'],100)->sort("id desc")->getAll("category_id IN(".$app->component->ads_categories->joinId($data->category_id)->getParentIds($data->category_id).") and status=? and id!=?", [1,$data->id]);
    }

    if($data){

        shuffle($data);

        foreach (array_slice($data, 0, 20) as $key => $value) {
           
            $value = $app->component->ads->getDataByValue($value);

            $content .= $app->view->setParamsComponent(['value'=>(object)$value])->includeComponent('items/grid-col5.tpl');

        }
    }

    return $content;

}

public function getStatisticsAdsByMonthChart(){   
    global $app;

    $series = [];
    $dates = [];
    $data = [];
    $action_count = [];

    $y = $app->datetime->format("Y")->getDate();
    $m = $app->datetime->format("m")->getDate();

    $days_in_month = $app->datetime->daysInMonth($m, $y);

    $x=0;
    while ($x++<$days_in_month){
       $dates[$y."-".$m."-".$x] = $y."-".$m."-".$x;
    }

    foreach ($dates as $date) {

        $totalCount = $app->model->ads_data->count("date(time_create)=?", [$date]);

        $action_count[translate("tr_1ad572680550ba922398bc5c7b049ba3")][] = ["date"=>date("d.M.Y", strtotime($date)), "count"=>(int)$totalCount];

    }

    foreach ($action_count as $action => $nested) {
        $data = [];
        foreach ($nested as $key => $value) {
            $data[] = ["x"=>$value["date"], "y"=>$value["count"]];
        }
        $series[] = ["name"=>$action, "data"=>$data];
    }

    return $series;
}

public function getViews($ad_id=0){
    global $app;

    return $app->model->ads_views->count("ad_id=?", [$ad_id]);

}

public function getViewsToday($ad_id=0){
    global $app;

    return  $app->model->ads_views->count("ad_id=? and date(time_create)=?", [$ad_id,$app->datetime->format("Y-m-d")->getDate()]);

}

public function hasAddToCart($data=[]){
    global $app;

    if($this->hasBuySecureDeal($data) && $app->component->ads_categories->categories[$data->category_id]["marketplace_status"] && $app->settings->basket_status){
        return true;
    }

    return false;

}

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

public function outActionButtonsInAdCard($data=[]){
    global $app;

    if($data->owner){

        if($data->status == 0){
            ?>
            <a class="btn-custom button-color-scheme1 width100" href="<?php echo outRoute("ad-edit", [$data->id]); ?>" ><?php echo translate("tr_1706282c5244c8e988f76c5eb939b754"); ?></a>
            <button class="btn-custom button-color-scheme6 width100 actionDeleteAdCard" data-id="<?php echo $data->id; ?>" ><?php echo translate("tr_ed2bbfbc53d83d3ad81f7fd6485ac6e8"); ?></button>
            <?php
        }elseif($data->status == 1){
            ?>
            <a class="btn-custom button-color-scheme1 width100" href="<?php echo outRoute("ad-edit", [$data->id]); ?>" ><?php echo translate("tr_1706282c5244c8e988f76c5eb939b754"); ?></a>
            <button class="btn-custom button-color-scheme2 width100 actionOpenStaticModal" data-modal-target="adRemovePublication" data-modal-params="<?php echo buildAttributeParams(["id"=>$data->id]); ?>" ><?php echo translate("tr_af1939bb99d547ff54c8623ba556ab5a"); ?></button>
            <?php
        }elseif($data->status == 2){
            ?>
            <a class="btn-custom button-color-scheme1 width100" href="<?php echo outRoute("ad-edit", [$data->id]); ?>" ><?php echo translate("tr_1706282c5244c8e988f76c5eb939b754"); ?></a>
            <button class="btn-custom button-color-scheme1 width100 actionExtendAdCard" data-id="<?php echo $data->id; ?>" ><?php echo translate("tr_18284259d971525f8d0bf9ae23871fcd"); ?></button>
            <button class="btn-custom button-color-scheme6 width100 actionDeleteAdCard" data-id="<?php echo $data->id; ?>" ><?php echo translate("tr_ed2bbfbc53d83d3ad81f7fd6485ac6e8"); ?></button>
            <?php
        }elseif($data->status == 3){
            ?>
            <a class="btn-custom button-color-scheme1 width100" href="<?php echo outRoute("ad-edit", [$data->id]); ?>" ><?php echo translate("tr_1706282c5244c8e988f76c5eb939b754"); ?></a>
            <button class="btn-custom button-color-scheme6 width100 actionDeleteAdCard" data-id="<?php echo $data->id; ?>" ><?php echo translate("tr_ed2bbfbc53d83d3ad81f7fd6485ac6e8"); ?></button>
            <?php
        }elseif($data->status == 4){
            if(!$data->block_forever_status){
            ?>
            <a class="btn-custom button-color-scheme1 width100" href="<?php echo outRoute("ad-edit", [$data->id]); ?>" ><?php echo translate("tr_1706282c5244c8e988f76c5eb939b754"); ?></a>
            <?php } ?>
            <button class="btn-custom button-color-scheme6 width100 actionDeleteAdCard" data-id="<?php echo $data->id; ?>" ><?php echo translate("tr_ed2bbfbc53d83d3ad81f7fd6485ac6e8"); ?></button>
            <?php
        }elseif($data->status == 5){
            ?>
            <a class="btn-custom button-color-scheme1 width100" href="<?php echo outRoute("ad-edit", [$data->id]); ?>" ><?php echo translate("tr_1706282c5244c8e988f76c5eb939b754"); ?></a>
            <button class="btn-custom button-color-scheme6 width100 actionDeleteAdCard" data-id="<?php echo $data->id; ?>" ><?php echo translate("tr_ed2bbfbc53d83d3ad81f7fd6485ac6e8"); ?></button>
            <?php
        }elseif($data->status == 7){
            ?>
            <button class="btn-custom button-color-scheme6 width100 actionDeleteAdCard" data-id="<?php echo $data->id; ?>" ><?php echo translate("tr_ed2bbfbc53d83d3ad81f7fd6485ac6e8"); ?></button>
            <?php
        }elseif($data->status == 8){
            ?>
            <a class="btn-custom button-color-scheme1 width100" href="<?php echo outRoute("ad-edit", [$data->id]); ?>" ><?php echo translate("tr_1706282c5244c8e988f76c5eb939b754"); ?></a>
            <button class="btn-custom button-color-scheme6 width100 actionDeleteAdCard" data-id="<?php echo $data->id; ?>" ><?php echo translate("tr_ed2bbfbc53d83d3ad81f7fd6485ac6e8"); ?></button>
            <?php
        }

    }else{

        if($data->status == 1){

            if($data->contact_method == "all"){
                ?>
                <button class="btn-custom button-color-scheme1 width100 actionOpenDialogueSendMessage" data-params="<?php echo $app->component->chat->buildParams(['ad_id'=>$data->id, 'whom_user_id'=>$data->user_id]); ?>" ><?php echo translate("tr_014478b5b412ab74b6a95f968d4e413d"); ?></button>
                <button class="btn-custom button-color-scheme2 width100 actionAdShowContacts" data-id="<?php echo $data->id; ?>" ><?php echo translate("tr_a3fe3a50afc89c343898bd962c49b514"); ?></button>
                <?php
            }elseif($data->contact_method == "call"){
                ?>
                <button class="btn-custom button-color-scheme2 width100 actionAdShowContacts" data-id="<?php echo $data->id; ?>" ><?php echo translate("tr_a3fe3a50afc89c343898bd962c49b514"); ?></button>
                <?php
            }elseif($data->contact_method == "message"){
                ?>
                <button class="btn-custom button-color-scheme1 width100 actionOpenDialogueSendMessage" data-params="<?php echo $app->component->chat->buildParams(['ad_id'=>$data->id, 'whom_user_id'=>$data->user_id]); ?>" ><?php echo translate("tr_014478b5b412ab74b6a95f968d4e413d"); ?></button>
                <?php
            }

        }elseif($data->status == 2){

            if($data->contact_method == "all"){
                ?>
                <button class="btn-custom button-color-scheme1 width100 actionOpenDialogueSendMessage" data-params="<?php echo $app->component->chat->buildParams(['ad_id'=>$data->id, 'whom_user_id'=>$data->user_id]); ?>" ><?php echo translate("tr_014478b5b412ab74b6a95f968d4e413d"); ?></button>
                <?php
            }elseif($data->contact_method == "message"){
                ?>
                <button class="btn-custom button-color-scheme1 width100 actionOpenDialogueSendMessage" data-params="<?php echo $app->component->chat->buildParams(['ad_id'=>$data->id, 'whom_user_id'=>$data->user_id]); ?>" ><?php echo translate("tr_014478b5b412ab74b6a95f968d4e413d"); ?></button>
                <?php
            }

        }

    }
  
}

public function outActionButtonsOrderAdCard($data=[]){
    global $app;

    if(!$data->owner){

        if($app->component->ads_categories->categories[$data->category_id]["type_goods"] == "partner_link"){

            $button_title = translate("tr_f9edcc918d2f3fcfd576493dfc442f0d");
            $button_color = 'style="background-color: #36b555; color: white !important;"';

            if($data->partner_button_name){
                $button_title = $data->partner_button_name;
            }

            if($data->partner_button_color){
                $button_color = 'style="background-color: '.$data->partner_button_color.'; color: white !important;"';
            }

            ?>
            <button class="btn-custom width100 mt30 actionGoToPartnerLink" <?php echo $button_color; ?> data-id="<?php echo $data->id; ?>" ><?php echo $button_title; ?></button>
            <?php

        }

        if($this->hasBuySecureDeal($data)){

            ?>

              <div class="ad-card-buy-now" >
                <span><i class="ti ti-shield-lock"></i> <?php echo translate("tr_c21b2ddff1f121219f81a576c5f6a242"); ?></span>
                <a class="btn-custom button-color-scheme5 width100" href="<?php echo outRoute('order-item-buy', [$data->id]); ?>" ><?php echo translate("tr_7718c3bbfa76ab13ca3af3016ab71c24"); ?></a>
              </div>

            <?php

        }

        if($this->hasAddToCart($data)){
            if(!$app->component->cart->checkInCart($data->id, $app->user->data->id)){
                ?>
                  <button class="btn-custom button-color-scheme3 width100 mt5 actionAddToCart" data-id="<?php echo $data->id; ?>" ><?php echo translate("tr_95e13e5129872446327b8c3a210ba2af"); ?></button>
                <?php
            }else{
                ?>
                  <button class="btn-custom button-color-scheme3 width100 mt5 actionAddToCart" data-route="<?php echo outRoute("cart"); ?>" ><?php echo translate("tr_5aa28eac85643cd8b1d7be4570391d11"); ?></button>
                <?php                    
            }
        }

    }


}

public function outActiveServicesInCardAd($data){
    global $app;

    if($data->user_id == $app->user->data->id && $data->status == 1){

        $getActiveServices = $app->component->ad_paid_services->getActiveServicesByAd($data->id);

        if(!$getActiveServices->ids){
            if($app->settings->paid_services_status){
                ?>

                <div class="card-status-info card-status-info-bg-success mt15" >
                  <div>
                    <strong><?php echo translate("tr_876a40d4c0609bb10617c97694ab345f"); ?></strong>
                  </div>
                  <a class="btn-custom button-color-scheme1 mt15" href="<?php echo outRoute('ad-services', [$data->id]); ?>" ><?php echo translate("tr_091a6185400057872fc532948628a66c"); ?></a>
                </div>

                <?php
            }
        }else{
            ?>

            <div class="card-status-info card-status-info-bg-success mt15" >
              <div>
                <strong><?php echo translate("tr_b7295ff9007af02510daf883df396618"); ?></strong>

                <div class="ad-card-active-services-container" >
                <?php

                    foreach ($getActiveServices->data as $value) {

                        $progress = ((time() - strtotime($value->order->time_create)) / (strtotime($value->order->time_expiration) - strtotime($value->order->time_create))) * 100;

                        ?>
                        <div class="ad-card-active-services-item" >
                            <div class="ad-card-active-services-item-name" ><?php echo translateFieldReplace($value->service, "name"); ?></div>
                            <div class="progress">
                              <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $progress; ?>%" aria-valuenow="<?php echo $progress; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>   
                        </div>                         
                        <?php
                    }

                ?>
                </div>

              </div>

              <?php if($app->settings->paid_services_status){ ?>

              <a class="btn-custom button-color-scheme1 mt15" href="<?php echo outRoute('ad-services', [$data->id]); ?>" ><?php echo translate("tr_091a6185400057872fc532948628a66c"); ?></a>

              <?php } ?>

            </div>

            <?php
        }

    }

}

public function outBookingAdditionalServicesInCard($data=[]){
    global $app;

    if($data->order->additional_services){

        foreach (_json_decode($data->order->additional_services) as $key => $value) {

            ?>
            <div class="order-card-additional-services-item" >
              
              <?php echo $data->item->booking->additional_services[$key]["name"]; ?>, <?php echo $app->system->amount($data->item->booking->additional_services[$key]["price"]); ?>

            </div>
            <?php

        }

    }

}

public function outBookingAdditionalServicesInCreate($data=[]){
    global $app;

    if($data){

        foreach ($data as $key => $value) {

            ?>
            <div class="ad-create-options-additional-services-item" >
              
              <div class="row" >
                <div class="col-lg-8 col-12" >
                      <input type="text" name="booking_additional_services[<?php echo $key; ?>][name]" class="form-control" value="<?php echo $value["name"]; ?>" placeholder="<?php echo translate("tr_45a4c11809990f3313f8f38748db27df"); ?>" >
                </div>
                <div class="col-lg-3 col-8" >
                      <input type="number" name="booking_additional_services[<?php echo $key; ?>][price]" class="form-control" value="<?php echo $value["price"]; ?>" placeholder="<?php echo translate("tr_682fa8dbadd54fda355b27f124938c93"); ?>" >
                </div>
                <div class="col-lg-1 col-2" >
                      <span class="ad-create-options-additional-services-item-delete" ><i class="ti ti-trash"></i></span>
                </div>
              </div>

            </div>
            <?php

        }

    }

}

public function outBookingEndingWord($count=0, $category_id=0){
    global $app;

    if($app->component->ads_categories->categories[$category_id]["booking_action"] == "booking"){
        return endingWord($count, translate("tr_1b154879c7ea4edfdabef1b2f7fcf184"), translate("tr_f8f61c85fc663385d3fdc791e3a3b8f1"), translate("tr_62a420d2028f13db2842ec1b4bc432cc"));
    }else{
        return endingWord($count, translate("tr_48e438a146f96b54bbe9d5046ffc3a2b"), translate("tr_0871eeafdf38726742fa5affa8a5d6eb"), translate("tr_c183655a02377815e6542875555b1340"));
    }                

}

public function outBookingSpecialDays($data=[]){
    global $app;

    if($data){

        foreach ($data as $key => $value) {

            ?>
            <div class="ad-create-options-special-days-item" >
              
              <div class="row" >
                <div class="col-lg-8 col-12" >
                      <input type="date" name="booking_special_days[<?php echo $key; ?>][date]" class="form-control" value="<?php echo $value["date"]; ?>" placeholder="<?php echo translate("tr_8cdd8bb771bcf038dfb2740fd50b332c"); ?>" >
                </div>
                <div class="col-lg-3 col-8" >
                      <input type="number" name="booking_special_days[<?php echo $key; ?>][price]" class="form-control" value="<?php echo $value["price"]; ?>" placeholder="<?php echo translate("tr_682fa8dbadd54fda355b27f124938c93"); ?>" >
                </div>
                <div class="col-lg-1 col-2" >
                      <span class="ad-create-options-special-days-item-delete" ><i class="ti ti-trash"></i></span>
                </div>
              </div>

            </div>
            <?php

        }

    }        

}

public function outBreadcrumb($data=[]){
    global $app;

    $result = '';
    $position = 2;

    $chain = $app->component->ads_categories->chainCategory($data->category_id);

    foreach ($chain->chain_array as $value) {
   
        $result .= '
            <li class="breadcrumb-item" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
              <a itemprop="item" href="'.$app->component->ads_categories->buildAliases($value).'"><span itemprop="name">'.translateFieldReplace($value, "name").'</span></a><meta itemprop="position" content="'.$position.'">
            </li>
        ';

        $position++;
    }

    return $result;

}

public function outGeoAndAddressInAdCard($data=[]){
    global $app;

    $result = [];

    if($data->address){

        $result[] = $data->address;

    }else{

        if($data->geo->region){
            $result[] = $data->geo->region->name;
        }

        $result[] = $data->geo->name;

    }

    $districts = $this->getCityDistrictsByAd($data->id)->data;

    if($districts){
        foreach ($districts as $key => $value) {
            $result[] = translate("tr_66f872ee0c56fb3dc21a01e1cb8724f1") . " " . $value["name"];
        }
    }

    return implode(", ", $result);

}

public function outGeoMetroInAdCard($data=[]){
    global $app;

    $result = "";

    $metro = $this->getCityMetroByAd($data->id)->data;

    if($metro){
        foreach ($metro as $key => $value) {
            $station = $app->model->geo_cities_metro->find("id=?", [$value["parent_id"]]);
            if($station){
                $result .= '
                  <div>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="17" height="17"><path fill="'.$station->color.'" fill-rule="evenodd" d="M11.154 4L8 9.53 4.845 4 1.1 13.466H0v1.428h5.657v-1.428H4.81l.824-2.36L8 15l2.365-3.893.824 2.36h-.85v1.427H16v-1.428h-1.1z"></path></svg>
                    '.$value["name"].', '.$station->name.'
                  </div>
                ';
            }
        }
    }

    if($result){
        return '<div class="ad-card-content-geo-metro" >' . $result . '</div>';
    }

}

public function outInfoPaidCategory($category_id=0, $user_id=0){
    global $app;

    if($app->component->ads_categories->categories[$category_id]["paid_status"]){

        if($app->component->ads_categories->categories[$category_id]["paid_free_count"]){

            if($app->user->isAuth()){

                if($app->component->ads->getCountFreePublicationsByUser($user_id, $category_id) >= (int)$app->component->ads_categories->categories[$category_id]["paid_free_count"]){

                    return translate("tr_e7a1c347a5499e07ddb193041121d536")." ".$app->system->amount($app->component->ads_categories->categories[$category_id]["paid_cost"]);

                }else{

                    return translate("tr_df0ef1856bbdb1391833422d6e4b9cae")." ".$app->component->ads->getRemainedCountFreePublicationsByUser($user_id, $category_id)." ".translate("tr_d6ef87c45f89a8c35aafff615fa38b50")." ".$app->system->amount($app->component->ads_categories->categories[$category_id]["paid_cost"]);
                }

            }else{
                return translate("tr_63fa00b1e6fbf0669ea74ebc737d4d21")." ".$app->component->ads_categories->categories[$category_id]["paid_free_count"]." ".endingWord($app->component->ads_categories->categories[$category_id]["paid_free_count"], translate("tr_72da6e264d15bb3fe698cdf4845f5299"), translate("tr_b97a105b2dbb49756bfddbe508adcd3e"), translate("tr_ea8b58390b62bab148e8624a35c7b796"))." ".translate("tr_d6ef87c45f89a8c35aafff615fa38b50")." ".$app->system->amount($app->component->ads_categories->categories[$category_id]["paid_cost"]);
            }
            

        }else{
            return translate("tr_c91ec5934a89a80809ec4d183fb441d3")." ".$app->system->amount($app->component->ads_categories->categories[$category_id]["paid_cost"]);
        }

    }

}

public function outItemCardFavorite($data=[], $user_id=0){
    global $app;

    if($data->user_id != $user_id){
    ?>

      <div class="container-item-favorite actionManageFavorite" data-id="<?php echo $data->id; ?>" >
        <?php if($app->component->profile->inFavorite($data->id, $user_id)){ ?>
            <i class="ti ti-heart-filled"></i>
        <?php }else{ ?>
            <i class="ti ti-heart"></i>
        <?php } ?>
      </div>

    <?php
    }

}

public function outLabelsInCatalog($data=[]){
    global $app;

    if($data->service_urgently_status || $data->condition_new_status || $data->booking_status || $data->delivery_status){
    ?>

      <div class="container-item-labels" >
        
        <?php if($data->delivery_status == 1 && $data->user->delivery_status){ ?>
        <div class="container-item-labels-4" ><span><?php echo translate("tr_78b5fee18901ca2645ea512251b8375c"); ?></span></div>
        <?php } ?>

        <?php if($data->service_urgently_status){ ?>
        <div class="container-item-labels-2" ><span><?php echo translate("tr_c85cf9e96515efc35d01f5ead5495666"); ?></span></div>
        <?php } ?>

        <?php
        if($data->booking_status){
            if($data->category->booking_action == "booking"){
                ?>
                <div class="container-item-labels-1" ><span><?php echo translate("tr_18683b0d308a45672c6569209d040ebe"); ?></span></div>
                <?php
            }else{
                ?>
                <div class="container-item-labels-1" ><span><?php echo translate("tr_83e1d0278ef91f7851b947dc73e66491"); ?></span></div>
                <?php
            }
        }
        ?>

        <?php if($data->condition_new_status){ ?>
        <div class="container-item-labels-1" ><span><?php echo translate("tr_963d95509d21446ecc58963ffbc37251"); ?></span></div>
        <?php } ?>

      </div>

    <?php
    }

}

public function outLocationByCatalog($value=[]){

    $result = [];

    $result[] = translateFieldReplace($value->geo, "name");

    return implode(", ", $result);
    
}

public function outMapAndOptionsInAdCreate($city_id=0, $data=[]){
    global $app;

    $content = '';
    $districts_items = [];
    $metro_items = [];

    $getDistricts = $app->model->geo_cities_districts->getAll("city_id=?", [intval($city_id)]);
    $getMetro = $app->model->geo_cities_metro->getAll("city_id=? and parent_id!=?", [intval($city_id),0]);

    if($getDistricts){
        foreach ($getDistricts as $key => $value) {
            $districts_items[] = ["item_name"=>$value["name"],"input_name"=>"geo_district_id[]","input_value"=>$value["id"]];
        }
        $content .= '
            <div class="ad-create-options-container-item" >
                  
              <h5 class="ad-create-options-container-item-title" > <strong>'.translate("tr_1a5241dbf994bc1f4a25da39ae951f58").'</strong> </h5>

              <div class="row" >
                <div class="col-md-6" >
                      '.$app->ui->buildUniSelect($districts_items, ["view"=>"radio", "selected"=>$this->getCityDistrictsByAd($data->id)->ids]).' 
                </div>
              </div>

            </div>
        ';
    }

    if($getMetro){
        foreach ($getMetro as $key => $value) {
            $station = $app->model->geo_cities_metro->find("id=?", [$value["parent_id"]]);
            $metro_items[] = ["item_name"=>'<span class="geo-metro-station-color-label" style="background-color:'.$station->color.';"></span>'.$value["name"].', '.$station->name,"input_name"=>"geo_metro_id[]","input_value"=>$value["id"]];
        }
        $content .= '
            <div class="ad-create-options-container-item" >
                  
              <h5 class="ad-create-options-container-item-title" > <strong>'.translate("tr_5765747a21bfd298aac39bf20b3b99e8").'</strong> </h5>

              <div class="row" >
                <div class="col-md-6" >
                      '.$app->ui->buildUniSelect($metro_items, ["view"=>"multi", "selected"=>$this->getCityMetroByAd($data->id)->ids]).'  
                </div>
              </div>

            </div>
        ';
    }

    $content .= '
        <div class="ad-create-options-container-item" >
            <h5 class="ad-create-options-container-item-title" > <strong>'.translate("tr_80148fa5ada7bcd36bf3b351ee3ca3b0").'</strong> </h5>

            <div class="input-geo-search-container ad-create-search-address" >
              <input type="text" name="geo_address" class="form-control mt20" placeholder="'.translate("tr_9d66aa312e1e28e241ba5292f8898593").'" value="'.$data->address.'" >
              <div class="input-geo-search-container-result" ></div>
            </div>
            <div class="map-container initMapAddress" id="initMapAddress" ></div>
        </div>
    ';

    return $content;

}

public function outMediaGalleryInCard($data=[], $params=[]){
    global $app;

    $source_video = $data->link_video ? $app->video->parseLinkSource($data->link_video) : '';

    if($data->media->images->all){

      ?>

      <div class="ad-card-media-slider-container" >

          <span class="ad-card-media-slider-nav-left" ><i class="ti ti-chevron-left"></i></span>
          <span class="ad-card-media-slider-nav-right" ><i class="ti ti-chevron-right"></i></span>

          <div class="ad-card-media-slider uniMediaSliderContainer ad-card-media-slider-swiper" >

            <div class="swiper-wrapper" >
                  <?php

                  foreach ($data->media->inline as $key => $value) {

                        if($value->type == "image"){
                            ?>
                            <a href="<?php echo $value->link; ?>" class="ad-card-media-slider-item uniMediaSliderItem swiper-slide" data-media-type="<?php echo $value->type; ?>" data-media-key="<?php echo $key; ?>" style="height: <?php echo $params["height"]; ?>;" >
                                <div style="height: <?php echo $params["height"]; ?>;" >
                                    <img src="<?php echo $value->link; ?>" data-key="<?php echo $key; ?>" alt="<?php echo $data->title; ?>" title="<?php echo $data->title; ?>" >
                                </div>
                            </a>
                            <?php
                        }elseif($value->type == "video"){
                            ?>
                            <a href="<?php echo $value->preview; ?>" class="ad-card-media-slider-item uniMediaSliderItem swiper-slide" data-media-video="<?php echo $value->link; ?>" data-media-type="<?php echo $value->type; ?>" data-media-key="<?php echo $key; ?>" style="height: <?php echo $params["height"]; ?>;" >
                                <div style="height: <?php echo $params["height"]; ?>;" >
                                    <img src="<?php echo $value->preview; ?>" data-key="<?php echo $key; ?>" alt="<?php echo $data->title; ?>" title="<?php echo $data->title; ?>" >
                                    <span class="ad-card-media-slider-item-label-video" ><i class="ti ti-video"></i></span>
                                </div>
                            </a>
                            <?php
                        }
                  }

                  if($source_video){
                        ?>
                        <a href="<?php echo $source_video->image; ?>" class="ad-card-media-slider-item uniMediaSliderItem swiper-slide" data-media-video="<?php echo $source_video->link; ?>" data-media-type="link_video" data-media-key="<?php echo $data->media->count; ?>" style="height: <?php echo $params["height"]; ?>;" >
                            <div style="height: <?php echo $params["height"]; ?>;" class="ad-card-media-slider-item-logo-video" >
                                <img src="<?php echo $source_video->image; ?>" data-key="<?php echo $data->media->count; ?>" alt="<?php echo $data->title; ?>" title="<?php echo $data->title; ?>" >
                                <span class="ad-card-media-slider-item-label-video" ><i class="ti ti-video"></i></span>
                            </div>
                        </a>
                        <?php                
                  }

                  ?>
            </div>

          </div>

      </div>

      <div class="ad-card-media-slider-miniatures" >
        <div class="swiper-wrapper" >
        </div>
      </div>

      <?php

    }elseif($source_video){

      ?>

      <div class="ad-card-media-slider-container" >

          <div class="ad-card-media-slider uniMediaSliderContainer" >
                <a href="<?php echo $source_video->image; ?>" class="ad-card-media-slider-item uniMediaSliderItem" data-media-video="<?php echo $source_video->link; ?>" data-media-type="video" data-media-key="0" style="height: <?php echo $params["height"]; ?>;" >
                    <div style="height: <?php echo $params["height"]; ?>;" >
                        <img src="<?php echo $source_video->image; ?>" data-key="<?php echo $data->media->count; ?>" alt="<?php echo $data->title; ?>" title="<?php echo $data->title; ?>" >
                        <span class="ad-card-media-slider-item-label-video" ><i class="ti ti-video"></i></span>
                    </div>
                </a>
          </div>

      </div>

      <?php            

    }

}

public function outMediaGalleryInCatalog($value=[]){
    global $app;

    if($value->media->images->all){
      foreach (array_slice($value->media->images->all, 0,10) as $key => $link) {
        ?>
        <img src="<?php echo $link; ?>" data-key="<?php echo $key; ?>" alt="<?php echo $value->title; ?>" class="image-autofocus" loading="lazy" >
        <?php
      }

      if(count($value->media->images->all) > 1){
        ?>
          <div class="container-item-images-indicator" >
              <?php
              foreach (array_slice($value->media->images->all, 0,10) as $key => $link) {
                ?>
                <span data-key="<?php echo $key; ?>" style="height: <?php echo $app->settings->board_catalog_height_item-2; ?>px" ></span>
                <?php
              }
              ?>
          </div>
        <?php
      }

    }else{
        ?>
        <img src="<?php echo $app->storage->noImage(); ?>" alt="<?php echo $value->title; ?>" class="image-autofocus" loading="lazy" >
        <?php
    }
    
}

public function outMediaInEditAd($data=[]){
    global $app;

    if($data->media->images->all){

      foreach ($data->media->inline as $key => $value) {

            if($value->name){

                $name = getInfoFile($value->name)->filename;

                if($value->type == "image"){
                    ?>
                    <div class="unidropzone-item" >
                      <span class="unidropzone-item-delete" ><i class="ti ti-x"></i></span>
                      <img class="image-autofocus" src="<?php echo $value->link; ?>" >
                      <input type="hidden" name="media[][image]" value="<?php echo $name; ?>" >
                    </div>
                    <?php
                }elseif($value->type == "video"){
                    ?>
                    <div class="unidropzone-item" >
                      <span class="unidropzone-item-delete" ><i class="ti ti-x"></i></span>
                      <img class="image-autofocus" src="<?php echo $value->preview; ?>" >
                      <input type="hidden" name="media[][video]" value="<?php echo $name; ?>" >
                    </div>
                    <?php
                }

            }else{

                if($value->type == "image"){
                    ?>
                    <div class="unidropzone-item" >
                      <span class="unidropzone-item-delete" ><i class="ti ti-x"></i></span>
                      <img class="image-autofocus" src="<?php echo $value->link; ?>" >
                      <input type="hidden" name="media[][image]" value="<?php echo $value->link; ?>" >
                    </div>
                    <?php
                }elseif($value->type == "video"){
                    ?>
                    <div class="unidropzone-item" >
                      <span class="unidropzone-item-delete" ><i class="ti ti-x"></i></span>
                      <img class="image-autofocus" src="<?php echo $app->storage->noImage(); ?>" >
                      <input type="hidden" name="media[][video]" value="<?php echo $value->link; ?>" >
                    </div>
                    <?php
                }                

            }

      }

    }

}

public function outPercentCompletion($data=[]){

    $result = 0;

    $start = strtotime($data->time_expiration) - ($data->publication_period * 86400);

    if($start){

        $result = ((time() - $start) / (strtotime($data->time_expiration) - $start)) * 100;

    }

    return $result >= 100 ? 100 : round($result, 2);

}

public function outPriceAndCurrency($data=[]){
    global $app;

    $data = (array)$data;

    $measure_title = '';

    if($data["price_gratis_status"]){
        return translate("tr_60183c67d880a855d91a9419f344e97e");
    }

    if($data["price"]){

        $measure = $app->model->system_measurements->find("id=?", [$data["price_measure_id"]]);

        if($measure){
            $measure_title = translate("tr_462eaa68988f6a1a10814f865d5160ad").' '.translateField($measure->name);
        }

        if($data["price_fixed_status"]){

            return $app->system->amount($data["price"], $data["currency_code"]).' '.$measure_title;

        }else{

            return translate("tr_7f164d12155a14bdb34181b6f8c41f3f").' '.$app->system->amount($data["price"], $data["currency_code"]).$measure_title;

        }

    }

    return translate("tr_8d7254e709bd2fbc45c82c02d6d1e269");

}

public function outPriceDifferentCurrenciesInAdCard($data=[]){
    global $app;
    return '';
    if($app->settings->board_card_price_different_currencies){
        if($data->price && !$data->price_gratis_status){
            return  '
                <div class="ad-card-prices-currency" >
                  <span>106,383 $</span>
                  <span>96,154 €</span>                  
                </div>
            ';
        }
    }

}

public function outPrices($data=[]){
    global $app;

    $measure_title = '';

    if($data->price_gratis_status){
        return '<span class="card-item-price-now" >'.translate("tr_60183c67d880a855d91a9419f344e97e").'</span>';
    }

    if($data->price){

        $measure = $app->model->system_measurements->find("id=?", [$data->price_measure_id]);

        if($measure){
            $measure_title = '<span class="card-item-price-measure-title" >'.translate("tr_462eaa68988f6a1a10814f865d5160ad").' '.translateField($measure->name).'</span>';
        }

        if($data->price_fixed_status){

            if($data->old_price){
                return '<span class="card-item-price-now" >'.$app->system->amount($data->price, $data->currency_code).$measure_title.'</span>
                <span class="card-item-price-old" >'.$app->system->amount($data->old_price, $data->currency_code).'</span>';
            }
            
            return '<span class="card-item-price-now" >'.$app->system->amount($data->price, $data->currency_code).$measure_title.'</span>';

        }else{

            if($data->old_price){
                return '<span class="card-item-price-now" >'.translate("tr_7f164d12155a14bdb34181b6f8c41f3f").' '.$app->system->amount($data->price, $data->currency_code).$measure_title.'</span>
                <span class="card-item-price-old" >'.$app->system->amount($data->old_price, $data->currency_code).'</span>';
            }
            
            return '<span class="card-item-price-now" >'.translate("tr_7f164d12155a14bdb34181b6f8c41f3f").' '.$app->system->amount($data->price, $data->currency_code).$measure_title.'</span>';

        }

    }

    return '<span class="card-item-price-now" >'.translate("tr_8d7254e709bd2fbc45c82c02d6d1e269").'</span>';

}

public function outShareSocialLinks($id=0){
    global $app;

    $ad = $this->getAd($id);

    $link = urlencode($this->buildAliasesAdCard($ad));

    ?>

    <div class="share-social-list-link" >
        <a href="https://vk.com/share.php?url=<?php echo $link; ?>" target="_blank" > <img src="<?php echo $app->storage->name("social/vk.png")->path('images')->get(); ?>"> <?php echo translate("tr_d235f33b916d3985aefdd3c5589b57b8"); ?></a>
        <a href="https://connect.ok.ru/offer?url=<?php echo $link; ?>" target="_blank" > <img src="<?php echo $app->storage->name("social/ok.png")->path('images')->get(); ?>"> <?php echo translate("tr_ef3f299a1b962975c0981fdec324c86c"); ?></a>   
        <a href="https://t.me/share/url?url=<?php echo $link; ?>" target="_blank" > <img src="<?php echo $app->storage->name("social/tg.png")->path('images')->get(); ?>"> <?php echo translate("tr_c915683f3ec888b8edcc7b06bd1428ec"); ?></a>
        <a href="whatsapp://send?text=<?php echo $link; ?>" target="_blank" > <img src="<?php echo $app->storage->name("social/wa.png")->path('images')->get(); ?>"> <?php echo translate("tr_8b777ebcc5034ce0fe96dd154bcb370e"); ?></a>
        <a href="#" class="copyToClipboard" data-link="<?php echo urldecode($link); ?>" ><?php echo translate("tr_0c15689762ce47e7e3aceac28dbe8d17"); ?></a>
    </div>

    <?php

}

public function outStatusByAd($status=0){
    global $app;

    return '<div><span class="status-label status-label-color-'.$this->status($status)->label.'" >'.$this->status($status)->name.'</span></div>';

}

public function outStatusInCardAd($data){
    global $app;

    if($data->owner){

        if($data->status == 0){
        ?>

        <div class="card-status-info card-status-info-bg-moderation" >
          <strong><?php echo translate("tr_779b189b218a6dd96008e19f7fd22883"); ?></strong>
          <p><?php echo translate("tr_6f1d4db88ab60d7914ea35150d27bcc2"); ?></p>
        </div>

        <?php }elseif($data->status == 2){ ?>

        <div class="card-status-info card-status-info-bg-gray" >
          <strong><?php echo translate("tr_f279ae952a1d2ef597edd30b9a4044e8"); ?></strong>
          <p><?php echo translate("tr_b6266c285d96b8a5397cb7dcd09230c2"); ?></p>
        </div>

        <?php }elseif($data->status == 3){ ?>

        <div class="card-status-info card-status-info-bg-gray"  >
          <strong><?php echo translate("tr_320386a36d375bcf1b05f292e4463e4b"); ?></strong>
          <p><?php echo translate("tr_b6266c285d96b8a5397cb7dcd09230c2"); ?></p>
        </div>

        <?php
        }elseif($data->status == 4){ ?>

        <div class="card-status-info card-status-info-bg-error" >
          <strong><?php echo translate("tr_5f9e133baa87da7c530ce299740bbec9"); ?></strong>
          <p><?php echo translate("tr_ce28b881ebd7df5f6f26f319aeb91a30"); ?> <?php echo $data->reason->text; ?></p>
          <?php if(!$data->block_forever_status){ ?>
          <p><?php echo translate("tr_2cbcf582e3ff7a6efbbbbcfd1a4888a7"); ?></p>
          <?php } ?>
        </div>

        <?php }elseif($data->status == 5){ ?>

        <div class="card-status-info card-status-info-bg-success"  >
          <strong><?php echo translate("tr_f0c85f1f5bb88b14ca1c6974cc805977"); ?></strong>
          <p><?php echo translate("tr_dce9f41b065a92f2631bbbb180aa5eba"); ?></p>
          <?php echo $app->component->transaction->buildPaymentButton(["target"=>"paid_category", "id"=>$data->id, "class"=>"btn-custom button-color-scheme1 mt15"]); ?>
        </div>

        <?php
        }elseif($data->status == 6){ ?>

        <div class="card-status-info card-status-info-bg-success"  >
          <strong><?php echo translate("tr_204430ebf3bce6664d8e03e9fd1581ce"); ?></strong>
        </div>

        <?php
        }elseif($data->status == 7){ ?>

        <div class="card-status-info card-status-info-bg-success"  >
          <strong><?php echo translate("tr_5890c2583af9a6b327d4d51f828678e7"); ?></strong>
        </div>

        <?php
        }elseif($data->status == 8){ ?>

        <div class="card-status-info card-status-info-bg-gray"  >
          <strong><?php echo translate("tr_601f38d372da3494796935405b52a3b3"); ?></strong>
          <p><?php echo translate("tr_32d52a75101c6cd92535651104533bd0"); ?></p>
        </div>

        <?php
        }

    }else{

        if($data->status == 0){
        ?>

        <div class="card-status-info card-status-info-bg-moderation" >
          <strong><?php echo translate("tr_779b189b218a6dd96008e19f7fd22883"); ?></strong>
        </div>

        <?php }elseif($data->status == 2){ ?>

        <div class="card-status-info card-status-info-bg-gray" >
          <strong><?php echo translate("tr_f279ae952a1d2ef597edd30b9a4044e8"); ?></strong>
        </div>

        <?php }elseif($data->status == 3){ ?>

        <div class="card-status-info card-status-info-bg-gray"  >
          <strong><?php echo translate("tr_320386a36d375bcf1b05f292e4463e4b"); ?></strong>
        </div>

        <?php
        }elseif($data->status == 4){ ?>

        <div class="card-status-info card-status-info-bg-error" >
          <strong><?php echo translate("tr_5f9e133baa87da7c530ce299740bbec9"); ?></strong>
        </div>

        <?php }elseif($data->status == 5){ ?>

        <div class="card-status-info card-status-info-bg-gray"  >
          <strong><?php echo translate("tr_47f1f18a961cd149db1dc53ba4b31b37"); ?></strong>
        </div>

        <?php
        }elseif($data->status == 6){ ?>

        <div class="card-status-info card-status-info-bg-success"  >
          <strong><?php echo translate("tr_204430ebf3bce6664d8e03e9fd1581ce"); ?></strong>
        </div>

        <?php
        }elseif($data->status == 7){ ?>

        <div class="card-status-info card-status-info-bg-success"  >
          <strong><?php echo translate("tr_5890c2583af9a6b327d4d51f828678e7"); ?></strong>
        </div>

        <?php
        }elseif($data->status == 7){ ?>

        <div class="card-status-info card-status-info-bg-gray"  >
          <strong><?php echo translate("tr_601f38d372da3494796935405b52a3b3"); ?></strong>
        </div>

        <?php
        }

    }

}

public function outUsersExtraStat($ad_id=0, $view=null){
    global $app;

    if($ad_id && $view){

        $ad = $app->model->ads_data->find("id=? and user_id=?", [$ad_id, $app->user->data->id]);

        if($ad){

            if($view == "cart"){

                $data = $app->model->cart->getAll("item_id=?", [$ad_id]);

                if($data){

                    foreach ($data as $key => $value) {
                        $user = $app->model->users->findById($value["user_id"]);
                        ?>
                        <div class="ad-users-info-stat-item" >
                            <div><img src="<?php echo $app->storage->name($user->avatar)->get(); ?>" class="image-autofocus" ></div>
                            <span><?php echo $app->user->name($user); ?></span>
                        </div>
                        <?php
                    }

                }else{
                    ?>
                    <p><?php echo translate("tr_c2c930fb0cfdeac7cbbf0ed285aa3b38"); ?></p>
                    <?php
                }

            }elseif($view == "favorite"){
                
                $data = $app->model->users_favorites->getAll("ad_id=?", [$ad_id]);

                if($data){

                    foreach ($data as $key => $value) {
                        $user = $app->model->users->findById($value["user_id"]);
                        ?>
                        <div class="ad-users-info-stat-item" >
                            <div><img src="<?php echo $app->storage->name($user->avatar)->get(); ?>" class="image-autofocus" ></div>
                            <span><?php echo $app->user->name($user); ?></span>
                        </div>
                        <?php
                    }

                }else{
                    ?>
                    <p><?php echo translate("tr_c2c930fb0cfdeac7cbbf0ed285aa3b38"); ?></p>
                    <?php
                }

            }elseif($view == "contacts"){
                
                $data = $app->model->users_actions->getAll("item_id=? and action_code=?", [$ad_id, "view_ad_contacts"]);

                if($data){

                    foreach ($data as $key => $value) {
                        $user = $app->model->users->findById($value["from_user_id"]);
                        ?>
                        <div class="ad-users-info-stat-item" >
                            <div><img src="<?php echo $app->storage->name($user->avatar)->get(); ?>" class="image-autofocus" ></div>
                            <span><?php echo $app->user->name($user); ?></span>
                        </div>
                        <?php
                    }

                }else{
                    ?>
                    <p><?php echo translate("tr_c2c930fb0cfdeac7cbbf0ed285aa3b38"); ?></p>
                    <?php
                }

            }

        }
    }

}

public function publication($params=[], $user_id=0, $admin=false){
    global $app;

    if(!$admin){
        $detect_status = $this->detectStatus($params,$user_id);
    }else{
        $detect_status = (object)["status" => 1, "reason_code" => null];
    }
    
    $params['price'] = formattedPrice($params['price']);
    $params['old_price'] = formattedPrice($params['old_price']);

    $expiration = $this->calculationTimeExpiration($params["term_date_day"]);

    $media = $this->uploadMedia($params['media']);

    $geo = $app->component->geo->getCityData($params['geo_city_id']);

    if(empty($params['geo_address'])){
        $params['geo_address_latitude'] = 0;
        $params['geo_address_longitude'] = 0;
    }

    if($app->component->ads_categories->categories[$params['category_id']]["price_fixed_change"]){
        $price_fixed_status = (int)$params['price_fixed_status'];
    }else{
        $price_fixed_status = 1;
    }

    if(intval($params["not_limited"])){
        $in_stock = 0;
    }else{
        $in_stock = (int)$params["in_stock"] ?: 1;
    }

    if($app->component->ads_categories->categories[$params['category_id']]["filter_generation_title"]){
        $params['title'] = $app->component->ads_filters->generationTitle($params['filter'], $params['category_id']);
    }

    if(!$app->user->data->service_tariff->items->autorenewal){
        $params["auto_renewal_status"] = 0;
    }

    if($params["old_price"]){
        if($params["price"] >= $params["old_price"]){
            $params["old_price"] = 0;
        }
    }

    $params["article_number"] = generateNumberCode(10);

    $ad_id = $app->model->ads_data->insert([
        "title"=>$params['title'], 
        "alias"=>slug($params['title']),
        "price"=>$params['price'],
        "old_price"=>$params['old_price'],
        "text"=>trimStr($params['text'],$app->settings->board_publication_max_length_text, false),
        "address"=>$app->component->geo->searchAddressByCoordinates($params['geo_address_latitude'],$params['geo_address_longitude']),
        "address_latitude"=>$params['geo_address_latitude'] ?: null,
        "address_longitude"=>$params['geo_address_longitude'] ?: null,
        "publication_period"=>$expiration->days,
        "currency_code"=>$this->getCurrencyCode($params["price_currency_code"]),
        "price_measure_id"=>$this->getPriceMeasure($params["price_measurement"]),
        "media"=>$media,
        "contacts"=>$this->buildContacts($params),
        "contact_method"=>$params['contact_method'] ?: "all",
        "category_id"=>$params['category_id'],
        "user_id"=>$user_id,
        "city_id"=>(int)$geo->id,
        "region_id"=>(int)$geo->region->id,
        "country_id"=>(int)$geo->country->id,
        "status"=>$detect_status->status,
        "reason_blocking_code"=>$detect_status->reason_code,
        "geo_latitude"=>$geo->latitude ?: null,
        "geo_longitude"=>$geo->longitude ?: null,
        "search_tags"=>$this->buildSearchTags($params,$geo),
        "time_expiration"=>$expiration->date,
        "article_number"=>$params["article_number"],
        "price_fixed_status"=>$price_fixed_status,
        "price_gratis_status"=>(int)$params["price_gratis_status"],
        "time_create"=>$app->datetime->getDate(),
        "time_sorting"=>$app->datetime->getDate(),
        "online_view_status"=>(int)$params["online_view_status"],
        "condition_new_status"=>(int)$params["condition_new_status"],
        "condition_brand_status"=>(int)$params["condition_brand_status"],
        "auto_renewal_status"=>(int)$params["auto_renewal_status"],
        "not_limited"=>(int)$params["not_limited"],
        "in_stock"=>$in_stock,
        "link_video"=>$params["link_video"],
        "external_content"=>$params["external_content"] ? encrypt($params["external_content"]) : null,
        "partner_link"=>$params["partner_link"] ?: null,
        "booking_status"=>(int)$app->component->ads_categories->categories[$params['category_id']]["booking_status"],
        "delivery_status"=>(int)$params["delivery_status"],
        "partner_button_name"=>trimStr($params["partner_button_name"],60, false) ?: null,
        "partner_button_color"=>$params["partner_button_color"] ?: null,
    ]);

    $app->component->ads_filters->addSelectedFilterItemsAd($params['filter'], $params['category_id'], $ad_id);

    $this->addFreePublications($ad_id,$user_id,$params['category_id']);
    $this->addGeoDistricts($params["geo_district_id"],$ad_id);
    $this->addGeoMetro($params["geo_metro_id"],$ad_id);
    $this->addBookingData($params,$ad_id);

    $app->component->ads_counter->updateCount($params['category_id'], (int)$geo->id, (int)$geo->region->id, (int)$geo->country->id, $detect_status->status);

    $chain = $app->component->ads_categories->chainCategory($params['category_id']);

    $app->event->createAd(["user_id"=>$user_id, "ad_id"=>$ad_id, "ad_title"=>$params['title'], "ad_category_name"=>$chain->chain_build]);

    return (object)["ad_id"=>$ad_id, "user_id"=>$user_id, "category_id"=>$params['category_id'], "detect_status"=>$detect_status];

}

public function publicationByImport($params=[]){
    global $app;

    $detect_status = (object)["status" => 1, "reason_code" => null];
    
    $params['price'] = formattedPrice($params['price']);
    $params['old_price'] = formattedPrice($params['old_price']);

    $expiration = $this->calculationTimeExpiration($params["term_date_day"]);

    $geo = $app->component->geo->getCityData($params['geo_city_id']);

    if(intval($params["not_limited"])){
        $in_stock = 0;
    }else{
        $in_stock = (int)$params["in_stock"] ?: 1;
    }

    if($params["old_price"]){
        if($params["price"] >= $params["old_price"]){
            $params["old_price"] = 0;
        }
    }

    $params["article_number"] = generateNumberCode(10);

    $ad_id = $app->model->ads_data->insert([
        "title"=>$params['title'], 
        "alias"=>slug($params['title']),
        "price"=>$params["price"],
        "old_price"=>$params["old_price"],
        "text"=>trimStr($params['text'],$app->settings->board_publication_max_length_text, false),
        "address"=>$app->component->geo->searchAddressByCoordinates($params['geo_address_latitude'],$params['geo_address_longitude']),
        "address_latitude"=>$params['geo_address_latitude'] ?: null,
        "address_longitude"=>$params['geo_address_longitude'] ?: null,
        "publication_period"=>$expiration->days,
        "currency_code"=>$this->getCurrencyCode($params["price_currency_code"]),
        "price_measure_id"=>$this->getPriceMeasure($params["price_measurement"]),
        "media"=>$params['media'] ?: null,
        "contacts"=>$this->buildContacts($params),
        "contact_method"=>"all",
        "category_id"=>$params['category_id'],
        "user_id"=>(int)$params['user_id'],
        "city_id"=>(int)$geo->id,
        "region_id"=>(int)$geo->region->id,
        "country_id"=>(int)$geo->country->id,
        "status"=>$detect_status->status,
        "reason_blocking_code"=>$detect_status->reason_code,
        "geo_latitude"=>$geo->latitude ?: null,
        "geo_longitude"=>$geo->longitude ?: null,
        "search_tags"=>$this->buildSearchTags($params,$geo),
        "time_expiration"=>$expiration->date,
        "article_number"=>$params["article_number"],
        "price_fixed_status"=>1,
        "price_gratis_status"=>(int)$params["price_gratis_status"],
        "time_create"=>$app->datetime->getDate($params["date"]),
        "time_sorting"=>$app->datetime->getDate(),
        "online_view_status"=>(int)$params["online_view_status"],
        "condition_new_status"=>(int)$params["condition_new_status"],
        "condition_brand_status"=>(int)$params["condition_brand_status"],
        "auto_renewal_status"=>(int)$params["auto_renewal"],
        "not_limited"=>(int)$params["not_limited"],
        "in_stock"=>$in_stock,
        "link_video"=>$params["link_video"],
        "external_content"=>$params["external_content"] ? encrypt($params["external_content"]) : null,
        "partner_link"=>$params["partner_link"] ?: null,
        "booking_status"=>(int)$app->component->ads_categories->categories[$params['category_id']]["booking_status"],
        "import_id"=>$params["import_id"],
        "import_item_id"=>$params["import_item_id"] ?: null,
    ]);

    $app->component->ads_filters->addSelectedFilterItemsAd($params['filter'], $params['category_id'], $ad_id);

    $app->component->ads_counter->updateCount($params['category_id'], (int)$geo->id, (int)$geo->region->id, (int)$geo->country->id, $detect_status->status);

}

public function setStyleHeightItemImage(){
    global $app;
    return 'style="height: '.$app->settings->board_catalog_height_item.'px"';
}

public function smartModeration($user_id=0){
    global $app;

    $personal_rating = 0;

    $user = $app->user->getData($user_id);

    $countMinReviews = $app->model->reviews->count("whom_user_id=? and status=? and rating IN(1,2,3)", [$user_id,1]);
    $countMaxReviews = $app->model->reviews->count("whom_user_id=? and status=? and rating IN(4,5)", [$user_id,1]);

    if($countMinReviews && $countMaxReviews){

        if($countMaxReviews > $countMinReviews){
            $personal_rating += 10;
        }

    }elseif($countMaxReviews){

        $personal_rating += 20;

    }

    $countAds = $app->model->ads_data->count("user_id=? and status IN(1,2,3,6,7)", [$user_id]);

    if($countAds <= 10){
        $personal_rating += 10;
    }elseif($countAds > 10){
        $personal_rating += 20;
    }

    $countComplaints = $app->model->complaints->count("whom_user_id=? and status=?", [$user_id,1]);

    if(!$countComplaints){
        $personal_rating += 10;
    }

    $countDeals = $app->model->transactions_deals->count("(from_user_id=? or whom_user_id=?) and status_payment=? and status_completed=?", [$user_id,$user_id,1,1]);

    if($countDeals <= 10){
        $personal_rating += 10;
    }elseif($countDeals > 10){
        $personal_rating += 20;
    }

    if($app->datetime->getDaysDiff($user->time_create) >= 30){
        $personal_rating += 10;
    }


    if($personal_rating >= 50){
        return true;
    }

    return false;

}

public function status($status=0){
    global $app;

    $statuses = $this->allStatuses();

    return (object)$statuses[$status];

}

public function update($params=[], $user_id=0, $ad_id=0, $admin=false){
    global $app;

    $ad = $app->model->ads_data->find("id=? and user_id=?", [$ad_id,$user_id]);

    if(!$ad) return [];

    $params['price'] = formattedPrice($params['price']);
    $params['old_price'] = formattedPrice($params['old_price']);

    if(!$admin){
        $detect_status = $this->detectStatus($params,$user_id,$ad);
    }else{
        $detect_status = (object)["status" => !$ad->status ? 0 : 1, "reason_code" => null];
    }

    $expiration = $this->calculationTimeExpiration($params["term_date_day"]);

    $media = $this->uploadMedia($params['media'], $ad);

    $geo = $app->component->geo->getCityData($params['geo_city_id']);

    if(empty($params['geo_address'])){
        $params['geo_address_latitude'] = 0;
        $params['geo_address_longitude'] = 0;
    }

    if($app->component->ads_categories->categories[$params['category_id']]["price_fixed_change"]){
        $price_fixed_status = (int)$params['price_fixed_status'];
    }else{
        $price_fixed_status = 1;
    }

    if(intval($params["not_limited"])){
        $in_stock = 0;
    }else{
        $in_stock = (int)$params["in_stock"] ?: 1;
    }

    if($app->component->ads_categories->categories[$params['category_id']]["filter_generation_title"]){
        $params['title'] = $app->component->ads_filters->generationTitle($params['filter'], $params['category_id']);
    }

    if(!$app->user->data->service_tariff->items->autorenewal){
        $params["auto_renewal_status"] = 0;
    }

    if($params["old_price"]){
        if($params["price"] >= $params["old_price"]){
            $params["old_price"] = 0;
        }
    }

    $app->model->ads_data->cacheKey(["id"=>$ad_id])->update([
        "title"=>$params['title'], 
        "alias"=>slug($params['title']),
        "price"=>$params["price"],
        "old_price"=>$params["old_price"],
        "text"=>trimStr($params['text'],$app->settings->board_publication_max_length_text, false),
        "address"=>$app->component->geo->searchAddressByCoordinates($params['geo_address_latitude'],$params['geo_address_longitude']),
        "address_latitude"=>$params['geo_address_latitude'] ?: null,
        "address_longitude"=>$params['geo_address_longitude'] ?: null,
        "publication_period"=>$expiration->days,
        "currency_code"=>$this->getCurrencyCode($params["price_currency_code"]),
        "price_measure_id"=>$this->getPriceMeasure($params["price_measurement"]),
        "media"=>$media,
        "contacts"=>$this->buildContacts($params),
        "contact_method"=>$params['contact_method'],
        "category_id"=>$params['category_id'],
        "city_id"=>(int)$geo->id,
        "region_id"=>(int)$geo->region->id,
        "country_id"=>(int)$geo->country->id,
        "status"=>$detect_status->status,
        "reason_blocking_code"=>$detect_status->reason_code,
        "geo_latitude"=>$geo->latitude ?: null,
        "geo_longitude"=>$geo->longitude ?: null,
        "search_tags"=>$this->buildSearchTags($params,$geo),
        "time_expiration"=>$expiration->date,
        "price_fixed_status"=>$price_fixed_status,
        "price_gratis_status"=>(int)$params["price_gratis_status"],
        "time_update"=>$app->datetime->getDate(),
        "online_view_status"=>(int)$params["online_view_status"],
        "condition_new_status"=>(int)$params["condition_new_status"],
        "condition_brand_status"=>(int)$params["condition_brand_status"],
        "auto_renewal_status"=>(int)$params["auto_renewal_status"],
        "not_limited"=>(int)$params["not_limited"],
        "in_stock"=>$in_stock,
        "link_video"=>$params["link_video"],
        "external_content"=>$params["external_content"] ? encrypt($params["external_content"]) : null,
        "partner_link"=>$params["partner_link"] ?: null,
        "booking_status"=>$app->component->ads_categories->categories[$params['category_id']]["booking_status"],
        "delivery_status"=>(int)$params["delivery_status"],
        "partner_button_name"=>trimStr($params["partner_button_name"],60, false) ?: null,
        "partner_button_color"=>$params["partner_button_color"] ?: null,
    ], $ad_id);

    $app->component->ads_filters->addSelectedFilterItemsAd($params['filter'], $params['category_id'], $ad_id);

    $this->addFreePublications($ad_id,$user_id,$params['category_id']);
    $this->addGeoDistricts($params["geo_district_id"],$ad_id);
    $this->addGeoMetro($params["geo_metro_id"],$ad_id);
    $this->addBookingData($params,$ad_id);

    $app->component->ads_counter->updateCount($params['category_id'], (int)$geo->id, (int)$geo->region->id, (int)$geo->country->id, $detect_status->status);

    return (object)["ad_id"=>$ad_id, "user_id"=>$user_id, "category_id"=>$params['category_id'], "detect_status"=>$detect_status, "data"=>$app->component->ads->getAd($ad_id)];

}

public function updateRatingAndReviews($user_id=0, $item_id=0){
    global $app;

    $total = $app->model->reviews->count("whom_user_id=? and item_id=? and status=?", [$user_id, $item_id, 1]);
    $app->model->ads_data->cacheKey(["id"=>$item_id])->update(["total_rating"=>$app->component->profile->calculateRating($user_id, $item_id), "total_reviews"=>$total], $item_id);

}

public function uploadMedia($media=[], $ad=[]){
    global $app;

    $result = [];
    $inline = [];
    $current_media = [];
    $current_inline = [];

    $folder = md5($app->datetime->format("Y-m-d")->getDate());

    if($media){

        if($ad){
            $current_media = _json_decode($ad->media);
            if($current_media){
                foreach ($current_media["inline"] as $value) {
                    if($value["name"]){
                        $current_inline[$value["name"]] = $value;
                    }else{
                        $current_inline[$value["link"]] = $value;
                    }
                }
            }
        }

        foreach ($media as $key => $nested) {
            foreach ($nested as $type => $value) {
                if(!$app->validation->isLink($value)->status){
                    $inline[] = ["type"=>$type, "name"=>$value];
                }else{
                    $inline[] = ["type"=>$type, "link"=>$value];
                }
            }
        }

        foreach (array_slice($inline, 0, $app->settings->board_publication_limit_count_media) as $key => $value) {

            if($value["type"] == "image"){

                if($value["name"]){

                    if(file_exists($app->config->storage->temp.'/'.$value["name"].'.webp')){
                        createFolder($app->config->storage->market->images.'/'.$folder);
                        if(copy($app->config->storage->temp.'/'.$value["name"].'.webp', $app->config->storage->market->images.'/'.$folder.'/'.$value["name"].'.webp')){
                           $result["images"][] = ["name"=>$value["name"].'.webp', "folder"=>$folder]; 
                           $result["inline"][$value["name"]] = ["type"=>$value["type"], "name"=>$value["name"].'.webp', "folder"=>$folder]; 
                        }
                    }else{

                        if($current_inline){
                            if($current_inline[$value["name"].'.webp']){
                              $result["images"][] = ["name"=>$value["name"].'.webp', "folder"=>$current_inline[$value["name"].'.webp']["folder"]]; 
                              $result["inline"][$value["name"]] = ["type"=>$value["type"], "name"=>$value["name"].'.webp', "folder"=>$current_inline[$value["name"].'.webp']["folder"]];
                              unset($current_inline[$value["name"].'.webp']);
                            }
                        }

                    }

                }else{

                    if($current_inline){
                        if($current_inline[$value["link"]]){
                          $result["images"][] = ["link"=>$value["link"]]; 
                          $result["inline"][$value["link"]] = ["type"=>$value["type"], "link"=>$value["link"]];   
                          unset($current_inline[$value["link"]]);
                        }
                    }

                }

            }elseif($value["type"] == "video"){

                if(file_exists($app->config->storage->temp.'/'.$value["name"].'.mp4')){
                    createFolder($app->config->storage->market->video.'/'.$folder);
                    if(copy($app->config->storage->temp.'/'.$value["name"].'.mp4', $app->config->storage->market->video.'/'.$folder.'/'.$value["name"].'.mp4')){
                       $result["video"][] = ["name"=>$value["name"].'.mp4', "folder"=>$folder, "preview"=>$value["name"].'.webp'];
                       $result["inline"][$value["name"]] = ["type"=>$value["type"], "name"=>$value["name"].'.mp4', "folder"=>$folder, "preview"=>$value["name"].'.webp'];
                    }
                }else{

                    if($current_inline){
                        if($current_inline[$value["name"].'.mp4']){
                           $result["video"][] = ["name"=>$value["name"].'.mp4', "folder"=>$current_inline[$value["name"].'.mp4']["folder"], "preview"=>$value["name"].'.webp'];
                           $result["inline"][$value["name"]] = ["type"=>$value["type"], "name"=>$value["name"].'.mp4', "folder"=>$current_inline[$value["name"].'.mp4']["folder"], "preview"=>$value["name"].'.webp'];
                           $result["images"][] = ["name"=>$value["name"].'.webp', "folder"=>$current_inline[$value["name"].'.mp4']["folder"]];

                           unset($current_inline[$value["name"].'.webp']);
                           unset($current_inline[$value["name"].'.mp4']);
                        }
                    }

                }

                if(file_exists($app->config->storage->temp.'/'.$value["name"].'.webp')){
                    createFolder($app->config->storage->market->images.'/'.$folder);
                    if(copy($app->config->storage->temp.'/'.$value["name"].'.webp', $app->config->storage->market->images.'/'.$folder.'/'.$value["name"].'.webp')){
                       $result["images"][] = ["name"=>$value["name"].'.webp', "folder"=>$folder];
                    }
                }

            }

            $app->storage->path('temp')->name($value["name"].'.webp')->delete();
            $app->storage->path('temp')->name($value["name"].'.mp4')->delete();

        }

    }

    if($current_inline){
        foreach ($current_inline as $key => $value) {
            if($value["type"] == "image"){
                $app->storage->path('market-images')->name($value["folder"].'/'.$value["name"])->delete();
            }elseif($value["type"] == "video"){
                $app->storage->path('market-video')->name($value["folder"].'/'.$value["name"])->delete();
                $app->storage->path('market-images')->name($value["folder"].'/'.$value["preview"])->delete();
            }
        }
    }

    return $result ? _json_encode($result) : null;

}

public function validationFormCreate($params=[]){
    global $app;

    $answer = [];

    if(!$app->component->ads_categories->categories[$params['category_id']]["filter_generation_title"]){
        if($app->validation->requiredField($params['title'])->status == false){
            $answer['title'] = $app->validation->error;
        }else{
            if($app->validation->correctLength($params['title'],$app->settings->board_publication_min_length_title,$app->settings->board_publication_max_length_title)->status == false){
                $answer['title'] = $app->validation->error;
            }
        }
    }

    if($app->validation->requiredField($params['text'])->status == false){
        $answer['text'] = $app->validation->error;
    }else{
        if($app->validation->correctLength($params['text'],$app->settings->board_publication_min_length_text,$app->settings->board_publication_max_length_text)->status == false){
            $answer['text'] = $app->validation->error;
        }
    }

    if($app->component->ads_categories->categories[$params['category_id']]["price_status"]){

        if($app->component->ads_categories->categories[$params['category_id']]["price_required"]){
            if($app->validation->requiredFieldPrice($params['price'])->status == false){
                $answer['price'] = $app->validation->error;
            }
            if($app->component->ads_categories->categories[$params['category_id']]["price_measure_ids"]){
                if($app->validation->requiredField($params['price_measurement'])->status == false){
                    $answer['price_measurement'] = $app->validation->error;
                }
            }
            if($app->settings->board_publication_currency_status && $app->settings->system_extra_currency){
                if($app->validation->requiredField($params['price_currency_code'])->status == false){
                    $answer['price_currency_code'] = $app->validation->error;
                }
            }
        }else{
            if($app->validation->requiredFieldPrice($params['price'])->status == true){
                if($app->component->ads_categories->categories[$params['category_id']]["price_measure_ids"]){
                    if($app->validation->requiredField($params['price_measurement'])->status == false){
                        $answer['price_measurement'] = $app->validation->error;
                    }
                }
                if($app->settings->board_publication_currency_status){
                    if($app->validation->requiredField($params['price_currency_code'])->status == false){
                        $answer['price_currency_code'] = $app->validation->error;
                    }
                }                
            }            
        }

    }

    $requiredFilters = $app->component->ads_filters->required($params['filter'], $params['category_id']);

    if($requiredFilters){
        foreach ($requiredFilters as $key => $value) {
            $answer[$key] = $value;
        }
    }

    if($app->settings->board_publication_only_photos){
        if(!$params['media']){
            $answer['media'] = translate("tr_7548012daa96f66e47c9a88df8faedbe");
        }
    }

    if($app->settings->board_publication_term_date_status){
        if($app->validation->requiredField($params['term_date_day'])->status == false){
            $answer['term_date_day'] = $app->validation->error;
        }            
    }

    if($app->component->ads_categories->categories[$params['category_id']]["change_city_status"] && $app->settings->active_countries){

        if($app->validation->requiredField($params['geo_city_id'])->status == false){
            $answer['geo_city_id'] = $app->validation->error;
        }else{
            if(!$app->component->geo->getCityData($params['geo_city_id'])){
                $answer['geo_city_id'] = translate("tr_47182458a9b56818cb4a15ecbc3accc2");
            }
        }

    }

    if($app->component->ads_categories->categories[$params['category_id']]["type_goods"] == "electronic_goods"){
        if($app->validation->requiredField($params['external_content'])->status == false){
            $answer['external_content'] = $app->validation->error;
        }
    }

    if($app->component->ads_categories->categories[$params['category_id']]["type_goods"] == "partner_link"){
        if($app->validation->requiredField($params['partner_link'])->status == false){
            $answer['partner_link'] = $app->validation->error;
        }
    }

    if($app->user->data->id){

        if($app->validation->requiredField($params['contact_method'])->status == false){
            $answer['contact_method'] = $app->validation->error;
        }

        if($app->settings->board_publication_required_email){

            if($app->validation->isEmail($params['contact_email'])->status == false){
                $answer['contact_email'] = $app->validation->error;
            }else{
                if($app->settings->email_confirmation_status){
                    if(!$app->model->users_verified_contacts->find("contact=? and user_id=?", [$params["contact_email"], $app->user->data->id]) && $app->user->data->email != $params["contact_email"]){
                        $answer['contact_email'] = translate("tr_1a9d5cffc42fd0c3e8ba8f9773687ecb");
                    } 
                }           
            }

        }

        if($app->settings->board_publication_required_phone_number){

            if($app->validation->isPhone($params['contact_phone'])->status == false){
                if($params['contact_method'] != "message"){
                    $answer['contact_phone'] = $app->validation->error;
                }
            }else{
                if($app->settings->phone_confirmation_status){
                    if(!$app->model->users_verified_contacts->find("contact=? and user_id=?", [$app->clean->phone($params["contact_phone"]), $app->user->data->id]) && $app->user->data->phone != $app->clean->phone($params["contact_phone"])){
                        $answer['contact_phone'] = translate("tr_92899cea85e05d5f506efb774dfd87a3");
                    } 
                }
            }

        }

        if($app->validation->requiredField($params['contact_name'])->status == false){
            $answer['contact_name'] = $app->validation->error;
        }

    }

    if($app->component->ads_categories->categories[$params['category_id']]["booking_status"]){

        if($params['booking_deposit_status']){
            if($app->validation->requiredField($params['booking_deposit_amount'])->status == false){
                $answer['booking_deposit_amount'] = $app->validation->error;
            }                
        }

        if(!$params['booking_full_payment_status']){
            if($app->validation->requiredField($params['booking_prepayment_percent'])->status == false){
                $answer['booking_prepayment_percent'] = $app->validation->error;
            }                
        }


    }

    return $answer;

}



}