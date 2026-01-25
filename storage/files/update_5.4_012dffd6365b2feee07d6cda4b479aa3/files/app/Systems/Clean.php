<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Systems;

class Clean
{

    private function _prepare($value)
    {
        $value = strval($value);
        $value = preg_replace("/(drop table|show tables|union)/", "", $value);
        $value = stripslashes($value);
        $value = str_ireplace(["\0", "\a", "\b", "\v", "\e", "\f"], ' ', $value);
        $value = htmlspecialchars_decode($value, ENT_QUOTES);   
        $value = str_replace("&amp;", "&", $value);
      
        return $value;
    }

    public function request()
    {
        if($_GET){
            foreach ($_GET as $key => $value) {
                if(is_string($value) == true){
                    $_GET[$key] = $this->str($value);
                }elseif(is_int($value) == true){
                    $_GET[$key] = $this->int($value);
                }elseif(is_float($value) == true){
                    $_GET[$key] = $this->float($value);
                }elseif(is_bool($value) == true){
                    $_GET[$key] = $this->bool($value);
                }elseif(is_array($value) == true){
                    $_GET[$key] = $this->multilevelArray($value);
                }else{
                    $_GET[$key] = $this->str($value);
                }
            }
        }
        if($_POST){
            foreach ($_POST as $key => $value) {
                if(is_string($value) == true){
                    $_POST[$key] = $this->str($value);
                }elseif(is_int($value) == true){
                    $_POST[$key] = $this->int($value);
                }elseif(is_float($value) == true){
                    $_POST[$key] = $this->float($value);
                }elseif(is_bool($value) == true){
                    $_POST[$key] = $this->bool($value);
                }elseif(is_array($value) == true){
                    $_POST[$key] = $this->multilevelArray($value);
                }else{
                    $_POST[$key] = $this->str($value);
                }
            }
        }
    }

    public function phpCode($value=null)
    {
        $value = trim($value);
        $value = str_replace(["<?php","<?=","<?","?>"], ["","","",""], $value);  
        return $value;
    }

    public function multilevelArray($value=[]){
        $result = [];
        if($value){
            foreach ($value as $key1 => $value1) {
                if(is_array($value1)){
                    $result[$key1] = $this->multilevelArray($value1);
                }else{
                    $result[$key1] = $this->str($value1);
                }
            }
        }
        return $result;
    }

    public function bool($value)
    {
        $value = $this->_prepare($value);
        $value = mb_ereg_replace('[\s]', '', $value);
        $value = str_ireplace(array('-', '+', 'false', 'null', 'off'), '', $value);
        return empty($value) ? 0 : 1;
    }

    public function int($value)
    {
        $value = $this->_prepare($value);
        $value = mb_ereg_replace('[\s]', '', $value);   
        $value = abs(intval($value));
        return $value;
    }

    public function float($value)
    {
        $value = $this->_prepare($value);
        $value = mb_ereg_replace('[\s]', '', $value);   
        $value = str_replace(',', '.', $value);
        $value = floatval($value);
        return $value;
    }

    public function text($value)
    {
        $value = $this->_prepare($value);
        $value = str_ireplace(array("\t"), ' ', $value);            
        $value = preg_replace(array(
            '@\/\*(.*?)\*\/@sm',
            '@<([\?\%]) .*? \\1>@sx',
            '@<\!\[CDATA\[.*?\]\]>@sx',
            '@<\!\[.*?\]>.*?<\!\[.*?\]>@sx',    
            '@\s--.*@',
            '@<script[^>]*?>.*?</script>@si',
            '@<style[^>]*?>.*?</style>@siU', 
            '@<[\/\!]*?[^<>]*?>@si',            
        ), ' ', $value);        
        $value = strip_tags($value);        
        $value = str_replace(array('/*', '*/', ' --', '#__'), ' ', $value); 
        $value = mb_ereg_replace('[ ]+', ' ', $value);          
        $value = trim($value);
        $value = htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');  
        $value = str_replace("&amp;", "&", $value);
        return $value;
    }

    public function str($value)
    {
        $value = $this->text($value);      
        $value = trim($value);
        return $value;
    }

    public function html($value)
    {
        $value = $this->_prepare($value);
        $value = mb_ereg_replace('[ ]+', ' ', $value);
        $value = trim($value);      
        $value = addslashes($value);
        return $value;
    }
   
    public function phone($value)
    {
        return preg_replace('/[^0-9]/', '', $value);
    }

}