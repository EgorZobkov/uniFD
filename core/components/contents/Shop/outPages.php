public function outPages($data=[], $link_class=""){
    global $app;

    $pages = $app->model->shops_pages->getAll("shop_id=?", [$data->shop->id]);
    if($pages){
        foreach ($pages as $key => $value) {

            if($data->page->id == $value["id"]){
                ?>
                <a class="<?php echo $link_class; ?> active" href="<?php echo $this->linkToPageCard($data->shop->alias, $value["alias"]); ?>" ><?php echo $value["name"]; ?></a>
                <?php
            }else{
                ?>
                <a class="<?php echo $link_class; ?>" href="<?php echo $this->linkToPageCard($data->shop->alias, $value["alias"]); ?>" ><?php echo $value["name"]; ?></a>
                <?php
            }

        }
    }

}