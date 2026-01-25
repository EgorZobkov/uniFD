public function outMainCategories(){
    global $app;

    if($this->getMainCategories()){

          $count_key = 0;

          foreach ($this->getMainCategories() as $key => $value) {

            $active = '';

            if($count_key == 0){
                $active = 'active';
            }

            $count_key++;

            ?>

            <a class="big-catalog-menu-category-item <?php echo $active; ?>" data-id="<?php echo $value["id"]; ?>" href="<?php echo $this->buildAliases($value); ?>" >
                <?php if($app->storage->name($value["image"])->exist()){ ?>
                <div> <img src="<?php echo $app->storage->name($value["image"])->host(true)->get(); ?>"> </div>
                <?php } ?>
                <?php echo translateFieldReplace($value, "name"); ?>
            </a>

            <?php

          }

    }

}