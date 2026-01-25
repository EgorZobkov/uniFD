<?php

/**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Components;
use App\Systems\Container;

class Shop
{

 public $alias = "shop";

 public function buildAliasesCategories($data=[], $shop_alias=null){
    global $app;

    $chain = $app->component->ads_categories->chainCategory($data["id"]);

    return $this->linkToCatalog($shop_alias) . '/' . $chain->chain_build_alias_request;

}

public function buildCategories($user_id=0){   
    global $app;

    $cats = [];
    $categories = [];

    $data = $app->model->ads_data->getAll("status=? and user_id=?", [1, $user_id]);

    if($data){
        foreach ($data as $key => $value) {

            $ids = $app->component->ads_categories->getReverseMainIds($value["category_id"]);

            if($ids){
                foreach (explode(",", $ids) as $id) {
                    $cats[$id] = $id;
                }
            }

        }
    }

    if($cats){
        $categories = $app->component->ads_categories->getCategories(implode(",", $cats));

    }

    return $categories;
    
}

public function checkCategoriesByAliasShop($request=null){
     global $app;

     if($app->component->ads_categories->categories){

        $end_alias = end($request);

        if($app->component->ads_categories->categories["alias"][$end_alias]){
             foreach ($app->component->ads_categories->categories["alias"][$end_alias] as $category_id => $value) {
                $chain = $app->component->ads_categories->chainCategory($category_id);
                if($chain->chain_build_alias_request == implode("/", $request)){
                   $value["chain"] = $chain;
                   return (object)$value;
                }
             }                
        }       

     }

     return [];

}

public function codeStatuses(){   
    global $app;

    $result["awaiting_verification"] = ["code"=>"awaiting_verification", "name"=>translate("tr_13068c40c12a556c1ed7cd182ac6ab87"), "label"=>'warning'];
    $result["published"] = ["code"=>"published", "name"=>translate("tr_93928aafced6398c7dbc2ee42e498ad9"), "label"=>"success"];
    $result["blocked"] = ["code"=>"blocked", "name"=>translate("tr_06d1f50f12d3f3426428c3de06aac118"), "label"=>"danger"];
    $result["rejected"] = ["code"=>"rejected", "name"=>translate("tr_22c9a6fed5c73377cc7b17aed5d649df"), "label"=>"secondary"];
    
    return $result;

}

public function countPages($shop_id=0){   
    global $app;

    return $app->model->shops_pages->count("shop_id=?", [$shop_id]);
    
}

public function delete($id=0, $user_id=0){
    global $app;

    if($user_id){
        $shop = $app->model->shops->find("id=? and user_id=?", [$id, $user_id]);
    }else{
        $shop = $app->model->shops->find("id=?", [$id]);
    }

    if($shop){
        $app->storage->clearAttachFiles([$shop->image]);
        $app->model->shops->delete("id=?", [$shop->id]);
        $app->model->shops_pages->delete("shop_id=?", [$shop->id]);

        $banners = $app->model->shops_banners->getAll("shop_id=?", [$shop->id]);
        if($banners){
            foreach ($banners as $key => $value) {
                $app->storage->clearAttachFiles([$value["image"]]);
            }
        }
        $app->model->shops_banners->delete("shop_id=?", [$shop->id]);
    }

}

public function getActiveShopByUserId($user_id=0){
    global $app;

    return $app->model->shops->find("user_id=? and status=?", [$user_id, "published"]);

}

public function getAllAdsUser($user_id=0){   
    global $app;

    $content = '';

    $getAds = $app->model->ads_data->sort("id desc")->getAll("user_id=? and status=?", [$user_id, 1]);
    if($getAds){

        if(count($getAds) > 8){
            shuffle($getAds);
        }

        foreach (array_slice($getAds, 0, 8) as $key => $value) {
           
            $value = $app->component->ads->getDataByValue($value);

            $content .= $app->view->setParamsComponent(['value'=>(object)$value])->includeComponent('items/grid.tpl');

        }

    }

    return $content;
    
}

public function getBanners($shop_id=0){
    global $app;

    $result = [];

    $banners = $app->model->shops_banners->sort("id desc")->getAll("shop_id=?", [$shop_id]);
    if($banners){
        foreach ($banners as $key => $value) {
            
            $result[] = ["id"=>$value["id"], "image"=>$app->storage->name($value["image"])->get()];

        }
    }

    return $result;

}

public function getCodeStatus($name=null){
    global $app;

    $code = $this->codeStatuses();

    return $code[$name] ? (object)$code[$name] : [];

}

public function getHomeAdsUser($user_id=0){   
    global $app;

    $content = '';

    $getAds = $app->model->ads_data->sort("id desc limit 100")->getAll("user_id=? and status=?", [$user_id, 1]);
    if($getAds){

        if(count($getAds) > 8){
            shuffle($getAds);
        }

        foreach (array_slice($getAds, 0, 8) as $key => $value) {
           
            $value = $app->component->ads->getDataByValue($value);

            $content .= $app->view->setParamsComponent(['value'=>(object)$value])->includeComponent('items/grid.tpl');

        }

    }

    return $content;
    
}

public function getHomeReviews($user_id=0){   
    global $app;

    $content = '';

    $getReviews = $app->model->reviews->sort("id desc")->getAll("whom_user_id=? and status=? and parent_id=?", [$user_id,1,0]);

    if($getReviews){
        foreach ($getReviews as $key => $value) {
           
            $value = $app->component->reviews->getDataByValue($value);

            $content .= $app->view->setParamsComponent(['value'=>(object)$value])->includeComponent('items/shop-review-list.tpl');

        }
    }

    return $content;
    
}

public function getShopByAlias($alias=null){
    global $app;

    return $app->model->shops->find("alias=?", [$alias]);

}

public function getShopByUserId($user_id=0){
    global $app;

    return $app->model->shops->find("user_id=?", [$user_id]);

}

public function linkToCatalog($shop_alias=null){
    global $app;

    return outLink('shop/' . $shop_alias . '/catalog');

}

public function linkToPageCard($shop_alias=null, $page_alias=null){
    global $app;

    return outLink('shop/' . $shop_alias . '/page/' . $page_alias);

}

public function linkToShopCard($alias=null){
    global $app;

    return outLink('shop/' . $alias);

}

public function outCategoriesList($shop_id=0){   
    global $app;

    $shop = $app->model->shops->find("id=?", [$shop_id]);

    $categories = $this->buildCategories($shop->user_id);

    return $this->outRecursionCategories($categories,0,0,$shop->alias);
    
}

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

public function outRecursionCategories($categories=[], $parent_id=0, $level=0, $shop_alias=null){

    if ($categories){
        foreach ($categories["parent_id"][$parent_id] as $value) {

            while ($x++<$level) $retreat .= '--';

            echo '<a href="'.$this->buildAliasesCategories($value, $shop_alias).'" >'.$retreat.$value["name"].'</a>';

            $level++;
            
            $this->outRecursionCategories($categories, $value["id"], $level, $shop_alias);
            
            $level--;
            
        }
    }

}

public function outStatusInCardShop($data=[]){
    global $app;

    if($data->owner){

        if($data->shop->status == "awaiting_verification"){
        ?>

        <div class="card-status-info card-status-info-bg-moderation" >
          <strong><?php echo translate("tr_a22a6ac5e3bb9c824b6b0defef2b71a8"); ?></strong>
          <p><?php echo translate("tr_d992e9794e23f088bf7e891773f29669"); ?></p>
        </div>

        <?php }elseif($data->shop->status == "blocked"){ ?>

        <div class="card-status-info card-status-info-bg-error" >
          <strong><?php echo translate("tr_72492cec85a3f7ca9b61a7a32949f5aa"); ?></strong>
        </div>

        <?php }elseif($data->shop->status == "rejected"){ ?>

        <div class="card-status-info card-status-info-bg-error"  >
          <strong><?php echo translate("tr_2943837ba61e63136527be245b0cbd2f"); ?></strong>
          <p><?php echo $data->shop->comment; ?></p>
        </div>

        <?php
        }

        
    }

}



}