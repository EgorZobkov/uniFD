<div class="col-12" >
  <a class="container-item-list <?php if($value->service_highlight_status){ echo 'container-item-list-highlight'; } ?>" href="<?php echo $app->component->ads->buildAliasesAdCard($value); ?>" <?php if($app->settings->board_catalog_ad_option_opening == "blank"){ echo 'target="_blank"'; } ?> >

    <div class="row" >

      <div class="col-md-5 col-lg-3 col-sm-5 col-12" >
        
        <div class="container-item-images" <?php echo $app->component->ads->setStyleHeightItemImage(); ?> >

          <?php echo $app->component->ads->outItemCardFavorite($value, $app->user->data->id) ?>

          <?php echo $app->component->ads->outMediaGalleryInCatalog($value); ?>

          <?php echo $app->component->ads->outLabelsInCatalog($value); ?>

        </div>

      </div>

      <div class="col-md-7 col-lg-7 col-sm-7 col-12" >

        <div class="container-item-list-content" >
           <div class="container-item-list-content-title" ><?php echo trimStr($value->title, 100, true); ?></div>
           <?php if($value->total_rating){ ?>
           <div class="container-item-list-content-rating" ><?php echo $app->component->reviews->outInfoRatingByColor($value); ?></div>
           <?php } ?>
           <div class="container-item-list-content-prices" ><?php echo $app->component->ads->outPrices($value); ?></div>
           <div class="container-item-list-content-desc" ><?php echo trimStr($value->text, 200, true); ?></div>
           <?php if($app->component->ads_categories->categories[$value->category_id]["filter_template_preset"]){ ?>
           <div class="container-item-list-content-properties" >
           <?php
            echo $app->component->ads_filters->buildPresetFilters($value->id, $value->category_id);
           ?>
           </div>    
           <?php } ?>       
           <div class="container-item-list-content-additionally" >
             <span><?php echo $app->component->ads->outLocationByCatalog($value); ?></span>
             <span><?php echo $app->datetime->outLastTime($value->time_create); ?></span>
           </div>
           <div class="container-item-list-content-user d-block d-lg-none" >
            <?php echo $app->component->profile->outFaceCard($value); ?>
           </div>
        </div>
        
      </div>

      <div class="d-none d-lg-block col-lg-2 col-sm-12 col-md-12 col-12" >

        <div class="container-item-list-content-user" >
          <?php echo $app->component->profile->outFaceCard($value); ?>
        </div>
        
      </div>

    </div>

  </a>
</div>