<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Systems;

class Session
{

    public static function start()
    {
        session_start();
    }

    public static function clear()
    {
        unset($_SESSION);
        session_destroy();
    }

    public static function getAll()
    {
        return $_SESSION;
    }

    public static function set($key=null, $value=null)
    {
        if(isset($key) && isset($value)) {
            $_SESSION[$key] = $value;
        }
    }

    public static function setSubarray($key=null, $value=null)
    {
        if(isset($key) && isset($value)) {
            $_SESSION[$key][] = $value;
        }
    }

    public static function setNestedSubarray($key1=null, $key2=null, $value=null)
    {
        if(isset($key1) && isset($key2) && isset($value)) {
            $_SESSION[$key1][$key2] = $value;
        }
    }

    public static function setArray($key=null, $array=[])
    {
        if(isset($key) && isset($array)) {
            $_SESSION[$key] = $array;
        }
    }

    public static function get($key=null)
    {
        if(isset($_SESSION[$key])){
            return $_SESSION[$key];
        }else{
            return null;
        }
    }

    public static function getByTime($key=null)
    {
        if(isset($_SESSION[$key])){
            if($_SESSION[$key]["term"] > time()){
                return $_SESSION[$key]["value"];
            }
        }
        return null;
    }

    public static function setByTime($key=null, $value=null, $seconds=null)
    {
        if(isset($key) && isset($value) && isset($seconds)) {
            $_SESSION[$key] = ["term"=>time()+$seconds, "value"=>$value];
        }
    }

    public static function getOnce($key=null)
    {
        if(isset($_SESSION[$key])){
            $result = $_SESSION[$key];
            unset($_SESSION[$key]);
            return $result;
        }else{
            return null;
        }
    }

    public static function getInt($key=null)
    {
        if(isset($_SESSION[$key])){
            return (int)$_SESSION[$key];
        }else{
            return 0;
        }
    }

    public static function delete($key=null)
    {
        if(isset($_SESSION[$key])){
            unset($_SESSION[$key]);
        }
    }

    public static function setNotify($type="warning", $message=null){
        static::setSubarray("web-flash-notify", ["type"=>$type,"message"=>$message]);
    }

    public static function setNotifyDashboard($type="warning", $message=null){
        static::setSubarray("dashboard-flash-notify", ["type"=>$type,"message"=>$message]);
    }

    public static function getNotify($session=null){
        global $app;

        if($session == "dashboard"){
            $session = "dashboard-flash-notify";
        }elseif($session == "web"){
            $session = "web-flash-notify";
        }

        $messages = [];
        $notify = static::get($session);
        if(isset($notify)){
            foreach ($notify as $key => $value) {
                $messages[] = ["message"=>$value["message"], "type"=>$value["type"]];
            }
            static::delete($session);
            return $messages;
        }
        return null;
    }

}