<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Systems;

use Exception;
use RedBeanPHP\R as R;

class Database
{

    public $requests_session = [];

    public function __construct(){

        $config = require BASE_PATH . '/config/db.php';

        R::setup($config["driver"].':host='.$config["host"].';port='.$config["port"].';dbname='.$config["database"],$config["user"], $config["password"]);

        if(!R::testConnection()){
            throw new Exception('Database connection error');
            die();
        }

        R::ext('xdispense', function( $type ){
            return R::getRedBean()->dispense( $type );
        });

        R::exec('SET sql_mode=""',[]);

        R::freeze(true);

        $this->setTimezone();

    }

    public function setTimezone(){
        $timezone = require BASE_PATH . '/config/timezone.php';
        if($this->settings->system_timezone){

          try {
              date_default_timezone_set($timezone[$this->settings->system_timezone]);
              $this->exec("SET time_zone = ?", [$timezone[$this->settings->system_timezone]]);
          } catch(Exception $e) { }

        }
    }

    public function encryptFields($fields=null){
        $this->encryptFields = $fields;
        return $this;
    }

    public function loadAll($table=null,$ids=[]){
        $data = R::loadAll($table, $ids);
        return $data->export();
    }

    public function getAll($query=null,$params=[]){
        $this->requests_session["getAll"][] = $query;
        return R::getAll($query, $params);
    }

    public function getRow($query=null,$params=[]){
        $this->requests_session["getRow"][] = $query;

        if(strpos($query, "limit") !== false){
            return R::getRow("$query", $params);
        }

        return R::getRow("$query limit 1", $params);
    }

    public function getSumByTotal($cell=null, $table=null, $query=null,$params=[]){
        $this->requests_session["getSumByTotal"][] = "SELECT SUM($cell) AS total FROM $table WHERE $query";
        $get = R::getRow("SELECT SUM($cell) AS total FROM $table WHERE $query", $params);
        return $get["total"] ?: 0;
    }

    public function exec($query=null,$params=[]){
        $this->requests_session["exec"][] = $query;
        return R::exec($query, $params);
    }

    public function find($table=null, $query=null, $param=[]){
        $this->requests_session["find"][] = $table . ', ' . $query;
        return R::findOne($table, $query, $param);
    }

    public function load($table=null,$id=0){
        $this->requests_session["load"][] = $table . ', ' . $id;
        return R::load($table, $id);
    }

    public function delete($table=null,$cond=null,$params=[]){
        $this->requests_session["delete"][] = "DELETE FROM {$table} WHERE {$cond}";
        if(isset($table) && isset($cond)){
            static::exec("DELETE FROM {$table} WHERE {$cond}",$params);
        }
    }

    public function truncate($table=null){
        if(isset($table)){
            static::exec("TRUNCATE TABLE `{$table}`");
        }
    }

    public function count($table=null, $query=null, $params=[]){
        $this->requests_session["count"][] = $table . ', ' . $query;
        return R::count($table, $query, $params);
    }

    public function insert($table=null,$params=[]){
        $this->requests_session["insert"][] = $table;
        if(count($params) && isset($table)){
            $data = R::xdispense($table);
            foreach($params as $name => $value){
                if(isset($this->encryptFields)){
                    if(in_array($name, $this->encryptFields)){
                        $value = encrypt($value);
                    }
                    $this->encryptFields(null);
                }
                $data[$name] = $value;
            }
            return R::store($data);
        }
    }

    public function update($table=null,$params=[], $conditionsOrId=null){

        $this->requests_session["update"][] = $table.','._json_encode($params);

        if(count($params) && isset($table) && isset($conditionsOrId)){

            if(is_numeric($conditionsOrId)){

                $fields = [];
                $values = [];

                foreach ($params as $name => $value) {
                    if(isset($this->encryptFields)){
                        if(in_array($name, $this->encryptFields)){
                            $value = encrypt($value);
                        }
                        $this->encryptFields(null);
                    }
                    $fields[] = "`{$name}`=?";
                    $values[] = $value;
                }

                $values[] = $conditionsOrId;

                return $this->exec("UPDATE $table SET ".implode(",",$fields)." WHERE id=?", $values);

            }elseif(is_array($conditionsOrId)){

                $fields = [];
                $values = [];

                foreach ($params as $name => $value) {
                    if(isset($this->encryptFields)){
                        if(in_array($name, $this->encryptFields)){
                            $value = encrypt($value);
                        }
                        $this->encryptFields(null);
                    }
                    $fields[] = "`{$name}`=?";
                    $values[] = $value;
                }

                foreach ($conditionsOrId[1] as $value) {
                    $values[] = $value;
                }

                return $this->exec("UPDATE $table SET ".implode(",",$fields)." WHERE ".$conditionsOrId[0], $values);

            }

        }

    }

    public function updateQuery($table=null,$query=null,$params=[]){
        $this->requests_session["updateQuery"][] = $table . ', ' . $query;
        return $this->exec("UPDATE $table SET ".$query, $params);
    }

    public function genSlots($params=[]){
        return R::genSlots($params);
    }

    public function insertColumnInt($table=null,$column=null){
        $result = $this->exec("SHOW COLUMNS FROM `{$table}` LIKE '{$column}'");
        if(!$result){
            $this->exec("ALTER TABLE `{$table}` ADD COLUMN {$column} INT NOT NULL DEFAULT '0'");
        }
    }

    public function insertColumnString($table=null,$column=null){
        $result = $this->exec("SHOW COLUMNS FROM `{$table}` LIKE '{$column}'");
        if(!$result){
            $this->exec("ALTER TABLE `{$table}` ADD COLUMN {$column} VARCHAR(255) NULL");
        }
    }

    public function insertColumnText($table=null,$column=null){
        $result = $this->exec("SHOW COLUMNS FROM `{$table}` LIKE '{$column}'");
        if(!$result){
            $this->exec("ALTER TABLE `{$table}` ADD COLUMN {$column} TEXT NULL DEFAULT NULL");
        }
    }

    public function deleteColumn($table=null,$column=null){
        $result = $this->exec("SHOW COLUMNS FROM `{$table}` LIKE '{$column}'");
        if($result){
            $this->exec("ALTER TABLE `{$table}` DROP `{$column}`");
        }
    }

    public function insertTables($table=null,$params=[]){
        if($params["data"]){
            $this->exec($params["data"]);
        }elseif($params["file"]){
            $this->exec(_file_get_contents($params["file"]));
        }
    }


}