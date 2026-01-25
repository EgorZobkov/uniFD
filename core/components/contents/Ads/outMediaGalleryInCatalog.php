public function outMediaGalleryInCatalog($value=[]){
    global $app;

    if($value->media->images->all){
      foreach (array_slice($value->media->images->all, 0,10) as $key => $link) {
        ?>
        <img src="<?php echo $link; ?>" data-key="<?php echo $key; ?>" alt="<?php echo $value->title; ?>" class="image-autofocus" loading="lazy" >
        <?php
      }

      if(count($value->media->images->all) > 1){
        ?>
          <div class="container-item-images-indicator" >
              <?php
              foreach (array_slice($value->media->images->all, 0,10) as $key => $link) {
                ?>
                <span data-key="<?php echo $key; ?>" style="height: <?php echo $app->settings->board_catalog_height_item-2; ?>px" ></span>
                <?php
              }
              ?>
          </div>
        <?php
      }

    }else{
        ?>
        <img src="<?php echo $app->storage->noImage(); ?>" alt="<?php echo $value->title; ?>" class="image-autofocus" loading="lazy" >
        <?php
    }
    
}