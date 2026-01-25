public function outPromoBanners(){
    global $app;

    $geo = $app->session->get("geo");

    $getPromo = $app->model->promo_banners->sort("sorting asc")->getAll("status=? and (category_id=? or category_id=0) and (page_show='catalog' or page_show IS null)", [1,$this->data->category->id]);
    if($getPromo){
        ?>
        <div class="widget-promo-banners-swiper mt15" >
            <div class="swiper-wrapper" >            
            <?php
            foreach ($getPromo as $key => $value) {

                if(!$app->validation->isLink($value["link"])->status){
                    if($value["geo_link_status"]){
                        if($geo){
                            $value["link"] = outLink($geo->alias . '/' . trim($value["link"], "/"));
                        }else{
                            $value["link"] = outLink($value["link"]);
                        }
                    }else{
                        $value["link"] = outLink($value["link"]);
                    }
                }
                
                ?>

                <a class="widget-promo-banner-item swiper-slide" style="background-color: <?php echo $value["bg_color"]; ?>;" href="<?php echo $value["link"]; ?>" >
                    <h4 style="color: <?php echo $value["text_color"]; ?>;" ><?php echo translateFieldReplace($value, "title"); ?></h4>
                    <p style="color: <?php echo $value["text_color"]; ?>;" ><?php echo translateFieldReplace($value, "text"); ?></p>
                    <?php if($value["image"]){ ?>
                        <img src="<?php echo $app->storage->name($value["image"])->host(true)->get(); ?>" title="<?php echo translateFieldReplace($value, "title"); ?>" alt="<?php echo translateFieldReplace($value, "title"); ?>" >
                    <?php } ?>
                </a>

                <?php
            }
            ?>
            </div>
        </div>
        <?php
    }

}