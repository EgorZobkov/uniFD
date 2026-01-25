<div class="col-12 col-lg-3" >
  <div class="profile-container-order-list" >

    <div>
      <span class="status-label status-label-color-<?php echo $app->component->transaction->getStatusDeal($value->status_processing)->label; ?>"><?php echo $app->component->transaction->getStatusDeal($value->status_processing)->name; ?></span>
    </div>
    <a class="profile-container-order-list-title" href="<?php echo outRoute("order-card", [$value->order_id]); ?>"><?php echo translate("tr_4d406f4dcd44a95252f06163a3cdcb5e"); ?> <?php echo $app->datetime->outDate($value->time_create); ?> <?php echo translate("tr_01340e1c32e59182483cfaae52f5206f"); ?> <?php echo $app->system->amount($value->amount); ?></a>
    <small>№<?php echo $value->order_id; ?></small>

    <div class="profile-container-order-items" >
        <div class="profile-container-order-item-image" >
          <img src="<?php echo $value->item->media->images->first; ?>" title="<?php echo $value->item->title; ?>" class="image-autofocus" >
        </div>
    </div>

  </div>
</div>