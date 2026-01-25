<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Http\Controllers\Api;

use App\Systems\Controller;

class ShopsController extends Controller {

    public function __construct($app){
        parent::__construct($app); 
    }

    public function getAllShops(){   

        $result = [];

        $data = $this->model->shops->pagination(true)->page($page)->output(50)->sort("id desc")->getAll("status=?", ["published"]); 

        if($data){

            foreach ($data as $key => $value) {

                $result[] = $this->api->shopData($value);
                
            }

        }

        return json_answer(["data"=>$result, "count"=>$this->pagination->totalItems .' '.endingWord($this->pagination->totalItems, translate("tr_2109cebe4b6728bad380b79a861f184e"), translate("tr_51923c0fdc02c8461fb160918542dca2"), translate("tr_2427780a191ff9299e6767668d3d2150")), "pages"=>$this->pagination->totalPages]);

    }


}