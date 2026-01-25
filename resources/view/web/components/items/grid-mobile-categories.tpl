<div class="col-md-4 col-sm-4 col-4" >
    <a class="mobile-grid-menu-category-item" data-id="<?php echo $value["id"]; ?>" href="<?php echo $app->component->ads_categories->buildAliases($value); ?>" >
        <div><?php echo translateFieldReplace($value, "name"); ?></div>
        <?php if($app->storage->name($value["image"])->exist()){ ?>
        <img src="<?php echo $app->storage->name($value["image"])->host(true)->get(); ?>">
        <?php } ?>                        
    </a>
</div>