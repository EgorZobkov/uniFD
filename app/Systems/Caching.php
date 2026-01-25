<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Systems;

class Caching
{

    public $instance;
    public $config;

    public function __construct(){

        $this->config = require BASE_PATH . '/config/caching.php';

        if(!$this->status()) return;

        try{

            if($this->config["driver"] == "memcached"){
                $this->instance = new \Memcached();
                $this->instance->addServer($this->config["memcached"]["host"], $this->config["memcached"]["port"]);
            }
            
        }catch (Exception $e){
            logger("Caching: {$e}");
        }

    }

    public function status(){
        return $this->config["status"];
    }

    public function set($key=null, $data=[]){
        global $app;

        if(!$this->status()) return;

        if($key && $data){

            if($this->config["driver"] == "memcached"){
                $this->instance->set($key, $data);
            }elseif($this->config["driver"] == "local"){
                file_put_contents($app->config->storage->cache."/".$key.".php", "<?php return ".var_export($data, true)."; ?>");                
            }

        }

    }

    public function get($key=null){
        global $app;

        if(!$this->status()) return false;

        if($key){

            if($this->config["driver"] == "memcached"){
                $result = $this->instance->get($key);
            }elseif($this->config["driver"] == "local"){
                if(file_exists($app->config->storage->cache."/".$key.".php")){
                    $result = require $app->config->storage->cache."/".$key.".php";  
                }             
            }

            if($result){
                return $result;
            }

        }

        return false;

    }

    public function update($params=[], $data=[]){
        global $app;

        if(!$this->status()) return;

        $this->delete($params);

        $this->set($params,$data);

    }

    public function delete($key=null){
        global $app;

        if(!$this->status()) return;

        if($key){
            if($this->config["driver"] == "memcached"){
                $this->instance->delete($key);
            }elseif($this->config["driver"] == "local"){
                unlink($app->config->storage->cache."/".$key.".php");
            }
        }

    }

    public function buildKey($table=null, $params=[]){
        global $app;
        return $table.'_'.md5(_json_encode($params).$app->config->app->private_service_key);
    }

    public function flush(){
        global $app;

        if(!$this->status()) return;
        
        if($this->config["driver"] == "memcached"){
            $this->instance->flush();
        }elseif($this->config["driver"] == "local"){
            deleteFolder($app->config->storage->cache);
        }
        
    }

}