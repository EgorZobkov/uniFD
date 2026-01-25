<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Http\Controllers\Api;

use App\Systems\Controller;

class CatalogController extends Controller {

    public function __construct($app){
        parent::__construct($app); 
    }

    public function getOffers(){

        $result = [];
        $ids = [];

        if($this->api->verificationAuth($_GET['token'], $_GET['user_id'])){

            $data = $this->model->ads_views->sort("time_create desc")->getAll("user_id=?", [$_GET['user_id']]);
            if($data){
                foreach ($data as $key => $value) {
                    $ids[] = $value["ad_id"];
                }
                $getAds = $this->model->ads_data->getAll("id IN(".implode(",", $ids).") and status=?", [1]);
                if($getAds){
                    foreach ($getAds as $key => $value) {
                        $value = $this->component->ads->getDataByValue($value);
                        $result["ads"][] = $this->api->adData($value);
                    }
                }
            }

            $ids = [];

            $data = $this->model->users_favorites->sort("time_create desc")->getAll("user_id=?", [$_GET['user_id']]);
            if($data){
                foreach ($data as $key => $value) {
                    $ids[] = $value["ad_id"];
                }
                $getAds = $this->model->ads_data->getAll("id IN(".implode(",", $ids).") and status=?", [1]);
                if($getAds){
                    foreach ($getAds as $key => $value) {
                        $value = $this->component->ads->getDataByValue($value);
                        $result["favorites"][] = $this->api->adData($value);
                    }
                }
            }

            $data = $this->model->users_searches->sort("time_create desc")->getAll("user_id=?", [$_GET['user_id']]);
            if($data){
                foreach ($data as $key => $value) {

                    $title = "";

                    $params = [];
                    $geo = [];
                    $geo_data = [];
                    $category = [];

                    if($value["category_id"]){
                        $category = $this->component->ads_categories->categories[$value["category_id"]];
                        if($category){
                            $category["chain"] = $this->component->ads_categories->chainCategory($value["category_id"]);
                        }
                    }

                    if($value["city_id"]){
                        $geo = $this->model->geo_cities->find("id=?", [$value["city_id"]]);
                        if($geo){
                            $geo_data = ["geo_name"=>"city", "id"=>$geo->id, "lat"=>$geo->latitude, "lon"=>$geo->longitude, "name"=>translateFieldReplace($geo, "name", $_REQUEST["lang_iso"]), "declension"=>translateFieldReplace($geo, "declension", $_REQUEST["lang_iso"])];
                        }
                    }elseif($value["region_id"]){
                        $geo = $this->model->geo_regions->find("id=?", [$value["region_id"]]);
                        if($geo){
                            $geo_data = ["geo_name"=>"region", "id"=>$geo->id, "name"=>translateFieldReplace($geo, "name", $_REQUEST["lang_iso"]), "declension"=>translateFieldReplace($geo, "declension", $_REQUEST["lang_iso"])];
                        }
                    }elseif($value["country_id"]){
                        $geo = $this->model->geo_countries->find("id=?", [$value["country_id"]]);
                        if($geo){
                            $geo_data = ["geo_name"=>"country", "id"=>$geo->id, "name"=>translateFieldReplace($geo, "name", $_REQUEST["lang_iso"]), "declension"=>translateFieldReplace($geo, "declension", $_REQUEST["lang_iso"])];
                        }
                    }

                    $value["params"] = $value["params"] ? _json_decode($value["params"]) : [];

                    if(!$value["params"]["search"]){
                        $params = $this->api->buildFiltersApp($value["params"]["filter"]);
                    }else{
                        $params["search"] = $value["params"]["search"];
                    }

                    if($category["chain"]){
                      $title = $category["chain"]->chain_build;
                    }elseif($geo){
                      $title = $geo->name;
                    }else{
                      $title = translate("tr_9a73b1e5b44bee481ab175b7e327451e");
                    } 

                    $subtitle = $this->component->catalog->buildChainNamesFilters($value["params"], $geo);

                    $result["searches"][] = [
                        "id"=>$value["id"],
                        "params"=>$params ?: null,
                        "title"=>$title,
                        "subtitle"=>$subtitle ?: translate("tr_ad84f1c208c00f5505b5c3d763962964"),
                        "category"=>$category ? ["id"=>$category["id"], "name"=>translateFieldReplace($category, "name", $_REQUEST["lang_iso"]), "breadcrumb"=>$category["chain"]->chain_build] : null,
                        "geo"=>$geo_data ?: null,
                    ];

                }
            }

        }   

        $ids = [];   

        $data = $this->model->ads_categories->sort("sorting asc")->getAll("parent_id=? and status=?", [0,1]);
        if($data){
            foreach ($data as $key => $value) {

                $result["categories"][] = $this->api->categoriesData($value);

            }
        }

        $data = $this->model->shops->sort("id desc limit 50")->getAll("status=?", ["published"]);
        if($data){
            shuffle($data); 
            foreach ($data as $key => $value) {

                $result["shops"][] = $this->api->shopData($value);

            }
        }

        return json_answer(["ads"=>$result["ads"] ?: null, "shops"=>$result["shops"] ?: null, "categories"=>$result["categories"] ?: null, "favorites"=>$result["favorites"] ?: null, "searches"=>$result["searches"] ?: null]);

    }

