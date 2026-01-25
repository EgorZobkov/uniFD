public function outFilterLinks(){
    global $app;

    if($app->component->catalog->data->category){

        if($app->component->catalog->data->filter_link){
            $getFilterLinks = $app->model->ads_filters_links->sort("name asc")->getAll("category_id=? and id!=?", [$app->component->catalog->data->category->id,$app->component->catalog->data->filter_link->id]);
        }else{
            $getFilterLinks = $app->model->ads_filters_links->sort("name asc")->getAll("category_id=?", [$app->component->catalog->data->category->id]);
        }

        if($getFilterLinks){
            ?>
            <div class="catalog-filter-links-container" >
            <?php
            foreach ($getFilterLinks as $key => $value) {
                ?>
                <a href="<?php echo $this->buildAliasesLink($value); ?>" title="<?php echo translateFieldReplace($value, "name"); ?>" ><?php echo translateFieldReplace($value, "name"); ?></a>
                <?php
            }
            ?>
            </div>
            <?php
        }

    }

}