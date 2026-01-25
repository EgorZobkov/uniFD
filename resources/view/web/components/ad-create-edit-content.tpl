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

      <?php if($app->component->ads_categories->categories[$data->category_id]["type_goods"] == "partner_link"){ ?>
      <div class="ad-create-options-container-item" >
          
          <h5 class="ad-create-options-container-item-title" > <strong><?php echo translate("tr_6b5d775b64e9503706984360194843b8"); ?></strong> </h5>

          <p><?php echo translate("tr_31b12f2d096e4885e8c8d85f67a353f7"); ?></p>

          <input type="text" name="partner_link" class="form-control mt15" value="<?php echo $ad ? $ad->partner_link : $data->partner_link; ?>" >

          <label class="form-label-error" data-name="partner_link"></label>

      </div>

      <div class="ad-create-options-container-item" >
          
          <h5 class="ad-create-options-container-item-title" > <strong><?php echo translate("tr_3e79a54f445eee43978fa5316625fb8f"); ?></strong> </h5>

          <p><?php echo translate("tr_98f8f954642b2c6fd855b2927ca6fc4e"); ?></p>

          <div class="row mt15" >
             <div class="col-lg-8" >
               <input type="text" name="partner_button_name" class="form-control" placeholder="<?php echo translate("tr_24434ff9dfa6999ad580f9b5b2818d0d"); ?>" value="<?php echo $ad ? $ad->partner_button_name : $data->partner_button_name; ?>" >
             </div>
             <div class="col-lg-4" >
               <input type="text" name="partner_button_color" class="form-control minicolors-input" data-swatches="#ef9a9a|#90caf9|#a5d6a7|#fff59d|#ffcc80|#bcaaa4|#eeeeee|#f44336|#2196f3|#4caf50|#ffeb3b|#ff9800|#795548|#9e9e9e" value="<?php if($ad){ echo $ad->partner_button_color; }else{ if($data->partner_button_color){ echo $data->partner_button_color; }else{ echo '#000000'; } } ?>" size="7">
             </div>
          </div>

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

      <?php if($app->component->ads_categories->categories[$data->category_id]["price_status"]){ ?>

      <div class="ad-create-options-container-item" >
          
          <h5 class="ad-create-options-container-item-title" > <strong><?php echo $data->price_name; ?></strong> </h5>

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
            <div>
              <label class="switch mt10">
                <input type="checkbox" class="switch-input" name="price_fixed_status" value="1" <?php if($ad){ echo $ad->price_fixed_status ? 'checked=""' : ''; }else{ echo 'checked=""'; } ?> >
                <span class="switch-toggle-slider">
                  <span class="switch-on"></span>
                  <span class="switch-off"></span>
                </span>
                <span class="switch-label"><?php echo translate("tr_c262493561e9568322b4cbe1d466adf0"); ?></span>
              </label>
            </div>
          <?php } ?>

          <?php if($data->price_gratis_status){ ?>
            <div>
              <label class="switch mt10">
                <input type="checkbox" class="switch-input" name="price_gratis_status" value="1" <?php if($ad){ echo $ad->price_gratis_status ? 'checked=""' : ''; } ?> >
                <span class="switch-toggle-slider">
                  <span class="switch-on"></span>
                  <span class="switch-off"></span>
                </span>
                <span class="switch-label"><?php echo translate("tr_60183c67d880a855d91a9419f344e97e"); ?></span>
              </label>
            </div>
          <?php } ?>

      </div>

      <?php } ?>

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

      <?php if($app->component->ads_categories->categories[$data->category_id]["marketplace_status"]){ ?>

      <div class="ad-create-options-container-item" >
          
          <h5 class="ad-create-options-container-item-title" > <strong><?php echo translate("tr_35044955818867ca2693fd49107c721c"); ?></strong> </h5>

          <label class="switch">
            <input type="checkbox" class="switch-input" name="not_limited" value="1" <?php if($ad){ echo $ad->not_limited ? 'checked=""' : ''; }else{ echo $data->not_limited ? 'checked=""' : ''; } ?> >
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label"><?php echo translate("tr_a92d5791c7f48700d5144818f1cda269"); ?></span>
          </label>

          <div class="ad-create-options-container-item-box-available-settings" <?php if($ad){ echo $ad->not_limited ? 'style="display: none;"' : 'style="display: block;"'; }else{ echo $data->not_limited ? 'style="display: none;"' : 'style="display: block;"'; } ?> >
            
            <div class="row mt10" >
              <div class="col-md-6" >
                <input type="number" name="in_stock" class="form-control" placeholder="<?php echo translate("tr_ff63789b30d2ceb649261319e671f4ef"); ?>" value="<?php echo $ad ? $ad->in_stock : $data->in_stock; ?>" >
              </div>
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

      <?php if($app->component->ads_categories->categories[$data->category_id]["online_view_status"] || $app->component->ads_categories->categories[$data->category_id]["condition_new_status"] || $app->component->ads_categories->categories[$data->category_id]["condition_brand_status"] || $app->user->data->service_tariff->items->autorenewal){ ?>
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

          if($app->component->ads_categories->categories[$data->category_id]["condition_new_status"]){

            ?>

            <p><?php echo translate("tr_5c05c32981cbfeb7b5326e4a6cc5d250"); ?></p>

            <div class="ad-create-options-container-item-extra" >
                <label class="switch">
                  <input type="checkbox" class="switch-input" name="condition_new_status" value="1" <?php if($ad){ echo $ad->condition_new_status ? 'checked=""' : ''; }else{ echo $data->condition_new_status ? 'checked=""' : ''; } ?> >
                  <span class="switch-toggle-slider">
                    <span class="switch-on"></span>
                    <span class="switch-off"></span>
                  </span>
                  <span class="switch-label"><?php echo translate("tr_963d95509d21446ecc58963ffbc37251"); ?></span>
                </label>
            </div>
            <?php

          }

          if($app->component->ads_categories->categories[$data->category_id]["condition_brand_status"]){

            ?>
            <div class="ad-create-options-container-item-extra" >
                <label class="switch">
                  <input type="checkbox" class="switch-input" name="condition_brand_status" value="1" <?php if($ad){ echo $ad->condition_brand_status ? 'checked=""' : ''; }else{ echo $data->condition_brand_status ? 'checked=""' : ''; } ?> >
                  <span class="switch-toggle-slider">
                    <span class="switch-on"></span>
                    <span class="switch-off"></span>
                  </span>
                  <span class="switch-label"><?php echo translate("tr_c5cda654625332b6af4149e1a04c5d56"); ?></span>
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

      <?php if($app->component->ads_categories->categories[$data->category_id]["delivery_status"] && $app->settings->integration_delivery_services_active){ ?>

      <div class="ad-create-options-container-item" >
          
          <h5 class="ad-create-options-container-item-title" > <strong><?php echo translate("tr_b973ee86903271172c9b4f5529bc19bb"); ?></strong> </h5>

          <div class="ad-create-options-container-item-extra" >
              <label class="switch">
                <input type="checkbox" class="switch-input" name="delivery_status" value="1" <?php if($ad){ echo $ad->delivery_status  ? 'checked=""' : ''; }else{ echo $data->delivery_status  ? 'checked=""' : ''; } ?> >
                <span class="switch-toggle-slider">
                  <span class="switch-on"></span>
                  <span class="switch-off"></span>
                </span>
                <span class="switch-label"><?php echo translate("tr_042e100c20f349ab8dde8ebc4e861303"); ?></span>
              </label>
          </div> 

          <p class="mb25" ><?php echo translate("tr_2097272ec4cb451ff2b84bc7a99184f8"); ?></p>         

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

      if($app->component->ads_categories->categories[$data->category_id]["type_goods"] == "partner_link" && !$ad){

          if(!$app->user->data->service_tariff->items->partner_products && $app->settings->board_publication_partner_products_active_tariffs){
            ?>
              <div class="ad-create-info-block-payment" >
                  
                  <h5><?php echo translate("tr_4bcc1aca34ff6d964017da74d4e2f62d"); ?></h5>

                  <p class="ad-create-info-block-payment-text" ><?php echo translate("tr_3f2531358c18e54ed0973f7180f255a5"); ?></p>

              </div>
            <?php 
          }

      }

    ?>

  </div>

</div>