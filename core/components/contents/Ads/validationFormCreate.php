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
        // Контакты задаются в настройках профиля, отдельная валидация не требуется
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