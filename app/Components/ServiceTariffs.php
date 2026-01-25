<?php

/**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Components;

class ServiceTariffs
{

 public $alias = "service_tariffs";

 public function checkAddTariff($tariff_id=0, $user_id=0){
    global $app;

    $tariff = $app->model->users_tariffs->find("id=?", [$tariff_id]);

    if($app->model->users_tariffs_onetime->find("user_id=? and tariff_id=?", [$user_id, $tariff_id])){
        return ["status"=>false, "answer"=>translate("tr_efab01bfb749713014c7f707071f1cb9")];
    }

    $order = $this->getActiveOrder($user_id);

    if($order){
        if($tariff->price < $order->amount){
            return ["status"=>false, "answer"=>translate("tr_b5eb978a817f0e6aa1dd5257e7650571")];
        }
    }

    return [];
  
}

public function createOrder($params=[]){
    global $app;

    $count_day = 0;

    $getTariff = $app->model->users_tariffs->find("id=?", [$params["tariff_id"]]);
    if($getTariff->count_day_fixed){
        $count_day = $getTariff->count_day;
    }

    $order = $this->getActiveOrder($params["user_id"]);

    if($order){
        if($order->tariff_id == $params["tariff_id"]){

            $time_expiration = $app->datetime->addDay($count_day)->getDate($order->time_expiration);

            $app->model->users_tariffs_orders->update(["time_expiration"=>$time_expiration, "status"=>1], $order->id);

            $app->event->extendServiceTariff($params);

            return;

        }
    }

    $params["time_create"] = $app->datetime->getDate();
    $params["time_expiration"] = $count_day ? $app->datetime->addDay($count_day)->getDate() : null;
    $params["count_day"] = $count_day;
    $params["status"] = 1;

    $app->model->users_tariffs_orders->delete("user_id=?", [$params["user_id"]]);
    $app->model->users_tariffs_orders->insert($params);
    $app->model->users->update(["tariff_id"=>$params["tariff_id"]], $params["user_id"]);

    $tariff = $app->component->service_tariffs->getOrderByUserId($params["user_id"]);

    if($tariff->items->shop){
        $shop = $app->component->shop->getShopByUserId($params["user_id"]);
        if($shop){
            $app->model->shops->update(["status"=>"published"], ["user_id=? and status=?", [$params["user_id"], "blocked"]]);
        }
    }

    if($getTariff->onetime){
        $app->model->users_tariffs_onetime->insert(["user_id"=>$params["user_id"], "tariff_id"=>$params["tariff_id"]]);
    }

    $app->event->addServiceTariff($params);        

}

public function getActiveOrder($user_id=0){
    global $app;

    return $app->model->users_tariffs_orders->find("user_id=? and (time_expiration > now() or time_expiration is null)", [$user_id]);
  
}

public function getOrderByUserId($user_id=0){
    global $app;

    $items = [];
    $order = $app->model->users_tariffs_orders->find("user_id=?", [$user_id]);

    if($order){

        $order->data = $app->model->users_tariffs->find("id=?", [$order->tariff_id]);

        if($order->data){

            $order->data->count_day_and_ending_word = $order->data->count_day . ' ' . endingWord($order->data->count_day, translate("tr_48e438a146f96b54bbe9d5046ffc3a2b"), translate("tr_0871eeafdf38726742fa5affa8a5d6eb"), translate("tr_c183655a02377815e6542875555b1340"));

            if(strtotime($order->time_expiration) > time() || $order->time_expiration == null){

                $order->expiration_status = true;
                $order->expiration_date = $order->time_expiration ? translate("tr_5192bdb7a058b0b2f9272d8696050d12") . ' ' . $app->datetime->outDateTime($order->time_expiration) : translate("tr_5459e68fa4cdc4e9c0907f030f976a5a");

                if($order->data->items_id){
                    $items = $app->model->users_tariffs_items->getAll("id IN(".implode(",", _json_decode($order->data->items_id)).")");
                    if($items){
                        foreach ($items as $value) {
                            $order->items[$value["code"]] = true;
                        }
                    }
                }

            }else{
                $order->expiration_status = false;
            }

        }else{
            $order->expiration_status = false;
        }

        return arrayToObject($order);
    }

    return [];

}

public function getStatisticsTariffsByMonthChart(){   
    global $app;

    $series = [];
    $dates = [];
    $data = [];
    $action_amount = [];

    $y = $app->datetime->format("Y")->getDate();
    $m = $app->datetime->format("m")->getDate();            

    $days_in_month = $app->datetime->daysInMonth($m, $y);

    $x=0;
    while ($x++<$days_in_month){
       $dates[$y."-".$m."-".$x] = $y."-".$m."-".$x;
    }

    $getTariffs = $app->model->users_tariffs->getAll();

    foreach ($dates as $date) {

        foreach ($getTariffs as $key => $value) {

            $getCount = $app->model->transactions->count("date(time_create)=? and tariff_id=?", [$date,$value["id"]]);
            $getAmount = $app->db->getSumByTotal("amount", "uni_transactions", "date(time_create)=? and tariff_id=?", [$date,$value["id"]]);

            if($getCount){
                $action_amount[$value["name"]][] = ["date"=>date("d.M.Y", strtotime($date)), "count"=>$getCount, "title"=>$getCount.' '.translate("tr_01340e1c32e59182483cfaae52f5206f").' '.$app->system->amount($getAmount)]; 
            }else{
                $action_amount[$value["name"]][] = ["date"=>date("d.M.Y", strtotime($date)), "count"=>0, "title"=>'0 '.translate("tr_01340e1c32e59182483cfaae52f5206f").' '.$app->system->amount(0)];
            }

        }

    }

    foreach ($action_amount as $action => $nested) {
        $data = [];
        foreach ($nested as $key => $value) {
            $data[] = ["x"=>$value["date"], "y"=>$value["count"], "title"=>$value["title"]];
        }
        $series[] = ["name"=>$action, "data"=>$data];
    }

    return $series;
}

public function getTariffData($tariff_id=0, $count=1){
    global $app;

    $getTariff = $app->model->users_tariffs->find("id=? and status=?", [$tariff_id,1]);
    if($getTariff){

        if($getTariff->count_day_fixed){
            return ["count"=>$getTariff->count_day, "amount"=>$getTariff->price, "name"=>$getTariff->name];
        }else{
            return ["count"=>0, "amount"=>$getTariff->price, "name"=>$getTariff->name];
        }

    }

    return [];

}

public function outItemsOptions($items=[]){
    global $app;

    $getItems = $app->model->users_tariffs_items->getAll();

    if($getItems){
        foreach ($getItems as $key => $value){
            if(compareValues($items, $value["id"])){
                echo '<option value="'.$value["id"].'" selected="" >'.$value["name"].'</option>';
            }else{
                echo '<option value="'.$value["id"].'" >'.$value["name"].'</option>';
            }
        }            
    }

}

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



}