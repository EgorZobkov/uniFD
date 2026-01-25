<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Systems;

class Translate
{

    public $data = [];
    public $current = [];
    public $hasLangRequest = false;
    public $isoLangRequest = null;

    public function getChangeLang(){
        global $app;

        return $app->session->get("current-lang") ?: $app->settings->default_language;

    }

    public function code($string=null){
        return $this->data[trim($string)] ? $this->data[trim($string)] : $string;
    }

    public function fieldReplace($field=null){
        global $app;

        $current_iso = $app->session->get("current-lang");

        if($current_iso){
            if($current_iso != $app->settings->default_language){
                return $field . "_" . $current_iso;
            }
        }

        return '';

    }

    public function hasLang($iso=null){
        global $app;

        return $app->model->languages->find("iso=? and status=?", [$iso,1]);

    }

    public function setDefaultContent(){
        global $app;

        $this->current = $app->settings->default_language ? $app->model->languages->find("iso=?", [$app->settings->default_language]) : [];
 
        if(file_exists($app->config->storage->translations . '/' . $this->current->iso . '/content.tr')){
            $this->data = require $app->config->storage->translations . '/' . $this->current->iso . '/content.tr';
        }else{
            $this->data = require $app->config->storage->translations . '/default.tr';
        }

    }

    public function setContent($iso=null){
        global $app;

        if(!$iso){
            $this->current = $app->model->languages->find("iso=? and status=?", [$this->getChangeLang(),1]);
        }else{
            $this->current = $app->model->languages->find("iso=?", [$iso]);
        }
 
        if(file_exists($app->config->storage->translations . '/' . $this->current->iso . '/content.tr')){
            $this->data = require $app->config->storage->translations . '/' . $this->current->iso . '/content.tr';
        }else{
            $this->data = require $app->config->storage->translations . '/default.tr';
        }

    }

    public function setJs($iso=null){
        global $app;

        if(file_exists($app->config->storage->translations . '/' . $this->current->iso . '/js.tr')){
            $content = require $app->config->storage->translations . '/' . $this->current->iso . '/js.tr';
        }else{
            $content = [];
        }

        $locale = $this->current->locale ? str_replace('_', '-', $this->current->locale) : 'ru-RU';

        $jsContent = "

            class Translate {

              constructor() {

                this.contentTranslate = "._json_encode($content).";
                this.defaultLocaleTranslate = '".$locale."';

              }

              content(value){
                return this.contentTranslate[value] ? this.contentTranslate[value] : value;
              }

              locale(){
                return this.defaultLocaleTranslate;
              }

            }

            window.Translate = Translate;

        ";

        $app->asset->registerJs(["view"=>$app->view->isolated, "name"=>"<script type=\"text/javascript\" >".$jsContent."</script>"]);

    }

