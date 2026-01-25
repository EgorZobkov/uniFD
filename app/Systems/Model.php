<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Systems;

class Model
{

    public $paginationStatus = false;

    public function pagination($status=null){
        $this->paginationStatus = $status;
        return $this;
    }

    public function page($page=1){
        $this->page = $page;
        return $this;
    }

    public function output($output=100){
        $this->output = $output?:100;
        return $this;
    }

    public function filter($filter=[]){
        $this->filter = $filter;
        return $this;
    }

    public function cacheKey($key=null){
        $this->cacheKey = $key;
        return $this;
    }

    public function search($search=null, $fields=[]){
        global $app;
        $this->search = $app->clean->str($search);
        $this->searchFields = $fields;
        return $this;
    }

    public function sort($sort=null){
        $this->sort = $sort;
        return $this;
    }

    public function find($conditions=null, $params=[]){
        global $app;
        $result = [];
        $result = $this->getRow($conditions, $params);
        if($result){
            return (object)$result;
        }
        return $result;
    }

    public function insert($params=[]){
        global $app;
        if($params){
            return $app->db->insert($this->table, $params);
        }
        return 0;
    }

    public function update($params=[], $conditionsOrId=null){
        global $app;

        $cacheKey = $this->cacheKey;
        $this->cacheKey(null);

        $app->db->update($this->table, $params, $conditionsOrId);

        if($cacheKey){
            $app->caching->delete($app->caching->buildKey($this->table, $cacheKey));
        }

    }

    public function updateQuery($query=null,$params=[]){
        global $app;
        $app->db->updateQuery($this->table, $query, $params);
    }

    public function delete($conditions=null, $params=[]){
        global $app;

        $cacheKey = $this->cacheKey;
        $this->cacheKey(null);

        $app->db->delete($this->table, $conditions, $params);

        if($cacheKey){
            $app->caching->delete($app->caching->buildKey($this->table, $cacheKey));
        }

    }

    public function truncate(){
        global $app;

        $app->db->truncate($this->table);
    }

    public function count($query=null, $params=[]){
        global $app;
        if(isset($query)){
            return $app->db->count($this->table, $query, $params);
        }else{
            return $app->db->count($this->table);
        }
    }

    public function getRow($conditions=null, $params=[]){
        global $app;

        $sort = '';
        $result = [];

        $cacheKey = $this->cacheKey;
        $this->cacheKey(null);
        
        if(isset($this->sort)){
            $sort = " order by " . $this->sort;
            $this->sort(null);
        }

        if($cacheKey){

            $key = $app->caching->buildKey($this->table, $cacheKey);

            if($app->caching->get($key)){ 
               return $app->caching->get($key);
            }

            if(isset($conditions)){
                $result = $app->db->getRow("select * from `".$this->table."` where $conditions $sort", $params);
                if($result){
                    $app->caching->set($key,$result);
                }
                return $result;
            }

        }

        if(isset($conditions)){
            $result = $app->db->getRow("select * from `".$this->table."` where $conditions $sort", $params);
        }

        return $result;

    }

    public function findById($id=0){
        global $app;
        return $this->find('id=?', [$id]);
    }

    public function getAll($conditions=null, $params=[]){
        global $app;

        $sort = '';
        $result = [];
        
        $cacheKey = $this->cacheKey;
        $this->cacheKey(null);

        if(isset($this->sort)){
            $sort = "order by " . $this->sort;
            $this->sort(null);
        }

        if($cacheKey){

            $key = $app->caching->buildKey($this->table, $cacheKey);

            if($app->caching->get($key)){ 
               return $app->caching->get($key);
            }

            $result = $app->db->getAll(isset($conditions) ? "select * from `".$this->table."` where $conditions $sort" : "select * from `".$this->table."` $sort", $params);

            if($result){
                $app->caching->set($key,$result);
            }

            return $result;

        }

        return $app->db->getAll(isset($conditions) ? "select * from `".$this->table."` where $conditions $sort" : "select * from `".$this->table."` $sort", $params);

    }

}