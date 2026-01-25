<div class="col-md-6 col-12 col-lg-4" >

    <a class="widget-shops-item-link" href="<?php echo $app->component->shop->linkToShopCard($value["alias"]); ?>" >
        <div class="widget-shops-item" >
            <div class="widget-shops-item-image" >
                <div><img src="<?php echo $app->storage->name($value["image"])->host(true)->get(); ?>" class="image-autofocus" ></div>
            </div>
            <div class="widget-shops-item-content" >
                <h4><?php echo trimStr($value["title"], 60, true); ?></h4>
                <div><?php echo $app->component->profile->stampCountRating($user->total_rating); ?></div>
            </div>
        </div>
        <p><?php echo trimStr($value["text"], 150, true); ?></p>
    </a>

</div>