    public function searchItems(){

        $result = [];
        $answer = '';
        $words = [];

        $session_id = $_GET["session_id"];

        $real_query = $_GET["query"];
        $data = $this->component->search->splitKeywords($_GET["query"]);

        $query = $data["query"];

        $keywords["query"][] = 'name LIKE ?';
        $keywords["params"][] = '%'.$query.'%';

        if($data["split"]){

            foreach ($data["split"] as $key => $value) {
                if(mb_strlen(trim($value), "UTF-8") > 1){
                    $words[] = trim($value);
                }
            }

            if(count($words) == 1){

                $keywords["query"][] = "(name LIKE ? or tags LIKE ?)";
                $keywords["params"][] = '%'.$words[0].'%';
                $keywords["params"][] = '%'.$words[0].'%';

            }elseif(count($words) == 2){
              
                $keywords["query"][] = "(name LIKE ? and name LIKE ?) or (tags LIKE ? and tags LIKE ?)";
                $keywords["params"][] = '%'.$words[0].'%';
                $keywords["params"][] = '%'.$words[1].'%';
                $keywords["params"][] = '%'.$words[0].'%';
                $keywords["params"][] = '%'.$words[1].'%';

            }elseif(count($words) == 3){
                
                $keywords["query"][] = "(name LIKE ? and name LIKE ? and name LIKE ?) or (tags LIKE ? and tags LIKE ? and tags LIKE ?)";
                $keywords["params"][] = '%'.$words[0].'%';
                $keywords["params"][] = '%'.$words[1].'%';
                $keywords["params"][] = '%'.$words[2].'%';
                $keywords["params"][] = '%'.$words[0].'%';
                $keywords["params"][] = '%'.$words[1].'%';
                $keywords["params"][] = '%'.$words[2].'%';

            }elseif(count($words) == 4){
                
                $keywords["query"][] = "(name LIKE ? and name LIKE ? and name LIKE ? and name LIKE ?) or (tags LIKE ? and tags LIKE ? and tags LIKE ? and tags LIKE ?)";
                $keywords["params"][] = '%'.$words[0].'%';
                $keywords["params"][] = '%'.$words[1].'%';
                $keywords["params"][] = '%'.$words[2].'%';
                $keywords["params"][] = '%'.$words[3].'%';
                $keywords["params"][] = '%'.$words[0].'%';
                $keywords["params"][] = '%'.$words[1].'%';
                $keywords["params"][] = '%'.$words[2].'%';
                $keywords["params"][] = '%'.$words[3].'%';

            }elseif(count($words) == 5){
                
                $keywords["query"][] = "(name LIKE ? and name LIKE ? and name LIKE ? and name LIKE ? and name LIKE ?) or (tags LIKE ? and tags LIKE ? and tags LIKE ? and tags LIKE ? and tags LIKE ?)";
                $keywords["params"][] = '%'.$words[0].'%';
                $keywords["params"][] = '%'.$words[1].'%';
                $keywords["params"][] = '%'.$words[2].'%';
                $keywords["params"][] = '%'.$words[3].'%';
                $keywords["params"][] = '%'.$words[4].'%';
                $keywords["params"][] = '%'.$words[0].'%';
                $keywords["params"][] = '%'.$words[1].'%';
                $keywords["params"][] = '%'.$words[2].'%';
                $keywords["params"][] = '%'.$words[3].'%';
                $keywords["params"][] = '%'.$words[4].'%';

            }elseif(count($words) == 6){
                
                $keywords["query"][] = "(name LIKE ? and name LIKE ? and name LIKE ? and name LIKE ? and name LIKE ? and name LIKE ?) or (tags LIKE ? and tags LIKE ? and tags LIKE ? and tags LIKE ? and tags LIKE ? and tags LIKE ?)";
                $keywords["params"][] = '%'.$words[0].'%';
                $keywords["params"][] = '%'.$words[1].'%';
                $keywords["params"][] = '%'.$words[2].'%';
                $keywords["params"][] = '%'.$words[3].'%';
                $keywords["params"][] = '%'.$words[4].'%';
                $keywords["params"][] = '%'.$words[5].'%';
                $keywords["params"][] = '%'.$words[0].'%';
                $keywords["params"][] = '%'.$words[1].'%';
                $keywords["params"][] = '%'.$words[2].'%';
                $keywords["params"][] = '%'.$words[3].'%';
                $keywords["params"][] = '%'.$words[4].'%';
                $keywords["params"][] = '%'.$words[5].'%';

            }

        }

        if(compareValues($this->settings->search_allowed_tables, "keywords")){

            $searchKeywords = $this->model->search_keywords->getAll(implode(" or ", $keywords["query"])." limit 50", $keywords["params"]);

            if($searchKeywords){
                foreach ($searchKeywords as $key => $value) {

                    if($value["goal_type"] == 2){
                        $category = $this->component->ads_categories->categories[$value["category_id"]];
                        $result["keywords"][] = ["title"=>translateFieldReplace($value, "name", $_REQUEST["lang_iso"]), "subtitle"=>null, "cat_id"=>$value["category_id"], "cat_name"=>translateFieldReplace($category, "name", $_REQUEST["lang_iso"]), "params"=>null];
                    }elseif($value["goal_type"] == 3){
                        $category = $this->component->ads_categories->categories[$value["category_id"]];
                        $result["keywords"][] = ["title"=>translateFieldReplace($value, "name", $_REQUEST["lang_iso"]), "subtitle"=>null, "cat_id"=>$value["category_id"], "cat_name"=>translateFieldReplace($category, "name", $_REQUEST["lang_iso"]), "params"=>null];
                    }
            
                }
            }

        }

        // if(compareValues($this->settings->search_allowed_tables, "filters")){

        //     $itemQuery = $this->component->search->buildKeywordsFields($data["split"], ["name"]);

        //     $itemQuery["query"] = "(".$itemQuery["query"].") limit 10";

        //     $searchFiltersLink = $this->model->ads_filters_links->getAll($itemQuery["query"], $itemQuery["params"]);

        //     if($searchFiltersLink){
        //         foreach ($searchFiltersLink as $key => $value) {

        //             $params = [];

        //             if($value["params"]){
        //                 parse_str($value["params"], $filters_params);
        //                 if ($filters_params) {
        //                     foreach ($filters_params['filter'] as $filter_id => $nested) {
        //                         foreach ($nested as $item_id) {
        //                             $filter_item = $this->model->ads_filters_items->find("id=?", [$item_id]);
        //                             $params[] = ["filterId"=>(string)$filter_id, "item"=>(string)$item_id, "name"=>(string)$filter_item->name];
        //                         }
        //                     }
        //                 }
        //             }

        //             $result["filters"][] = ["title"=>translateFieldReplace($value, "name"), "params"=>$params ?: null];
        //         }
        //     }

        // }

        if(compareValues($this->settings->search_allowed_tables, "shops")){

            if($this->settings->search_allowed_text){
                $itemQuery = $this->component->search->buildKeywordsFields($data["split"], ["title", "text"]);
            }else{
                $itemQuery = $this->component->search->buildKeywordsFields($data["split"], ["title"]);
            }

            $itemQuery["query"] = "(".$itemQuery["query"].") and status=? limit 10";
            $itemQuery["params"][] = 'published';

            $searchShops = $this->model->shops->getAll($itemQuery["query"], $itemQuery["params"]);

            if($searchShops){
                foreach ($searchShops as $key => $value) {
                    $result["shops"][] = ["title"=>$value["title"], "subtitle"=>translate("tr_8b1d96f8de04890d0139a4ced65111b8"), "id"=>$value["id"], "logo"=>$this->storage->name($value["image"])->host(true)->get()];
                }            
            }

        }

        if(compareValues($this->settings->search_allowed_tables, "ads")){

            if($this->settings->search_allowed_text){
                $itemQuery = $this->component->search->buildKeywordsFields($data["split"], ["search_tags", "title", "text", "article_number"]);
            }else{
                $itemQuery = $this->component->search->buildKeywordsFields($data["split"], ["search_tags", "title", "article_number"]);
            }

            $itemQuery["query"] = "((".$itemQuery["query"].") or title LIKE ?) and status=? limit 10";
            $itemQuery["params"][] = "%".$real_query."%";
            $itemQuery["params"][] = 1;

            $searchItems = $this->model->ads_data->getAll($itemQuery["query"], $itemQuery["params"]);

            if($searchItems){
                foreach ($searchItems as $key => $value) {
                    $value = $this->component->ads->getDataByValue($value);
                    $result["ads"][] = ["title"=>$value->title, "image"=>$value->media->images->first, "price"=>$this->api->price(["ad"=>$value]), "subtitle"=>translate("tr_a8017171f9cfb1e5367ef6d7ae6a8e9d"), "id"=>$value->id];
                } 
            }

        }

        return json_answer(["status"=>true, "data"=>$result]);

    }

