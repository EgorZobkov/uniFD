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