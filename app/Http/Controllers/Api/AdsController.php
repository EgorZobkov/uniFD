<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Http\Controllers\Api;

use App\Systems\Controller;

class AdsController extends Controller {

    public function __construct($app){
        parent::__construct($app); 
    }

    public function getAllAds(){ 

        $result = [];
        $markers = [];
        $images = [];
        $build_query = [];

        $whom_user_id = (int)$_GET["whom_user_id"];

        $recommendations = $_GET["recommendations"] == 'true' ? true : false;
        $advertisement = $_GET["advertisement"] == 'true' ? true : false;
        $fresh = $_GET["fresh"] == 'true' ? true : false;

        $page = (int)$_GET["page"] ? (int)$_GET["page"] : 1;

        if($recommendations){
            $sort = 'time_sorting desc';
        }elseif($fresh){
            $sort = 'time_create desc';
        }else{
            $sort = 'time_sorting desc';
        }

        if($_GET["search"]){
            $build_query["search"] = $_GET["search"];
        }else{
            $build_query = [];
        }

        if(!$whom_user_id){

            $geoObj = (object)["city_id"=>(int)$_GET["city_id"], "region_id"=>(int)$_GET["region_id"], "country_id"=>(int)$_GET["country_id"]];

            $build = $this->component->catalog->buildQuery($build_query, 0, $geoObj);

            if($build){
                $data = $this->model->ads_data->pagination(true)->page($page)->output(50)->sort($sort)->getAll($build["query"], $build["params"]); 
            }

        }else{
            $data = $this->model->ads_data->pagination(true)->page($page)->output(50)->sort($sort)->getAll("user_id=? and status=?", [$whom_user_id, 1]); 
        }

        if($data){

            foreach ($data as $key => $value) {

                $value = $this->component->ads->getDataByValue($value);

                $result[] = $this->api->adData($value);

            }

        }

        return json_answer(["data"=>$result ?: null, "count"=>$this->pagination->totalItems . ' ' . endingWord($this->pagination->totalItems, translate("tr_9d928c2189f3ae48a5f8564491674a93"), translate("tr_d698d30efcc1e36c5ad2ded581b2f8ee"), translate("tr_6c851bdebb2c3d43cc0a06bc61fef96d")), "pages"=>$this->pagination->totalPages, "advertisement"=>null]);

    }


}