    public function getAds(){

        $result = [];
        $params = [];
        $ids = [];

        $page = (int)$_GET["page"] ? (int)$_GET["page"] : 1;

        $params["filter"] = $_GET["filters"] ? $this->api->normalizedFiltersCatalogArray(_json_decode(html_entity_decode($_GET["filters"]))) : [];

        if($_GET["search"]){
            $params["search"] = $_GET["search"];
        }

        $price_from = $_GET["price_from"];
        $price_to = $_GET["price_to"];

        $urgently = $_GET["urgently"] ? true : false;
        $delivery_status = $_GET["delivery_status"] ? true : false;
        $condition_new_status = $_GET["condition_new_status"] ? true : false;
        $condition_brand_status = $_GET["condition_brand_status"] ? true : false;
        $booking_status = $_GET["booking_status"] ? true : false;

        if($price_from){
            $params["filter"]["price_from"] = $price_from;
        }

        if($price_to){
            $params["filter"]["price_to"] = $price_to;
        }

        if($urgently){
            $params["filter"]["switch"]["urgently"] = true;
        }

        if($delivery_status){
            $params["filter"]["switch"]["delivery"] = true;
        }

        if($condition_new_status){
            $params["filter"]["switch"]["only_new"] = true;
        }

        if($condition_brand_status){
            $params["filter"]["switch"]["only_brand"] = true;
        }

        if($_GET["calendar_date_start"]){
            $params["filter"]["calendar_date_start"] = $_GET["calendar_date_start"];
        }

        if($_GET["calendar_date_end"]){
            $params["filter"]["calendar_date_end"] = $_GET["calendar_date_end"];
        }

        if($_GET["sorting"] == "news"){
            $sort = 'id desc';
        }elseif($_GET["sorting"] == "price_asc"){
            $sort = 'price asc';
        }elseif($_GET["sorting"] == "price_desc"){
            $sort = 'price desc';
        }else{
            $sort = 'time_sorting desc';
        }

        $geoObj = (object)["city_id"=>(int)$_GET["city_id"], "region_id"=>(int)$_GET["region_id"], "country_id"=>(int)$_GET["country_id"]];

        $build = $this->component->catalog->buildQuery($params, (int)$_GET["cat_id"], $geoObj);

        if($build){
            $data = $this->model->ads_data->pagination(true)->page($page)->output(50)->sort($sort)->getAll($build["query"], $build["params"]);
        } 

        if($data){

            foreach ($data as $key => $value) {

                $value = $this->component->ads->getDataByValue($value);

                $ids[] = $value->id;

                $result[] = $this->api->adData($value);

            }

            $this->component->catalog->updateCountDisplay($ids);

        }

        return json_answer(["data"=>$result, "count"=>$this->pagination->totalItems . ' ' . endingWord($this->pagination->totalItems, translate("tr_9d928c2189f3ae48a5f8564491674a93"), translate("tr_d698d30efcc1e36c5ad2ded581b2f8ee"), translate("tr_6c851bdebb2c3d43cc0a06bc61fef96d")), "pages"=>$this->pagination->totalPages, "advertisement"=>null]);

    }

