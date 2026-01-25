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