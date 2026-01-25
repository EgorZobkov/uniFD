<?php

/**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Components;
use App\Systems\Container;

class Cart
{

 public $alias = "cart";

 public function addToCart($item_id=0, $count=1, $user_id=0){
    global $app;

    $session_id = $app->session->get("user-session-id");

    $ad = $app->component->ads->getAd($item_id);

    if(!$ad || $ad->delete){
        return "error";
    }

    if(!$app->component->ads->hasAddToCart($ad)){
        return "error";
    }

    if(!$app->component->ads->checkAvailable($item_id)){
        return "not_available";
    }

    if(!$this->checkInCart($item_id, $user_id)){
        $app->model->cart->insert(["user_id"=>(int)$user_id, "whom_user_id"=>(int)$ad->user_id, "item_id"=>$item_id, "count"=>$count, "time_create"=>$app->datetime->getDate(), "session_id"=>$session_id]);
        if($user_id){
            $app->event->addToCart(["from_user_id"=>$user_id, "item_id"=>$item_id, "whom_user_id"=>$ad->user_id]);
        }
    }

    return "added";

}

public function checkInCart($item_id=0, $user_id=0){
    global $app;

    $item = [];
    $session_id = $app->session->get("user-session-id");

    if($user_id){

        $item = $app->model->cart->find("user_id=? and item_id=?", [$user_id, $item_id]);

    }elseif($session_id){

        $item = $app->model->cart->find("session_id=? and item_id=?", [$session_id, $item_id]);

    }

    return $item;

}

public function count($user_id=0){
    global $app;

    $count = 0;
    $session_id = $app->session->get("user-session-id");

    if($user_id){

        $getItems = $app->model->cart->sort("id desc")->getAll("user_id=?", [$user_id]);

    }elseif($session_id){

        $getItems = $app->model->cart->sort("id desc")->getAll("session_id=?", [$session_id]);

    }

    if($getItems){
        foreach ($getItems as $key => $value) {
            if($app->model->ads_data->find("id=?", [$value["item_id"]])){
                $count = $count + $value["count"];
            }
        }
    }

    return $count;

}

public function delete($id=0, $user_id=0){
    global $app;

    $session_id = $app->session->get("user-session-id");

    if($user_id){

        $app->model->cart->delete("user_id=? and id=?", [$user_id, $id]);

    }elseif($session_id){

        $app->model->cart->delete("session_id=? and id=?", [$session_id, $id]);

    }

}

public function getCartItems($user_id=0, $item_ids=[]){
    global $app;

    $session_id = $app->session->get("user-session-id");
    $items = [];

    if($item_ids){

        if(is_array($item_ids)){

            if($user_id){
                $getItems = $app->model->cart->sort("id desc")->getAll("user_id=? and id IN(".implode(",", $item_ids).")", [$user_id]);
            }elseif($session_id){
                $getItems = $app->model->cart->sort("id desc")->getAll("session_id=? and id IN(".implode(",", $item_ids).")", [$session_id]);
            }

        }

    }else{

        if($user_id){
            $getItems = $app->model->cart->sort("id desc")->getAll("user_id=?", [$user_id]);
        }elseif($session_id){
            $getItems = $app->model->cart->sort("id desc")->getAll("session_id=?", [$session_id]);
        }

    }

    if($getItems){

        foreach ($getItems as $key => $value) {
            
            $ad = $app->component->ads->getAd($value["item_id"]);

            $items[$ad->user_id][] = (object)["id"=>$value["id"], "count"=>$value["count"], "item"=>$ad];

        }

    }

    return $items;

}

public function minusCount($id=0, $user_id=0){
    global $app;

    $session_id = $app->session->get("user-session-id");
    $count = 0;
    $price = 0;

    if($user_id){
        $get = $app->model->cart->find("user_id=? and id=?", [$user_id, $id]);
    }elseif($session_id){
        $get = $app->model->cart->find("session_id=? and id=?", [$session_id, $id]);
    }

    if($get){

        $count = $get->count;

        $ad = $app->model->ads_data->find("id=?", [$get->item_id]);

        if($ad){

            if($count > 1){

                $count = $count-1;

                if(!$ad->not_limited){

                    if($count > $ad->in_stock){
                        $count = $ad->in_stock;
                    }

                }

            }

            $price = $ad->price * $count;

        }else{
            return (object)["count"=>0, "price"=>0];
        }

        $app->model->cart->update(["count"=>$count], $get->id);

    }

    return (object)["count"=>$count, "price"=>$price];
    
}

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

public function plusCount($id=0, $user_id=0){
    global $app;

    $session_id = $app->session->get("user-session-id");
    $count = 0;
    $price = 0;

    if($user_id){
        $get = $app->model->cart->find("user_id=? and id=?", [$user_id, $id]);
    }elseif($session_id){
        $get = $app->model->cart->find("session_id=? and id=?", [$session_id, $id]);
    }

    if($get){

        $count = $get->count+1;

        $ad = $app->model->ads_data->find("id=?", [$get->item_id]);

        if($ad){

            if(!$ad->not_limited){

                if($count > $ad->in_stock){
                    $count = $ad->in_stock;
                }

            }

            $price = $ad->price * $count;

        }else{
            return (object)["count"=>0, "price"=>0];
        }

        $app->model->cart->update(["count"=>$count], $get->id);

    }

    return (object)["count"=>$count, "price"=>$price];
    
}

public function totalAmount($user_id=0, $item_ids=[]){
    global $app;

    $session_id = $app->session->get("user-session-id");
    $amount = 0;

    if($item_ids){

        if(is_array($item_ids)){

            if($user_id){
                $getItems = $app->model->cart->getAll("user_id=? and id IN(".implode(",", $item_ids).")", [$user_id]);
            }elseif($session_id){
                $getItems = $app->model->cart->getAll("session_id=? and id IN(".implode(",", $item_ids).")", [$session_id]);
            }

        }

    }else{

        if($user_id){
            $getItems = $app->model->cart->getAll("user_id=?", [$user_id]);
        }elseif($session_id){
            $getItems = $app->model->cart->getAll("session_id=?", [$session_id]);
        }

    }

    if($getItems){

        foreach ($getItems as $key => $value) {
            
            $ad = $app->model->ads_data->find("id=?", [$value["item_id"]]);

            if($ad){

                if(!$ad->not_limited){

                    if($value["count"] <= $ad->in_stock){
                        $amount += $ad->price * $value["count"];
                    }else{
                        $amount += $ad->price * $ad->in_stock;
                    }

                }else{
                    $amount += $ad->price * $value["count"];
                }

            }

        }

    }

    return $amount;

}

public function totalCountChangeItems($user_id=0, $item_ids=[]){
    global $app;

    $session_id = $app->session->get("user-session-id");
    $count = 0;

    if($item_ids){
        if(is_array($item_ids)){

            if($user_id){
                $getItems = $app->model->cart->getAll("user_id=? and id IN(".implode(",", $item_ids).")", [$user_id]);
            }elseif($session_id){
                $getItems = $app->model->cart->getAll("session_id=? and id IN(".implode(",", $item_ids).")", [$session_id]);
            }

            if($getItems){

                foreach ($getItems as $key => $value) {
                    
                    $ad = $app->model->ads_data->find("id=?", [$value["item_id"]]);

                    if($ad){

                        if(!$ad->not_limited){

                            if($ad->in_stock){

                                if($value["count"] <= $ad->in_stock){
                                    $count += $value["count"];
                                }else{
                                    $count += $ad->in_stock;
                                }

                            }

                        }else{
                            $count += $value["count"];
                        }

                    }

                }

            }

        }
    }

    return $count;

}

public function updateUserItems(){
    global $app;

    $session_id = $app->session->get("user-session-id");

    if($app->user->isAuth()){
        if($session_id){
            $app->model->cart->update(["user_id"=>$app->user->data->id], ["session_id=?", [$session_id]]);
            $app->model->cart->delete("user_id=? and whom_user_id=?", [$app->user->data->id, $app->user->data->id]);
        }
    }

}



}