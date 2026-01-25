public function outCheckoutItems($data=[]){
    global $app;

    foreach ($data->items as $user_id => $nested) {

        $user = $app->model->users->findById($user_id);

        ?>
        <div class="cart-ad-card-container" >

        <div class="cart-ad-card-item-user" >
            <a href="<?php echo $app->component->profile->linkUserCard($user->alias); ?>"><?php echo $app->user->name($user); ?></a>
            <span class="cart-ad-card-item-user-rating"><i class="ti ti-star-filled"></i> <?php echo $user->total_rating; ?></span>
        </div>
        
        <?php

        foreach ($nested as $key => $value) {
            
            ?>

              <div class="cart-ad-card-item" data-id="<?php echo $value->id; ?>" >
                <div class="cart-ad-card-item-image" > <img src="<?php echo $value->item->media->images->first; ?>" class="image-autofocus" > </div>
                <div class="cart-ad-card-item-content" >
                    <div class="cart-ad-card-item-content-title" > <a href="<?php echo $app->component->ads->buildAliasesAdCard($value->item); ?>"><?php echo $value->item->title; ?></a> </div>
                    
                    <?php

                      if($value->item->category->type_goods == "physical_goods"){
                          ?>
                          <span class="btn-custom-mini button-color-scheme2 mt10 actionOpenStaticModal" data-modal-target="cartChangeDelivery" data-modal-params="<?php echo buildAttributeParams(["id"=>$value->item->id]); ?>" ><?php echo translate("tr_902193d42ce3a1f2dc226f882c8e8a3a"); ?></span>
                          <div class="cart-ad-card-item-<?php echo $value->item->id; ?>" >
                                <div class="cart-ad-card-item-delivery-name" ></div>
                                <input type="hidden" name="delivery_point_id[<?php echo $value->item->id; ?>]" value="0" class="cart-item-delivery-points" >
                          </div>
                          <?php
                      }

                      if($value->item->category->type_goods == "electronic_goods"){
                          ?>
                          <small><?php echo translate("tr_6ce42989e48acb25228c9e1021b69981"); ?></small>
                          <?php
                      }

                    ?>
                </div>
              </div>

            <?php

        }

        ?>
        </div>
        <?php

    }

}