    public function updateTables(){
        global $app;

        $translates = [];

        $data = $app->model->chat_automessages->getAll();

        foreach ($data as $key => $value) {

            if(strpos($value["text"], "tr_") === false){

                $code = "tr_" . md5("chat_automessages_".$value["text"]);
                $translates[$code] = addslashes($value["text"]);

                $app->model->chat_automessages->update(["text"=>$code], $value["id"]);

            }

        }

        $data = $app->model->frontend_home_widgets->getAll();

        foreach ($data as $key => $value) {

            if(strpos($value["name"], "tr_") === false){

                $code = "tr_" . md5("frontend_home_widgets_".$value["name"]);
                $translates[$code] = addslashes($value["name"]);

                $app->model->frontend_home_widgets->update(["name"=>$code], $value["id"]);

            }
          
        }

        $data = $app->model->profile_menu->getAll();

        foreach ($data as $key => $value) {

            if(strpos($value["name"], "tr_") === false){

                $code = "tr_" . md5("profile_menu_".$value["name"]);
                $translates[$code] = addslashes($value["name"]);

                $app->model->profile_menu->update(["name"=>$code], $value["id"]);

            }
          
        }

        $data = $app->model->system_home_widgets->getAll();

        foreach ($data as $key => $value) {

            if(strpos($value["name"], "tr_") === false){

                $code = "tr_" . md5("system_home_widgets_".$value["name"]);
                $translates[$code] = addslashes($value["name"]);

                $app->model->system_home_widgets->update(["name"=>$code], $value["id"]);

            }
          
        }

        $data = $app->model->system_measurements->getAll();

        foreach ($data as $key => $value) {

            if(strpos($value["name"], "tr_") === false){

                $code = "tr_" . md5("system_measurements_".$value["name"]);
                $translates[$code] = addslashes($value["name"]);

                $app->model->system_measurements->update(["name"=>$code], $value["id"]);

            }
          
        }

        $data = $app->model->system_menu->getAll();

        foreach ($data as $key => $value) {

            if(strpos($value["name"], "tr_") === false){

                $code = "tr_" . md5("system_menu_".$value["name"]);
                $translates[$code] = addslashes($value["name"]);

                $app->model->system_menu->update(["name"=>$code], $value["id"]);

            }
          
        }

        $data = $app->model->system_price_names->getAll();

        foreach ($data as $key => $value) {

            if(strpos($value["name"], "tr_") === false){

                $code = "tr_" . md5("system_price_names_".$value["name"]);
                $translates[$code] = addslashes($value["name"]);

                $app->model->system_price_names->update(["name"=>$code], $value["id"]);

            }
          
        }

        $data = $app->model->system_privileges->getAll();

        foreach ($data as $key => $value) {

            if(strpos($value["name"], "tr_") === false){

                $code = "tr_" . md5("system_privileges_".$value["name"]);
                $translates[$code] = addslashes($value["name"]);

                $app->model->system_privileges->update(["name"=>$code], $value["id"]);

            }
          
        }

        $data = $app->model->system_roles->getAll();

        foreach ($data as $key => $value) {

            if(strpos($value["name"], "tr_") === false){

                $code = "tr_" . md5("system_roles_".$value["name"]);
                $translates[$code] = addslashes($value["name"]);

                $app->model->system_roles->update(["name"=>$code], $value["id"]);

            }
          
        }

        $data = $app->model->system_settings_sections->getAll();

        foreach ($data as $key => $value) {

            if(strpos($value["name"], "tr_") === false){

                $code = "tr_" . md5("system_settings_sections_".$value["name"]);
                $translates[$code] = addslashes($value["name"]);

                $app->model->system_settings_sections->update(["name"=>$code], $value["id"]);

            }

        }

        $data = $app->model->system_verification_users_permissions->getAll();

        foreach ($data as $key => $value) {

            if(strpos($value["name"], "tr_") === false){

                $code = "tr_" . md5("system_verification_users_permissions_".$value["name"]);
                $translates[$code] = addslashes($value["name"]);

                $app->model->system_verification_users_permissions->update(["name"=>$code], $value["id"]);

            }

        }

        $data = $app->model->template_pages->getAll();

        foreach ($data as $key => $value) {

            if(strpos($value["name"], "tr_") === false){

                $code = "tr_" . md5("template_pages_".$value["name"]);
                $translates[$code] = addslashes($value["name"]);

                $app->model->template_pages->update(["name"=>$code], $value["id"]);

            }

        }

        if($translates){

            foreach ($translates as $key => $value) {
                $this->insertDefaultContent($key, $value, "db");
            }    
            
        }

        return ["added"=>count($translates)];

    }

