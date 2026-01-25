<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Systems;

use App\Systems\Logger;

class Addons
{

    public function payment($aliasOrId=null){
        global $app;

        try {

            if(isset($aliasOrId)){

                $data = $app->model->system_payment_services->find("alias=? or id=?", [$aliasOrId,$aliasOrId]);

                if($data){

                    if(file_exists(BASE_PATH."/app/Addons/Payments/"._ucfirst($data->alias).".php")){
                        $class = "\App\Addons\Payments\\"._ucfirst($data->alias);
                        $instance = new $class();
                        return $instance;
                    }

                }

            }

        } catch (Exception $e) {
            Logger::set("Addons payment class error: {$e->getMessage()}");
        }

    }

    public function delivery($aliasOrId=null){
        global $app;

        try {

            if(isset($aliasOrId)){

                $data = $app->model->system_delivery_services->find("alias=? or id=?", [$aliasOrId,$aliasOrId]);

                if($data){

                    if(file_exists(BASE_PATH."/app/Addons/Delivery/"._ucfirst($data->alias).".php")){
                        $class = "\App\Addons\Delivery\\"._ucfirst($data->alias);
                        $instance = new $class();
                        return $instance;
                    }

                }

            }

        } catch (Exception $e) {
            Logger::set("Addons delivery class error: {$e->getMessage()}");
        }

    }

    public function messenger($aliasOrId=null){
        global $app;

        try {

            if(isset($aliasOrId)){

                $data = $app->model->system_messenger_services->find("alias=? or id=?", [$aliasOrId,$aliasOrId]);

                if($data){

                    if(file_exists(BASE_PATH."/app/Addons/Messengers/"._ucfirst($data->alias).".php")){
                        $class = "\App\Addons\Messengers\\"._ucfirst($data->alias);
                        $instance = new $class();
                        return $instance;
                    }

                }

            }

        } catch (Exception $e) {
            Logger::set("Addons messenger class error: {$e->getMessage()}");
        }

    }

    public function sms($aliasOrId=null){
        global $app;

        try {

            if(isset($aliasOrId)){

                $data = $app->model->system_sms_services->find("alias=? or id=?", [$aliasOrId,$aliasOrId]);

                if($data){

                    if(file_exists(BASE_PATH."/app/Addons/Sms/"._ucfirst($data->alias).".php")){
                        $class = "\App\Addons\Sms\\"._ucfirst($data->alias);
                        $instance = new $class();
                        return $instance;
                    }

                }

            }

        } catch (Exception $e) {
            Logger::set("Addons sms class error: {$e->getMessage()}");
        }

    }

    public function map($aliasOrId=null){
        global $app;

        try {

            if(isset($aliasOrId)){

                if(file_exists(BASE_PATH."/app/Addons/Maps/"._ucfirst($aliasOrId).".php")){
                    $class = "\App\Addons\Maps\\"._ucfirst($aliasOrId);
                    $instance = new $class();
                    return $instance;
                }

            }

        } catch (Exception $e) {
            Logger::set("Addons map class error: {$e->getMessage()}");
        }

    }

    public function smtp($aliasOrId=null){
        global $app;

        try {

            if(isset($aliasOrId)){

                $data = $app->model->system_smtp_services->find("code=? or id=?", [$aliasOrId,$aliasOrId]);

                if($data){

                    if(file_exists(BASE_PATH."/app/Addons/Smtp/"._ucfirst($data->code).".php")){
                        $class = "\App\Addons\Smtp\\"._ucfirst($data->code);
                        $instance = new $class();
                        return $instance;
                    }

                }

            }

        } catch (Exception $e) {
            Logger::set("Addons smtp class error: {$e->getMessage()}");
        }

    }

    public function oauth($aliasOrId=null){
        global $app;

        try {

            if(isset($aliasOrId)){

                $data = $app->model->system_oauth_services->find("alias=? or id=?", [$aliasOrId,$aliasOrId]);

                if($data){

                    if(file_exists(BASE_PATH."/app/Addons/OAuth/"._ucfirst($data->alias).".php")){
                        $class = "\App\Addons\OAuth\\"._ucfirst($data->alias);
                        $instance = new $class();
                        return $instance;
                    }

                }

            }

        } catch (Exception $e) {
            Logger::set("Addons oauth class error: {$e->getMessage()}");
        }

    }

}