public function getMenu(){
    global $app;

    $result = [];

    $menu = $app->model->profile_menu->cacheKey(["parent_id"=>0])->sort("sorting asc")->getAll("parent_id=?", [0]);
    foreach ($menu as $key => $value) {
        if($value["submenu"]){
            $result[$value["id"]] = $value;
            $result[$value["id"]]["submenu"] = $app->model->profile_menu->cacheKey(["parent_id"=>$value["id"]])->sort("sorting asc")->getAll("parent_id=?", [$value["id"]]);
        }else{
            $result[$value["id"]] = $value;
        }
    }

    foreach ($result as $key => $value) {
        if($value["submenu"]){

            ?>
            <div class="dropdown-box-list-nested-toggle">
                <a href="#"><?php echo $value["icon"]; ?> <?php echo translateField($value["name"]); ?> <i class="ti ti-chevron-down"></i></a>
                <div class="dropdown-box-list-nested" >
                <?php
                    foreach ($value["submenu"] as $subkey => $subvalue) {
                        if($subvalue["route_alias"] == "profile-shop"){
                            if($app->settings->shops_status){
                            ?>
                            <a href="<?php echo outRoute($subvalue["route_alias"]); ?>"><svg width="26" height="26"></svg> <?php echo translateField($subvalue["name"]); ?></a>
                            <?php
                            }
                        }else{
                            ?>
                            <a href="<?php echo outRoute($subvalue["route_alias"]); ?>"><svg width="26" height="26"></svg> <?php echo translateField($subvalue["name"]); ?></a>
                            <?php                                
                        }
                    }
                ?>
                </div>
            </div>
            <?php

        }else{
            if($value["route_alias"] == "profile-wallet"){
                if($app->settings->profile_wallet_status){
                    ?>
                    <a href="<?php echo outRoute($value["route_alias"]); ?>"><?php echo $value["icon"]; ?> <?php echo translateField($value["name"]); ?> <strong><?php echo $app->user->data->balance_by_currency; ?></strong></a>
                    <?php
                }
            }elseif($value["route_alias"] == "profile-referral"){
                if($app->settings->referral_program_status && $app->settings->profile_wallet_status){
                    ?>
                    <a href="<?php echo outRoute($value["route_alias"]); ?>"><?php echo $value["icon"]; ?> <?php echo translateField($value["name"]); ?></a>
                    <?php
                }
            }else{
                ?>
                <a href="<?php echo outRoute($value["route_alias"]); ?>"><?php echo $value["icon"]; ?> <?php echo translateField($value["name"]); ?></a>
                <?php                    
            }
        }
    }

}