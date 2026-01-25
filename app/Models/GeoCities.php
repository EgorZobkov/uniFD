<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Models;

use App\Systems\Model;

class GeoCities extends Model
{

    public $alias = 'geo_cities';
    public $table = 'uni_geo_cities';

    public function getAll($conditions=null, $params=[]){
        global $app;

        $query = [];
        $like = [];
        $sort = "";
        $results = [];

        if(isset($this->sort)){
            $sort = "order by " . $this->sort;
        }

        if(isset($conditions)){
            $query[] = $conditions;
        }

        if($this->search){ 
            if($this->searchFields){
                foreach ($this->searchFields as $value) {
                    $like[] = $value . ' LIKE ?';                    
                }

                $query[] = '(' . implode(" or ", $like) . ')';

                foreach ($this->searchFields as $value) {
                    $params[] = $this->search.'%';                 
                }
            }else{
                $query[] = 'name LIKE ?';
                $params[] = $this->search.'%';
            }
        }

        if(isset($this->filter)){

            if(isset($this->filter["region_id"])){
                $query[] = 'region_id=?';
                $params[] = $this->filter["region_id"];
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

        $this->search(null);
        $this->sort(null);
        $this->filter(null);
        $this->pagination(null);

        return $results;

    }

}