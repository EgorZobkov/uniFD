<div class="col-auto" >
<a data-id="<?php echo $value["id"]; ?>" href="<?php echo $app->component->ads_categories->buildAliases($value); ?>" class="home-widget-categories-item <?php echo $active; ?>" >
    <?php if($app->storage->name($value["image"])->exist()){ ?>
    <img src="<?php echo $app->storage->name($value["image"])->host(true)->get(); ?>">
    <?php } ?>
    <div><?php echo translateFieldReplace($value, "name"); ?></div>
</a>
</div>