    public function getSnippets(){
        
        $result = [];

        $category_id = (int)$_GET["cat_id"];
        $city_id = (int)$_GET["city_id"]; 
        $region_id = (int)$_GET["region_id"]; 
        $country_id = (int)$_GET["country_id"]; 

        $price_from = $_GET["price_from"];
        $price_to = $_GET["price_to"];

        $urgently = $_GET["urgently"] ? true : false;
        $delivery_status = $_GET["delivery_status"] ? true : false;
        $condition_new_status = $_GET["condition_new_status"] ? true : false;
        $condition_brand_status = $_GET["condition_brand_status"] ? true : false;
        $booking_status = $_GET["booking_status"] ? true : false;

        $calendar_date_start = $_GET["calendar_date_start"];
        $calendar_date_end = $_GET["calendar_date_end"];

    
        $category = $this->model->ads_categories->find("id=? and status=?", [$category_id, 1]);

        if($category){
            $result[] = ["name"=>translateFieldReplace($category, "name", $_REQUEST["lang_iso"]), "code"=>"category", "id"=>$category_id];
        }else{
            $result[] = ["name"=>translate("tr_6926e02be4135897ae84b36941554684"), "code"=>"category", "id"=>null];
        }

        if($price_from && $price_to){
            $result[] = ["name"=>translate("tr_50b6450b4c1ce87e8874b0fa6879381d").' '.$this->system->amount($price_from).' '.translate("tr_538dc63d3c6db1a1839cafbaf359799b").' '.$this->system->amount($price_to), "code"=>"price"];
        }elseif($price_from){
            $result[] = ["name"=>translate("tr_50b6450b4c1ce87e8874b0fa6879381d").' '.$this->system->amount($price_from), "code"=>"price"];
        }elseif($price_to){
            $result[] = ["name"=>translate("tr_1a0628dfe431c9d920bc2fc206d16216").' '.$this->system->amount($price_to), "code"=>"price"];
        }

        if($urgently){
            $result[] = ["name"=>translate("tr_bb71eea68aa45f860d272c59eb48a5d4"), "code"=>"urgently"];
        }

        if($delivery_status){
            $result[] = ["name"=>translate("tr_7d385c05a88aa250fc72ebcc783c5991"), "code"=>"delivery_status"];
        }

        if($condition_new_status){
            $result[] = ["name"=>translate("tr_7a3bd05f21cc1e4c20c5e132bc6f65ad"), "code"=>"condition_new_status"];
        }

        if($condition_brand_status){
            $result[] = ["name"=>translate("tr_20f93ff4a64889c679136ecc86ac912e"), "code"=>"condition_brand_status"];
        }

        if($category){

            if($category->booking_status){

              if($category->booking_action == "booking"){

                if($booking_status){
                    $result[] = ["name"=>translate("tr_63783067211bb3ccaeef2b6a42c8cb8a"), "code"=>"booking_status"];
                }

                if($calendar_date_start){
                    if($calendar_date_start && $calendar_date_end){
                        $result[] = ["name"=>translate("tr_c6b97b4d41831884b043705743050140").' '.date("d.m.Y", strtotime($calendar_date_start)).' '.translate("tr_22d57c9399ca22ffbe414f057e8ff6dc").' '.date("d.m.Y", strtotime($calendar_date_end)), "code"=>"booking_date"];
                    }elseif($calendar_date_start){
                        $result[] = ["name"=>translate("tr_bc0e23f5ccdb046d3341d5ccf47e7159").' '.date("d.m.Y", strtotime($calendar_date_start)), 'code'=>'booking_date'];
                    }
                }

              }else{

                if($booking_status){
                    $result[] = ["name"=>translate("tr_4cde4557d1ec234515bdadfbbde9050a"), "code"=>"booking_status"];
                }

                if($calendar_date_start){
                    if($calendar_date_start && $calendar_date_end){
                        $result[] = ["name"=>translate("tr_ac5234c05b30480182b828921bd868da").' '.date("d.m.Y", strtotime($calendar_date_start)).' '.translate("tr_22d57c9399ca22ffbe414f057e8ff6dc").' '.date("d.m.Y", strtotime($calendar_date_end)), "code"=>"booking_date"];
                    }elseif($calendar_date_start){
                        $result[] = ["name"=>translate("tr_9f0bba0dacad1eacd3a9fcd80e8bd00a").' '.date("d.m.Y", strtotime($calendar_date_start)), "code"=>"booking_date"];
                    }
                }

              }

            }

        }

        return json_answer(["data"=>$result ?: null]);

    }

