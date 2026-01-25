<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful code!
 */

namespace App\Systems;

use App\Systems\Clean;

class Validation
{

    public $error = null;

    public function setExt($value=null){
        $this->extensions = $value;
        return $this;
    }

    public function required($bool=null){
        $this->required = $bool;
        return $this;
    }

    public function issetField($value=null){
        if(isset($value)){
            if(trim($value) != ""){
                return (object)["status"=>true];
            }
        }
        return (object)["status"=>false];
    }

    public function isLink($link=null){
        if(isset($link)){
            if(strpos($link, "://") !== false){
                return (object)["status"=>true];
            }
        }
        return (object)["status"=>false];
    }

    public function requiredField($value=null){
        if(trim($value)){
            return (object)["status"=>true];
        }
        $this->error = translate("tr_bca62e8bb39a76f12905896f5388d8ac");
        return (object)["status"=>false];
    }

    public function requiredFieldPrice($value=null){
        $value = preg_replace('/[^0-9.,]/', '', $value);
        if(trim($value)){
            return (object)["status"=>true];
        }
        $this->error = translate("tr_bca62e8bb39a76f12905896f5388d8ac");
        return (object)["status"=>false];
    }

    public function requiredFieldArray($value=null){
        if(is_array($value)){
            if(count($value)){
                return (object)["status"=>true];
            }
        }
        $this->error = translate("tr_bca62e8bb39a76f12905896f5388d8ac");
        return (object)["status"=>false];
    }

    public function isEmail($value=null){
        if(filter_var(trim($value), FILTER_VALIDATE_EMAIL)){
            return (object)["status"=>true];
        }
        $this->error = translate("tr_3bb6a1478ac15d60a2fdcb8dc61e9458");
        return (object)["status"=>false];
    }

    public function isPassword($value=null){
        if(trim($value)){
            return (object)["status"=>true];
        }
        $this->error = translate("tr_d304162d4168085c50aa8b15ded4c2fa");
        return (object)["status"=>false];
    }
    
    public function correctPassword($value=null){
        if(_mb_strlen($value) >= 6 && _mb_strlen($value) <= 30){
            return (object)["status"=>true];
        }
        $this->error = translate("tr_27294904cf019b08d4a4c00c87bc8cb4");
        return (object)["status"=>false];
    }

    public function isUserName($value=null){
        if(trim($value)){
            return (object)["status"=>true];
        }
        $this->error = translate("tr_bca62e8bb39a76f12905896f5388d8ac");
        return (object)["status"=>false];
    }

    public function isRoleAdmin($value=null){
        if(intval($value)){
            return (object)["status"=>true];
        }
        $this->error = translate("tr_bca62e8bb39a76f12905896f5388d8ac");
        return (object)["status"=>false];
    }

    public function isRolePrivilege($value=null){
        if(is_array($value)){
            if(count($value) > 0){
                return (object)["status"=>true];
            }
        }
        $this->error = translate("tr_34e30c90a5a394e109b0df71d36e56a3");
        return (object)["status"=>false];
    }

    public function issetFiles($value=null){
        $data = normalizeFilesArray($value);
        if($data){
            return (object)["status"=>true];
        }
        $this->error = translate("tr_bca62e8bb39a76f12905896f5388d8ac");
        return (object)["status"=>false];
    }

    public function isSelectedCategories($value=[]){
        if(is_array($value)){
            if(count($value) > 0){
                if(trim($value[0]) != ""){
                    return (object)["status"=>true];
                }
            }
        }
        $this->error = translate("tr_08e07cf54d7ef9e6fb0da456c3a4ab4c");
        return (object)["status"=>false];
    }

    public function requiredItemsFilters($items=[]){
        $items_value = [];
        if(is_array($items)){
           foreach ($items as $action => $nested) {
              foreach ($nested as $id => $value) {
                 if(trim($value)) $items_value[] = trim($value);
              }
           }
           if($items_value){
                return (object)["status"=>true];            
           }
        }
        $this->error = translate("tr_38f2669b5a7af398c996cd4938f30975");
        return (object)["status"=>false];
    }

