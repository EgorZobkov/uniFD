public function outUserAdsAndSearchInStatistics($user_id=0){   
    global $app;

    $items = $app->model->ads_data->sort("id desc limit 3")->getAll("user_id=? and status IN(1,3,7)", [$user_id]);

    if($items){

        ?>

        <input type="text" class="form-control user-statistics-items-search" placeholder="<?php echo translate("tr_ff8ef34ca636fa06f0c6e3f3ceae279a"); ?>" >

        <div class="user-items-container mt15" >

          <?php foreach ($items as $item){ ?>
          <a class="user-item-container" href="<?php echo outRoute('profile-statistics'); ?>?item_id=<?php echo $item["id"]; ?>" >
              <div class="user-item-container-box1" >
                 <div class="user-item-container-image" >
                    <img src="<?php echo $app->component->ads->getMedia($item["media"])->images->first; ?>" class="image-autofocus" >
                 </div>
              </div>
              <div class="user-item-container-box2" >
                 <span><?php echo $item["title"]; ?></span>
                 <span><?php echo $app->component->ads->outPriceAndCurrency($item); ?></span>
              </div>
          </a>
          <?php } ?>

        </div>

        <?php

    }else{
        ?>

          <div class="mt20 not-found-title-container" >
             <div class="not-found-title-container-image" >🧐</div>
             <p><?php echo translate("tr_698ee392dad3099a37dae5c98118fb2d"); ?></p>           
          </div>            

        <?php
    }
    
}