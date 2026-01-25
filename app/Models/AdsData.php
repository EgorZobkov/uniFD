<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Models;

use App\Systems\Model;

class AdsData extends Model
{

    public $alias = 'ads_data';
    public $table = 'uni_ads_data';

    public function geo($params=[]){
        $this->geo = $params;
        return $this;
    }

    public function getAll($conditions=null, $params=[]){
        global $app;

        $query = [];
        $sort = "";
        $results = [];

        if(isset($this->sort)){
            $sort = "order by " . $this->sort;
        }

        if(isset($conditions)){
            $query[] = $conditions;
        }

        if($this->search){
            $query[] = '(search_tags LIKE ? or article_number LIKE ?)';
            $params[] = '%'.$this->search.'%';
            $params[] = '%'.$this->search.'%';
        }

        if(isset($this->geo)){

            if($this->geo->city_id){
                $query[] = 'city_id=?';
                $params[] = $this->geo->city_id;
            }elseif($this->geo->region_id){
                $query[] = 'region_id=?';
                $params[] = $this->geo->region_id;                
            }elseif($this->geo->country_id){
                $query[] = 'country_id=?';
                $params[] = $this->geo->country_id;                
            }

        }

        if(isset($this->filter)){

            if(isset($this->filter["status"])){
                $query[] = 'status=?';
                $params[] = $app->clean->int($this->filter["status"]);
            }

            if(isset($this->filter["category_id"])){
                $query[] = 'category_id=?';
                $params[] = $app->clean->int($this->filter["category_id"]);
            }

            if(isset($this->filter["import_id"])){
                $query[] = 'import_id=?';
                $params[] = $app->clean->int($this->filter["import_id"]);
            }

            if(isset($this->filter["today"])){
                $query[] = 'date(time_create)=?';
                $params[] = $app->datetime->format("Y-m-d")->getDate();
            }

            if($this->filter["date_start"] || $this->filter["date_end"]){
                if($this->filter["date_start"] && $this->filter["date_end"]){
                    $query[] = '(DATE(time_create) BETWEEN ? and ?)';
                    $params[] = $app->clean->str($this->filter["date_start"]);
                    $params[] = $app->clean->str($this->filter["date_end"]);
                }elseif($this->filter["date_start"]){
                    $query[] = 'DATE(time_create)=?';
                    $params[] = $app->clean->str($this->filter["date_start"]);
                }
            }

        }

        if($this->paginationStatus){
            if($query){
               $totalCount = $this->count(implode(" and ", $query), $params);
               $app->pagination->page($this->page)->output($this->output)->total($totalCount)->init();
               $results = $app->db->getAll("select * from `".$this->table."` where ".implode(" and ", $query)." $sort ".$app->pagination->offset(), $params);
            }else{
               $totalCount = $this->count();
               $app->pagination->page($this->page)->output($this->output)->total($totalCount)->init();
               $results = $app->db->getAll("select * from `".$this->table."` $sort ".$app->pagination->offset());
            }
        }else{
            if($query){
               $results = $app->db->getAll("select * from `".$this->table."` where ".implode(" and ", $query)." ".$sort, $params);
            }else{
               $results = $app->db->getAll("select * from `".$this->table."` $sort");
            }
        }

        $this->filter(null);
        $this->geo(null);
        $this->search(null);
        $this->sort(null);
        $this->pagination(null);

        return $results;

    }

}