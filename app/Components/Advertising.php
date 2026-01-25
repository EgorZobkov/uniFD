<?php

/**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Components;

class Advertising
{

 public $alias = "advertising";
 public $data = [];

 public function checkGeo($data=[]){
    global $app;

    $geo = $app->session->get("geo");

    if($geo){

        if($data["city"]){
            foreach ($data["city"] as $key => $value) {
                if($geo->city_id == $value){
                    return true;
                }
            }
        }
        if($data["region"]){
            foreach ($data["region"] as $key => $value) {
                if($geo->region_id == $value){
                    return true;
                }                
            }
        }
        if($data["country"]){
            foreach ($data["country"] as $key => $value) {
                if($geo->country_id == $value){
                    return true;
                }                
            }
        }

    }

    return false;

}

public function countClick($id=0){
    global $app;

    return $app->model->advertising_transitions->count("advertising_id=?", [$id]);
    
}

public function delete($id=0){
    global $app;

    $app->model->advertising->delete("id=?", [$id]);
    $app->model->advertising_transitions->delete("advertising_id=?", [$id]);

}

public function fixClick($code=0, $user_id=0){
    global $app;

    $data = $app->model->advertising->find("uniq_code=? and status=?", [$code, 1]);

    if(!$data){
        return;
    }

    if($user_id){

        $check = $app->model->advertising_transitions->find("advertising_id=? and user_id=? and date(time_create)=?", [$data->id, $user_id, $app->datetime->format("Y-m-d")->getDate()]);
        
        if(!$check){
            $app->model->advertising_transitions->insert(["advertising_id"=>$data->id, "user_id"=>$user_id, "ip"=>getIp(), "time_create"=>$app->datetime->getDate()]);
        }

    }elseif(getIp()){

        if(isBot(getUserAgent())){
            return;
        }

        $check = $app->model->advertising_transitions->find("ip=? and advertising_id=? and date(time_create)=?", [getIp(), $data->id, $app->datetime->format("Y-m-d")->getDate()]);

        if(!$check){
            $app->model->advertising_transitions->insert(["advertising_id"=>$data->id, "user_id"=>0, "ip"=>getIp(), "time_create"=>$app->datetime->getDate()]);
        }

    }
    
}

public function getGeoList($data=[]){
    global $app;

    $list = [];

    if($data["city"]){
        $get = $app->model->geo_cities->getAll("id IN(".implode(",", $data["city"]).")");
        foreach ($get as $key => $value) {
            $list[] = $value["name"];
        }
    }
    if($data["region"]){
        $get = $app->model->geo_regions->getAll("id IN(".implode(",", $data["region"]).")");
        foreach ($get as $key => $value) {
            $list[] = $value["name"];
        }
    }
    if($data["country"]){
        $get = $app->model->geo_countries->getAll("id IN(".implode(",", $data["country"]).")");
        foreach ($get as $key => $value) {
            $list[] = $value["name"];
        }
    }

    return implode(",", $list);

}

public function getStatisticsTransitionsByMonthChart(){   
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

    $getAdvertising = $app->model->advertising->getAll();

    foreach ($dates as $date) {

        foreach ($getAdvertising as $key => $value) {

            $getCount = $app->model->advertising_transitions->count("date(time_create)=? and advertising_id=?", [$date,$value["id"]]);

            if($getCount){
                $action_amount[translateField($value["name"])][] = ["date"=>date("d.M.Y", strtotime($date)), "count"=>$getCount, "title"=>$getCount.' '.endingWord($getCount, translate("tr_20b4dec10798ad185565ff7941c651da"),translate("tr_3fa7d89fb89054493d81a6d175ec141e"),translate("tr_9ac96ada273b88026b753b7d2403b601"))]; 
            }else{
                $action_amount[translateField($value["name"])][] = ["date"=>date("d.M.Y", strtotime($date)), "count"=>0, "title"=>'0 '.translate("tr_9ac96ada273b88026b753b7d2403b601")];
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

public function outByCode($code=null){
    global $app;

    $category_id = $app->component->catalog->data->category->id ?: 0;

    $data = $app->model->advertising->getAll("uniq_code=? and status=? and (time_start is null or date(now())>=date(time_start)) and (time_end is null or date(time_end)>=date(now())) and (category_id=? or category_id=0)", [$code,1,$category_id]);

    if($data){

        ?>
        <div class="advertising-banner-container advertising-banner-swiper" >
        <div class="swiper-wrapper" >            
        <?php

        foreach ($data as $key => $value) {

            if($value["geo"]){

                if(!$this->checkGeo(_json_decode($value["geo"]))){
                    break;
                }

            }

            if($value["lang_iso"]){

                if($app->translate->getChangeLang() != $value["lang_iso"]){
                    break;
                }

            }

            if($value["type"] == "banner"){
                ?>
                <a class="advertising-banner-item actionAdvertisingClick swiper-slide" data-code="<?php echo $code; ?>" href="<?php echo $value["link"]; ?>" target="_blank" >
                    <img src="<?php echo $app->storage->name($value["image"])->get(); ?>">
                </a>
                <?php
            }else{
                ?>
                <div class="advertising-script-item actionAdvertisingClick swiper-slide" data-code="<?php echo $code; ?>" >
                    <?php echo urldecode($value["code"]); ?>
                </div>
                <?php
            }

        }

        ?>
        </div>
        <div class="advertising-banner-swiper-pagination" ></div>
        </div>
        <?php

    }

}

public function outInResults($index=0, $options=[]){
    global $app;

    $results = '';

    $category_id = $app->component->catalog->data->category->id ?: 0;

    $data = $app->model->advertising->getAll("position=? and status=? and result_index=? and (time_start is null or date(now())>=date(time_start)) and (time_end is null or date(time_end)>=date(now())) and (category_id=? or category_id=0)", ["results",1,$index,$category_id]);
    
    if($app->router->currentRoute->name == "home-load-items"){
        $result_view = "grid";
    }else{
        $result_view = $app->component->catalog->getViewItems($app->component->catalog->data->category->id);
    }

    if($data){

        shuffle($data);

        foreach ($data as $key => $value) {

            if($value["geo"]){

                if(!$this->checkGeo(_json_decode($value["geo"]))){
                    break;
                }

            }

            if($value["lang_iso"]){

                if($app->translate->getChangeLang() != $value["lang_iso"]){
                    break;
                }

            }

            if($value["type"] == "banner"){

                if($value["result_view"] == "list" && $result_view == "list"){
                    $results .= '
                    <div class="advertising-banner-container" >
                        <a class="advertising-banner-item actionAdvertisingClick" data-code="'.$value["uniq_code"].'" href="'.$value["link"].'" target="_blank" >
                            <img src="'.$app->storage->name($value["image"])->get().'">
                        </a>
                    </div>
                    ';
                }elseif($value["result_view"] == "grid" && $result_view == "grid"){
                    $results .= '
                    <div class="'.$options["col-grid"].'" >
                        <div class="advertising-banner-grid-container" >
                            <a class="advertising-banner-grid-item actionAdvertisingClick" data-code="'.$value["uniq_code"].'" href="'.$value["link"].'" target="_blank" >
                                <img src="'.$app->storage->name($value["image"])->get().'">
                            </a>
                        </div>
                    </div>
                    ';                        
                }

            }else{

                if($value["result_view"] == "list" && $result_view == "list"){
                    $results .= '
                    <div class="advertising-script-container" >
                        <div class="advertising-script-item actionAdvertisingClick" data-code="'.$value["uniq_code"].'" >
                            '.urldecode($value["code"]).'
                        </div>
                    </div>
                    ';
                }elseif($value["result_view"] == "grid" && $result_view == "grid"){
                    $results .= '
                    <div class="'.$options["col-grid"].'" >
                        <div class="advertising-script-grid-container" >
                            <div class="advertising-script-grid-item actionAdvertisingClick" data-code="'.$value["uniq_code"].'" >
                                '.urldecode($value["code"]).'
                            </div>
                        </div>
                    </div>
                    ';                        
                }

            }
        }

    }

    return $results;

}



}