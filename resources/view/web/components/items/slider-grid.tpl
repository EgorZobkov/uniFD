<div class="widget-ads-slider-container-item" >
  <a class="container-item-grid <?php if($value->service_highlight_status){ echo 'container-item-grid-highlight'; } ?>" href="<?php echo $app->component->ads->buildAliasesAdCard($value); ?>" <?php if($app->settings->board_catalog_ad_option_opening == "blank"){ echo 'target="_blank"'; } ?> >
    <div class="container-item-images" <?php echo $app->component->ads->setStyleHeightItemImage(); ?> >

      <?php echo $app->component->ads->outItemCardFavorite($value, $app->user->data->id) ?>

      <?php echo $app->component->ads->outMediaGalleryInCatalog($value); ?>

      <?php echo $app->component->ads->outLabelsInCatalog($value); ?>

    </div>
    <div class="container-item-grid-content" >
       <div class="container-item-grid-content-prices" ><?php echo $app->component->ads->outPrices($value); ?></div>
       <div class="container-item-grid-content-title" ><?php echo trimStr($value->title, 40, true); ?></div>
       <div class="container-item-grid-content-additionally" >
         <span><?php echo $app->component->ads->outLocationByCatalog($value); ?></span>
         <span><?php echo $app->datetime->outLastTime($value->time_create); ?></span>

         <div class="container-item-grid-content-user" >
            <?php echo $app->component->profile->outFaceCard($value); ?>
         </div>
         
       </div>
    </div>
  </a>
</div>