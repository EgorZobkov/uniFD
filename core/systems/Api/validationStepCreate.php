public function validationStepCreate($params=[], $user_id=0, $step=null, $update=false){
    global $app;

    $answer = [];

    $category_id = (int)$params['category_id'];

    if(!$app->component->ads_categories->categories[$category_id]){
        return null;
    }

    $user = $app->model->users->find("id=?", [$user_id]);

    if($step == 1 || $step == null){

        if(!$app->component->ads_categories->categories[$category_id]["filter_generation_title"]){
            if($app->validation->requiredField($params['title'])->status == false){
                $answer[] = translate("tr_a7f8a505c03860819c69c3f9c13ac37f");
            }else{
                if($app->validation->correctLength($params['title'],$app->settings->board_publication_min_length_title,$app->settings->board_publication_max_length_title)->status == false){
                    $answer[] = translate("tr_f2212de15734ed39aa5b0f099c88743f") . " " . $app->settings->board_publication_min_length_title . " " . translate("tr_538dc63d3c6db1a1839cafbaf359799b") . " " . $app->settings->board_publication_max_length_title . " " . translate("tr_8dd2b69669960646469fbeb70b2005fd");
                }
            }
        }

        if($app->validation->requiredField($params['text'])->status == false){
            $answer[] = translate("tr_b42fda28c3163fbcea01eb354ad77ba6");
        }else{
            if($app->validation->correctLength($params['text'],$app->settings->board_publication_min_length_text,$app->settings->board_publication_max_length_text)->status == false){
                $answer[] = translate("tr_cb1c35ba8ed57e2de1505d2e825348d3") . " " . $app->settings->board_publication_min_length_text . " " . translate("tr_538dc63d3c6db1a1839cafbaf359799b") . " " . $app->settings->board_publication_max_length_text . " " . translate("tr_8dd2b69669960646469fbeb70b2005fd");
            }
        }

        if($app->settings->board_publication_only_photos){
            if(!$params['media']){
                $answer[] = translate("tr_bb9a5a0b8f814f37cdb561d15a26bdf6");
            }
        }

        if($app->component->ads_categories->categories[$category_id]["type_goods"] == "electronic_goods"){
            if($app->validation->requiredField($params['external_content'])->status == false){
                $answer[] = translate("tr_0eebdddf6afc16de5938ae0c8cf0313c");
            }
        }

        if($app->component->ads_categories->categories[$category_id]["type_goods"] == "partner_link"){
            if($app->validation->requiredField($params['partner_link'])->status == false){
                $answer[] = translate("tr_8b21c9f272561a529bcf9b750841afa6");
            }
        }

        if($app->component->ads_categories->categories[$category_id]["change_city_status"] && $app->settings->active_countries){

            if($app->validation->requiredField($params['geo_city_id'])->status == false){
                $answer[] = translate("tr_7dfe7a8f465fe0769c414fc3f21278c6");
            }else{
                if(!$app->component->geo->getCityData($params['geo_city_id'])){
                    $answer[] = translate("tr_7dfe7a8f465fe0769c414fc3f21278c6");
                }
            }

        }

    }

    if($step == 2 || $step == null){

        if($app->component->ads_categories->categories[$category_id]["price_status"]){

            if($app->component->ads_categories->categories[$category_id]["price_required"]){
                if($app->validation->requiredFieldPrice($params['price'])->status == false){
                    $answer[] = translate("tr_bcf614572f9cb39274d6bbc3f73abe55");
                }
                if($app->component->ads_categories->categories[$category_id]["price_measure_ids"]){
                    if(count(_json_decode($app->component->ads_categories->categories[$category_id]["price_measure_ids"])) > 1){
                        if($app->validation->requiredField($params['price_measurement'])->status == false){
                            $answer[] = translate("tr_8f4100a8f642ff72b34d1181415b86bd");
                        }
                    }
                }
                if($app->settings->board_publication_currency_status && $app->settings->system_extra_currency){
                    if($app->validation->requiredField($params['price_currency_code'])->status == false){
                        $answer[] = translate("tr_99fe6d8bfc9a5c3b37a13185b26b0a56");
                    }
                }
            }else{
                if($app->validation->requiredFieldPrice($params['price'])->status == true){
                    if($app->component->ads_categories->categories[$category_id]["price_measure_ids"]){
                        if(count(_json_decode($app->component->ads_categories->categories[$category_id]["price_measure_ids"])) > 1){
                            if($app->validation->requiredField($params['price_measurement'])->status == false){
                                $answer[] = translate("tr_8f4100a8f642ff72b34d1181415b86bd");
                            }
                        }
                    }
                    if($app->settings->board_publication_currency_status){
                        if($app->validation->requiredField($params['price_currency_code'])->status == false){
                            $answer[] =  translate("tr_99fe6d8bfc9a5c3b37a13185b26b0a56");
                        }
                    }                
                }            
            }

        }

        if($update == false){
        
            if($app->settings->board_publication_term_date_status){
                if($app->validation->requiredField($params['term_date_day'])->status == false){
                    $answer[] = translate("tr_9e421a29c146e4013464613852719927");
                }            
            }

        }

        $requiredFilters = $this->filtersRequired($params['filters'], $category_id);

        if($requiredFilters){
            foreach ($requiredFilters as $key => $value) {
                $answer[] = $value;
            }
        }

        if($app->component->ads_categories->categories[$category_id]["booking_status"]){

            if($params['booking_deposit_status']){
                if($app->validation->requiredField($params['booking_deposit_amount'])->status == false){
                    $answer[] = translate("tr_40bca3fb1594f0af8ec5d197f1cfb73f");
                }                
            }

            if(!$params['booking_full_payment_status']){
                if($app->validation->requiredField($params['booking_prepayment_percent'])->status == false){
                    $answer[] = translate("tr_23255f6433c0878203899dfa1c15c2f6");
                }                
            }


        }

    }

    if($step == 3 || $step == null){

        if($app->validation->requiredField($params['contact_method'])->status == false){
            $answer[] = translate("tr_42267bbfa09b11b07a76674985f07875");
        }

        if($app->settings->board_publication_required_email){

            if($app->validation->isEmail($params['contact_email'])->status == false){
                $answer[] = translate("tr_3e3b7d9fb90cbdb9146fcff444b8ebe3");
            }else{
                if($app->settings->email_confirmation_status){
                    if(!$app->model->users_verified_contacts->find("contact=? and user_id=?", [$params["contact_email"], $user_id]) && $user->email != $params["contact_email"]){
                        $answer[] = translate("tr_1a9d5cffc42fd0c3e8ba8f9773687ecb");
                    } 
                }           
            }

        }

        if($app->settings->board_publication_required_phone_number){

            if($app->validation->isPhone($params['contact_phone'])->status == false){
                if($params['contact_method'] != "message"){
                    $answer[] = translate("tr_524283064f10cdddf715075cb1f5a2bb");
                }
            }else{
                if($app->settings->phone_confirmation_status){
                    if(!$app->model->users_verified_contacts->find("contact=? and user_id=?", [$app->clean->phone($params["contact_phone"]), $user_id]) && $user->phone != $app->clean->phone($params["contact_phone"])){
                        $answer[] = translate("tr_92899cea85e05d5f506efb774dfd87a3");
                    } 
                }
            }

        }

        if($app->validation->requiredField($params['contact_name'])->status == false){
            $answer[] = translate("tr_3e8d97ffba2a26223318e731b3550174");
        }

    }

    return $answer;

}