    public function getCategories(){

        $result = [];
        $parent_id = 0;
        $main_parent_id = 0;
        $main_parent_name = "";
        $nested = false;

        if(intval($_GET['id'])){

            $main_parent_id = $this->component->ads_categories->categories[intval($_GET['id'])]["parent_id"] ?: intval($_GET['id']);
            $main_parent_name = $this->component->ads_categories->categories[$main_parent_id]["name"];

            $category = $this->model->ads_categories->find("parent_id=? and status=?", [intval($_GET['id']),1]);

            if($category){

                $subcategory = true;
                $nested = true;

                $parent_id = $this->component->ads_categories->categories[intval($_GET['id'])]["parent_id"];
                $parent_name = $this->component->ads_categories->categories[$parent_id]["name"];    

                $data = $this->model->ads_categories->getAll("status=? and parent_id=?", [1, intval($_GET['id'])]);

            }else{

                $data_subcategory = $this->model->ads_categories->find("id=? and status=?", [$this->component->ads_categories->categories[intval($_GET['id'])]["parent_id"],1]);

                if($data_subcategory){
                    $parent_id = $this->component->ads_categories->categories[$data_subcategory->id]["parent_id"];
                    $parent_name = $this->component->ads_categories->categories[$parent_id]["name"];                    
                }else{
                    $parent_id = $this->component->ads_categories->categories[intval($_GET['id'])]["parent_id"];
                    $parent_name = $this->component->ads_categories->categories[$parent_id]["name"];                    
                }

                $subcategory = $data_subcategory ? true : false;

                $data = $this->model->ads_categories->getAll("status=? and parent_id=?", [1, $this->component->ads_categories->categories[intval($_GET['id'])]["parent_id"]]);

            }

            if($nested){
                $parent_breadcrumb = $this->component->ads_categories->getBuildNameChain($this->component->ads_categories->getParentsId(intval($_GET['id'])));
            }else{
                $parent_breadcrumb = $this->component->ads_categories->getBuildNameChain($this->component->ads_categories->getParentsId($main_parent_id));
            }

        }else{

            $data = $this->model->ads_categories->getAll("status=? and parent_id=?", [1,0]);
            $subcategory = false;
            $parent_id = 0;
            $parent_name = null;

        }

        if($data){

            foreach ($data as $key => $value) {

                $parent = $this->model->ads_categories->find("parent_id=? and status=?", [$value["id"],1]);

                $breadcrumb = $this->component->ads_categories->getBuildNameChain($this->component->ads_categories->getParentsId($value["id"]));

                $result[] = [
                    "id"=>(int)$value["id"],
                    "name"=>translateFieldReplace($value, "name", $_REQUEST["lang_iso"]),
                    "image"=>$this->storage->name($value["image"])->exist() ? $this->storage->name($value["image"])->host(true)->get() : null,
                    "parent_id"=>(int)$value["parent_id"],
                    "subcategory"=>$parent ? true : false,
                    "parent_name"=>$value["parent_id"] ? translateFieldReplace($this->component->ads_categories->categories[$value["parent_id"]], "name", $_REQUEST["lang_iso"]) : null,
                    "breadcrumb"=>$breadcrumb,
                ];

            }

        }

        return json_answer(["data"=>$result, "parent_name"=>$parent_name ?: null, "parent_id"=>intval($parent_id), "subcategory"=>$subcategory, "breadcrumb"=>$parent_breadcrumb ?: null, "nested"=>$nested, "main_parent_id"=>$main_parent_id, "main_parent_name"=>$main_parent_name ?: null]);

    }

