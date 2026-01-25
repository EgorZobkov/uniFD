<?php

/**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Components;
use App\Systems\Container;

class Catalog
{

 public $alias = "catalog";
 public $data = [];

 public function buildChainNamesFilters($params=[], $geo=[]){
    global $app;

    $result = [];

    if($geo){
        $result[] = $geo->name;
    }

    if($params["filter"]["price_from"]){
        $result[] = translate("tr_50b6450b4c1ce87e8874b0fa6879381d")." ".$app->system->amount($params["filter"]["price_from"]);
        unset($params["filter"]["price_from"]);
    }

    if($params["filter"]["price_to"]){
        $result[] = translate("tr_1a0628dfe431c9d920bc2fc206d16216")." ".$app->system->amount($params["filter"]["price_to"]);
        unset($params["filter"]["price_to"]);
    }

    if($params["city_districts"]){
        $result[] = translate("tr_eed248b6d4d4b1363de9fc590de921c2")." ".count($params["city_districts"]);
    }

    if($params["city_metro"]){
        $result[] = translate("tr_fae5417d546768ff2552ea52752e4fe6")." ".count($params["city_metro"]);
    }

    if($params["search"]){
        $result[] = translate("tr_bfc95980634bf529e8a406db2c842b31")." ".$params["search"];
    }

    if($params["sort"]){
        if($params["sort"] == "news"){
           $result[] = translate("tr_67994f179ee9cff8c25e295ed1a7a375");
        }elseif($params["sort"] == "price_asc"){
           $result[] = translate("tr_1ee3ebbb2c276425f26aedde12911cb5");
        }elseif($params["sort"] == "price_desc"){
           $result[] = translate("tr_d57c74946bf3b0f62d3ece8e4d34523b");
        }
    }

    if($params["filter"]){
        $result[] = translate("tr_beb17c7b102f4290331f8480b73bdfc1")." ".count($params["filter"])." ".endingWord(count($params["filter"]), translate("tr_525cf87caa93db1879f3336c1fae54b5"), translate("tr_7a6c3d490cd5136182142ff421e08a6b"), translate("tr_486f855767fbe51af5695abec9681ea5"));
    }

    return $result ? implode(" - ", $result) : '';

}

public function buildFilterToGet($filter=null){
    global $app;

    mb_parse_str($filter, $result);

    $_GET['filter'] = $result["filter"];

}

public function buildParamsForm($params=[], $category_id=0, $only_default_filters=true){
    global $app;

    $price_from = $params["filter"]["price_from"] ?: '';
    $price_to = $params["filter"]["price_to"] ?: '';
    $priceName = '';

    $subcategoryItems = [];
    $subcategoryParentId = 0;
    $subcategoryParentCategory = null;
    $subcategorySelectedName = 'Все подкатегории';
    $selectedCategoryId = $params["c_id"] ?? $category_id;
   
    if($price_from && $price_to){
        if($price_from > $price_to){
            $price_from = '';
        }
    }

    if($app->component->ads_categories->categories[$category_id]["price_name_id"]){
        $systemPrice = $app->model->system_price_names->find("id=?", [$app->component->ads_categories->categories[$category_id]["price_name_id"]]);
        if($systemPrice){
            $priceName = translateField($systemPrice->name);
        }else{
            $priceName = translate("tr_682fa8dbadd54fda355b27f124938c93");
        }
    }else{
        $priceName = translate("tr_682fa8dbadd54fda355b27f124938c93");
    }
    



    if($category_id){
        if($app->component->ads_categories->categories["parent_id"][$category_id]){
            $subcategoryItems = $app->component->ads_categories->categories["parent_id"][$category_id];
            $subcategoryParentId = $category_id;
            $subcategoryParentCategory = $app->component->ads_categories->categories[$category_id];
        }else{
            $parentId = $app->component->ads_categories->categories[$category_id]["parent_id"] ?: 0;
            if($parentId && $app->component->ads_categories->categories["parent_id"][$parentId]){
                $subcategoryItems = $app->component->ads_categories->categories["parent_id"][$parentId];
                $subcategoryParentId = $parentId;
                $subcategoryParentCategory = $app->component->ads_categories->categories[$parentId];
            }
        }
    }

    if($subcategoryItems){
        if($selectedCategoryId != $subcategoryParentId){
            foreach ($subcategoryItems as $subcategory) {
                if($subcategory["id"] == $selectedCategoryId){
                    $subcategorySelectedName = translateFieldReplace($subcategory, "name");
                    break;
                }
            }
        }
    }

    ?>

    <div class="params-form-filters-container" >

    <?php if($category_id){ ?>

        <?php if($subcategoryItems){ ?>
        <div class="params-form-item params-form-item-subcategory" >
            <label class="params-form-item-label" >Подкатегория</label>
            <div class="uni-select" data-status="0" >
                <span class="uni-select-name" data-default-name="Все подкатегории" ><?php echo $subcategorySelectedName; ?></span>
                <div class="uni-select-content" >
                    <div class="uni-select-content-container" >
                        <a class="uni-select-content-item<?php echo $selectedCategoryId == $subcategoryParentId ? ' uni-select-item-active' : ''; ?>" href="<?php echo $subcategoryParentCategory ? $app->component->ads_categories->buildAliases($subcategoryParentCategory) : '#'; ?>" >
                            <span>Все подкатегории</span>
                        </a>
                        <?php foreach ($subcategoryItems as $subcategory) { ?>
                            <a class="uni-select-content-item<?php echo $selectedCategoryId == $subcategory["id"] ? ' uni-select-item-active' : ''; ?>" href="<?php echo $app->component->ads_categories->buildAliases($subcategory); ?>" >
                                <span><?php echo translateFieldReplace($subcategory, "name"); ?></span>
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>

        <?php if($app->component->ads_categories->categories[$category_id]["price_status"]){ ?>
        <div class="params-form-item params-form-item-price" >
            <label class="params-form-item-label" ><?php echo $priceName; ?></label>
            <div class="row" >
                <div class="col-6" ><input type="text" class="form-control" name="filter[price_from]" placeholder="<?php echo translate("tr_996b125bc9bba860718d999df2ecc61d"); ?>" value="<?php echo $price_from; ?>" /></div>
                <div class="col-6" ><input type="text" class="form-control" name="filter[price_to]" placeholder="<?php echo translate("tr_c2aa9c0cecea49717bb2439da36a7387"); ?>" value="<?php echo $price_to; ?>" /></div>
            </div>
        </div> 
        <?php } ?>   
    <?php }else{ ?>  
        <div class="params-form-item params-form-item-price" >
            <label class="params-form-item-label" ><?php echo translate("tr_682fa8dbadd54fda355b27f124938c93"); ?></label>
            <div class="row" >
                <div class="col-6" ><input type="text" class="form-control" name="filter[price_from]" placeholder="<?php echo translate("tr_996b125bc9bba860718d999df2ecc61d"); ?>" value="<?php echo $price_from; ?>" /></div>
                <div class="col-6" ><input type="text" class="form-control" name="filter[price_to]" placeholder="<?php echo translate("tr_c2aa9c0cecea49717bb2439da36a7387"); ?>" value="<?php echo $price_to; ?>" /></div>
            </div>
        </div> 
    <?php } ?>          

    <div class="params-form-item params-form-item-switch" >
        <label class="switch">
          <input type="checkbox" class="switch-input" name="filter[switch][urgently]" value="1" <?php echo $params["filter"]["switch"]["urgently"] ? 'checked=""' : ''; ?> >
          <span class="switch-toggle-slider">
            <span class="switch-on"></span>
            <span class="switch-off"></span>
          </span>
          <span class="switch-label"><?php echo translate("tr_c85cf9e96515efc35d01f5ead5495666"); ?></span>
        </label>
    </div>

    <?php if($app->component->ads_categories->categories[$category_id]["delivery_status"]){ ?>
    <div class="params-form-item params-form-item-switch" >
        <label class="switch">
          <input type="checkbox" class="switch-input" name="filter[switch][delivery]" value="1" <?php echo $params["filter"]["switch"]["delivery"] ? 'checked=""' : ''; ?> >
          <span class="switch-toggle-slider">
            <span class="switch-on"></span>
            <span class="switch-off"></span>
          </span>
          <span class="switch-label"><?php echo translate("tr_4e049833e66e92f322fcafd7b2798f8f"); ?></span>
        </label>
    </div>
    <?php } ?>

    <?php if($app->component->ads_categories->categories[$category_id]["condition_new_status"]){ ?>
    <div class="params-form-item params-form-item-switch" >
        <label class="switch">
          <input type="checkbox" class="switch-input" name="filter[switch][only_new]" value="1" <?php echo $params["filter"]["switch"]["only_new"] ? 'checked=""' : ''; ?> >
          <span class="switch-toggle-slider">
            <span class="switch-on"></span>
            <span class="switch-off"></span>
          </span>
          <span class="switch-label"><?php echo translate("tr_71a1870b0d47ee55459cd727e88b8b8d"); ?></span>
        </label>
    </div>
    <?php } ?>

    <?php if($app->component->ads_categories->categories[$category_id]["condition_brand_status"]){ ?>
    <div class="params-form-item params-form-item-switch" >
        <label class="switch">
          <input type="checkbox" class="switch-input" name="filter[switch][only_brand]" value="1" <?php echo $params["filter"]["switch"]["only_brand"] ? 'checked=""' : ''; ?> >
          <span class="switch-toggle-slider">
            <span class="switch-on"></span>
            <span class="switch-off"></span>
          </span>
          <span class="switch-label"><?php echo translate("tr_3e66cad801646a25439eb6f191565d21"); ?></span>
        </label>
    </div>
    <?php } ?>

    <?php if($app->component->ads_categories->categories[$category_id]["booking_status"]){ ?>

        <div class="params-form-item params-form-item-calendar" >
            <label class="params-form-item-label"><?php echo translate("tr_35836cab785c307eaae16002e9c2e397"); ?></label>
            <div class="params-form-item-calendar-range1" style="display: none;" ></div>
            <div class="params-form-item-calendar-range2"></div>
        </div>

        <input type="hidden" name="filter[calendar_date_start]" class="params-form-calendar-date-start" value="<?php echo $params["filter"]["calendar_date_start"]; ?>" >
        <input type="hidden" name="filter[calendar_date_end]" class="params-form-calendar-date-end" value="<?php echo $params["filter"]["calendar_date_end"]; ?>" >              

    <?php } ?>

    <?php echo $app->component->ads_filters->outFiltersByCatalog($params["filter"], $category_id, $only_default_filters); ?>

    </div>

    <?php

     if($params["sort"]){
        ?>
        <input type="hidden" name="sort" value="<?php echo $params["sort"]; ?>" >
        <?php
     }

     ?>

     <?php if(!$subcategoryItems){ ?>
        <input type="hidden" name="c_id" value="<?php echo $category_id; ?>" >
     <?php } ?>

     <?php

}

public function buildQuery($request=[], $category_id=0, $geo=[]){
    global $app;

    $flQueryResult = [];
    $flQuery= [];
    $flCount = 0;
    $filter = $request["filter"];

    $price_from = (int)$filter["price_from"];
    $price_to = (int)$filter["price_to"];

    $query[] = "status=?";
    $params[] = 1;
    $ids = [];
    $ids_not = [];

    if($request["search"]){

        $data = $app->component->search->splitKeywords($request["search"]);

        if($data["split"]){
            
            if($app->settings->search_allowed_text){
                $itemQuery = $app->component->search->buildKeywordsFields($data["split"], ["search_tags", "title", "text", "article_number"]);
            }else{
                $itemQuery = $app->component->search->buildKeywordsFields($data["split"], ["search_tags", "title", "article_number"]);
            }

            $query[] = "(title LIKE ? or (".$itemQuery["query"]."))";
            $params[] = $request["search"];
            $params = array_merge($params, $itemQuery["params"]);

            $category_id = 0;
        }

    }

    if($price_from && $price_to){  
        $query[] = "(price BETWEEN ? AND ?)";
        $params[] = round($price_from,2);
        $params[] = round($price_to,2);
        unset($filter["price_from"]);
        unset($filter["price_to"]);
    }else{
        if($price_from){
           $query[] = "(price >= ?)";
           $params[] = round($price_from,2);
           unset($filter["price_from"]);
        }elseif($price_to){
           $query[] = "(price <= ?)";
           $params[] = round($price_to,2);
           unset($filter["price_to"]);
        }
    }

    if($filter["switch"]["urgently"]){
       $query[] = "(service_urgently_status = ?)";
       $params[] = 1;
    }

    if($filter["switch"]["only_new"]){
       $query[] = "(condition_new_status = ?)";
       $params[] = 1;
    }

    if($filter["switch"]["only_brand"]){
       $query[] = "(condition_brand_status = ?)";
       $params[] = 1;
    }

    if($filter["switch"]["delivery"]){
       $query[] = "(delivery_status = ?)";
       $params[] = 1;
    }

    if($filter["calendar_date_start"] && $filter["calendar_date_end"]){

       $query[] = "(booking_status = ?)";
       $params[] = 1;

       $getBookingDates = $app->model->booking_dates->getAll("(date BETWEEN ? AND ?)", [$filter["calendar_date_start"], $filter["calendar_date_end"]]);
       
       if($getBookingDates){
            foreach ($getBookingDates as $key => $value) {
                $ids_not[$value["ad_id"]] = $value["ad_id"];
            }
       }

    }

    if($category_id){

        $categories_ids = $app->component->ads_categories->joinId($category_id)->getParentIds($category_id);

        if($categories_ids){
            $query[] = "category_id IN (".$categories_ids.")";
        } 

    }

    if($geo){

        if($geo->city_id){
            $query[] = '(city_id=? or city_id=?)';
            $params[] = $geo->city_id;
            $params[] = 0;
        }elseif($geo->region_id){
            $query[] = '(region_id=? or region_id=?)';
            $params[] = $geo->region_id;       
            $params[] = 0;         
        }elseif($geo->country_id){
            $query[] = '(country_id=? or country_id=?)';
            $params[] = $geo->country_id;
            $params[] = 0;                
        }

    }

    if($request["city_districts"]){
        $districts_ids = [];
        if(is_array($request["city_districts"])){
            $getDistricts = $app->model->ads_city_districts_ids->getAll("district_id IN(".implode(",", $request["city_districts"]).")");
            if($getDistricts){
                foreach ($getDistricts as $key => $value) {
                    $districts_ids[] = $value["id"];
                    $ids[$value["ad_id"]] = $value["ad_id"];
                }
            }
        }
    }

    if($request["city_metro"]){
        $metro_ids = [];
        if(is_array($request["city_metro"])){
            $getMetro = $app->model->ads_city_metro_ids->getAll("metro_id IN(".implode(",", $request["city_metro"]).")");
            if($getMetro){
                foreach ($getMetro as $key => $value) {
                    $metro_ids[] = $value["id"];
                    $ids[$value["ad_id"]] = $value["ad_id"];
                }
            }
        }
    }

    unset($filter["switch"]);

    if($filter){

       foreach($filter AS $filter_id => $nested){

           $getFilter = $app->model->ads_filters->find("id=? and status=?", [$filter_id, 1]);

           if($getFilter){

             if($getFilter->view != "input" && $getFilter->view != "input_text"){

                 foreach($nested AS $key => $value){
    
                     if($value != "" && $value != "null"){
                         
                         if(!$flQuery[$filter_id]){
                            $flCount++;
                         }

                         $flQuery[$filter_id][] = "(filter_id='".intval($filter_id)."' AND item_id='".intval($value)."')";
                         
                     } 
                   
                 }            
            
             }elseif($getFilter->view == "input"){

                $flCount++;
                if($nested["from"] && $nested["to"]){
                    $flQuery[$filter_id][] = "(filter_id='".intval($filter_id)."' AND (value BETWEEN ".($nested["from"] ? round($nested["from"],2) : 0)." AND ".($nested["to"] ? round($nested["to"],2) : 0)."))";
                }elseif($nested["from"]){
                    $flQuery[$filter_id][] = "(filter_id='".intval($filter_id)."' AND value >= ".($nested["from"] ? round($nested["from"],2) : 0).")";
                }elseif($nested["to"]){
                    $flQuery[$filter_id][] = "(filter_id='".intval($filter_id)."' AND value <= ".($nested["to"] ? round($nested["to"],2) : 0).")";
                }

             }elseif($getFilter->view == "input_text"){

                $flCount++;
                $flQuery[$filter_id][] = "(filter_id='".intval($filter_id)."' AND value = '".$nested[0]."')";

             }

             if($flQuery[$filter_id]){
                $flQueryResult[] = implode(" OR ",$flQuery[$filter_id]);
             }    

           }       
      
       }            

    }

    if($flQueryResult){

         $getItemsIdsFilter = $app->model->ads_filters_ids->getItemsIdsFilter("(".implode(" OR ", $flQueryResult).") GROUP BY ad_id HAVING cnt >= ".$flCount);

         if($getItemsIdsFilter){
             foreach ($getItemsIdsFilter as $value) {
                $ids[$value["ad_id"]] = $value["ad_id"];
             }
         }

         if(!$ids){
            return [];
         }

    }

    if($request["city_districts"] && $request["city_metro"]){
        if($districts_ids && $metro_ids){
            $query[] = 'id IN('.implode(",", $ids).')';
        }else{
            return [];
        }
    }elseif($request["city_districts"]){
        if($districts_ids){
            $query[] = 'id IN('.implode(",", $ids).')';
        }else{
            return [];
        }
    }elseif($request["city_metro"]){
        if($metro_ids){
            $query[] = 'id IN('.implode(",", $ids).')';
        }else{
            return [];
        }
    }elseif($ids){
        $query[] = 'id IN('.implode(",", $ids).')';
    }

    if($ids_not){
        $query[] = 'id NOT IN('.implode(",", $ids_not).')';
    }

    return ["query"=>implode(" and ", $query), "params"=>$params];

}

public function currentAliases(){
    global $app;

    $request = $app->session->get("request-catalog");

    $geo = $app->session->get("geo");

    if($request){

        return outLink($request->uri);

    }else{

        if($geo){
            return outLink($geo->alias);
        }else{
            return outLink('all');
        }

    }

}

public function getViewItems($category_id=0){
    global $app;

    if($app->session->get("item-view")){
        return $app->session->get("item-view");
    }else{

        if($app->component->ads_categories->categories[$category_id]["default_view_items_catalog"]){
            return $app->component->ads_categories->categories[$category_id]["default_view_items_catalog"];
        }

    }

    return $app->settings->board_catalog_ad_view ?: "grid";

}

public function outBreadcrumb(){
    global $app;

    $result = '';
    $position = 2;

    if($this->data->category){
        foreach ($this->data->category->chain->chain_array as $value) {
       
            $result .= '
                <li class="breadcrumb-item" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                  <a itemprop="item" href="'.$app->component->ads_categories->buildAliases($value).'"><span itemprop="name">'.translateFieldReplace($value, "name").'</span></a><meta itemprop="position" content="'.$position.'">
                </li>
            ';

            $position++;
        }
    }

    if($this->data->filter_link){
        $result .= '
            <li class="breadcrumb-item" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"><span itemprop="name">'.translateFieldReplace($this->data->filter_link, "name").'</span><meta itemprop="position" content="'.$position.'"></li>
        ';
    }

    return $result;

}

public function outLinkMap(){
    global $app;

    $params = getRequestParams();
    $geo = $app->session->get("geo");

    if($geo){

        if($params){
            return outRoute("search-by-map") . '/' . $geo->alias . "?" . $params;
        }elseif($this->data->category){
            return outRoute("search-by-map") . '/' . $geo->alias . "?c_id=" . $this->data->category->id;
        }else{
            return outRoute("search-by-map") . '/' . $geo->alias;
        }

    }else{

        if($params){
            return outRoute("search-by-map") . "?" . $params;
        }elseif($this->data->category){
            return outRoute("search-by-map") . "?c_id=" . $this->data->category->id;
        }else{
            return outRoute("search-by-map");
        }

    }

}

public function outLinkSorting(){
  global $app;

   if($_GET["sort"] == "news"){
      $name = translate("tr_2ebf5bc73c343c4a3432e2830fc2305a");
   }elseif($_GET["sort"] == "price_asc"){
      $name = translate("tr_bb83caef0c698fbb9281ce5c1aa8b4fb");
   }elseif($_GET["sort"] == "price_desc"){
      $name = translate("tr_4bc6552ecd53b60e5ad26be683b25d56");
   }else{
      $name = translate("tr_2ebf5bc73c343c4a3432e2830fc2305a");
   }

  return '
     <div class="uni-dropdown" >
        <span class="uni-dropdown-name"> <span>'.$name.'</span> <i class="ti ti-chevron-down"></i></span>  
        <div class="uni-dropdown-content uni-dropdown-content-align-right" >
         <a href="'.requestBuildVars(["sort"=>"news"]).'" class="uni-dropdown-content-item" >'.translate("tr_2ebf5bc73c343c4a3432e2830fc2305a").'</a>
         <a href="'.requestBuildVars(["sort"=>"price_asc"]).'" class="uni-dropdown-content-item" >'.translate("tr_bb83caef0c698fbb9281ce5c1aa8b4fb").'</a>
         <a href="'.requestBuildVars(["sort"=>"price_desc"]).'" class="uni-dropdown-content-item" >'.translate("tr_4bc6552ecd53b60e5ad26be683b25d56").'</a>
        </div>               
     </div>
     ';

}

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

public function outStories(){
    global $app;

    $geo = $app->session->get("geo");

    ?>

    <section class="widget-stories-container user-stories-swiper mt15" >
       <div class="swiper-wrapper" >
            <?php echo $app->component->stories->outUsersStoriesInCatalog($this->data->category->id, $geo->city_id); ?>
       </div>
    </section>

    <?php

}

public function requestData($main_request=null){
    global $app;

    $data = [];
    $pattern = [];

    $main_request_array = explode("/", trim($main_request, "/"));

    if($app->translate->getChangeLang() == $main_request_array[0]){
        unset($main_request_array[0]);
        $main_request_array = array_values($main_request_array);
    }

    if($app->settings->active_countries){

        if($app->component->geo->statusMultiCountries()){

            $data["country"] = $app->model->geo_countries->find("alias=? and status=?", [$main_request_array[0],1]);
            if($data["country"]){

                unset($main_request_array[0]);

                $main_request_array = array_values($main_request_array);

                $cond_country = "and country_id IN(".$data["country"]->id.")";

            }else{
                abort(404);
            }

        }else{

            if($main_request_array[0] == "all"){
                unset($main_request_array[0]);
            }

            $cond_country = "and country_id IN(".implode(",",$app->settings->active_countries).")";

        }

        if($main_request_array){

            $data["category"] = $app->component->ads_categories->checkCategoriesByAliasCatalog($main_request_array);

            if(!$data["category"]){

                $last = end($main_request_array);

                $getFilterLinks = $app->model->ads_filters_links->getAll('alias=?', [$last]);
                if($getFilterLinks){
                    foreach ($getFilterLinks as $key => $value) {
                        if(strpos($main_request, $value["full_aliases"]) !== false){
                            $data["filter_link"] = (object)$value;
                            break;
                        }
                    }
                }

                if($data["filter_link"]){

                    $data["category"] = $app->component->ads_categories->checkCategoriesByIdCatalog($data["filter_link"]->category_id);

                    if(!$_GET["filter"]){
                        $this->buildFilterToGet($data["filter_link"]->params);
                    }else{
                        $app->router->goToUrl($app->component->ads_categories->buildAliases((array)$data["category"])."?".http_build_query($_GET));
                    }

                    $request = trim(str_replace($data["filter_link"]->full_aliases, "", implode("/", $main_request_array)), "/");

                    if($request){
                        $request = explode("/", $request);
                     
                        if(count($request) == 1){

                            $data["city"] = $app->model->geo_cities->find("alias=? and status=? $cond_country", [$request[0],1]);
                            if(!$data["city"]){
                                $data["region"] = $app->model->geo_regions->find("alias=? and status=? $cond_country", [$request[0],1]);
                                if(!$data["region"]){
                                    abort(404);
                                }                            
                            }else{
                                if($data["city"]->region_id){
                                    abort(404);
                                }
                            }

                        }elseif(count($request) == 2){

                            $data["region"] = $app->model->geo_regions->find("alias=? and status=? $cond_country", [$request[0],1]);
                            if($data["region"]){
                                $data["city"] = $app->model->geo_cities->find("alias=? and region_id=? and status=? $cond_country", [$request[1],$data["region"]->id,1]);
                                if(!$data["city"]){
                                    abort(404);
                                }
                            }else{
                                abort(404);
                            }

                        }else{
                            abort(404);
                        }
                    }

                }else{

                    if(count($main_request_array) == 1){

                        $data["city"] = $app->model->geo_cities->find("alias=? and status=? $cond_country", [$main_request_array[0],1]);
                        if(!$data["city"]){
                            $data["region"] = $app->model->geo_regions->find("alias=? and status=? $cond_country", [$main_request_array[0],1]);
                            if(!$data["region"]){
                                abort(404);
                            }                            
                        }else{
                            if($data["city"]->region_id){
                                abort(404);
                            }
                        }               

                    }elseif(count($main_request_array) == 2){

                        $data["region"] = $app->model->geo_regions->find("alias=? and status=? $cond_country", [$main_request_array[0],1]);
                        if($data["region"]){ 
                            $data["city"] = $app->model->geo_cities->find("alias=? and region_id=? and status=? $cond_country", [$main_request_array[1],$data["region"]->id,1]);
                            if(!$data["city"]){
                                unset($main_request_array[0]);
                                $data["category"] = $app->component->ads_categories->checkCategoriesByAliasCatalog($main_request_array);
                                if(!$data["category"]){
                                    abort(404);
                                }
                            }
                        }else{
                            $data["city"] = $app->model->geo_cities->find("alias=? and status=? $cond_country", [$main_request_array[0],1]);
                            if($data["city"]){
                                if(!$data["city"]->region_id){
                                    unset($main_request_array[0]);
                                    $data["category"] = $app->component->ads_categories->checkCategoriesByAliasCatalog($main_request_array);
                                    if(!$data["category"]){
                                        abort(404);
                                    }
                                }else{
                                    abort(404);
                                }
                            }else{
                                abort(404);
                            }
                        }        

                    }else{

                        $data["region"] = $app->model->geo_regions->find("alias=? and status=? $cond_country", [$main_request_array[0],1]);
                        if($data["region"]){
                            $data["city"] = $app->model->geo_cities->find("alias=? and region_id=? and status=? $cond_country", [$main_request_array[1],$data["region"]->id,1]);
                            if($data["city"]){
                                unset($main_request_array[0]);
                                unset($main_request_array[1]);
                                $data["category"] = $app->component->ads_categories->checkCategoriesByAliasCatalog($main_request_array);
                                if(!$data["category"]){
                                    abort(404);
                                }
                            }else{
                                unset($main_request_array[0]);
                                $data["category"] = $app->component->ads_categories->checkCategoriesByAliasCatalog($main_request_array);
                                if(!$data["category"]){
                                    abort(404);
                                }
                            }
                        }else{
                            $data["city"] = $app->model->geo_cities->find("alias=? and status=? $cond_country", [$main_request_array[0],1]);
                            if($data["city"]){
                                if(!$data["city"]->region_id){
                                    unset($main_request_array[0]);
                                    $data["category"] = $app->component->ads_categories->checkCategoriesByAliasCatalog($main_request_array);
                                    if(!$data["category"]){
                                        abort(404);
                                    }
                                }else{
                                    abort(404);
                                }
                            }else{
                                abort(404);
                            }
                        }

                    }

                }

            }

        }

        if($data["city"]){
            $app->component->geo->setChange($data["city"]->id, "city");
        }elseif($data["region"]){
            $app->component->geo->setChange($data["region"]->id, "region");
        }elseif($data["country"]){
            $app->component->geo->setChange($data["country"]->id, "country");
        }else{
            $app->component->geo->setChange();
        }

    }else{

        $app->component->geo->setChange();

        if($main_request != "all"){

            $data["filter_link"] = $app->model->ads_filters_links->find('full_aliases=?', [$main_request]);

            if(!$data["filter_link"]){

                $data["category"] = $app->component->ads_categories->checkCategoriesByAliasCatalog($main_request_array);
                if(!$data["category"]){
                    abort(404);
                }

            }else{

                $data["category"] = $app->component->ads_categories->checkCategoriesByIdCatalog($data["filter_link"]->category_id);
                if(!$_GET["filter"]){
                    $this->buildFilterToGet($data["filter_link"]->params);
                }else{
                    $app->router->goToUrl($app->component->ads_categories->buildAliases((array)$data["category"])."?".http_build_query($_GET));
                }                

            }

        }

    }

    $this->data = (object)$data;

    $app->session->setArray("request-catalog", (object)["uri"=>clearRequestURI(), "params"=>getRequestParams(), "category_id"=>$this->data->category ? $this->data->category->id : 0]);

    return $this->data;

}

public function updateCountDisplay($ids=[]){
    global $app;

    if(!isBot(getUserAgent()) && $ids){
        $app->model->ads_data->updateQuery("count_display=count_display+1 where id IN(".implode(",", $ids).")");
    }

}



}