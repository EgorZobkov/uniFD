public function outPodFilterItemsOptions($filter_id=0){
    global $app;

    $items = $app->model->ads_filters_items->getAll("filter_id=? order by name asc", [$filter_id]);

    if($items){
        foreach ($items as $key => $value) {
           $parentItem = $app->model->ads_filters_items->find("id=?", [$value["item_parent_id"]]);
           if($parentItem){
                ?>
                <option value="<?php echo $value["id"]; ?>" ><?php echo translateFieldReplace($parentItem, "name"); ?> - <?php echo translateFieldReplace($value, "name"); ?></option>
                <?php                
           }else{
                ?>
                <option value="<?php echo $value["id"]; ?>" ><?php echo translateFieldReplace($value, "name"); ?></option>
                <?php
           }
        }
    }

}