<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Systems;

class Asset{

    public static $assets = [];

    public function __construct(){
        if(file_exists(BASE_PATH . '/config/assets.php')) {
            $data = require BASE_PATH . '/config/assets.php';
            if(is_array($data)){
                static::$assets = $data;
            }
        }
    }

    public static function registerJs($params=[]){
        if(count($params)){
            if(isset($params['view'])){
                if(isset($params['name'])){
                    static::$assets[$params['view']]['js'][] = $params['name'];
                }
            }
        }
    }

    public static function registerCss($params=[]){
        if(count($params)){
            if(isset($params['view'])){
                if(isset($params['name'])){
                    static::$assets[$params['view']]['css'][] = $params['name'];
                }
            }
        }
    }

    public static function getJs($view=null){
        $resource = require BASE_PATH . '/config/resource.php';
        if(isset(static::$assets[$view]['js'])) {
            return str_replace(["{assets_path}","{resources_path}"],[isset($resource["assets"][$view]["base"]) ? resource(null,$resource["assets"][$view]["base"]) : '',resource(null,$resource["path"])],implode("\n",static::$assets[$view]['js']));
        }
    }

    public static function getCss($view=null){
        $resource = require BASE_PATH . '/config/resource.php';
        if(isset(static::$assets[$view]['css'])) {
            return str_replace(["{assets_path}","{resources_path}"],[isset($resource["assets"][$view]["base"]) ? resource(null,$resource["assets"][$view]["base"]) : '',resource(null,$resource["path"])],implode("\n",static::$assets[$view]['css']));
        }
    }

}