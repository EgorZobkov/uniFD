<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Systems;

use Symfony\Component\HttpFoundation\Request;

class ErrorHandler
{

    public function register(){

        error_reporting(E_ERROR | E_PARSE | E_COMPILE_ERROR | E_CORE_ERROR);
        ini_set('display_errors', 0);

        register_shutdown_function(function(){
            self::handler();
        });
 
    }

    public static function devMode(){
        $data = require BASE_PATH . '/config/app.php';
        if($data['debug']){
            if(!count($data['debug_allowed_ip'])){
                return true;
            }else{
                foreach ($data['debug_allowed_ip'] as $ip){
                    if(Request::createFromGlobals()->getClientIp() == $ip){
                        return true;
                    }
                }
            }
        }
        return false;
    }

    public static function handler(){

        if ($exception = error_get_last()){
            switch($exception['type']){
                case E_ERROR:
                case E_CORE_ERROR:
                case E_PARSE:
                case E_COMPILE_ERROR:
                return self::exception($exception);
                break;
            }
        }

    }

    public static function exception($exception=null){
        global $app;

        $resource = require BASE_PATH . '/config/resource.php';

        $app->translate->data = require $app->config->storage->translations . '/default.tr';

        if(isset($exception)){
           
            if(self::devMode()) {

                logger(self::convertExceptionToString($exception));

                echo self::convertExceptionToString($exception);

            }else{
  
                logger(self::convertExceptionToString($exception));

                http_response_code(500);

                $vars['app'] = $app;

                extract($vars);

                if(file_exists($resource["answer"]["path"].'/500.tpl')){
                    require $resource["answer"]["path"].'/500.tpl';
                }

            }
        }

    }

    public static function convertExceptionToString($exception){

        $placeholders = [
            '{{message}}' => $exception["message"],
            '{{file}}' => $exception["file"],
            '{{line}}' => $exception["line"],
        ];

        return strtr('{{message}} {{file}} on line {{line}}', $placeholders);
    }
}