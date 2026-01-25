<?php

/**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Components;

class AdPaidServices
{

 public $alias = "ad_paid_services";

 public function activation($alias=null, $ad_id=0, $count_day=0){
    global $app;

    if($alias == "urgently"){

        $app->model->ads_data->update(["service_urgently_status"=>1], $ad_id);

    }elseif($alias == "highlight"){

        $app->model->ads_data->update(["service_highlight_status"=>1], $ad_id);

    }elseif($alias == "stories"){

        $app->component->stories->addWaitingMakeCollage($ad_id, $count_day, $app->user->data->id);

    }elseif($alias == "top"){

        $app->model->ads_data->update(["service_top_status"=>1, "time_sorting"=>$app->datetime->getDate()], $ad_id);

    }elseif($alias == "package"){

        $app->model->ads_data->update(["service_urgently_status"=>1, "service_highlight_status"=>1, "service_top_status"=>1, "time_sorting"=>$app->datetime->getDate()], $ad_id);
        $app->component->stories->addWaitingMakeCollage($ad_id, $count_day, $app->user->data->id);

    }
  
}

public function createOrder($params=[]){
    global $app;

    $getService = $app->model->ads_services->find("id=?", [$params["service_id"]]);

    if($getService->count_day_fixed){
        $count_day = $getService->count_day;
    }else{
        $count_day = $params["count_day"];
    }

    $params["time_create"] = $app->datetime->getDate();
    $params["time_expiration"] = $app->datetime->addDay($count_day)->getDate();

    $app->model->ads_services_orders->insert($params);

    $this->activation($getService->alias, $params["ad_id"], $count_day);

    $app->event->addPaidService($params);        

}

public function deactivation($service_id=0, $ad_id=0){
    global $app;

    $getService = $app->model->ads_services->find("id=?", [$service_id]);

    if($getService->alias == "urgently"){

        $app->model->ads_data->update(["service_urgently_status"=>0], $ad_id);

    }elseif($getService->alias == "highlight"){

        $app->model->ads_data->update(["service_highlight_status"=>0], $ad_id);

    }elseif($getService->alias == "top"){

        $ad = $app->model->ads_data->find("id=?", [$ad_id]);

        $app->model->ads_data->update(["service_top_status"=>1, "time_sorting"=>$ad->time_create], $ad_id);

    }elseif($getService->alias == "package"){

        $ad = $app->model->ads_data->find("id=?", [$ad_id]);

        $app->model->ads_data->update(["service_urgently_status"=>0, "service_highlight_status"=>0, "service_top_status"=>0, "time_sorting"=>$ad->time_create], $ad_id);

    }
  
}

public function getActiveOrder($ad_id=0, $service_id=0){
    global $app;

    return $app->model->ads_services_orders->find("ad_id=? and service_id=? and time_expiration > now()", [$ad_id, $service_id]);
  
}

public function getActiveServicesByAd($ad_id=0){
    global $app;

    $result = [];
    $ids = [];
    $aliases = [];
    $result_by_alias = [];

    $getOrders = $app->model->ads_services_orders->getAll("ad_id=? and time_expiration > now()", [$ad_id]);

    if($getOrders){
        foreach ($getOrders as $key => $value) {

            $getService = $app->model->ads_services->getRow("id=?", [$value["service_id"]]);

            $ids[] = $value["service_id"];
            $aliases[] = $getService["alias"];

            $result[] = arrayToObject(["order"=>$value, "service"=>$getService]);
            $result_by_alias[$getService["alias"]] = arrayToObject(["order"=>$value, "service"=>$getService]);

        }
    }

    return (object)["ids"=>$ids,"aliases"=>$aliases, "data"=>$result, "data_by_alias"=>$result_by_alias];       

}

public function getServiceData($service_id=0, $count=1){
    global $app;

    $getService = $app->model->ads_services->find("id=? and status=?", [$service_id,1]);
    if($getService){

        if($getService->count_day_fixed){
            return ["count"=>$getService->count_day, "amount"=>$getService->price, "name"=>translateFieldReplace($getService, "name")];
        }else{
            return ["count"=>abs(intval($count)), "amount"=>$getService->price * abs(intval($count)), "name"=>translateFieldReplace($getService, "name")];
        }

    }

    return [];

}

public function getStatisticsServicesByMonthChart(){   
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

    $getServices = $app->model->ads_services->getAll();

    foreach ($dates as $date) {

        foreach ($getServices as $key => $value) {

            $getCount = $app->model->transactions->count("date(time_create)=? and service_id=?", [$date,$value["id"]]);
            $getAmount = $app->db->getSumByTotal("amount", "uni_transactions", "date(time_create)=? and service_id=?", [$date,$value["id"]]);

            if($getCount){
                $action_amount[$value["name"]][] = ["date"=>date("d.M.Y", strtotime($date)), "count"=>$getCount, "title"=>$getCount." ".translate("tr_01340e1c32e59182483cfaae52f5206f")." ".$app->system->amount($getAmount)]; 
            }else{
                $action_amount[$value["name"]][] = ["date"=>date("d.M.Y", strtotime($date)), "count"=>0, "title"=>translate("tr_3fe59f7174fefbd8d28d1b96c44fc46d").' '.$app->system->amount(0)];
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

public function outItemsWaitingList($item_id=0, $user_id=0, $output=50){
    global $app;

    $items = '';
    $ids = [];

    $getOrders = $app->model->ads_services_orders->getAll("user_id=? and time_expiration > now()", [$user_id]);

    if($getOrders){
        foreach ($getOrders as $key => $value) {
            $getService = $app->model->ads_services->find("id=?", [$value["service_id"]]);
            if($getService->alias == "package"){
                $ids[] = $value["ad_id"];
            }
        }
    }

    if($ids){
        $getItems = $app->model->ads_data->getAll("id NOT IN(".implode(",", $ids).") and user_id=? and status=? order by id desc limit ?", [$user_id,1,intval($output)]);
    }else{
        $getItems = $app->model->ads_data->getAll("user_id=? and status=? order by id desc limit ?", [$user_id,1,intval($output)]);
    }

    if($getItems){

        foreach ($getItems as $key => $value) {
            $active = '';

            $array_images = $app->component->ads->getMedia($value["media"]);

            if($item_id == $value["id"]){
                $active = 'active';
            }

            $items .= '
                <a class="ad-paid-services-ads-item '.$active.'" href="'.outRoute("ad-services", [$value["id"]]).'" >
                
                 <div class="ad-paid-services-ads-item-image" > <img src="'.$array_images->images->first.'" class="image-autofocus" > </div>
                 <div class="ad-paid-services-ads-item-title" > '.$value["title"].' </div>

                </a>
            ';
        }

        return '
        <div class="ad-paid-services-ads-container" >
        <p>'.count($getItems).' '.endingWord(count($getItems), translate("tr_9fb3c8f80c97b33ef42bbc8c05b1318e"),translate("tr_bb66218008cb14902539f6d6d25cf4f2"),translate("tr_3a56c05cec9c49dbbf159eea4b5fe61e")).'</p>
        <input class="form-control" placeholder="'.translate("tr_c4e13f3e179240627dcb0ef7c41ca3d4").'" />
        <div class="ad-paid-services-ads-list" >'.$items.'</div>
        </div>';

    }

}

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

public function searchItemsWaitingList($query=null, $user_id=0){
    global $app;

    $items = '';
    $ids = [];

    $getOrders = $app->model->ads_services_orders->getAll("user_id=? and time_expiration > now()", [$user_id]);

    if($getOrders){
        foreach ($getOrders as $key => $value) {
            $getService = $app->model->ads_services->find("id=?", [$value["service_id"]]);
            if($getService->alias == "package"){
                $ids[] = $value["ad_id"];
            }
        }
    }

    if($ids){
        $getItems = $app->model->ads_data->sort("id desc limit 50")->search($query)->getAll("id NOT IN(".implode(",", $ids).") and user_id=? and status=?", [$user_id,1]);
    }else{
        $getItems = $app->model->ads_data->sort("id desc limit 50")->search($query)->getAll("user_id=? and status=?", [$user_id,1]);
    }

    if($getItems){

        foreach ($getItems as $key => $value) {

            $array_images = $app->component->ads->getMedia($value["media"]);

            $items .= '
                <a class="ad-paid-services-ads-item" href="'.outRoute("ad-services", [$value["id"]]).'" >
                
                 <div class="ad-paid-services-ads-item-image" > <img src="'.$array_images->images->first.'" class="image-autofocus" > </div>
                 <div class="ad-paid-services-ads-item-title" > '.$value["title"].' </div>

                </a>
            ';
        }

    }

    if($items){
        return $items;
    }else{
        return '<div>'.translate("tr_8767f9ec282489d3e8e29021d0967187").'</div>';
    }

}



}