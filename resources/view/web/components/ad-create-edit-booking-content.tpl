<?php

$chain = $app->component->ads_categories->chainCategory($data->category_id);

?>

<div class="row" >
  <div class="col-md-6 order-lg-1 order-2" >

      <span class="ad-create-options-category-chain" ><?php echo $chain->chain_build; ?></span>

      <?php
      if(!$app->component->ads_categories->categories[$data->category_id]["filter_generation_title"]){
        ?>
            <div class="ad-create-options-container-item" >
                
                <h5 class="ad-create-options-container-item-title" > <strong><?php echo translate("tr_33ea34d8ad8f8fb23396552ee810fa9e"); ?></strong> </h5>
                <input type="text" name="title" class="form-control" value="<?php echo $ad ? $ad->title : $data->title; ?>" >

                <label class="form-label-error" data-name="title"></label>

            </div>
        <?php
      }
      ?>

      <div class="ad-create-options-container-item" >
          
          <h5 class="ad-create-options-container-item-title" > <strong><?php echo translate("tr_38ca0af80cd7bd241500e81ba2e6efff"); ?></strong> </h5>
          <textarea name="text" class="form-control-textarea" ><?php echo $ad ? $ad->text : $data->text; ?></textarea>
          <label class="form-label-error" data-name="text" ></label>

      </div>

      <div class="ad-create-options-container-item" >
          
          <h5 class="ad-create-options-container-item-title" > <strong><?php echo translate("tr_c24797c4abfb4ebe54dc45b9e411ac3a"); ?></strong> </h5>

          <p><?php echo translate("tr_25fb5a4c68afb45e682bcfa595f905c2"); ?></p>

          <div class="init-unidropzone unidropzone mt10 sortable" >

            <?php if($app->settings->board_publication_add_video_status){ ?>
            <div class="unidropzone-change"  ><?php echo translate("tr_b760653ac17f261ac6679ad14f732a95"); ?></div>

            <input type="file" name="unidropzone_files[]" multiple="multiple" <?php echo $app->ui->outAcceptUploadFormatFiles("multiple"); ?> >
            <?php }else{ ?>
            <div class="unidropzone-change"  ><?php echo translate("tr_666c01d719f2cb6ba604618e5783bbbe"); ?></div>

            <input type="file" name="unidropzone_files[]" multiple="multiple" <?php echo $app->ui->outAcceptUploadFormatFiles("image"); ?> >
            <?php } ?>

            <div class="unidropzone-container unidropzone-container-show" >
              
              <?php echo $app->component->ads->outMediaInEditAd($ad); ?>

            </div>

          </div>

          <label class="form-label-error" data-name="media"></label>

          <input type="text" name="link_video" class="form-control mt15" placeholder="<?php echo translate("tr_662d6fb048aed921e26d9d9de4c18124"); ?>" value="<?php echo $ad ? $ad->link_video : $data->link_video; ?>" >
          
      </div>

      <?php if($app->component->ads_categories->categories[$data->category_id]["type_goods"] == "electronic_goods"){ ?>
      <div class="ad-create-options-container-item" >
          
          <h5 class="ad-create-options-container-item-title" > <strong><?php echo translate("tr_480107c7e081f07e1a616b3e98a1bc89"); ?></strong> </h5>

          <p><?php echo translate("tr_b15ce76a996b17b0ecaa4a657d20665c"); ?></p>

          <textarea class="form-control-textarea" name="external_content" ><?php echo $ad ? $ad->external_content : $data->external_content; ?></textarea>

          <label class="form-label-error" data-name="external_content"></label>

      </div>
      <?php } ?>

      <?php
      if($data->filters){
        ?>

            <div class="ad-create-options-container-item" >
                
                <h5 class="ad-create-options-container-item-title" > <strong><?php echo translate("tr_d6f9a39be4b8938d8499ac3b525abea7"); ?></strong> </h5>

                <p class="mb25" ><?php echo translate("tr_40f621eeceedda3781fb5610a0aaec60"); ?></p>

                <?php echo $data->filters; ?>

            </div>

        <?php                   
      }
      ?>

      <?php if($app->component->ads_categories->categories[$data->category_id]["type_goods"] == "realty"){ ?>
      <div class="ad-create-options-container-item" >
          
          <h5 class="ad-create-options-container-item-title" > <strong><?php echo translate("tr_2ca65dadf0f4da055ad221b6665e8353"); ?></strong> </h5>

          <div class="row" >
            <div class="col-md-6" >
                  <input type="number" name="booking_max_guests" class="form-control" value="<?php echo $ad ? $ad->booking->max_guests : ''; ?>" >
            </div>
          </div>

      </div>
      <?php } ?>

      <div class="ad-create-options-container-item" >
          
          <h5 class="ad-create-options-container-item-title" > <strong><?php echo translate("tr_8a444244ccbf9387bdfdd6bc32101626"); ?></strong> </h5>

          <p><?php echo translate("tr_c33416c530fccc2bf0e5392b40fe71ef"); ?></p>

          <div class="row" >
            <div class="col-md-6" >
                  <input type="number" name="booking_min_days" class="form-control" value="<?php echo $ad ? $ad->booking->min_days : ''; ?>" placeholder="<?php echo translate("tr_873b767827f1401e3ed580fe4dfe32ab"); ?>" >
                  <label class="form-label-error" data-name="booking_min_days"></label>
            </div>
            <div class="col-md-6" >
                  <input type="number" name="booking_max_days" class="form-control" value="<?php echo $ad ? $ad->booking->max_days : ''; ?>" placeholder="<?php echo translate("tr_60015a0bce080d67d124abe501b54958"); ?>" >
                  <label class="form-label-error" data-name="booking_max_days"></label>
            </div>
          </div>

      </div>

      <div class="ad-create-options-container-item" >
          
          <h5 class="ad-create-options-container-item-title" > <strong><?php echo translate("tr_e3c1f39b86bb7162bddb548e2cfd6077"); ?></strong> </h5>

          <div>
          <label class="switch">
            <input type="checkbox" class="switch-input" name="booking_deposit_status" value="1" <?php echo $ad->booking->deposit_status ? 'checked=""' : ''; ?> >
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label"><?php echo translate("tr_c7bb13829f0c52a28e01bedd29bdfe0d"); ?></span>
          </label>
          </div>

          <div class="ad-create-options-container-item-box-booking-deposit-settings" <?php if($ad){ echo $ad->booking->deposit_status ? 'style="display: block;"' : 'style="display: none;"'; } ?> >
          <div class="row mt10" >
            <div class="col-md-6" >
                  <input type="number" name="booking_deposit_amount" class="form-control" value="<?php echo $ad ? $ad->booking->deposit_amount : ''; ?>" placeholder="<?php echo translate("tr_b7ee740305fa015cbed91712bfe1a4d1"); ?>" >
                  <label class="form-label-error" data-name="booking_deposit_amount"></label>
            </div>
          </div>
          </div>

          <div class="mt10" >
          <label class="switch">
            <input type="checkbox" class="switch-input" name="booking_full_payment_status" value="1" <?php if($ad){ echo $ad->booking->full_payment_status ? 'checked=""' : ''; }else{ echo 'checked=""'; } ?> >
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label"><?php echo translate("tr_04d41109b9d57cc0de14c9d0d5617d28"); ?></span>
          </label>
          </div>

          <div class="ad-create-options-container-item-box-booking-prepayment-settings" <?php if($ad){ echo !$ad->booking->full_payment_status ? 'style="display: block;"' : 'style="display: none;"'; } ?> >
          <div class="row mt10" >
            <div class="col-md-6" >
                  <input type="number" name="booking_prepayment_percent" class="form-control" value="<?php echo $ad ? $ad->booking->prepayment_percent : ''; ?>" placeholder="<?php echo translate("tr_546cbc92e2286db0baa5fa3ca668703a"); ?>" >
                  <label class="form-label-error" data-name="booking_prepayment_percent"></label>
            </div>
          </div>
          </div>

      </div>

      <div class="ad-create-options-container-item" >
          
          <h5 class="ad-create-options-container-item-title" > <strong><?php echo $data->price_name; ?></strong> </h5>

          <p><?php echo translate("tr_54414064646f46bb565b7e13d0a05781"); ?></p>

          <div class="row" >
            <div class="col-md-6" >
                  <input type="number" name="price" class="form-control" value="<?php echo $ad ? $ad->price : $data->price; ?>" step="0.01" >
                  <label class="form-label-error" data-name="price"></label>
            </div>
            <?php if($data->price_measurement_status){ ?>
            <div class="col-md-6" >
                  <?php if(count($data->price_measurement_items_array) > 1){ ?>
                  <?php echo $data->price_measurement_items; ?>  
                     <label class="form-label-error" data-name="price_measurement"></label>
                  <?php }else{ ?>
                     <input type="hidden" name="price_measurement" value="<?php echo $data->price_measurement_items_array[0]["id"]; ?>" >
                  <?php } ?>
            </div>
            <?php } ?>
          </div>

          <?php if($data->price_fixed_change_status){ ?>
          <label class="switch mt10">
            <input type="checkbox" class="switch-input" name="price_fixed_status" value="1" <?php if($ad){ echo $ad->price_fixed_status ? 'checked=""' : ''; }else{ echo ''; } ?> >
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label"><?php echo translate("tr_c262493561e9568322b4cbe1d466adf0"); ?></span>
          </label>
          <?php } ?>

      </div>

      <div class="ad-create-options-container-item" >
          
          <h5 class="ad-create-options-container-item-title" > <strong><?php echo translate("tr_dd3f14ba93f4b89a820a7e66e235526b"); ?></strong> </h5>

          <p><?php echo translate("tr_5ee717a8ed3b51f8bc653f47d84be17d"); ?></p>

          <div class="ad-create-options-week-days-container" >
              <div class="ad-create-options-week-days-item" >
                
                <div class="row" >
                  <div class="col-lg-6 col-6" >
                        <strong><?php echo translate("tr_aae9f1f89cb94eca5395ee5895ec3254"); ?></strong>
                        <input type="number" name="booking_week_days_price[1]" class="form-control mt10" step="0.01" value="<?php if($ad){ echo $ad->booking->week_days_price ? $ad->booking->week_days_price[1] : ''; } ?>" placeholder="<?php echo translate("tr_682fa8dbadd54fda355b27f124938c93"); ?>" >
                  </div>
                </div>

              </div>
              <div class="ad-create-options-week-days-item" >
                
                <div class="row" >
                  <div class="col-lg-6 col-6" >
                        <strong><?php echo translate("tr_5ee6823986a8f899e72867769cc79f50"); ?></strong>
                        <input type="number" name="booking_week_days_price[2]" class="form-control mt10" step="0.01" value="<?php if($ad){ echo $ad->booking->week_days_price ? $ad->booking->week_days_price[2] : ''; } ?>" placeholder="<?php echo translate("tr_682fa8dbadd54fda355b27f124938c93"); ?>" >
                  </div>
                </div>

              </div>
              <div class="ad-create-options-week-days-item" >
                
                <div class="row" >
                  <div class="col-lg-6 col-6" >
                        <strong><?php echo translate("tr_05a6fc3b0f38613c1204533941d7fbf2"); ?></strong>
                        <input type="number" name="booking_week_days_price[3]" class="form-control mt10" step="0.01" value="<?php if($ad){ echo $ad->booking->week_days_price ? $ad->booking->week_days_price[3] : ''; } ?>" placeholder="<?php echo translate("tr_682fa8dbadd54fda355b27f124938c93"); ?>" >
                  </div>
                </div>

              </div> 
              <div class="ad-create-options-week-days-item" >
                
                <div class="row" >
                  <div class="col-lg-6 col-6" >
                        <strong><?php echo translate("tr_afc65037bfd6f02b96fed9402a04e559"); ?></strong>
                        <input type="number" name="booking_week_days_price[4]" class="form-control mt10" step="0.01" value="<?php if($ad){ echo $ad->booking->week_days_price ? $ad->booking->week_days_price[4] : ''; } ?>" placeholder="<?php echo translate("tr_682fa8dbadd54fda355b27f124938c93"); ?>" >
                  </div>
                </div>

              </div>
              <div class="ad-create-options-week-days-item" >
                
                <div class="row" >
                  <div class="col-lg-6 col-6" >
                        <strong><?php echo translate("tr_e22ad436a75ddca627ceceb8133ed473"); ?></strong>
                        <input type="number" name="booking_week_days_price[5]" class="form-control mt10" step="0.01" value="<?php if($ad){ echo $ad->booking->week_days_price ? $ad->booking->week_days_price[5] : ''; } ?>" placeholder="<?php echo translate("tr_682fa8dbadd54fda355b27f124938c93"); ?>" >
                  </div>
                </div>

              </div>
              <div class="ad-create-options-week-days-item" >
                
                <div class="row" >
                  <div class="col-lg-6 col-6" >
                        <strong><?php echo translate("tr_cee58b7423c8a4be832c9c6b451266a3"); ?></strong>
                        <input type="number" name="booking_week_days_price[6]" class="form-control mt10" step="0.01" value="<?php if($ad){ echo $ad->booking->week_days_price ? $ad->booking->week_days_price[6] : ''; } ?>" placeholder="<?php echo translate("tr_682fa8dbadd54fda355b27f124938c93"); ?>" >
                  </div>
                </div>

              </div>
              <div class="ad-create-options-week-days-item" >
                
                <div class="row" >
                  <div class="col-lg-6 col-6" >
                        <strong><?php echo translate("tr_aa48fa26be782a62ae1c97db92b52286"); ?></strong>
                        <input type="number" name="booking_week_days_price[7]" class="form-control mt10" step="0.01" value="<?php if($ad){ echo $ad->booking->week_days_price ? $ad->booking->week_days_price[7] : ''; } ?>" placeholder="<?php echo translate("tr_682fa8dbadd54fda355b27f124938c93"); ?>" >
                  </div>
                </div>

              </div>                                                                                                           
          </div>

      </div>

      <div class="ad-create-options-container-item" >
          
          <h5 class="ad-create-options-container-item-title" > <strong><?php echo translate("tr_2f65331185abdf3f4a7ac9f810ebbcb2"); ?></strong> </h5>

          <div class="ad-create-options-additional-services-container" >
            <?php if($ad){ echo $app->component->ads->outBookingAdditionalServicesInCreate($ad->booking->additional_services); } ?>
          </div>

          <span class="btn-custom-mini button-color-scheme1 mt10 actionAddBookingAdditionalService" ><?php echo translate("tr_5eba283b81890978e67f4aa96dde1724"); ?></span>

      </div>

      <div class="ad-create-options-container-item" >
          
          <h5 class="ad-create-options-container-item-title" > <strong><?php echo translate("tr_cee1c1209ef90a3bdcb2a3b36ef98b16"); ?></strong> </h5>

          <p><?php echo translate("tr_9b148f740391a327d99a0d52f78a75f3"); ?></p>

          <div class="ad-create-options-special-days-container" >
            <?php if($ad){ echo $app->component->ads->outBookingSpecialDays($ad->booking->special_days); } ?>
          </div>

          <span class="btn-custom-mini button-color-scheme1 mt10 actionAddBookingSpecialDays" ><?php echo translate("tr_5eba283b81890978e67f4aa96dde1724"); ?></span>

      </div>

      <?php if($data->price_currency_status){ ?>
      <div class="ad-create-options-container-item" >
          
          <h5 class="ad-create-options-container-item-title" > <strong><?php echo translate("tr_cf55d9a902b71b917a6f0f8aedd4ed11"); ?></strong> </h5>

          <div class="row" >
            <div class="col-md-6" >
                  <?php echo $data->price_currency_items; ?>
                  <label class="form-label-error" data-name="price_currency_code"></label>
            </div>
          </div>

      </div>
      <?php } ?>

      <?php if($data->term_date_status){ ?>

      <div class="ad-create-options-container-item" >
          
          <h5 class="ad-create-options-container-item-title" > <strong><?php echo translate("tr_23fd6a45118da7115a40e7fdda97edfa"); ?></strong> </h5>

          <div class="row" >
            <div class="col-md-6" >
                  <?php echo $data->term_date_items ?> 
                  <label class="form-label-error" data-name="term_date_day"></label> 
            </div>
          </div>

      </div>

      <?php } ?>

      <?php if($app->component->ads_categories->categories[$data->category_id]["online_view_status"] || $app->user->data->service_tariff->items->autorenewal){ ?>
      <div class="ad-create-options-container-item-extra-settings" >
          
          <h5 class="ad-create-options-container-item-title" > <strong><?php echo translate("tr_e0009397faa01627a668afee5b5f4f48"); ?></strong> </h5>

          <?php

          if($app->component->ads_categories->categories[$data->category_id]["online_view_status"]){

            ?>
              <div class="ad-create-options-container-item-extra" >
                <label class="switch">
                  <input type="checkbox" class="switch-input" name="online_view_status" value="1" <?php if($ad){ echo $ad->online_view_status ? 'checked=""' : ''; }else{ echo $data->online_view_status ? 'checked=""' : ''; } ?> >
                  <span class="switch-toggle-slider">
                    <span class="switch-on"></span>
                    <span class="switch-off"></span>
                  </span>
                  <span class="switch-label"><?php echo translate("tr_0e5417bc45088e982954ceadf71d2213"); ?></span>
                </label>
              </div>
            <?php

          }

          if($app->user->data->service_tariff->items->autorenewal){

            ?>
            <div class="ad-create-options-container-item-extra" >
                <label class="switch">
                  <input type="checkbox" class="switch-input" name="auto_renewal_status" value="1" <?php if($ad){ echo $ad->auto_renewal_status ? 'checked=""' : ''; }else{ echo $data->auto_renewal_status ? 'checked=""' : ''; } ?> >
                  <span class="switch-toggle-slider">
                    <span class="switch-on"></span>
                    <span class="switch-off"></span>
                  </span>
                  <span class="switch-label"><?php echo translate("tr_f139acad6b9e9ae951fc74f9df710e96"); ?></span>
                </label>
            </div>
            <?php

          }

          ?>

      </div>
      <?php } ?>

      <?php if($app->component->ads_categories->categories[$data->category_id]["change_city_status"] && $app->settings->active_countries){ ?>

      <div class="ad-create-options-container-item" >
          
          <h5 class="ad-create-options-container-item-title" > <strong><?php echo translate("tr_06d897a2b68c63493b65390fe35e7a2a"); ?></strong> </h5>

          <div class="input-geo-search-container ad-create-search-city" >
            <input type="text" class="form-control" placeholder="<?php echo translate("tr_63c324fe0008bda6b72c9f1ce11e8056"); ?>" value="<?php echo $ad ? $app->component->geo->outFullNameCity((array)$ad->geo) : ''; ?>" >
            <div class="input-geo-search-container-result" ></div>
          </div>

          <label class="form-label-error" data-name="geo_city_id"></label>

      </div>

      <div class="ad-create-options-container-item-box-geo" <?php if($ad){ echo $ad->city_id ? 'style="display: block;"' : 'style="display: none;"'; }else{ echo $data->city_id ? 'style="display: block;"' : 'style="display: none;"'; } ?> >
          <?php echo $app->component->ads->outMapAndOptionsInAdCreate($ad ? $ad->city_id : $data->city_id, $ad); ?>
      </div>

      <?php } ?>

      <?php if($app->user->data->id || $data->is_admin){ ?>

      <div class="ad-create-options-container-item" >
          
          <h5 class="ad-create-options-container-item-title mb20" > <strong><?php echo translate("tr_75768c49c24662cc4465237b0731e1ce"); ?></strong> </h5>

          <div class="row" >
            <div class="col-md-6" ><label class="form-control-label" ><?php echo translate("tr_ac7b6fe044615014a68e0c71e6367655"); ?></label></div>
            <div class="col-md-6" >
                <?php echo $app->ui->buildUniSelect([["item_name"=>translate("tr_2896f02474404ef29588f3489d8a461e"),"input_name"=>"contact_method","input_value"=>"all"],["item_name"=>translate("tr_6aa1128b7f28aa917e80ee45c0da715f"),"input_name"=>"contact_method","input_value"=>"call"],["item_name"=>translate("tr_0994356b1cef3b535e4900be810d7759"),"input_name"=>"contact_method","input_value"=>"message"],["item_name"=>translate("tr_bd21fbcbe7f325040fc3dd6bfe4a0245"),"input_name"=>"contact_method","input_value"=>"hide"]], ["view"=>"radio","selected"=>[ $ad ? $ad->contact_method : "all" ]]); ?>
                <label class="form-label-error" data-name="contact_method"></label>
            </div>
          </div>

          <?php if($app->settings->board_publication_required_email){ ?>
          <div class="row mt10" >
            <div class="col-md-6" ><label class="form-control-label" ><?php echo translate("tr_92d65fa726a6a4b889597e2e0b1efa58"); ?></label></div>
            <div class="col-md-6" >
              <input type="text" name="contact_email" class="form-control" value="<?php if($ad){ echo $ad->contacts->email; }else{ echo $app->user->data->email; } ?>" >
              <label class="form-label-error" data-name="contact_email"></label>
              <div class="actionSendVerifyCodeEmailContainer" >
                <span class="btn-custom-mini button-color-scheme3 actionSendVerifyCodeEmail mt10" ><?php echo translate("tr_e2603bcce79e0b861ac1f1bd464de2b6"); ?></span>
              </div>
            </div>
          </div>
          <?php } ?>

          <?php if($app->settings->board_publication_required_phone_number){ ?>
          <div class="row mt10" >
            <div class="col-md-6" ><label class="form-control-label" ><?php echo translate("tr_9fdc3f131f7923e7bdd4ec60d465ae87"); ?></label></div>
            <div class="col-md-6" >
              <?php echo $app->ui->outInputPhoneContact($ad ? $ad->contacts->phone : $app->user->data->phone, ["input_name"=>"contact_phone"]); ?>
              <label class="form-label-error" data-name="contact_phone"></label>
              <div class="actionSendVerifyCodePhoneContainer" >
                <span class="btn-custom-mini button-color-scheme3 actionSendVerifyCodePhone mt10" ><?php echo translate("tr_e2603bcce79e0b861ac1f1bd464de2b6"); ?></span>
              </div>
            </div>
          </div>
          <?php } ?>

          <div class="row mt10" >
            <div class="col-md-6" ><label class="form-control-label" ><?php echo translate("tr_3d194ab0c64a01573a74db711cf28ce8"); ?></label></div>
            <div class="col-md-6" >
              <input type="text" name="contact_name" class="form-control" value="<?php if($ad){ echo $ad->contacts->name; }else{ echo $app->user->data->name; } ?>" >
              <label class="form-label-error" data-name="contact_name"></label>
            </div>
          </div>

          <?php if($app->settings->board_publication_required_contact_max){ ?>
          <div class="row mt10" >
            <div class="col-md-6" ><label class="form-control-label" > <i class="ti ti-brand-telegram"></i> <?php echo translate("tr_6a061313d22e51e0f25b7cd4dc065233"); ?></label></div>
            <div class="col-md-6" >
              <input type="text" name="contact_max" class="form-control" value="<?php if($ad){ echo $ad->contacts->max; }else{ echo $app->user->data->contacts->max; } ?>" >
            </div>
          </div>
          <?php } ?>

          <?php if($app->settings->board_publication_required_contact_whatsapp){ ?>
          <div class="row mt10" >
            <div class="col-md-6" ><label class="form-control-label" > <i class="ti ti-brand-whatsapp"></i> <?php echo translate("tr_8b777ebcc5034ce0fe96dd154bcb370e"); ?></label></div>
            <div class="col-md-6" >
              <input type="text" name="contact_whatsapp" class="form-control" value="<?php if($ad){ echo $ad->contacts->whatsapp; }else{ echo $app->user->data->contacts->whatsapp; } ?>" >
            </div>
          </div>
          <?php } ?>

          <?php if($app->settings->board_publication_required_contact_telegram){ ?>
          <div class="row mt10" >
            <div class="col-md-6" ><label class="form-control-label" > <i class="ti ti-brand-telegram"></i> <?php echo translate("tr_c915683f3ec888b8edcc7b06bd1428ec"); ?></label></div>
            <div class="col-md-6" >
              <input type="text" name="contact_telegram" class="form-control" value="<?php if($ad){ echo $ad->contacts->telegram; }else{ echo $app->user->data->contacts->telegram; } ?>" >
            </div>
          </div>
          <?php } ?>

      </div>

      <?php } ?>

  </div>
  <div class="col-md-4 order-lg-2 order-1" >

    <?php
    if($app->component->ads_categories->categories[$data->category_id]["paid_status"]){
      ?>
        <div class="ad-create-info-block-payment" >
          
            <h5><?php echo translate("tr_ec861f779e3ca5d47636abd8d7219f67"); ?></h5>

            <p class="ad-create-info-block-payment-text" ><?php echo $app->component->ads->outInfoPaidCategory($data->category_id, $app->user->data->id); ?></p>

        </div>
      <?php
    }
    ?>

  </div>

</div>