    public function saveSearch(){

        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $result = $this->api->saveCatalogSearch($_POST, $_POST['user_id']);

        return json_answer(["status"=>true, "auth"=>true, "answer"=>$result["answer"]]);

    }

    public function getAdsMap(){

        $data = [];
        $result = [];
        $params = [];
        $geoObj = [];
        $ids = [];
        
        $topLeft = $_GET["top_left"];
        $topRight = $_GET["top_right"];
        $bottomLeft = $_GET["bottom_left"];
        $bottomRight = $_GET["bottom_right"];

        $params["filter"] = $_GET["filters"] ? $this->api->normalizedFiltersCatalogArray(_json_decode(html_entity_decode($_GET["filters"]))) : [];

        if($_GET["search"]){
            $params["search"] = $_GET["search"];
        }

        $price_from = $_GET["price_from"];
        $price_to = $_GET["price_to"];

        $urgently = $_GET["urgently"] ? true : false;
        $delivery_status = $_GET["delivery_status"] ? true : false;
        $condition_new_status = $_GET["condition_new_status"] ? true : false;
        $condition_brand_status = $_GET["condition_brand_status"] ? true : false;
        $booking_status = $_GET["booking_status"] ? true : false;

        if($price_from){
            $params["filter"]["price_from"] = $price_from;
        }

        if($price_to){
            $params["filter"]["price_to"] = $price_to;
        }

        if($urgently){
            $params["filter"]["switch"]["urgently"] = true;
        }

        if($delivery_status){
            $params["filter"]["switch"]["delivery"] = true;
        }

        if($condition_new_status){
            $params["filter"]["switch"]["only_new"] = true;
        }

        if($condition_brand_status){
            $params["filter"]["switch"]["only_brand"] = true;
        }

        if($_GET["calendar_date_start"]){
            $params["filter"]["calendar_date_start"] = $_GET["calendar_date_start"];
        }

        if($_GET["calendar_date_end"]){
            $params["filter"]["calendar_date_end"] = $_GET["calendar_date_end"];
        }

        if($_GET["sorting"] == "news"){
            $sort = 'id desc';
        }elseif($_GET["sorting"] == "price_asc"){
            $sort = 'price asc';
        }elseif($_GET["sorting"] == "price_desc"){
            $sort = 'price desc';
        }else{
            $sort = 'time_sorting desc';
        }

        $build = $this->component->catalog->buildQuery($params, (int)$_GET["cat_id"], $geoObj);

        if($build){

            if($topLeft && $topRight && $bottomLeft && $bottomRight){

                $build["query"] = $build["query"] . " and " . "(((address_latitude < ? and address_longitude < ?) and (address_latitude > ? and address_longitude > ?)) or ((geo_latitude < ? and geo_longitude < ?) and (geo_latitude > ? and geo_longitude > ?)))";
                
                $build["params"][] = $topLeft;     
                $build["params"][] = $topRight;
                $build["params"][] = $bottomLeft;
                $build["params"][] = $bottomRight;
                $build["params"][] = $topLeft;     
                $build["params"][] = $topRight;
                $build["params"][] = $bottomLeft;
                $build["params"][] = $bottomRight;

                $data = $this->model->ads_data->sort($sort)->getAll($build["query"], $build["params"]);

            }

        } 

        if($data){

            foreach ($data as $key => $value) {

                $ids[] = $value["id"];

                $lat = "";
                $lon = "";

                if($value["address_latitude"] || $value["geo_latitude"]){
                    $lat = $value["address_latitude"] ? $value["address_latitude"] : $value["geo_latitude"];
                }

                if($value["address_longitude"] || $value["geo_longitude"]){
                    $lon = $value["address_longitude"] ? $value["address_longitude"] : $value["geo_longitude"];
                }

                $media = $this->component->ads->getMedia($value["media"]);

                $user = $this->model->users->find("id=?", [$value['user_id']]);

                $geo = $this->model->geo_cities->find("id=?", [$value['city_id']]);

                $result[] =  [
                    "id"=>$value["id"],
                    "title"=>html_entity_decode($value["title"]),
                    "price"=>$this->api->price(["ad"=>$value]),
                    "city"=>$geo ? $geo->name : null,
                    "city_area"=>$geo ? $geo->name : null,
                    "time_create"=>$this->datetime->outLastTime($value["time_create"]),
                    "images"=>$media->images->all,
                    "lat"=>$lat ?: null,
                    "lon"=>$lon ?: null,
                    "count_images"=>$media->count,
                    "markers"=>null,
                    "user" => [
                        "id"=>$value['user_id'],
                        "display_name"=>$this->user->name($user),
                        "avatar"=>$this->storage->name($user->avatar)->host(true)->get(),
                    ],                    
                ];

            }

        }

        return json_answer(["data"=>$result, "count"=>count($result) . ' ' . endingWord(count($result), translate("tr_9d928c2189f3ae48a5f8564491674a93"), translate("tr_d698d30efcc1e36c5ad2ded581b2f8ee"), translate("tr_6c851bdebb2c3d43cc0a06bc61fef96d"))]);

    }

