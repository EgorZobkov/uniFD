<div class="col-12" >
  <a class="profile-container-item-list" href="<?php echo $app->component->ads->buildAliasesAdCard($value); ?>" <?php if($app->settings->board_catalog_ad_option_opening == "blank"){ echo 'target="_blank"'; } ?> >

    <div class="row" >

      <div class="col-lg-2 col-3" >
        
        <div class="profile-container-item-images" >

          <img src="<?php echo $value->media->images->first; ?>" class="image-autofocus" >

        </div>

      </div>

      <div class="col-lg-8 col-7" >

        <div class="profile-container-item-list-content" >
           <div class="profile-container-item-list-content-status" ><?php echo $app->component->ads->outStatusByAd($value->status); ?></div>
           <div class="profile-container-item-list-content-title" >
                <?php echo $value->title; ?>
           </div>
           <div class="profile-container-item-list-content-info" >
                <span><?php echo translate("tr_c1edf1d122e386bd5bc4d996d31b8248"); ?> <strong><?php echo $app->datetime->outStringDiff(null,$value->time_expiration); ?></strong> </span>
           </div>
        </div>
        
      </div>

      <div class="col-lg-2 col-2 text-end" >

        <div class="profile-button-item-delete actionProfileDeleteRenewal" data-id="<?php echo $value->id; ?>" ><i class="ti ti-trash"></i></div>
        
      </div>

    </div>

  </a>
</div>