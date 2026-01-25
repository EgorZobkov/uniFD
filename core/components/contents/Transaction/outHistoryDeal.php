public function outHistoryDeal($order_id=null){
    global $app;

    $getHistory = $app->model->transactions_deals_history->sort("id desc")->getAll("order_id=? and (user_id=? or user_id=?)", [$order_id, 0, $app->user->data->id]);

    if($getHistory){
        foreach ($getHistory as $key => $value) {
            ?>

            <div class="timeline-action-item">
              <div class="timeline-action-item-point"></div>
              <div class="timeline-action-item-event">
                
                <div class="timeline-action-item-header">
                  <h6 class="mb-0"><?php echo $this->getHistoryCode($value["action_code"])->name; ?></h6>
                  <small class="text-muted"><?php echo $app->datetime->outDateTime($value["time_create"]); ?></small>
                </div>

                <?php if($value["comment"]){ ?>
                <p class="mb-0 mt-1"><?php echo $value["comment"]; ?></p>
                <?php }

                if($value["media"]){
                    ?>
                    <div class="timeline-action-media uniMediaSliderContainer" >
                    <?php
                    foreach (_json_decode($value["media"]) as $key => $media_item) {
                        ?>
                        <a class="timeline-action-media-item uniMediaSliderItem" href="<?php echo $app->storage->name($media_item)->host(true)->get(); ?>" data-media-key="<?php echo $key; ?>" data-media-type="image" ><img src="<?php echo $app->storage->name($media_item)->host(true)->get(); ?>" class="image-autofocus" /></a>
                        <?php
                    }
                    ?>
                    </div>
                    <?php
                }

                ?>
              </div>
            </div>

            <?php
        }
    }

}