public function outCartItems($data=[]){
    global $app;

    foreach ($data->items as $user_id => $nested) {

        $user = $app->model->users->findById($user_id);

        ?>
        <div class="cart-ad-card-container" >

        <div class="cart-ad-card-item-user" >
            <a href="<?php echo $app->component->profile->linkUserCard($user->alias); ?>"><?php echo $app->user->name($user); ?></a>
            <span class="cart-ad-card-item-user-rating"><i class="ti ti-star-filled"></i> <?php echo $user->total_rating ?: 0; ?></span>
        </div>
        
        <?php

        foreach ($nested as $key => $value) {
            
            ?>

              <div class="cart-ad-card-item" data-id="<?php echo $value->id; ?>" >
                <div class="cart-ad-card-item-checkbox" >
                    <div class="form-check">
                      <input class="form-check-input cartCheckboxItem" type="checkbox" name="item_id[]" value="<?php echo $value->id; ?>" <?php if($value->item->delete){ echo 'disabled=""'; }else{ echo 'checked'; } ?> >
                    </div>                        
                </div>
                <div class="cart-ad-card-item-image" > <img src="<?php echo $value->item->media->images->first; ?>" class="image-autofocus" > </div>
                <div class="cart-ad-card-item-content" >

                    <div class="row" >
                        <div class="col-md-7" >
                            
                          <div class="cart-ad-card-item-content-title" > <a href="<?php echo $app->component->ads->buildAliasesAdCard($value->item); ?>"><?php echo $value->item->title; ?></a> </div>
                          
                        </div>
                        <div class="col-md-3 col-9" >

                          <div class="cart-ad-card-item-content-prices" ><?php echo $app->system->amount($value->item->price * $value->count); ?></div>

                          <?php
                            if(!$value->item->not_limited){

                                if($value->item->in_stock){

                                    if($value->item->in_stock > 1){
                                        ?>
                                          <div class="cart-ad-card-item-content-quantity" >

                                          <div class="quantity_inner">        
                                              <button class="bt_minus actionMinusCountItemCart" data-id="<?php echo $value->id; ?>">
                                                  <svg viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                              </button>
                                              <span class="quantity"><?php echo $value->count; ?></span>
                                              <button class="bt_plus actionPlusCountItemCart" data-id="<?php echo $value->id; ?>">
                                                  <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                              </button>
                                          </div>

                                          </div>
                                        <?php                                            
                                    }

                                }else{
                                    ?>
                                    <span class="cart-ad-card-item-content-quantity-remains" ><?php echo translate("tr_f5d1470a611480ac7b74324c2beb152e"); ?></span>
                                    <?php
                                }

                            }else{

                                ?>

                                  <div class="cart-ad-card-item-content-quantity" >

                                  <div class="quantity_inner">        
                                      <button class="bt_minus actionMinusCountItemCart" data-id="<?php echo $value->id; ?>">
                                          <svg viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                      </button>
                                      <span class="quantity"><?php echo $value->count; ?></span>
                                      <button class="bt_plus actionPlusCountItemCart" data-id="<?php echo $value->id; ?>">
                                          <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                      </button>
                                  </div>

                                  </div>

                                <?php

                            }
                          ?>

                        </div>
                        <div class="col-md-2 col-3 text-end" >
                            
                            <div class="cart-ad-card-item-delete actionDeleteItemCart" data-id="<?php echo $value->id; ?>" > <i class="ti ti-trash"></i> </div>

                        </div>
                    </div>

                </div>
                
              </div>

            <?php

        }

        ?>
        </div>
        <?php

    }

}