<div class="col-md-6 col-6 col-sm-6 col-lg-3" >
  <a class="container-item-grid" href="<?php echo $app->component->ads->buildAliasesAdCard($value); ?>" <?php if($app->settings->board_catalog_ad_option_opening == "blank"){ echo 'target="_blank"'; } ?> >
    <div class="container-item-images" <?php echo $app->component->ads->setStyleHeightItemImage(); ?> >

      <?php echo $app->component->ads->outItemCardFavorite($value, $app->user->data->id) ?>

      <?php echo $app->component->ads->outMediaGalleryInCatalog($value); ?>

    </div>
    <div class="container-item-grid-content" >
       <div class="container-item-grid-content-prices" ><?php echo $app->component->ads->outPrices($value); ?></div>
       <?php if($app->user->data->id == $value->user_id){ ?>
       <div class="container-item-grid-content-status" ><?php echo $app->component->ads->outStatusByAd($value->status); ?></div>
       <?php } ?>
       <div class="container-item-grid-content-title" ><?php echo trimStr($value->title, 40, true); ?></div>
    </div>
  </a>
</div>