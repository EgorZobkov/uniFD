public function outStories(){
    global $app;

    if($app->user->data->service_tariff->items->add_stories){

        ?>
        <div class="user-stories-swiper" >
            <div class="swiper-wrapper" >

                <div class="widget-stories-item actionChangeAddStory swiper-slide" >
                    <div>
                        <div class="widget-stories-item-circle stories-border-add" >
                            <div class="widget-stories-item-circle-image" >
                                <img src="<?php echo $app->storage->getAssetImage("6423009237658671.png"); ?>" class="image-autofocus" >
                                <div class="widget-stories-item-process-load" ><span class="spinner-border" role="status" aria-hidden="true"></span></div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php echo $app->component->stories->outUsersStories(); ?>

            </div>
        </div>
        <?php

    }else{

        if($app->model->stories->count()){

            ?>
            <div class="user-stories-swiper" >
                <div class="swiper-wrapper" >
                    <?php echo $app->component->stories->outUsersStories(); ?>
                </div>
            </div>
            <?php

        }

    }

}