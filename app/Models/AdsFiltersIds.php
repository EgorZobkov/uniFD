<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Models;

use App\Systems\Model;

class AdsFiltersIds extends Model
{

    public $alias = 'ads_filters_ids';
    public $table = 'uni_ads_filters_ids';

    public function getItemsIdsFilter($query=null){
        global $app;

        $results = [];

        if($query){
            $results = $app->db->getAll("select ad_id, count(ad_id) AS cnt FROM `".$this->table."` where $query");
        }

        return $results;

    }

}