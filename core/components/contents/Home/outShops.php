public function outShops(){
    global $app;

    if(!$app->settings->shops_status){
        return;
    }

    $getShops = $app->model->shops->sort("id desc limit 6")->getAll("status=?", ["published"]);
    if($getShops){

        ?>

        <div class="bold-title-and-link" >
            <span><?php echo translate("tr_cfb8af01cc910b08e8796e03cf662f5f"); ?></span>
            <a class="btn-custom-mini button-color-scheme1" href="<?php echo outRoute('shops'); ?>"><?php echo translate("tr_9bda15acad8029f349e418646e5d0e2f"); ?></a>
        </div>

        <div class="row row-cols-2 g-2 g-lg-3" >
        <?php

        foreach ($getShops as $key => $value) {

            $user = $app->model->users->find("id=?", [$value["user_id"]]);

            echo $app->view->setParamsComponent(['value'=>$value, 'user'=>$user])->includeComponent('items/home-shop-grid.tpl');

        }

        ?>
        </div>
        <?php

    }

}