    public function updateContent(){
        global $app;

        $data1 = globRecursive(BASE_PATH.'/app');
        $data2 = globRecursive(BASE_PATH.'/resources');
        $data3 = globRecursive(BASE_PATH.'/core/components');
        $data4 = globRecursive(BASE_PATH.'/core/controllers');
        $data5 = globRecursive(BASE_PATH.'/core/systems');

        $translates = [];
        $translates_js = [];
        $translates_db = [];
        $translates_db_js = [];
        $errors = [];

        $data = array_merge($data1, $data2, $data3, $data4, $data5);

        if($data){
            foreach ($data as $key => $value) {

                $temp_translates = [];

                $ext = pathinfo($value->path, PATHINFO_EXTENSION);

                if($ext == "php" || $ext == "tpl" || $ext == "js"){
                
                    $content = _file_get_contents($value->path);

                    if($content){

                        if($ext == "php" || $ext == "tpl"){

                            preg_match_all("|translate\((['\"].*?['\"])\)|", $content, $result);

                            if($result[1]){

                                foreach ($result[1] as $value2) {

                                    $val = trim(trim($value2), "'");
                                    $val = trim($val, '"');

                                    if(strpos($val, "tr_") === false){

                                        $code = "tr_" . md5($val);

                                        if(!$translates[$code]){
                                            $translates[$code] = $val;
                                        } 

                                        $content = str_replace($value2, '"'.$code.'"', $content);

                                        $temp_translates[] = $code;

                                    }

                                }

                                if($temp_translates){
                                    if(!_file_put_contents($value->path, $content)){
                                        $errors[] = path($value->path);
                                    }
                                }

                            }

                        }elseif($ext == "js"){

                            preg_match_all("|translate.content\((['\"].*?['\"])\)|", $content, $result);

                            if($result[1]){

                                foreach ($result[1] as $value2) {

                                    $val = trim(trim($value2), "'");
                                    $val = trim($val, '"');

                                    if(strpos($val, "tr_") === false){

                                        $code = "tr_" . md5($val);

                                        if(!$translates_js[$code]){
                                            $translates_js[$code] = $val;
                                        }

                                        $content = str_replace($value2, '"'.$code.'"', $content);

                                        $temp_translates[] = $code;

                                    }

                                }

                                if($temp_translates){
                                    if(!_file_put_contents($value->path, $content)){
                                        $errors[] = path($value->path);
                                    }
                                }

                            }

                        }

                    }

                }

            }
        }

        if($translates){
           
            foreach ($translates as $key => $value) {
                $this->insertDefaultContent($key, $value, "static");
            }

        }

        if($translates_js){
           
            foreach ($translates_js as $key => $value) {
                $this->insertDefaultContent($key, $value, "js");
            }
            
        }

        $getTranslations = $app->model->translations_default_content->getAll("type=? or type=?", ["static", "db"]);

        if($getTranslations){

            foreach ($getTranslations as $key => $value) {
                
                $translates_db[$value["content_key"]] = $value["text"];

            }

            $result = '<?php return '.var_export($translates_db, true).'; ?>';

            @chmod($app->config->storage->translations . '/default.tr', 0777);

            _file_put_contents($app->config->storage->translations . '/default.tr', $result);

        }

        $getTranslations = $app->model->translations_default_content->getAll("type=?", ["js"]);

        if($getTranslations){

            foreach ($getTranslations as $key => $value) {
                
                $translates_db_js[$value["content_key"]] = $value["text"];

            }

            $result = '<?php return '.var_export($translates_db_js, true).'; ?>';

            @chmod($app->config->storage->translations . '/js.tr', 0777);

            _file_put_contents($app->config->storage->translations . '/js.tr', $result);

        }

        if($translates_db || $translates_db_js){

            $getLanguages = $app->model->languages->getAll();

            if($getLanguages){

                foreach ($getLanguages as $key => $value) {

                    $content = [];

                    if(file_exists($app->config->storage->translations . '/' . $value["iso"] . '/content.tr')){
                        $content = require $app->config->storage->translations . '/' . $value["iso"] . '/content.tr';
                    }            

                    foreach ($translates_db as $tr_key => $tr_value) {
                        if(!$content[$tr_key]){
                            $content[$tr_key] = $tr_value;
                        }
                    }

                    $result = '<?php return '.var_export($content, true).'; ?>';

                    @chmod($app->config->storage->translations . '/' . $value["iso"] . '/content.tr', 0777);

                    _file_put_contents($app->config->storage->translations . '/' . $value["iso"] . '/content.tr', $result);                

                    $content = [];

                    if(file_exists($app->config->storage->translations . '/' . $value["iso"] . '/js.tr')){
                        $content = require $app->config->storage->translations . '/' . $value["iso"] . '/js.tr';
                    }            

                    foreach ($translates_db_js as $tr_key => $tr_value) {
                        if(!$content[$tr_key]){
                            $content[$tr_key] = $tr_value;
                        }
                    }

                    $result = '<?php return '.var_export($content, true).'; ?>';

                    @chmod($app->config->storage->translations . '/' . $value["iso"] . '/js.tr', 0777);

                    _file_put_contents($app->config->storage->translations . '/' . $value["iso"] . '/js.tr', $result);

                }

            }

        }

        return ["added"=>count($translates), "errors"=>count($errors), "errors_answer"=>$errors];

    }

    public function insertDefaultContent($key=null, $text=null, $type=null){
        global $app;

        if(!$app->model->translations_default_content->find("content_key=? and type=?", [$key,$type])){
            $app->model->translations_default_content->insert(["content_key"=>$key, "text"=>$text, "type"=>$type]);
        }
        
    }

    public function statusMultiLanguages(){
        global $app;

        if($app->settings->multi_languages_status){
            if($app->model->languages->find("status=?", [1])){
                return true;
            }
        }

        return false;

    }

    public function hasLanguageRequest(){
        global $app;

        if(!$app->settings->multi_languages_status){
            return false;
        }

        $current_iso = $this->getChangeLang();

        $request = explode("/", trim(getAllRequestURI(), "/"));

        if($app->config->app->prefix_path){

            if($request){
                if($request[0] == $app->config->app->prefix_path){
                    unset($request[0]);
                    $request = array_values($request);
                }
            }

        }

        if($request){

            if(count($request) == 1){

                if($request[0] == $app->settings->default_language){

                    $app->session->delete("current-lang");
                    $app->router->goToUrl(getHost()); 

                }else{

                    if($app->model->languages->find("iso=? and status=?", [$request[0],1])){
                        $app->session->set("current-lang", $request[0]);
                    }else{
                        $app->session->delete("current-lang");
                    }

                }

            }else{

                if($request[0] == $app->settings->default_language){
                    unset($request[0]);
                    $app->router->goToUrl(getHost()."/".implode("/", $request));
                }else{
                    if($app->model->languages->find("iso=? and status=?", [$request[0],1])){
                        $app->session->set("current-lang", $request[0]);
                    }else{
                        $app->session->delete("current-lang");
                    }
                }                

            }

        }else{

            if($current_iso == $app->settings->default_language){
                $app->session->delete("current-lang");         
            }else{
                $app->router->goToUrl(getHost()."/".$current_iso);
            }

        }

    }

    public function buildLink($iso=null){
        global $app;

        return getHost() . '/' . $iso;

    }

}