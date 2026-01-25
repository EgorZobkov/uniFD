<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Models;

use App\Systems\Model;

class Reviews extends Model
{

    public $alias = 'reviews';
    public $table = 'uni_reviews';

    public function getAll($conditions=null, $params=[]){
        global $app;

        $query = [];
        $sort = "";

        if(isset($this->sort)){
            $sort = "order by " . $this->sort;
        }

        if(isset($conditions)){
            $query[] = $conditions;
        }

        if($this->search){ 
            $query[] = '(item_id=?)';
            $params[] = $this->search;
        }

        if(isset($this->filter)){

            if(isset($this->filter["status"])){
                $query[] = 'status=?';
                $params[] = $this->filter["status"];
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

        $this->search(null);
        $this->sort(null);
        $this->filter(null);
        $this->pagination(null);

        return $results;

    }

}