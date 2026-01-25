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