public function outAdsVip(){
    global $app;

    $data = $app->model->ads_data->sort("id desc limit 100")->getAll("status=? and service_urgently_status=?", [1,1]);

    if($data){

    shuffle($data);

    ?>

    <div class="bold-title-and-link" >
        <span><?php echo translate("tr_954a3184125c3e5917239f101fb9ff48"); ?></span>
        <a class="btn-custom-mini button-color-scheme1" href="<?php echo $app->component->geo->getChange() ? $app->component->geo->getChange()->alias : outLink('all'); ?>?filter[switch][urgently]=1"><?php echo translate("tr_1cc7e7972b8c9daa5e9c8e94483acc7d"); ?></a>
    </div>

    <div class="widget-ads-slider-container-items-vip" >
        
        <div class="row row-cols-2 row-cols-lg-5 g-2 g-lg-3" >
        <?php
        foreach (array_slice($data, 0, 10) as $item) {

            $item = $app->component->ads->getDataByValue($item);

            echo $app->view->setParamsComponent(['value'=>$item])->includeComponent('items/home-grid.tpl');

        }
        ?>
        </div>

    </div>

    <?php
    }

}