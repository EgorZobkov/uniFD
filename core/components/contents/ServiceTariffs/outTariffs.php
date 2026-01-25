public function outTariffs(){
    global $app;

    $getTariffs = $app->model->users_tariffs->sort("recommended desc, sorting asc")->getAll("status=?", [1]);

    if($getTariffs){

        foreach ($getTariffs as $key => $value) {

            $items = [];

            if($value["items_id"]){
                $items = $app->model->users_tariffs_items->getAll("id IN(".implode(",", _json_decode($value["items_id"])).")");
            }

            $order = $app->model->users_tariffs_orders->find("user_id=? and tariff_id=? and (time_expiration > now() or time_expiration is null)", [$app->user->data->id, $value["id"]]);

            ?>

            <div class="profile-tariffs-list-item swiper-slide <?php if($order){ echo 'added active'; } ?>" data-id="<?php echo $value["id"]; ?>" >

              <?php 
              if(!$order){
                  if($value["recommended"]){
                    ?>
                    <span class="profile-tariffs-list-item-label status-label-color-success" ><?php echo translate("tr_a2d067bae66a41616b405a46a7f342f9"); ?></span>
                    <?php
                  }
              }else{
                ?>
                <span class="profile-tariffs-list-item-label status-label-color-success" ><?php echo translate("tr_00026c7612245e31d0525f28dd5d3c17"); ?></span>
                <?php                    
              }
              ?>

              <?php if($value["image"]){ ?>
                 <div class="profile-tariffs-list-item-image" > <img src="<?php echo $app->storage->name($value["image"])->get(); ?>" > </div>
              <?php } ?>

              <div class="profile-tariffs-list-item-content" >

                  <h5><?php echo translateFieldReplace($value, "name"); ?></h5>

                  <div class="profile-tariffs-list-item-prices" >
                      
                      <?php if($value["price"]){ ?>

                          <span class="profile-tariffs-list-item-price-now" ><?php echo $app->system->amount($value["price"]); ?></span>

                          <?php if($value["old_price"]){ ?>
                          <span class="profile-tariffs-list-item-price-old" ><?php echo $app->system->amount($value["old_price"]); ?></span>
                          <?php } ?>

                          <?php if($value["count_day_fixed"]){ ?>
                          <span><?php echo translate("tr_462eaa68988f6a1a10814f865d5160ad"); ?> <?php echo $value["count_day"]; ?> <?php echo endingWord($value["count_day"], translate("tr_48e438a146f96b54bbe9d5046ffc3a2b"), translate("tr_0871eeafdf38726742fa5affa8a5d6eb"), translate("tr_c183655a02377815e6542875555b1340")); ?></span>
                          <?php }else{ ?>
                          <span><?php echo translate("tr_a24eeb5fdf0983de68c3a81a1e0a751b"); ?></span>
                          <?php } ?>

                      <?php }else{ ?>

                          <?php if($value["count_day_fixed"]){ ?>
                          <span><?php echo translate("tr_9b968143ae053f12af81015dc3e958d4"); ?> <?php echo $value["count_day"]; ?> <?php echo endingWord($value["count_day"], translate("tr_48e438a146f96b54bbe9d5046ffc3a2b"), translate("tr_0871eeafdf38726742fa5affa8a5d6eb"), translate("tr_c183655a02377815e6542875555b1340")); ?></span>
                          <?php }else{ ?>
                          <span><?php echo translate("tr_bc029280c9291699fdfe12b891567a46"); ?></span>
                          <?php } ?>

                      <?php }
                       ?>

                  </div>

                  <p><?php echo translateFieldReplace($value, "text"); ?></p>

                  <div class="profile-tariffs-list-items" >
                  <?php
                  if($items){
                    foreach ($items as $item) {
                        ?>
                        <span>
                            <i class="ti ti-check"></i> <?php echo translateFieldReplace($item, "name"); ?>
                            <?php if($item["text"]){ ?>
                            <div> <small><?php echo translateFieldReplace($item, "text"); ?></small> </div>
                            <?php } ?>
                        </span>
                        <?php
                    }
                  }
                  ?>
                  </div>

              </div>                  
              
            </div>

            <?php

        }
    }


}