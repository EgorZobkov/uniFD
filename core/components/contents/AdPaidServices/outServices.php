public function outServices($ad_id=0){
    global $app;

    $getActiveServices = $this->getActiveServicesByAd($ad_id);

    if($getActiveServices->data_by_alias["package"]){

        ?>

            <div class="ad-paid-services-list-item added active" >

              <div class="row" >
                <div class="col-md-2" >
                  <div class="ad-paid-services-list-item-image" > <img src="<?php echo $app->storage->name($getActiveServices->data_by_alias["package"]->service->image)->get(); ?>" > </div>
                </div>
                <div class="col-md-8" >
                  <div class="ad-paid-services-list-item-content" >

                      <div class="ad-paid-services-list-item-added" ><span><?php echo translate("tr_d0228ee04fc673ad983110952ac2035a"); ?></span></div>

                      <h5><?php echo $getActiveServices->data_by_alias["package"]->service->name; ?></h5>
                      <p><?php echo $getActiveServices->data_by_alias["package"]->service->text; ?></p>

                      <strong><?php echo translate("tr_210629676d236bf85e0dbb3c2f8ec7d7"); ?> <?php echo $app->datetime->outStringDiff($getActiveServices->data_by_alias["package"]->order->time_create, $getActiveServices->data_by_alias["package"]->order->time_expiration); ?></strong>

                  </div>                  
                </div>
                <div class="col-md-2" >                  
                </div>
              </div>
              
            </div>

        <?php 

    }else{

        if($getActiveServices->ids){
            $getServices = $app->model->ads_services->sort("recommended desc")->getAll("status=? and alias!=?", [1, "package"]);
        }else{
            $getServices = $app->model->ads_services->sort("recommended desc")->getAll("status=?", [1]);
        }

        if($getServices){

            foreach ($getServices as $key => $value) {

                if(!compareValues($getActiveServices->ids, $value["id"])){
                    ?>

                        <div class="ad-paid-services-list-item" data-id="<?php echo $value["id"]; ?>" >

                          <?php 
                          if($value["recommended"]){
                            ?>
                            <span class="ad-paid-services-list-item-recommended" ><?php echo translate("tr_a2d067bae66a41616b405a46a7f342f9"); ?></span>
                            <?php
                          }
                          ?>

                          <div class="row" >
                            <div class="col-md-2" >
                              <div class="ad-paid-services-list-item-image" > <img src="<?php echo $app->storage->name($value["image"])->get(); ?>" > </div>
                            </div>
                            <div class="col-md-8 col-9" >
                              <div class="ad-paid-services-list-item-content" >

                                  <h5><?php echo translateFieldReplace($value, "name"); ?></h5>
                                  <p><?php echo translateFieldReplace($value, "text"); ?></p>

                                  <?php if($value["count_day_fixed"]){ ?>

                                  <strong><?php echo translate("tr_e73bef6ffbaf33e11595b0a4c1639a44"); ?> <?php echo $value["count_day"]; ?> <?php echo endingWord($value["count_day"], translate("tr_48e438a146f96b54bbe9d5046ffc3a2b"), translate("tr_0871eeafdf38726742fa5affa8a5d6eb"), translate("tr_c183655a02377815e6542875555b1340")); ?></strong>

                                  <?php }else{ ?>

                                  <div class="quantity_inner">        
                                      <button class="bt_minus">
                                          <svg viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                      </button>
                                      <span class="quantity" ><?php echo translate("tr_f5b8aacf39dcd00d28d8661e051d1b07"); ?></span>
                                      <button class="bt_plus">
                                          <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                      </button>
                                  </div>

                                  <input type="hidden" class="ad-paid-services-list-item-count" name="count_day[<?php echo $value["id"]; ?>]" value="1" >

                                  <?php } ?>

                                  <div class="ad-paid-services-action-payment" >
                                    <button class="initOptionsPaymentServices btn-custom button-color-scheme1" ><?php echo translate("tr_ad5c2ce8c246a75449fc289b032c5ca8"); ?></button>
                                  </div>

                              </div>                  
                            </div>
                            <div class="col-md-2 col-3" >
                              <div class="ad-paid-services-list-item-price" >

                                  <span class="ad-paid-services-list-item-price-now" ><?php echo $app->system->amount($value["price"]); ?></span>
                                  <?php if($value["old_price"]){ ?>
                                  <span class="ad-paid-services-list-item-price-old" ><?php echo $app->system->amount($value["old_price"]); ?></span>
                                  <?php } ?>

                              </div>                  
                            </div>
                          </div>
                          
                        </div>

                    <?php
                }else{

                    $order = $this->getActiveOrder($ad_id, $value["id"]);

                    ?>

                        <div class="ad-paid-services-list-item added" >

                          <div class="row" >
                            <div class="col-md-2" >
                              <div class="ad-paid-services-list-item-image" > <img src="<?php echo $app->storage->name($value["image"])->get(); ?>" > </div>
                            </div>
                            <div class="col-md-8" >
                              <div class="ad-paid-services-list-item-content" >

                                  <div class="ad-paid-services-list-item-added" ><span><?php echo translate("tr_d0228ee04fc673ad983110952ac2035a"); ?></span></div>

                                  <h5><?php echo translateFieldReplace($value, "name"); ?></h5>
                                  <p><?php echo translateFieldReplace($value, "text"); ?></p>

                                  <strong><?php echo translate("tr_210629676d236bf85e0dbb3c2f8ec7d7"); ?> <?php echo $app->datetime->outStringDiff($order->time_create, $order->time_expiration); ?></strong>

                              </div>                  
                            </div>
                            <div class="col-md-2" >                  
                            </div>
                          </div>
                          
                        </div>

                    <?php                    
                }

            }
        }

    }


}