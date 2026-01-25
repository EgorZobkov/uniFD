<div class="col-12" >
  <div class="profile-container-order-list" >

    <div>
      <span class="status-label status-label-color-<?php echo $app->component->transaction->getStatusDeal($value->status_processing)->label; ?>"><?php echo $app->component->transaction->getStatusDeal($value->status_processing)->name; ?></span>
    </div>
    <div class="profile-container-order-list-title" ><?php echo translate("tr_4d406f4dcd44a95252f06163a3cdcb5e"); ?> <?php echo $app->datetime->outDate($value->time_create); ?> <?php echo translate("tr_01340e1c32e59182483cfaae52f5206f"); ?> <?php echo $app->system->amount($value->amount); ?></div>
    <small>№<?php echo $value->order_id; ?></small>

    <div class="profile-container-order-items" >
        <div class="profile-container-order-item-image" >
          <img src="<?php echo $value->item->media->images->first; ?>" title="<?php echo $value->item->title; ?>" class="image-autofocus" >
        </div>
    </div>

    <div class="profile-container-order-item-buttons" >
       <a class="btn-custom-mini button-color-scheme1" href="<?php echo outRoute("order-card", [$value->order_id]); ?>"><?php echo translate("tr_224748b03c741989f3e5de7e13c20a1c"); ?></a>
        <?php
         if(($value->status_processing == "completed_order" || $value->status_processing == "cancel_order")){

            if($value->from_user_id == $app->user->data->id){
              ?>
              <a class="btn-custom-mini button-color-scheme2" href="<?php echo outRoute("review-add", [$value->whom_user_id]); ?>?order_id=<?php echo $value->order_id; ?>"><?php echo translate("tr_2af71ff00b69145ccccd98a4a02e81b8"); ?></a>
              <?php
            }else{
              ?>
              <a class="btn-custom-mini button-color-scheme2" href="<?php echo outRoute("review-add", [$value->from_user_id]); ?>?order_id=<?php echo $value->order_id; ?>"><?php echo translate("tr_2af71ff00b69145ccccd98a4a02e81b8"); ?></a>
              <?php
            }

         }
        ?>
    </div>

  </div>
</div>