public function outMainCategoriesGrid($shop_id=0){   
    global $app;

    $shop = $app->model->shops->find("id=?", [$shop_id]);

    $categories = $this->buildCategories($shop->user_id);

    if($categories["parent_id"][0]){

          foreach ($categories["parent_id"][0] as $key => $value) {

            ?>

            <div class="col-md-4 col-sm-4 col-4" >
                <a class="mobile-grid-menu-category-item" data-id="<?php echo $value["id"]; ?>" href="<?php echo $this->buildAliasesCategories($value, $shop->alias); ?>" >
                    <div><?php echo $value["name"]; ?></div>
                    <?php if($app->storage->name($value["image"])->exist()){ ?>
                    <img src="<?php echo $app->storage->name($value["image"])->host(true)->get(); ?>">
                    <?php } ?>                        
                </a>
            </div>

            <?php

          }

    }

}