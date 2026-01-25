<div class="col-md-4 col-12" >

    <a class="widget-shops-item-link" href="<?php echo $app->component->shop->linkToShopCard($value["alias"]); ?>" >
        <div class="widget-shops-item" >
            <div class="widget-shops-item-image" >
                <div><img src="<?php echo $app->storage->name($value["image"])->host(true)->get(); ?>" class="image-autofocus" ></div>
            </div>
            <div class="widget-shops-item-content" >
                <h4><?php echo trimStr($value["title"], 40, true); ?></h4>
                <div><?php echo $app->component->profile->stampCountRating($user->total_rating); ?></div>
            </div>
        </div>
    </a>

</div>