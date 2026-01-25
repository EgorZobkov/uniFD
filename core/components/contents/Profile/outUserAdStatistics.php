public function outUserAdStatistics($item_id=0, $user_id=0){   
    global $app;

    $content = '';

    $ad = $app->model->ads_data->find("id=? and user_id=?", [$item_id, $user_id]);
    $actions = $app->model->users_actions->pagination(true)->page($_GET['page'])->output(20)->sort("id desc")->filter(["date_start"=>$_GET['date_start'], "date_end"=>$_GET['date_end']])->getAll("item_id=? and whom_user_id=?", [$item_id,$user_id]);

    if($ad){

        ?>

        <p><?php echo translate("tr_cbb8b49fe24232cbd0bd1ab287dd34fa"); ?> <strong><?php echo $ad->title; ?></strong> </p>

        <?php echo $this->outUserAdStatisticsByMonth($item_id, $_GET["month"],$_GET["year"]); ?>

        <div class="profile-statistics-chart" id="profile-statistics-chart" ></div>  

        <h3 class="mt15 mb30" > <strong><?php echo translate("tr_fb3df31bf52df6c142a279ecdb6dd94c"); ?></strong> </h3>

        <?php
        
        if($_GET['date_start'] && $_GET['date_end']){
            ?>
            <div class="btn-custom-mini button-color-scheme2 mb20 openModal" data-modal-id="profileStatisticsChangeDateModal" ><?php echo translate("tr_28b76906f14ac4b4d584dfb15226b05a") . ': ' . $app->datetime->outDate($_GET['date_start']) . '-' . $app->datetime->outDate($_GET['date_end']); ?></div>
            <?php
        }elseif($_GET['date_start']){
            ?>
            <div class="btn-custom-mini button-color-scheme2 mb20 openModal" data-modal-id="profileStatisticsChangeDateModal" ><?php echo translate("tr_28b76906f14ac4b4d584dfb15226b05a") . ': ' . $app->datetime->outDate($_GET['date_start']); ?></div>
            <?php
        }else{
            ?>
            <div class="btn-custom-mini button-color-scheme2 mb20 openModal" data-modal-id="profileStatisticsChangeDateModal" ><?php echo translate("tr_28b76906f14ac4b4d584dfb15226b05a"); ?></div>
            <?php
        }

        if($actions){

        foreach ($actions as $key => $value) {

            $user = $app->model->users->cacheKey(["id"=>$value["from_user_id"]])->find('id=?', [$value["from_user_id"]]);

            $content .= $app->view->setParamsComponent(['value'=>(object)$value, 'user'=>$user])->includeComponent('items/profile-statistics-actions-list.tpl');

        }

        echo $content;

        echo $app->pagination->display();

        }

    }else{
        ?>
        <p><?php echo translate("tr_29735b4fc08617ddb7b1766a9cc8001b"); ?></p>
        <?php
    }
    
}