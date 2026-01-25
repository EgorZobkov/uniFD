public function outByCode($code=null){
    global $app;

    $category_id = $app->component->catalog->data->category->id ?: 0;

    $data = $app->model->advertising->getAll("uniq_code=? and status=? and (time_start is null or date(now())>=date(time_start)) and (time_end is null or date(time_end)>=date(now())) and (category_id=? or category_id=0)", [$code,1,$category_id]);

    if($data){

        ?>
        <div class="advertising-banner-container advertising-banner-swiper" >
        <div class="swiper-wrapper" >            
        <?php

        foreach ($data as $key => $value) {

            if($value["geo"]){

                if(!$this->checkGeo(_json_decode($value["geo"]))){
                    break;
                }

            }

            if($value["lang_iso"]){

                if($app->translate->getChangeLang() != $value["lang_iso"]){
                    break;
                }

            }

            if($value["type"] == "banner"){
                ?>
                <a class="advertising-banner-item actionAdvertisingClick swiper-slide" data-code="<?php echo $code; ?>" href="<?php echo $value["link"]; ?>" target="_blank" >
                    <img src="<?php echo $app->storage->name($value["image"])->get(); ?>">
                </a>
                <?php
            }else{
                ?>
                <div class="advertising-script-item actionAdvertisingClick swiper-slide" data-code="<?php echo $code; ?>" >
                    <?php echo urldecode($value["code"]); ?>
                </div>
                <?php
            }

        }

        ?>
        </div>
        <div class="advertising-banner-swiper-pagination" ></div>
        </div>
        <?php

    }

}