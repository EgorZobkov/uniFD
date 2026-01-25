<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Models;

use App\Systems\Model;

class Transactions extends Model
{

    public $alias = 'transactions';
    public $table = 'uni_transactions';

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
            $query[] = '(action_code LIKE ? or order_id LIKE ?)';
            $params[] = '%'.$this->search.'%';
            $params[] = '%'.$this->search.'%';
        }

        if(isset($this->filter)){

            if(isset($this->filter["action_code"])){
                $query[] = 'action_code=?';
                $params[] = $app->clean->str($this->filter["action_code"]);
            }

            if(isset($this->filter["tariff_id"])){
                $query[] = 'tariff_id=?';
                $params[] = $app->clean->int($this->filter["tariff_id"]);
            }

            if(isset($this->filter["status_payment"])){
                $query[] = 'status_payment=?';
                $params[] = $this->filter["status_payment"] == "paid" ? 1 : 0;
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