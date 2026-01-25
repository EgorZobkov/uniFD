public function outMediaGalleryInCard($data=[], $params=[]){
    global $app;

    $source_video = $data->link_video ? $app->video->parseLinkSource($data->link_video) : '';

    if($data->media->images->all){

      ?>

      <div class="ad-card-media-slider-container" >

          <span class="ad-card-media-slider-nav-left" ><i class="ti ti-chevron-left"></i></span>
          <span class="ad-card-media-slider-nav-right" ><i class="ti ti-chevron-right"></i></span>

          <div class="ad-card-media-slider uniMediaSliderContainer ad-card-media-slider-swiper" >

            <div class="swiper-wrapper" >
                  <?php

                  foreach ($data->media->inline as $key => $value) {

                        if($value->type == "image"){
                            ?>
                            <a href="<?php echo $value->link; ?>" class="ad-card-media-slider-item uniMediaSliderItem swiper-slide" data-media-type="<?php echo $value->type; ?>" data-media-key="<?php echo $key; ?>" style="height: <?php echo $params["height"]; ?>;" >
                                <div style="height: <?php echo $params["height"]; ?>;" >
                                    <img src="<?php echo $value->link; ?>" data-key="<?php echo $key; ?>" alt="<?php echo $data->title; ?>" title="<?php echo $data->title; ?>" >
                                </div>
                            </a>
                            <?php
                        }elseif($value->type == "video"){
                            ?>
                            <a href="<?php echo $value->preview; ?>" class="ad-card-media-slider-item uniMediaSliderItem swiper-slide" data-media-video="<?php echo $value->link; ?>" data-media-type="<?php echo $value->type; ?>" data-media-key="<?php echo $key; ?>" style="height: <?php echo $params["height"]; ?>;" >
                                <div style="height: <?php echo $params["height"]; ?>;" >
                                    <img src="<?php echo $value->preview; ?>" data-key="<?php echo $key; ?>" alt="<?php echo $data->title; ?>" title="<?php echo $data->title; ?>" >
                                    <span class="ad-card-media-slider-item-label-video" ><i class="ti ti-video"></i></span>
                                </div>
                            </a>
                            <?php
                        }
                  }

                  if($source_video){
                        ?>
                        <a href="<?php echo $source_video->image; ?>" class="ad-card-media-slider-item uniMediaSliderItem swiper-slide" data-media-video="<?php echo $source_video->link; ?>" data-media-type="link_video" data-media-key="<?php echo $data->media->count; ?>" style="height: <?php echo $params["height"]; ?>;" >
                            <div style="height: <?php echo $params["height"]; ?>;" class="ad-card-media-slider-item-logo-video" >
                                <img src="<?php echo $source_video->image; ?>" data-key="<?php echo $data->media->count; ?>" alt="<?php echo $data->title; ?>" title="<?php echo $data->title; ?>" >
                                <span class="ad-card-media-slider-item-label-video" ><i class="ti ti-video"></i></span>
                            </div>
                        </a>
                        <?php                
                  }

                  ?>
            </div>

          </div>

      </div>

      <div class="ad-card-media-slider-miniatures" >
        <div class="swiper-wrapper" >
        </div>
      </div>

      <?php

    }elseif($source_video){

      ?>

      <div class="ad-card-media-slider-container" >

          <div class="ad-card-media-slider uniMediaSliderContainer" >
                <a href="<?php echo $source_video->image; ?>" class="ad-card-media-slider-item uniMediaSliderItem" data-media-video="<?php echo $source_video->link; ?>" data-media-type="video" data-media-key="0" style="height: <?php echo $params["height"]; ?>;" >
                    <div style="height: <?php echo $params["height"]; ?>;" >
                        <img src="<?php echo $source_video->image; ?>" data-key="<?php echo $data->media->count; ?>" alt="<?php echo $data->title; ?>" title="<?php echo $data->title; ?>" >
                        <span class="ad-card-media-slider-item-label-video" ><i class="ti ti-video"></i></span>
                    </div>
                </a>
          </div>

      </div>

      <?php            

    }

}