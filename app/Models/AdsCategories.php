<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Models;

use App\Systems\Model;

class AdsCategories extends Model
{

    public $alias = 'ads_categories';
    public $table = 'uni_ads_categories';

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
            $query = [];
            $params = [];

            $query[] = '(name LIKE ?)';
            $params[] = '%'.$this->search.'%';
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

            if($this->cacheKey){

                $key = $app->caching->buildKey($this->table, $this->cacheKey);

                if($app->caching->get($key)){ 
                   $results =  $app->caching->get($key);
                }else{
                    if($query){
                       $results = $app->db->getAll("select * from `".$this->table."` where ".implode(" and ", $query)." ".$sort, $params);
                    }else{
                       $results = $app->db->getAll("select * from `".$this->table."` $sort");
                    }
                }

                if($results){
                    $app->caching->set($key,$results);
                }

            }else{

                if($query){
                   $results = $app->db->getAll("select * from `".$this->table."` where ".implode(" and ", $query)." ".$sort, $params);
                }else{
                   $results = $app->db->getAll("select * from `".$this->table."` $sort");
                }

            }

        }

        $this->search(null);
        $this->sort(null);
        $this->filter(null);
        $this->pagination(null);
        $this->cacheKey(null);

        return $results;

    }

}