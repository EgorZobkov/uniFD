<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Models;

use App\Systems\Model;

class Users extends Model
{

    public $alias = 'users';
    public $table = 'uni_users';

    public function findByAlias($alias=null, $extra_data=false, $cache=false){
        global $app;

        if($cache){
            $user = $this->cacheKey(["alias"=>$alias])->find("alias=?", [$alias]);
        }else{
            $user = $this->find("alias=?", [$alias]);
        }

        if($user){

            if($extra_data){
                return $app->user->buildData($user);
            }
            
            return $user;

        }else{

            $data = (object)[];
            $get = $app->model->users_delete->find("user_alias=?", [$alias]);
            if($get){
                $data->id = $get->id;
                $data->alias = $get->user_alias;
                $data->full_name = $get->name . '(' . translate("tr_c63e795e61a5d17aa60e8c20b06a6988") . ')';
                $data->name = $get->name . '(' . translate("tr_c63e795e61a5d17aa60e8c20b06a6988") . ')';
                $data->delete = true;
                return $data;
            }

        }

        return [];

    }

    public function findById($id=0, $extra_data=false, $cache=false){
        global $app;

        if($cache){
            $user = $this->cacheKey(["id"=>$id])->find("id=?", [$id]);
        }else{
            $user = $this->find("id=?", [$id]);
        }

        if($user){

            if($extra_data){
                return $app->user->buildData($user);
            }

            return $user;

        }else{

            $data = (object)[];
            $get = $app->model->users_delete->find("user_id=?", [$id]);
            if($get){
                $data->id = $id;
                $data->alias = $get->user_alias;
                $data->full_name = $get->name . '(' . translate("tr_c63e795e61a5d17aa60e8c20b06a6988") . ')';
                $data->name = $get->name . '(' . translate("tr_c63e795e61a5d17aa60e8c20b06a6988") . ')';
                $data->delete = true;
                return $data;
            }

        }

        return [];

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

        if(isset($this->search)){ 
            $query[] = '(name LIKE ? or surname LIKE ? or middlename LIKE ? or email LIKE ? or phone LIKE ? or id = ?)';
            $params[] = '%'.$this->search.'%';
            $params[] = '%'.$this->search.'%';
            $params[] = '%'.$this->search.'%';
            $params[] = '%'.$this->search.'%';
            $params[] = '%'.$this->search.'%';
            $params[] = $this->search;
        }

        if(isset($this->filter)){

            if(isset($this->filter["status"])){
                $query[] = 'status=?';
                $params[] = $this->filter["status"];
            }

            if(isset($this->filter["online"])){
                $query[] = 'unix_timestamp(time_last_activity)+300 > unix_timestamp(?)';
                $params[] = $app->datetime->getDate();
            }

            if(isset($this->filter["only_admin"])){
                $query[] = 'admin=?';
                $params[] = 1;
            }

            if(isset($this->filter["import_id"])){
                $query[] = 'import_id=?';
                $params[] = $app->clean->int($this->filter["import_id"]);
            }

            if($this->filter["date_start"] || $this->filter["date_end"]){
                if($this->filter["date_start"] && $this->filter["date_end"]){
                    $query[] = '(DATE(time_create) BETWEEN ? and ?)';
                    $params[] = $this->filter["date_start"];
                    $params[] = $this->filter["date_end"];
                }elseif($this->filter["date_start"]){
                    $query[] = 'DATE(time_create)=?';
                    $params[] = $this->filter["date_start"];
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