<?php

/**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Components;

class Home
{

	public $alias = "home";

 public function outAdsByCategories(){
    global $app;

    if($app->settings->frontend_home_slider_categories_ids){

    	foreach ($app->settings->frontend_home_slider_categories_ids as $id) {

    		$parent_ids = '';
    		
    		$category = $app->component->ads_categories->categories[$id];

    		$parent_ids = $app->component->ads_categories->joinId($id)->getParentIds($id);

    		if($parent_ids){

        		$data = $app->model->ads_data->sort("id desc limit 5")->getAll("status=? and category_id IN(".$parent_ids.")", [1]);

        		if($data){

        		shuffle($data);
        		?>

		        <div class="bold-title-and-link" >
		        	<span><?php echo translateFieldReplace($category, "name"); ?></span>
		        	<a class="btn-custom-mini button-color-scheme1" href="<?php echo $app->component->ads_categories->buildAliases($category); ?>"><?php echo translate("tr_1cc7e7972b8c9daa5e9c8e94483acc7d"); ?></a>
		        </div>

                <div class="row row-cols-2 row-cols-lg-5 g-2 g-lg-3" >
		        
		        	<?php
		        	foreach ($data as $item) {

		                $item = $app->component->ads->getDataByValue($item);

		                echo $app->view->setParamsComponent(['value'=>$item])->includeComponent('items/home-grid.tpl');

		        	}
		        	?>

		        </div>

        		<?php
        		}

    		}

    	}

    }


}

public function outAdsVip(){
    global $app;

    $data = $app->model->ads_data->sort("id desc limit 100")->getAll("status=? and service_urgently_status=?", [1,1]);

    if($data){

    shuffle($data);

    ?>

    <div class="bold-title-and-link" >
        <span><?php echo translate("tr_954a3184125c3e5917239f101fb9ff48"); ?></span>
        <a class="btn-custom-mini button-color-scheme1" href="<?php echo $app->component->geo->getChange() ? $app->component->geo->getChange()->alias : outLink('all'); ?>?filter[switch][urgently]=1"><?php echo translate("tr_1cc7e7972b8c9daa5e9c8e94483acc7d"); ?></a>
    </div>

    <div class="widget-ads-slider-container-items-vip" >
        
        <div class="row row-cols-2 row-cols-lg-5 g-2 g-lg-3" >
        <?php
        foreach (array_slice($data, 0, 10) as $item) {

            $item = $app->component->ads->getDataByValue($item);

            echo $app->view->setParamsComponent(['value'=>$item])->includeComponent('items/home-grid.tpl');

        }
        ?>
        </div>

    </div>

    <?php
    }

}

public function outArticlesBlog(){
    global $app;

    $data = $app->model->blog_posts->sort("id desc limit 50")->getAll("status=?", [1]);
    if($data){

        shuffle($data);

        ?>

        <div class="bold-title-and-link" >
            <span><?php echo translate("tr_103a554114af7c598a4f835ac463722e"); ?></span>
            <a class="btn-custom-mini button-color-scheme1" href="<?php echo outRoute('blog'); ?>"><?php echo translate("tr_9cc58bef25297a7f6a867891be20657c"); ?></a>
        </div>

        <div class="row row-cols-2 g-2 g-lg-3" >
        <?php

        foreach (array_slice($data, 0, 3) as $key => $value) {

            echo $app->view->setParamsComponent(['value'=>(object)$value])->includeComponent('items/home-post-grid.tpl');

        }

        ?>
        </div>
        <?php

    }

}

public function outCategories(){
    global $app;

    if($app->component->ads_categories->categories){

          foreach ($app->component->ads_categories->getMainCategories() as $key => $value) {

            ?>
            <a data-id="<?php echo $value["id"]; ?>" href="<?php echo $app->component->ads_categories->buildAliases($value); ?>" class="home-widget-categories-item"  >
                <?php if($app->storage->name($value["image"])->exist()){ ?>
                <img src="<?php echo $app->storage->name($value["image"])->host(true)->get(); ?>">
                <?php } ?>
                                <div><?php echo translateFieldReplace($value, "name"); ?></div>
            </a>
            <?php

          }

    }

}

public function outPromoBanners(){
    global $app;

    $geo = $app->session->get("geo");

    $getPromo = $app->model->promo_banners->sort("sorting asc")->getAll("status=? and (page_show='home' or page_show IS null)", [1]);
    if($getPromo){
        ?>
        <div class="widget-promo-banners-swiper" >
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

public function outShops(){
    global $app;

    if(!$app->settings->shops_status){
        return;
    }

    $getShops = $app->model->shops->sort("id desc limit 6")->getAll("status=?", ["published"]);
    if($getShops){

        ?>

        <div class="bold-title-and-link" >
            <span><?php echo translate("tr_cfb8af01cc910b08e8796e03cf662f5f"); ?></span>
            <a class="btn-custom-mini button-color-scheme1" href="<?php echo outRoute('shops'); ?>"><?php echo translate("tr_9bda15acad8029f349e418646e5d0e2f"); ?></a>
        </div>

        <div class="row row-cols-2 g-2 g-lg-3" >
        <?php

        foreach ($getShops as $key => $value) {

            $user = $app->model->users->find("id=?", [$value["user_id"]]);

            echo $app->view->setParamsComponent(['value'=>$value, 'user'=>$user])->includeComponent('items/home-shop-grid.tpl');

        }

        ?>
        </div>
        <?php

    }

}

public function outStories(){
    global $app;

    if($app->user->data->service_tariff->items->add_stories){

        ?>
        <div class="user-stories-swiper" >
            <div class="swiper-wrapper" >

                <div class="widget-stories-item actionChangeAddStory swiper-slide" >
                    <div>
                        <div class="widget-stories-item-circle stories-border-add" >
                            <div class="widget-stories-item-circle-image" >
                                <img src="<?php echo $app->storage->getAssetImage("6423009237658671.png"); ?>" class="image-autofocus" >
                                <div class="widget-stories-item-process-load" ><span class="spinner-border" role="status" aria-hidden="true"></span></div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php echo $app->component->stories->outUsersStories(); ?>

            </div>
        </div>
        <?php

    }else{

        if($app->model->stories->count()){

            ?>
            <div class="user-stories-swiper" >
                <div class="swiper-wrapper" >
                    <?php echo $app->component->stories->outUsersStories(); ?>
                </div>
            </div>
            <?php

        }

    }

}



}