    public function requiredFieldsImport($items=[]){
        $items_value = [];
        if(is_array($items)){
           foreach ($items as $key => $value) {
                if(trim($value) != "") $items_value[] = trim($value);
           }
           if($items_value){
                return (object)["status"=>true];            
           }
        }
        $this->error = translate("tr_150b1c5146fa2be53d19f3c5571872f9");
        return (object)["status"=>false];
    }

    public function isImage($value=null){
        global $app;

        $errors = [];

        if(isset($this->extensions)){
            $allowed_extensions = $this->extensions;
            $this->setExt(null);
        }else{
            $allowed_extensions = $app->settings->allowed_extensions_images;
        }

        $data = normalizeFilesArray($value);

        if($data){

            foreach ($data as $key => $value) {

                if($value["size"] > 10*1024*1024){
                   $errors[] = translate("tr_13163506fc464568f8f4aea15a4f5840");
                }

                if(getInfoFile($value["name"])->extension){
                    if (!in_array(getInfoFile($value["name"])->extension, $allowed_extensions)){
                        $errors[] = translate("tr_b3ca22ec2a99303c0e25a718d3aaf059") . " " . implode(",", $allowed_extensions);
                    }
                }else{
                    $errors[] = translate("tr_b3ca22ec2a99303c0e25a718d3aaf059") . " " . implode(",", $allowed_extensions);
                }

            }

            if($errors){
                $this->error = implode("\n", $errors);
                return (object)["status"=>false];
            }

        }else{
            if(isset($this->required)){
                $this->required = null;
                $this->error = translate("tr_f28b3bd953a0c31a9329b8738186f2e3");
                return (object)["status"=>false];                
            }
        }

        return (object)["status"=>true];
        
    }

    public function isFile($value=null){
        global $app;

        $errors = [];

        if(isset($this->extensions)){
            $allowed_extensions = $this->extensions;
            $this->setExt(null);
        }else{
            $allowed_extensions = $app->settings->allowed_extensions_files;
        }

        $data = normalizeFilesArray($value);

        if($data){

            foreach ($data as $key => $value) {

                if($value["size"] > 100*1024*1024){
                   $errors[] = translate("tr_a4f494f314a0e372b0ad131e739f0c87");
                }

                if(getInfoFile($value["name"])->extension){
                    if (!in_array(getInfoFile($value["name"])->extension, $allowed_extensions)){
                        $errors[] = translate("tr_b3ca22ec2a99303c0e25a718d3aaf059") . " " . implode(",", $allowed_extensions);
                    }
                }else{
                    $errors[] = translate("tr_b3ca22ec2a99303c0e25a718d3aaf059") . " " . implode(",", $allowed_extensions);
                }

            }

            if($errors){
                $this->error = implode("\n", $errors);
                return (object)["status"=>false];
            }

        }else{
            if(isset($this->required)){
                $this->required = null;
                $this->error = translate("tr_ae137af84cac6cdf52186a3020967831");
                return (object)["status"=>false];                
            }
        }

        return (object)["status"=>true];
        
    }

    public function isPhone($phone=null){
        global $app;

        $phone = preg_replace('/[^0-9]/', '', $phone);
        if($phone){
            foreach ($app->config->phone_codes as $code => $value) {
                
                if(substr($phone, 0, strlen($value->code)) == $value->code){
                    if(strlen($phone) == $value->length){
                        return (object)["status"=>true];
                    }
                }

            }
        }

        $this->error = translate("tr_d8cc65b296a85d76248fd771b7678d69");
        return (object)["status"=>false];
    }

    public function isAllowedPhone($phone=null){
        global $app;

        $countries = [];
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if($app->settings->allowed_templates_phone_all_status){
            return (object)["status"=>true];
        }

        if($phone){
            if(!$app->settings->allowed_templates_phone_all_status){

                $template = (array)$app->config->phone_codes;

                if($app->settings->allowed_templates_phone){
                    foreach ($app->settings->allowed_templates_phone as $key => $code) {

                        $countries[] = $template[$code]->country;

                        if(substr($phone, 0, strlen($template[$code]->code)) == $template[$code]->code){
                            if(strlen($phone) == $template[$code]->length){
                                return (object)["status"=>true];
                            }
                        }

                    }   
                       
                }         

            }
        }

        $this->error = implode(", ", $countries);
        return (object)["status"=>false];
    }

