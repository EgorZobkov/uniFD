<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Models;

use App\Systems\Model;

class UsersVerifications extends Model
{

    public $alias = 'users_verifications';
    public $table = 'uni_users_verifications';

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

        if(isset($this->filter)){

            if(isset($this->filter["status"])){
                $query[] = 'status=?';
                $params[] = $this->filter["status"];
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