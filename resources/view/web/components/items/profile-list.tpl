<div class="col-12" >
  <a class="profile-container-item-list" href="<?php echo $app->component->ads->buildAliasesAdCard($value); ?>" <?php if($app->settings->board_catalog_ad_option_opening == "blank"){ echo 'target="_blank"'; } ?> >

    <div class="row" >

      <div class="col-md-3 col-sm-3 col-lg-3 col-5" >
        
        <div class="profile-container-item-images" >

          <img src="<?php echo $value->media->images->first; ?>" class="image-autofocus" >

        </div>

      </div>

      <div class="col-md-9 col-sm-9 col-lg-9 col-7" >

        <div class="profile-container-item-list-content" >
          <div class="profile-container-item-list-content-status" ><?php echo $app->component->ads->outStatusByAd($value->status); ?></div>
           <div class="profile-container-item-list-content-title" ><?php echo $value->title; ?></div>
           <div class="profile-container-item-list-content-prices" ><?php echo $app->component->ads->outPrices($value); ?></div>
           <div class="profile-container-item-list-content-additionally" >
             <span><?php echo $app->component->ads->outLocationByCatalog($value); ?></span>
             <span><?php echo $app->datetime->outLastTime($value->time_create); ?></span>
           </div>
        </div>
        
      </div>

    </div>

  </a>
</div>