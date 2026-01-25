<div class="col-12" >
  <a class="container-item-list-map <?php if($value->service_highlight_status){ echo 'container-item-list-highlight'; } ?>" href="<?php echo $app->component->ads->buildAliasesAdCard($value); ?>" target="_blank" >

    <div class="row" >

      <div class="col-md-5 col-sm-5 col-lg-5 col-12" >
        
        <div class="container-item-list-map-images" >

          <?php echo $app->component->ads->outItemCardFavorite($value, $app->user->data->id) ?>

          <img src="<?php echo $value->media->images->first; ?>" class="image-autofocus" alt="<?php echo $value->title; ?>" title="<?php echo $value->title; ?>" >

          <?php echo $app->component->ads->outLabelsInCatalog($value); ?>

        </div>

      </div>

      <div class="col-md-7 col-sm-7 col-lg-7 col-12" >

        <div class="container-item-list-map-content" >
           <div class="container-item-list-map-content-title" ><?php echo trimStr($value->title, 100, true); ?></div>
           <?php if($value->total_rating){ ?>
           <div class="container-item-list-map-content-rating" ><?php echo $app->component->reviews->outInfoRatingByColor($value); ?></div>
           <?php } ?>
           <div class="container-item-list-map-content-prices" ><?php echo $app->component->ads->outPrices($value); ?></div>      
           <div class="container-item-list-map-content-additionally" >
             <span><?php echo $app->component->ads->outLocationByCatalog($value); ?></span>
             <span><?php echo $app->datetime->outLastTime($value->time_create); ?></span>
           </div>
           <div class="container-item-list-map-content-user" >
            <?php echo $app->component->profile->outFaceCard($value); ?>
           </div>
        </div>
        
      </div>

    </div>

  </a>
</div>