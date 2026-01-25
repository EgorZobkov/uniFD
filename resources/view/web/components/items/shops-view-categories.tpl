<div class="col-md-2" >
<a data-id="<?php echo $value["id"]; ?>" href="<?php echo $app->component->ads_categories->buildAliasesShops($value); ?>" <?php echo $active; ?> >
    <div><?php echo translateFieldReplace($value, "name"); ?></div>
    <?php if($app->storage->name($value["image"])->exist()){ ?>
    <img src="<?php echo $app->storage->name($value["image"])->host(true)->get(); ?>">
    <?php } ?>
</a>
</div>