    public function isAllowedEmail($email=null){
        global $app;

        $services = [];

        if($app->settings->allowed_templates_email_all_status){
            return (object)["status"=>true];
        }

        if($email){

            $email = explode("@", $email);

            if(!$app->settings->allowed_templates_email_all_status){

                if($app->settings->allowed_templates_email){

                    $allowed_templates_email = explode(",", $app->settings->allowed_templates_email);

                    foreach ($allowed_templates_email as $key => $service) {

                        $services[] = "@".trim($service);

                        if(trim($service) == $email[1]){
                            return (object)["status"=>true];
                        }

                    }   
                       
                }         

            }
        }

        $this->error = implode(", ", $services);
        return (object)["status"=>false];
    }

    public function correctLogin($login=null){
        global $app;

        if($app->settings->registration_authorization_method == "email-phone"){

            if(strpos($login, "@") !== false){

                if($this->isEmail($login)->status == false){
                    return (object)["status"=>false, "answer"=>translate("tr_3bb6a1478ac15d60a2fdcb8dc61e9458")];
                }else{
                    return (object)["status"=>true, "email"=>$login];
                }

            }else{

                if($this->isPhone($login)->status == false){
                    return (object)["status"=>false, "answer"=>translate("tr_d8cc65b296a85d76248fd771b7678d69")];
                }else{
                    $login = preg_replace('/[^0-9]/', '', $login);
                    return (object)["status"=>true, "phone"=>$login];
                }

            }

        }elseif($app->settings->registration_authorization_method == "phone"){

            if($this->isPhone($login)->status == false){
                return (object)["status"=>false, "answer"=>translate("tr_d8cc65b296a85d76248fd771b7678d69")];
            }else{
                $login = preg_replace('/[^0-9]/', '', $login);
                return (object)["status"=>true, "phone"=>$login];
            }

        }elseif($app->settings->registration_authorization_method == "email"){

            if($this->isEmail($login)->status == false){
                return (object)["status"=>false, "answer"=>translate("tr_3bb6a1478ac15d60a2fdcb8dc61e9458")];
            }else{
                return (object)["status"=>true, "email"=>$login];
            }

        }

    }

    public function correctContact($contact=null){
        global $app;

        if(strpos($contact, "@") !== false){

            if($this->isEmail($contact)->status == false){
                return (object)["status"=>false, "answer"=>translate("tr_3bb6a1478ac15d60a2fdcb8dc61e9458")];
            }else{
                return (object)["status"=>true, "email"=>$contact];
            }

        }else{

            if(ctype_digit(preg_replace('/[^0-9]/', '', $contact))){

                if($this->isPhone($contact)->status == false){
                    return (object)["status"=>false, "answer"=>translate("tr_d8cc65b296a85d76248fd771b7678d69")];
                }else{
                    $contact = preg_replace('/[^0-9]/', '', $contact);
                    return (object)["status"=>true, "phone"=>$contact];
                }

            }else{

                if($this->isEmail($contact)->status == false){
                    return (object)["status"=>false, "answer"=>translate("tr_3bb6a1478ac15d60a2fdcb8dc61e9458")];
                }else{
                    return (object)["status"=>true, "email"=>$contact];
                }

            }

        }

    }

    public function correctLength($value=null, $min=0, $max=0){
        if($min || $max){
            if(_mb_strlen($value) >= $min && _mb_strlen($value) <= $max){
                return (object)["status"=>true];
            }
            if($min && $max){
                $this->error = translate("tr_b51d7ded7832595cc2fde8581924dc78")." ".$min." ".translate("tr_538dc63d3c6db1a1839cafbaf359799b")." ".$max." ".translate("tr_8dd2b69669960646469fbeb70b2005fd");
            }elseif($min){
                $this->error = translate("tr_b51d7ded7832595cc2fde8581924dc78")." ".$min." ".translate("tr_8dd2b69669960646469fbeb70b2005fd");
            }elseif($max){
                $this->error = translate("tr_aad2db98608e944d6024163883007a32")." ".$max." ".translate("tr_8dd2b69669960646469fbeb70b2005fd");
            }
            return (object)["status"=>false];
        }else{
            return (object)["status"=>true];
        }
    }

}