    public function getAdsByIds(){

        $result = [];

        if($_GET['ids']){

            $ids = _json_decode(html_entity_decode($_GET['ids']));

            if($ids){
                $data = $this->model->ads_data->getAll("status=? and id IN(".implode(",", $ids).")", [1]);
            }

        }

        if($data){

            foreach ($data as $key => $value) {

                $value = $this->component->ads->getDataByValue($value);

                $result[] = $this->api->adData($value);

            }

        }

        return json_answer(["data"=>$result]);

    }

    public function getAdsByFilters(){

        $result = [];
        $params = [];

        $page = (int)$_GET["page"] ? (int)$_GET["page"] : 1;
        $personal_filter_id = (int)$_GET["personal_filter_id"];

        $getFilterLinks = $this->model->ads_filters_links->find('id=?', [$personal_filter_id]);

        if(!$getFilterLinks){
            return json_answer(null);
        }

        mb_parse_str($getFilterLinks->params, $params);

        if($_GET["sorting"] == "news"){
            $sort = 'id desc';
        }elseif($_GET["sorting"] == "price_asc"){
            $sort = 'price asc';
        }elseif($_GET["sorting"] == "price_desc"){
            $sort = 'price desc';
        }else{
            $sort = 'time_sorting desc';
        }

        $build = $this->component->catalog->buildQuery($params, (int)$getFilterLinks->category_id);

        if($build){
            $data = $this->model->ads_data->pagination(true)->page($page)->output(50)->sort($sort)->getAll($build["query"], $build["params"]);
        } 

        if($data){

            foreach ($data as $key => $value) {

                $value = $this->component->ads->getDataByValue($value);

                $ids[] = $value->id;

                $result[] = $this->api->adData($value);

            }

            $this->component->catalog->updateCountDisplay($ids);

        }

        return json_answer(["data"=>$result, "title"=>translateFieldReplace($getFilterLinks, "name"), "count"=>$this->pagination->totalItems . ' ' . endingWord($this->pagination->totalItems, translate("tr_9d928c2189f3ae48a5f8564491674a93"), translate("tr_d698d30efcc1e36c5ad2ded581b2f8ee"), translate("tr_6c851bdebb2c3d43cc0a06bc61fef96d")), "pages"=>$this->pagination->totalPages, "advertisement"=>null]);

    }

}