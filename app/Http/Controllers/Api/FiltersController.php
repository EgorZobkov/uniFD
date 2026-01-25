<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Http\Controllers\Api;

use App\Systems\Controller;

class FiltersController extends Controller {

    public function __construct($app){
        parent::__construct($app); 
    }

    public function getOptions(){

        $result = [];

        $change_filters = $_GET["filters"] ? $this->api->normalizedFiltersArray(_json_decode(html_entity_decode($_GET["filters"]))) : [];

        $category_id = (int)$_GET['cat_id'];

        $filters_id = $this->component->ads_filters->getFiltersByCategory($category_id);

        if($this->component->ads_categories->categories[$category_id]["price_name_id"]){
            $systemPrice = $this->model->system_price_names->find("id=?", [$this->component->ads_categories->categories[$category_id]["price_name_id"]]);
            if($systemPrice){
                $result["price_name"] = translateField($systemPrice->name);
            }else{
                $result["price_name"] = translate("tr_682fa8dbadd54fda355b27f124938c93");
            }
        }else{
            $result["price_name"] = translate("tr_682fa8dbadd54fda355b27f124938c93");
        }

        $result["price_status"] = $this->component->ads_categories->categories[$category_id]["price_status"] ? true : false;

        $getCategories = $this->model->ads_categories->getAll("parent_id=? and status=?", [0,1]);
        if($getCategories){
            foreach ($getCategories as $key => $value) {

                $result["categories"][] = $this->api->categoriesData($value);

            }
        }

        $result["options"]["urgently"] = translate("tr_c85cf9e96515efc35d01f5ead5495666");

        if($this->component->ads_categories->categories[$category_id]["delivery_status"]){
            $result['options']['delivery_status'] = translate("tr_7d385c05a88aa250fc72ebcc783c5991");
        }else{
            $result['options']['delivery_status'] = null;
        }

        if($this->component->ads_categories->categories[$category_id]["condition_new_status"]){
            $result['options']['condition_new_status'] = translate("tr_71a1870b0d47ee55459cd727e88b8b8d");
        }else{
            $result['options']['condition_new_status'] = null;
        }

        if($this->component->ads_categories->categories[$category_id]["condition_brand_status"]){
            $result['options']['condition_brand_status'] = translate("tr_3e66cad801646a25439eb6f191565d21");
        }else{
            $result['options']['condition_brand_status'] = null;
        }

        if($this->component->ads_categories->categories[$category_id]["booking_status"]){
            $result['options']['booking_status'] = translate("tr_63783067211bb3ccaeef2b6a42c8cb8a");
        }else{
            $result['options']['booking_status'] = null;
        }

        if($filters_id){

            $filters = $this->component->ads_filters->getFilters();

            $getFilters = $this->model->ads_filters->sort("sorting asc")->getAll("status=? and parent_id=? and id IN(".implode(",", $filters_id).")", [1,0]);

            if($getFilters){

                 foreach ($getFilters as $key => $value) {

                    $items = [];

                    $getItems = $this->model->ads_filters_items->getAll("filter_id=?", [$value["id"]]);

                    if($getItems){

                        foreach ($getItems as $item_value) {
                            $items[] = ["name"=>translateFieldReplace($item_value, "name", $_REQUEST["lang_iso"]), "id"=>$item_value["id"], "podfilter"=>$this->model->ads_filters_items->find("item_parent_id=?", [$item_value["id"]]) ? true : false];
                        }

                    }

                    $ids_podfilter = $this->component->ads_filters->getParentIds($value["id"]);

                    $result["filters"][] = [
                        "id" => $value["id"],
                        "view" => $value["view"],
                        "name" => translateFieldReplace($value, "name", $_REQUEST["lang_iso"]),
                        "ids_podfilter"=> $ids_podfilter ? explode(",", $ids_podfilter) : null,
                        "items" => $items,
                        "required" => $value["required"] ? true : false,
                        "podfilter" => $filters["parent_id"][$value["id"]] ? true : false,
                    ];

                    if($change_filters[$value["id"]]){

                        $parent_filters = $this->api->buildPodfiltersArray($value["id"], $change_filters, $filters);

                        if($parent_filters){
                            $result["filters"] = array_merge($result["filters"], $parent_filters);
                        }

                    }

                 }

            }

        }

        return json_answer(["data"=>$result]);

    }

    public function getAllFilters(){

        $result = [];

        $change_filters = $_GET["filters"] ? $this->api->normalizedFiltersArray(_json_decode(html_entity_decode($_GET["filters"]))) : [];

        $category_id = (int)$_GET['cat_id'];

        $filters_id = $this->component->ads_filters->getFiltersByCategory($category_id);

        if($filters_id){

            $filters = $this->component->ads_filters->getFilters();

            $getFilters = $this->model->ads_filters->sort("sorting asc")->getAll("status=? and parent_id=? and id IN(".implode(",", $filters_id).")", [1,0]);

            if($getFilters){

                 foreach ($getFilters as $key => $value) {

                    $items = [];

                    $getItems = $this->model->ads_filters_items->getAll("filter_id=?", [$value["id"]]);

                    if($getItems){

                        foreach ($getItems as $item_value) {
                            $items[] = ["name"=>translateFieldReplace($item_value, "name", $_REQUEST["lang_iso"]), "id"=>$item_value["id"], "podfilter"=>$this->model->ads_filters_items->find("item_parent_id=?", [$item_value["id"]]) ? true : false];
                        }

                    }

                    $ids_podfilter = $this->component->ads_filters->getParentIds($value["id"]);

                    $result[] = [
                        "id" => $value["id"],
                        "view" => $value["view"],
                        "name" => translateFieldReplace($value, "name", $_REQUEST["lang_iso"]),
                        "ids_podfilter"=> $ids_podfilter ? explode(",", $ids_podfilter) : null,
                        "items" => $items,
                        "required" => $value["required"] ? true : false,
                        "podfilter" => $filters["parent_id"][$value["id"]] ? true : false,
                    ];

                    if($change_filters[$value["id"]]){

                        $parent_filters = $this->api->buildPodfiltersArray($value["id"], $change_filters, $filters);

                        if($parent_filters){ 
                            $result = array_merge($result, $parent_filters);
                        }

                    }

                 }

            }

        }

        return json_answer(["data"=>$result]);

    }

}
