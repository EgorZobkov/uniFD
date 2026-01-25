<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Systems;

 class System
 {

 public $data = [];
 public $user = [];
 
 public function addAuth($params=[]){
    global $app;
    $app->model->auth->insert(["user_id"=>$params["user_id"], "token"=>$params["token"], "time_expiration"=>$app->datetime->addDay(30)->getDate(), "ip"=>getIp(), "user_agent"=>_json_encode(getUserAgent()), "geo"=>null, "entry_point"=>$params["entry_point"], "device_model"=>$params["device_model"] ?: null]);
}

public function addAuthSession($params=[]){
    global $app;
    $app->model->auth_sessions->insert(["user_id"=>$params["user_id"], "user_agent"=>_json_encode(getUserAgent()), "ip"=>getIp(), "time_create"=>$app->datetime->getDate(), "geo"=>null, "device_model"=>$params["device_model"] ?: null]);
}

public function addReasonBlocking($text=null){
    global $app;

    if($text){
        $code = generateNumberCode(6);
        $app->model->system_reasons_blocking->insert(["name"=>$text, "text"=>$text, "code"=>$code]);
        return $code;
    }

}

public function amount($amount=0, $currency_code=null){
    global $app;

    if(isset($currency_code)){
        $currency_code = $this->getCurrencyByCode($currency_code)->symbol;
    }else{
        if($app->settings->system_default_currency){
            $currency_code = $this->getDefaultCurrency()->symbol;
        }else{
            $currency_code = "$";
        }
    }

    $amountFormat = numberFormat($amount,2,$app->settings->system_price_fraction_separator,$app->settings->system_price_separator == "spacing" ? " " : $app->settings->system_price_separator);

    if(explode($app->settings->system_price_fraction_separator, $amountFormat)[1] != '0' && explode($app->settings->system_price_fraction_separator, $amountFormat)[1] != '00'){
        $amountExplode = explode($app->settings->system_price_fraction_separator,$amountFormat);
        $amount = $amountExplode[0].".".$amountExplode[1];
    }else{
        $amount = numberFormat($amount,0,$app->settings->system_price_fraction_separator,$app->settings->system_price_separator == "spacing" ? " " : $app->settings->system_price_separator);
    }
   
    if($app->settings->system_currency_spacing){ $spacing = " "; }else{ $spacing = ""; }

    if($app->settings->system_currency_position == "start"){
        return $currency_code.$spacing.$amount;
    }else{
        return $amount.$spacing.$currency_code;
    }

}

public function amountShort($amount=0, $currency_code=null){
    global $app;

    if(!$app->settings->system_price_reduction_status){
        return $this->amount($amount, $currency_code);
    }

    if(isset($currency_code)){
        $currency_code = $this->getCurrencyByCode($currency_code)->symbol;
    }else{
        if($app->settings->system_default_currency){
            $currency_code = $this->getDefaultCurrency()->symbol;
        }else{
            $currency_code = "$";
        }
    }

    if($amount >= 1000000 && $amount <= 9999999){
        
        if(substr($amount, 1,1) != 0){
           $amount = substr($amount, 0,1).','.substr($amount, 1,1).' '.translate("tr_6b884b09b6a84c56f4624a2d67b42682");
        }else{
           $amount = substr($amount, 0,1).' '.translate("tr_6b884b09b6a84c56f4624a2d67b42682");
        }

    }elseif( $amount >= 10000000 && $amount <= 99999999 ){

        $amount = substr($amount, 0,2).' '.translate("tr_6b884b09b6a84c56f4624a2d67b42682");

    }elseif($amount >= 100000000 && $amount <= 999999999){

        $amount = substr($amount, 0,3).' '.translate("tr_6b884b09b6a84c56f4624a2d67b42682");

    }elseif($amount >= 1000000000 && $amount <= 9999999999){

        if(substr($amount, 1,1) != 0){
           $amount = substr($amount, 0,1).','.substr($amount, 1,1).' '.translate("tr_f6ed0cf8f656bd20b3696b469eecf9fd");
        }else{
           $amount = substr($amount, 0,1).' '.translate("tr_f6ed0cf8f656bd20b3696b469eecf9fd");
        }

    }else{
        
        $amountFormat = numberFormat($amount,2,$app->settings->system_price_fraction_separator,$app->settings->system_price_separator == "spacing" ? " " : $app->settings->system_price_separator);

        if(explode($app->settings->system_price_fraction_separator, $amountFormat)[1] != '0' && explode($app->settings->system_price_fraction_separator, $amountFormat)[1] != '00'){
            $amountExplode = explode($app->settings->system_price_fraction_separator,$amountFormat);
            $amount = $amountExplode[0].".".$amountExplode[1];
        }else{
            $amount = numberFormat($amount,0,$app->settings->system_price_fraction_separator,$app->settings->system_price_separator == "spacing" ? " " : $app->settings->system_price_separator);
        }

    }        

    if($app->settings->system_currency_spacing){ $spacing = " "; }else{ $spacing = ""; }

    if($app->settings->system_currency_position == "start"){
        return $currency_code.$spacing.$amount;
    }else{
        return $amount.$spacing.$currency_code;
    }

}

public function breadcrumbs($chain=null){
    global $app;

    $results = [];

    if(isset($chain)){ 

        foreach ($chain as $name => $link) {
            if(isset($link)){
              $results[] = '<a href="'.$link.'" >'.$name.'</a>';
            }else{
              $results[] = $name;
            } 
        }

        return implode('<span class="text-muted" > / </span>', $results);

    }

}

public function buildWebhook($addon=null, $alias=null, $action=null){
    global $app;
    if($action){
        return getHost().'/webhook/'.$app->config->app->private_service_key.'/'.$addon.'/'.$alias.'/'.$action;
    }else{
        return getHost().'/webhook/'.$app->config->app->private_service_key.'/'.$addon.'/'.$alias;
    }
}

public function captchaVerify($code, $captcha_id=null){   
    global $app;

    $codes = $app->session->get("captcha");

    if(isset($codes)){
        if(empty($code)){
            return ["status"=>false, "answer"=>translate("tr_74ae10c77013a9fdccd7268e9a9d1328")];
        }else{
            if(in_array($code, $codes)){
                $app->session->delete("captcha");
                $app->session->delete($captcha_id);
                return ["status"=>true];
            }else{
                return ["status"=>false, "answer"=>translate("tr_f3d36dc0151f78dc12e1d428a4c5f599")];
            }
        }
    }else{
        return ["status"=>false, "answer"=>translate("tr_b033c1aed3f5073873e0d02f5af7abed")];
    }
}

public function changeStatusVerifyCodeByInternalId($status, $service_internal_id=0){
    global $app;
    $app->model->users_waiting_verify_code->update(["status"=>intval($status)], ["service_internal_id=?", [$service_internal_id]]);
}

public function checkAccessSite(){
    global $app;

    if(!$app->settings->access_status){

        $ips = [];

        if($app->settings->access_allowed_ip){
          $allowed_ip = explode(",",$app->settings->access_allowed_ip);
          foreach ($allowed_ip as $key => $value) {
            $ips[] = trim($value);
          }
        }

        if(!in_array(getIp(), $ips)){
        
            if($app->settings->access_action == "text"){

               abort(403, ["text"=>$app->settings->access_text, "title"=>translate("tr_5e0fdf78a87ddb64c9c72d11c779a494")]);

            }elseif($app->settings->access_action == "redirect"){

               if($app->settings->access_redirect_link) $app->router->goToUrl($app->settings->access_redirect_link);

            }

        }

    }

}

public function checkSystemFavorite($route_name=null){
    global $app;
    if(isset($route_name)){
        $check = $app->model->system_favorites->find("user_id=? and route_name=?", [$app->user->data->id,$route_name]);

        if($check){
            return (object)["status"=>true];
        }else{
            return (object)["status"=>false];
        }
    }
    return (object)["status"=>false];
}

public function checkVerifyContact($contact=[], $code=null, $session_id=null){
    global $app;

    if(!$app->settings->phone_confirmation_status && !$app->settings->email_confirmation_status){
        return true;
    }

    if(!$session_id){
        $session_id = $app->session->get("user-session-id");
    }

    if($contact["email"]){

        if($app->settings->email_confirmation_status){

            $data = $app->model->users_waiting_verify_code->find("session_id=? and code=? and contact=? order by id desc", [$session_id,$code,$contact["email"]]);

            if($data){
                return true;
            }

        }else{
            return true;
        }

    }elseif($contact["phone"]){

        if($app->settings->phone_confirmation_status){

            $data = $app->model->users_waiting_verify_code->find("session_id=? and contact=? order by id desc", [$session_id,$contact["phone"]]);

            if($data){
                if($data->status == 1){
                    return true;
                }elseif($code && $data->code == $code){
                    return true;
                }
            }

        }else{
            return true;
        }

    }

    return false;
 
}

public function checkingBadRequests($action=null, $user_id=0){
    global $app;

    if($action == "ad_create"){

        $getLastCountAds = $app->model->ads_data->count("time_create >= DATE_SUB(NOW(),INTERVAL 1 MINUTE) and user_id=?", [$user_id]);

        if($getLastCountAds >= 6){
            $app->model->users->update(["status"=>2, "reason_blocking_code"=>"flood", "time_expiration_blocking"=>$app->datetime->addHours(1)->getDate()], ["admin=? and id=?", [0,$user_id]]);
            return true;
        }

    }elseif($action == "chat"){

        $getLastCountMessages = $app->model->chat_messages->count("time_create >= DATE_SUB(NOW(),INTERVAL 1 MINUTE) and from_user_id=?", [$user_id]);

        if($getLastCountMessages >= 60){
            $app->model->users->update(["status"=>2, "reason_blocking_code"=>"spam", "time_expiration_blocking"=>$app->datetime->addHours(1)->getDate()], ["admin=? and id=?", [0,$user_id]]);
            $app->model->chat_messages->delete("time_create >= DATE_SUB(NOW(),INTERVAL 1 MINUTE) and from_user_id=?", [$user_id]);
            return true;
        }

        $getLastCountMessages = $app->model->chat_messages->count("time_create >= DATE_SUB(NOW(),INTERVAL 10 MINUTE) and from_user_id=? and has_contact_information=?", [$user_id,1]);

        if($getLastCountMessages >= 10){
            $app->model->users->update(["status"=>2, "reason_blocking_code"=>"spam", "time_expiration_blocking"=>$app->datetime->addHours(1)->getDate()], ["admin=? and id=?", [0,$user_id]]);
            $app->model->chat_messages->delete("time_create >= DATE_SUB(NOW(),INTERVAL 10 MINUTE) and from_user_id=? and has_contact_information=?", [$user_id,1]);
            return true;
        }

    }

    return false;
}

public function clearVerifyCodes($contact=[]){
    global $app;
    if($contact["email"] || $contact["phone"]){
        $app->model->users_waiting_verify_code->delete("contact=?", [$contact["email"] ?: $contact["phone"]]);
    }
}

public function fixTraffic(){
    global $app;

    if($app->config->app->prefix_path){

        $uri_explode = explode("/", trim(getAllRequestURI(), "/"));

        if($uri_explode[0] == $app->config->app->prefix_path){
            unset($uri_explode[0]);
        }

        $uri = implode("/", $uri_explode);

    }else{

        $uri = getAllRequestURI();
        
    }

    if($uri){
        $extension = getInfoFile($uri)->extension;
        if($extension){
            return;
        }
    }

    if(isBot(getUserAgent())){
        return;
    }

    $session_id = $app->session->get("user-session-id");

    if($session_id){

        if($app->model->traffic_realtime->find("session_id=?", [$session_id])){
            $app->model->traffic_realtime->update(["uri"=>$uri?:null, "time_update"=>$app->datetime->getDate()], ["session_id=?", [$session_id]]);
        }else{
            $app->model->traffic_realtime->insert(["uri"=>$uri?:null, "session_id"=>$session_id, "time_create"=>$app->datetime->getDate(), "time_update"=>$app->datetime->getDate(), "ip"=>getIp(), "user_agent"=>_json_encode(getUserAgent()), "referer"=>$_SERVER['HTTP_REFERER']?:null]);
        }

        if($app->settings->system_report_status){
            if(!$app->model->traffic_report->find("session_id=?", [$session_id])){
                $app->model->traffic_report->insert(["time_create"=>$app->datetime->getDate(), "session_id"=>$session_id]);
            }
        }

    }

}

public function getAllReasonsBlocking(){
    global $app;

    $result = [];

    foreach ($this->reasonsBlocking() as $key => $value) {
        $result[$key] = $value;
    }

    $getReasons = $app->model->system_reasons_blocking->getAll();
    if($getReasons){
        foreach ($getReasons as $value) {
            $result[$value["code"]] = $value;
        }
    }

    return $result;

}

public function getCurrencyByCode($code=null){
    global $app;
    $currency = (array)$app->config->currency;
    return $currency[$code];
}

public function getDefaultCurrency(){
    global $app;
    return $this->getCurrencyByCode($app->settings->system_default_currency);
}

public function getDefaultPhoneTemplate(){
    global $app;

    $template = (array)$app->config->phone_codes;

    if($app->settings->default_template_phone_iso){
        return $template[$app->settings->default_template_phone_iso];
    }else{
        return $template["RU"];
    }

    return [];

}

public function getPhoneTemplate(){
    global $app;

    $template = (array)$app->config->phone_codes;

    if(!$app->settings->allowed_templates_phone_all_status){
        if($app->settings->allowed_templates_phone){
            if(count($app->settings->allowed_templates_phone) == 1){
                return $template[$app->settings->allowed_templates_phone[0]];
            }
        }
    }

    return [];

}

public function getPhones(){
    global $app;

    $result = [];
    $template = (array)$app->config->phone_codes;

    if(!$app->settings->allowed_templates_phone_all_status){
        if($app->settings->allowed_templates_phone){
            foreach ($app->settings->allowed_templates_phone as $key => $value) {
                $result[$value] = $template[$value];
            }
        }else{
            return $template;
        }
    }else{
        return $template;
    }

    return $result;

}

public function getReasonBlocking($code=null){
    global $app;

    if($code){
        $reasons = $this->getAllReasonsBlocking();
        return (object)$reasons[$code] ?: [];
    }

    return [];

}

public function getSystemFavorites(){
    global $app;

    $favorites = [];
    $result = "";

    $getFavorites = $app->model->system_favorites->sort("id desc")->getAll("user_id=?", [$app->user->data->id]);

    if($getFavorites){
        foreach ($getFavorites as $value) {
            $favorites[] = '
                <div class="dropdown-shortcuts-item col">
                  <span class="dropdown-shortcuts-item-delete template-delete-favorite" data-id="'.$value["id"].'" ><i class="ti ti-trash"></i></span>
                  <span class="dropdown-shortcuts-icon mb-1" >
                    <i class="ti '.$value["page_icon"].' fs-4" ></i>
                  </span>
                  <a href="'.$app->router->getRoute($value["route_name"]).'" class="stretched-link">'.$value["page_name"].'</a>
                </div>
            ';
        }

        $chunk = array_chunk($favorites, 2);

        foreach ($chunk as $key => $nested) {
            $result .= '<div class="row row-bordered overflow-visible g-0">';
            foreach ($nested as $key => $value) {
                $result .= $value;
            }
            $result .= '</div>';
        }

        return $result;

    }else{

        return '
          <div class="header-favorites-empty text-center">
            <i class="ti ti-heart-broken"></i>
            <p>'.translate("tr_1023b68c5302f670fbb32d3fb80febd2").'</p>
          </div>
        ';

    }


}

public function getSystemHomeWidgets(){
    global $app;

    $getWidgets = $app->model->system_home_widgets->sort("sorting asc")->getAll();

    if($getWidgets){
        foreach ($getWidgets as $value) {

            $findWidget = $app->model->system_home_users_widgets->find("user_id=? and widget_id=?", [$app->user->data->id,$value["id"]]);

            if($findWidget){
                echo '
                    <li class="list-group-item d-flex justify-content-between align-items-center list-group-item-padding" draggable="false" >
                      <span class="d-flex justify-content-between align-items-center">
                        <span>'.translateField($value["name"]).'</span>
                      </span>
                      <span>
                        <label class="switch">
                            <input type="checkbox" class="switch-input" value="'.$value["id"].'" name="template_home_widgets[]" checked="" >
                            <span class="switch-toggle-slider">
                              <span class="switch-on"></span>
                              <span class="switch-off"></span>
                            </span>
                        </label>
                      </span>
                    </li>
                ';
            }else{
                echo '
                    <li class="list-group-item d-flex justify-content-between align-items-center list-group-item-padding" draggable="false" >
                      <span class="d-flex justify-content-between align-items-center">
                        <span>'.translateField($value["name"]).'</span>
                      </span>
                      <span>
                        <label class="switch">
                            <input type="checkbox" class="switch-input" value="'.$value["id"].'" name="template_home_widgets[]" >
                            <span class="switch-toggle-slider">
                              <span class="switch-on"></span>
                              <span class="switch-off"></span>
                            </span>
                        </label>
                      </span>
                    </li>
                ';                    
            }

        }
    }

}

public function getSystemTemplate(){
    global $app;

    if($app->user->data->customize_template){
        $app->user->data->customize_template->theme_color = $app->user->data->customize_template->theme_color?:$app->settings->system_default_template_theme_color;
        $app->user->data->customize_template->position_menu = $app->user->data->customize_template->position_menu?:$app->settings->system_default_template_position_menu;
        $app->user->data->customize_template->direction = $app->user->data->customize_template->direction?:$app->settings->system_default_template_direction;
        $app->user->data->customize_template->language = $app->user->data->customize_template->language?:$app->settings->default_language;
        $app->user->data->customize_template->collapsed_sidebar = $app->user->data->customize_template->collapsed_sidebar ? true : false;
        return $app->user->data->customize_template;
    }
     
    return (object)["theme_color"=>$app->settings->system_default_template_theme_color, "position_menu"=>$app->settings->system_default_template_position_menu, "direction"=>$app->settings->system_default_template_direction, "language"=>$app->settings->default_language, "collapsed_sidebar"=>true];

}

public function initСustomizeTemplate(){
    global $app;

    if($this->getSystemTemplate()->theme_color == 'dark'){

        if($this->getSystemTemplate()->direction == 'rtl'){
            $app->asset->registerCss(["view"=>"dashboard", "name"=>"<link rel=\"stylesheet\" href=\"{assets_path}/css/rtl/core-dark.css\" />"]);
            $app->asset->registerCss(["view"=>"dashboard", "name"=>"<link rel=\"stylesheet\" href=\"{assets_path}/css/rtl/theme-default-dark.css\" />"]);
        }else{
            $app->asset->registerCss(["view"=>"dashboard", "name"=>"<link rel=\"stylesheet\" href=\"{assets_path}/css/core-dark.css\" />"]);
            $app->asset->registerCss(["view"=>"dashboard", "name"=>"<link rel=\"stylesheet\" href=\"{assets_path}/css/theme-default-dark.css\" />"]);
        }

    }else{

        if($this->getSystemTemplate()->direction == 'rtl'){
            $app->asset->registerCss(["view"=>"dashboard", "name"=>"<link rel=\"stylesheet\" href=\"{assets_path}/css/rtl/core.css\" />"]);
            $app->asset->registerCss(["view"=>"dashboard", "name"=>"<link rel=\"stylesheet\" href=\"{assets_path}/css/rtl/theme-default.css\" />"]);
        }else{
            $app->asset->registerCss(["view"=>"dashboard", "name"=>"<link rel=\"stylesheet\" href=\"{assets_path}/css/core.css\" />"]);
            $app->asset->registerCss(["view"=>"dashboard", "name"=>"<link rel=\"stylesheet\" href=\"{assets_path}/css/theme-default.css\" />"]);
        }

    }

}

public function installUpdates($files=[]){
    global $app;

    $update_errors = [];
    $update_result = [];
    $max_version = '';
    $compile_core = true;

    $zip = new \ZipArchive;

    if(!_file_put_contents($app->config->storage->files."/temp.txt", "temp")){
        return ["status"=>false, "result"=>translate("tr_63bc728d578f57002448a8439ca255a2") . $app->config->storage->files];
    }else{
        unlink($app->config->storage->files."/temp.txt");
    }

    if($files){

        foreach ($files as $key => $value) {

            $filename = "update_".$key."_".md5(uniqid());

            try {

                if(_mkdir($app->config->storage->files."/".$filename, 0777)){
            
                    if(_file_put_contents($app->config->storage->files."/".$filename."/".$filename.".zip", _file_get_contents($value))){

                        if($zip->open($app->config->storage->files."/".$filename."/".$filename.".zip") === TRUE) {

                            $zip->extractTo($app->config->storage->files."/".$filename."/");
                            $zip->close();

                            unlink($app->config->storage->files."/".$filename."/".$filename.".zip");

                            include($app->config->storage->files."/".$filename."/install.php");

                        }

                    }else{
                        $update_errors[] = translate("tr_31cadc6ecf349ebe52ab305caad87485").$app->config->storage->files."/".$filename.".zip";
                    }

                }else{
                    $update_errors[] = translate("tr_334050c5f836a554afed3509ed00e52e").$app->config->storage->files."/".$filename;
                }

            } catch (Exception $e) {

                logger("Update: {$e->getMessage()}");
                return ["status"=>false, "result"=>$e->getMessage()];

            }

        }

        if($update_errors){
            logger("Update error: ".implode(",", $update_errors));
            return ["status"=>false, "result"=>implode(",", $update_errors)];                
        }

        if($compile_core){

            $result = $app->builder->compileCore();

            if($result["status"]){
                foreach ($files as $key => $value) {
                    $app->model->system_updates->insert(["time_create"=>$app->datetime->getDate(), "version"=>$key]);
                    $max_version = $key;
                }
                $app->model->settings->update($max_version,"system_version");
                $app->model->settings->update($app->datetime->getDate(),"system_last_update");
            }else{
                return ["status"=>false, "result"=>$result["errors"]];
            }

        }else{

            foreach ($files as $key => $value) {
                $app->model->system_updates->insert(["time_create"=>$app->datetime->getDate(), "version"=>$key]);
                $max_version = $key;
            }
            $app->model->settings->update($max_version,"system_version");
            $app->model->settings->update($app->datetime->getDate(),"system_last_update");                

        }

    }

    logger("Update result: ".implode(",", $update_result));
    return ["status"=>true, "result"=>implode(",", $update_result)];

}

public function multiPhonesStatus(){
    global $app;

    $result = [];
    $template = (array)$app->config->phone_codes;

    if(!$app->settings->allowed_templates_phone_all_status){
        if($app->settings->allowed_templates_phone){
            if(count($app->settings->allowed_templates_phone) == 1){
                return false;
            }else{
                return true;
            }
        }else{
            return true;
        }
    }else{
        return true;
    }

    return false;

}

public function outSystemHomeSkeletonWidgets(){
    global $app;

    $getUserWidgets = $app->model->system_home_users_widgets->sort("sorting asc")->getAll("user_id=?", [$app->user->data->id]);
    if($getUserWidgets){
        foreach ($getUserWidgets as $key => $value) {
            $widget = $app->model->system_home_widgets->find("id=?", [$value["widget_id"]]);
            echo $app->view->setParamsComponent(['data'=>(object)$value, 'widget'=>$widget])->includeComponent("home/skeleton.tpl");
        }
    }else{
        echo $app->ui->wrapperInfo('dashboard-no-widgets-home');
    }
        
}

public function outSystemMenu(){
      global $app;

      $getMenu = $app->model->system_menu->sort("sorting asc")->getAll("parent_id=?", [0]);

      foreach ($getMenu as $key => $value) {

        if($value["submenu"] == 0){

          if(isset($app->user->data->privilegesList[$value["route_id"]]["view"]) || $app->user->data->role->chief){
          ?>
            <li class="menu-item <?php if($app->router->currentRoute->route_id == $value["route_id"]){ echo 'active'; } ?>">
              <a href="<?php echo $app->router->getRoute($value["route_alias"]); ?>" class="menu-link">
                <?php echo $value["icon"]; ?>
                <div><?php echo translateField($value["name"]); ?></div>
              </a>
            </li>
          <?php
          }

        }else{

          $getSubmenu = $app->model->system_menu->sort("sorting asc")->getAll("parent_id=?", [$value["id"]]);
          $getItemByRoute = $app->model->system_menu->find("route_id=? and parent_id=?", [$app->router->currentRoute->route_id, $value["id"]]);

          if(!$app->user->data->role->chief){
              if($getSubmenu){
                  foreach ($getSubmenu as $subkey => $subvalue) {
                      if(!$app->user->data->privilegesList[$subvalue["route_id"]]["view"]){
                          unset($getSubmenu[$subkey]);
                      }
                  }
              }
          }

          if($getSubmenu){

             ?>

              <li class="menu-item <?php if($getItemByRoute){ echo 'open'; } ?>">
                <a class="menu-link menu-toggle">
                  <?php echo $value["icon"]; ?>
                  <div><?php echo translateField($value["name"]); ?></div>
                </a>
                <ul class="menu-sub">

                  <?php
                     foreach ($getSubmenu as $subvalue) {
                        ?>

                        <li class="menu-item <?php if($app->router->currentRoute->route_id == $subvalue["route_id"]){ echo 'active'; } ?>">
                          <a href="<?php echo $app->router->getRoute($subvalue["route_alias"]); ?>" class="menu-link">
                            <div><?php echo translateField($subvalue["name"]); ?></div>
                          </a>
                        </li>

                        <?php
                     }
                  ?>

                </ul>
              </li>
                               
             <?php

          }
             
        }

      }        

  }

public function outSystemStaticNotifications($notification=null){
    global $app;

    $answer = '';

    if(isset($notification)){

        if($notification == "cron"){

            if (!$app->settings->crontab_time_last_execution) {
                return '
                  <div class="alert alert-warning d-flex align-items-center" role="alert">
                    <span class="alert-icon text-warning me-2">
                      <i class="ti ti-bell ti-xs"></i>
                    </span>
                    '.translate("tr_9c11ff8889b148b39ac4223a33d884c5").'
                  </div>                    
                ';                    
            }

        }

    }

}

public function outWidgetNotifications(){
    global $app;

    $apiNotifications = [];

    ob_start();

    if($app->settings->uni_api_last_notifications){
        foreach ($app->settings->uni_api_last_notifications as $value) {
            ?>

            <div class="card-widget-slider-item swiper-slide" >
              <h2 class="text-white mb-0 mt-0"> <strong><?php echo $value["title"]; ?></strong> </h2>

              <p class="text-white mb-0 mt-1" ><?php echo $value["text"]; ?></p>

              <?php if($value["button"]){ ?>
              <a class="btn btn-label-primary waves-effect mt-3" href="<?php echo $value["button"]["link"]; ?>" ><?php echo $value["button"]["name"]; ?></a>
              <?php } ?>

            </div>

            <?php
        }
    }

    if(!$app->settings->crontab_time_last_execution){
        ?>
        <div class="card-widget-slider-item swiper-slide" >
          <h2 class="text-white mb-0 mt-0"> <strong><?php echo translate("tr_64b6d889b9cfacde402506be7bc06bf2"); ?></strong> </h2>

          <p class="text-white mb-0 mt-1" ><?php echo translate("tr_4faaa1080cbf3cc29dcedd764e0b16fb"); ?></p>

          <button class="btn btn-label-primary waves-effect mt-3 openModal" data-modal-id="widgetNotificationCronModal" ><?php echo translate("tr_41c72714bbc27f600124f8e97727e17b"); ?></button>

        </div>            
        <?php
    }else{

        if($app->datetime->getTime($app->settings->crontab_time_last_execution) + 300 < $app->datetime->currentTime()){
            ?>
            <div class="card-widget-slider-item swiper-slide" >
              <h2 class="text-white mb-0 mt-0"> <strong><?php echo translate("tr_64b6d889b9cfacde402506be7bc06bf2"); ?></strong> </h2>

              <p class="text-white mb-0 mt-1" ><?php echo translate("tr_96f53b7985f152e753ddfcb63317b4be"); ?></p>

              <button class="btn btn-label-primary waves-effect mt-3 openModal" data-modal-id="widgetNotificationCronModal" ><?php echo translate("tr_41c72714bbc27f600124f8e97727e17b"); ?></button>

            </div>            
            <?php                
        }

    }

    if(!$app->settings->mailer_service){
        ?>
        <div class="card-widget-slider-item swiper-slide" >
          <h2 class="text-white mb-0 mt-0"> <strong><?php echo translate("tr_b39f4099540dd5eb2c0d13e6ed40fde1"); ?></strong> </h2>

          <p class="text-white mb-0 mt-1" ><?php echo translate("tr_dfb918b903b1ae6b5195155de9fb8cd3"); ?></p>

          <a class="btn btn-label-primary waves-effect mt-3" href="<?php echo getUrlDashboard().'/settings/mailing'; ?>" ><?php echo translate("tr_b1c0497af1a1c0e82e6926735e05ba86"); ?></a>

        </div>
        <?php
    }

    if(!$app->settings->integration_payment_services_active){
        ?>
        <div class="card-widget-slider-item swiper-slide" >
          <h2 class="text-white mb-0 mt-0"> <strong><?php echo translate("tr_06af7dd185e713d01d1ec6fe109f6024"); ?></strong> </h2>

          <p class="text-white mb-0 mt-1" ><?php echo translate("tr_7e86b776f84aa82ef517b5bcf9c36b1b"); ?></p>

          <a class="btn btn-label-primary waves-effect mt-3" href="<?php echo getUrlDashboard().'/settings/integrations'; ?>" ><?php echo translate("tr_b1c0497af1a1c0e82e6926735e05ba86"); ?></a>

        </div>
        <?php
    }

    if(!$app->settings->seo_robots_data){
        ?>
        <div class="card-widget-slider-item swiper-slide" >
          <h2 class="text-white mb-0 mt-0"> <strong><?php echo translate("tr_ab95ecb1ed8827ab92a06afe5a20191a"); ?></strong> </h2>

          <p class="text-white mb-0 mt-1" ><?php echo translate("tr_cde6c9ac0938af397cf29455d828fccb"); ?></p>

          <a class="btn btn-label-primary waves-effect mt-3" href="<?php echo getUrlDashboard().'/settings/seo'; ?>" ><?php echo translate("tr_b1c0497af1a1c0e82e6926735e05ba86"); ?></a>

        </div>
        <?php
    }

    return ob_get_clean();

}

public function reasonsBlocking(){

    return [
        "violation_rules" => ["name"=>translate("tr_8783815b28fdab2eff52f6cc19f43259"), "text"=>translate("tr_8783815b28fdab2eff52f6cc19f43259"), "code"=>"violation_rules"],
        "spam" => ["name"=>translate("tr_bb3d0681e32d39bb5f7264e184709856"), "text"=>translate("tr_bb3d0681e32d39bb5f7264e184709856"), "code"=>"spam"],
        "flood" => ["name"=>translate("tr_cf55d3d07c59deb3b0d2b98d48cc5800"), "text"=>translate("tr_cf55d3d07c59deb3b0d2b98d48cc5800"), "code"=>"flood"],
        "offense" => ["name"=>translate("tr_d7ace59fa3da9e2db3ee1de4e52de572"), "text"=>translate("tr_d7ace59fa3da9e2db3ee1de4e52de572"), "code"=>"offense"],
        "fraud" => ["name"=>translate("tr_0e07cf658632b90cd4392cb7bd4d7145"), "text"=>translate("tr_0e07cf658632b90cd4392cb7bd4d7145"), "code"=>"fraud"],
        "sold" => ["name"=>translate("tr_3f5bcbf7df315c0aa22d693f8a780500"), "text"=>translate("tr_3f5bcbf7df315c0aa22d693f8a780500"), "code"=>"sold"],
        "prohibited_goods" => ["name"=>translate("tr_a624ed2c31ba8e9a716045b71e0ae6a5"), "text"=>translate("tr_a624ed2c31ba8e9a716045b71e0ae6a5"), "code"=>"prohibited_goods"],
        "wrong_category" => ["name"=>translate("tr_1c0db56139570b0781d0f4a830644f01"), "text"=>translate("tr_1c0db56139570b0781d0f4a830644f01"), "code"=>"wrong_category"],
        "wrong_price" => ["name"=>translate("tr_3222b337e584a0c838ffab09dda0396d"), "text"=>translate("tr_3222b337e584a0c838ffab09dda0396d"), "code"=>"wrong_price"],
        "incorrect_content" => ["name"=>translate("tr_7b1b58cb9eb302720cce7220aae9751a"), "text"=>translate("tr_7b1b58cb9eb302720cce7220aae9751a"), "code"=>"incorrect_content"],
        "incorrect_phone" => ["name"=>translate("tr_6bcf7df7f0c7a6afda3343c0aeb85d36"), "text"=>translate("tr_6bcf7df7f0c7a6afda3343c0aeb85d36"), "code"=>"incorrect_phone"],
        "incorrect_address" => ["name"=>translate("tr_7adc401231a4b170e6605cdbec5f4300"), "text"=>translate("tr_7adc401231a4b170e6605cdbec5f4300"), "code"=>"incorrect_address"],
        "obscene_content" => ["name"=>translate("tr_a94bcf09a3edd9b4f0c642d8c29f1221"), "text"=>translate("tr_a94bcf09a3edd9b4f0c642d8c29f1221"), "code"=>"obscene_content"],
        "forbidden_words" => ["name"=>translate("tr_fffa4ea57fe6e4878091cc56adde0249"), "text"=>translate("tr_fffa4ea57fe6e4878091cc56adde0249"), "code"=>"forbidden_words"],
        "сontact_information" => ["name"=>translate("tr_49511ab56b12f212691c768fdd4025c1"), "text"=>translate("tr_49511ab56b12f212691c768fdd4025c1"), "code"=>"сontact_information"],
    ];

}

public function searchCombined($query=null){
    global $app;

    $result = [];
    $answer = '';

    if(_mb_strlen($query) < 2){
        return ["status"=>false];
    }

    $searchSettingsSnippets = $app->model->system_settings_search_snippets->getAll("title LIKE ? or subtitle LIKE ?", ['%'.$query.'%','%'.$query.'%']);

    if($searchSettingsSnippets){
        foreach ($searchSettingsSnippets as $key => $value) {
            $result["settings"][] = ["title"=>$value["title"],"subtitle"=>$value["subtitle"], "link"=>getUrlDashboard().'/'.$value["route_name"]];
        }
    }

    $searchUsers = $app->model->users->getAll("(name LIKE ? or surname LIKE ? or email LIKE ? or phone LIKE ? or alias LIKE ?) limit 30", ['%'.$query.'%','%'.$query.'%','%'.$query.'%','%'.$query.'%','%'.$query.'%']);

    if($searchUsers){
        foreach ($searchUsers as $key => $value) {
            $result["users"][] = ["name"=>$app->user->name($value), "link"=>$app->router->getRoute("dashboard-user-card", [$value['id']])];
        }
    }

    $searchItems = $app->model->ads_data->getAll("(search_tags LIKE ? or text LIKE ? or title LIKE ? or article_number=?) limit 30", ['%'.$query.'%','%'.$query.'%','%'.$query.'%',$query]);

    if($searchItems){
        foreach ($searchItems as $key => $value) {
            $value = $app->component->ads->getDataByValue($value);
            $result["items"][] = ["name"=>$value->title, "link"=>$app->component->ads->buildAliasesAdCard($value)];
        } 
    }

    if($result){
        foreach ($result as $type => $nested) {

            if($type == "users"){

                 $answer .= '
                    <div class="header-search-results-box-items" >
                      <p>'.translate("tr_b8c4e70da7bea88961184a1c1be9cb13").'</p>
                ';

                foreach ($nested as $key => $value) {
                    $answer .= '
                      <a class="header-search-results-item" href="'.$value["link"].'" >
                        <span class="header-search-results-item-title" >'.$value["name"].'</span>                        
                      </a>
                    ';
                }

                 $answer .= '
                    </div>
                ';

            }elseif($type == "items"){

                 $answer .= '
                    <div class="header-search-results-box-items" >
                      <p>'.translate("tr_083ab3d9a9221cf6a1641c2c7c5f0d3c").'</p>
                ';

                foreach ($nested as $key => $value) {
                    $answer .= '
                      <a class="header-search-results-item" href="'.$value["link"].'" target="_blank" >
                        <span class="header-search-results-item-title" >'.$value["name"].'</span>                        
                      </a>
                    ';
                }

                 $answer .= '
                    </div>
                ';

            }elseif($type == "settings"){

                 $answer .= '
                    <div class="header-search-results-box-items" >
                      <p>'.translate("tr_c919d65bd95698af8f15fa8133bf490d").'</p>
                ';

                foreach ($nested as $key => $value) {
                    $answer .= '
                      <a class="header-search-results-item" href="'.$value["link"].'" >
                        <span class="header-search-results-item-title" >'.$value["title"].'</span>      
                        <span class="header-search-results-item-subtitle">'.$value["subtitle"].'</span>                  
                      </a>
                    ';
                }

                 $answer .= '
                    </div>
                ';

            }

        }
        return ["status"=>true, "answer"=>$answer];
    }

    return ["status"=>false];

}

public function sendCodeVerifyContact($contact=[], $session_id=null){
    global $app;

    $result = [];

    if(!$session_id){
        $session_id = $app->session->get("user-session-id");
    }

    if(!$session_id && !getIp()){
        return ["status"=>false, "answer"=>translate("tr_eaf72927132caf9363e1382e59040976")];
    }

    $getCountSend = $app->model->users_waiting_verify_code->count("session_id=? or ip=?", [$session_id,getIp()]);

    if($getCountSend >= $app->settings->system_verify_attempts_count){

        $lastTime = $app->model->users_waiting_verify_code->sort("time_create desc")->find("session_id=? or ip=?", [$session_id,getIp()]);
        $time = strtotime($lastTime->time_create) + $app->settings->system_verify_block_time;

        if(time() >= $time){
            $app->model->users_waiting_verify_code->delete("session_id=? or ip=?", [$session_id,getIp()]);
        }else{
            return ["status"=>false, "answer"=>translate("tr_c864c3ee198870d8e76c354ffc383454") . ' ' . $app->datetime->outRemainedTime(time(), $time)];
        }
 
    }

    $code = generateNumberCode($app->settings->confirmation_length_code);

    if($contact["email"]){

        $result = $app->notify->params(["code"=>$code, "text"=>$code, "session_id"=>$session_id])->code("confirm_email")->to($contact["email"])->sendVerifyCode();

        return $result; 

    }elseif($contact["phone"]){

        $result = $app->notify->params(["code"=>$code, "text"=>$code, "session_id"=>$session_id])->to($contact["phone"])->sendVerifyCode();

        return $result; 

    }

    return $result; 

}

public function statisticReportByHours(){
    global $app;

    $result = [];

    $result["users_traffic"] = ["name"=>translate("tr_d664efd59401f509ad4ed40efd99fad1"), "count"=>$app->model->traffic_report->count("time_create >= DATE_SUB(NOW(),INTERVAL ".$app->settings->system_report_period." HOUR)")];
    $result["users"] = ["name"=>translate("tr_5fa90e66fe2996d856e966858464b41e"), "count"=>$app->model->users->count("time_create >= DATE_SUB(NOW(),INTERVAL ".$app->settings->system_report_period." HOUR)")];
    $result["ads"] = ["name"=>translate("tr_0c1f524fbb63b2da064e49ce614af003"), "count"=>$app->model->ads_data->count("time_create >= DATE_SUB(NOW(),INTERVAL ".$app->settings->system_report_period." HOUR)")];
    $result["transactions"] = ["name"=>translate("tr_77f9b85e7d01590d032f2855362be8f7"), "count"=>$app->model->transactions->count("time_create >= DATE_SUB(NOW(),INTERVAL ".$app->settings->system_report_period." HOUR)")];
    $result["transactions_amount"] = ["name"=>translate("tr_7bd619f38bbbe73528f93fb7a276d98a"), "count"=>$app->db->getSumByTotal("amount", "uni_transactions", "time_create >= DATE_SUB(NOW(),INTERVAL ".$app->settings->system_report_period." HOUR)")];
    $result["reviews"] = ["name"=>translate("tr_6e1481c558a14cbcdcabb9a0af726f4e"), "count"=>$app->model->reviews->count("time_create >= DATE_SUB(NOW(),INTERVAL ".$app->settings->system_report_period." HOUR) and status=?", [1])];
    $result["complaints"] = ["name"=>translate("tr_2f9b9237fd75c2a08052eb443ac81458"), "count"=>$app->model->complaints->count("time_create >= DATE_SUB(NOW(),INTERVAL ".$app->settings->system_report_period." HOUR) and status=?", [1])];
    $result["deals"] = ["name"=>translate("tr_a2cd08bbbe3c1bea939897a780561a1c"), "count"=>$app->model->transactions_deals->count("time_create >= DATE_SUB(NOW(),INTERVAL ".$app->settings->system_report_period." HOUR)")];
    $result["users_verifications"] = ["name"=>translate("tr_cc39f940e4267e4311c0e61bc5892809"), "count"=>$app->model->users_verifications->count("time_create >= DATE_SUB(NOW(),INTERVAL ".$app->settings->system_report_period." HOUR) and status=?", ['awaiting_verification'])];

    return arrayToObject($result);

}

public function statisticReportHasData($data){
    global $app;

    $count = 0;

    foreach ($data as $key => $value) {
        $count += $value->count;
    }

    return $count;

}

public function statisticSummaryByMonth(){
    global $app;

    $result = [];

    $result["transactions_amount"] = ["name"=>translate("tr_7bd619f38bbbe73528f93fb7a276d98a"), "count"=>$app->system->amount($app->db->getSumByTotal("amount", "uni_transactions", "year(time_create) = ? and month(time_create) = ?", [$app->datetime->currentYear(), $app->datetime->currentMonth()])), "count_today"=>$app->db->getSumByTotal("amount", "uni_transactions", "date(time_create) = ?", [$app->datetime->format("Y-m-d")->getDate()])];
    $result["users"] = ["name"=>translate("tr_5fa90e66fe2996d856e966858464b41e"), "count"=>$app->model->users->count("year(time_create) = ? and month(time_create) = ?", [$app->datetime->currentYear(), $app->datetime->currentMonth()]), "count_today"=>$app->model->users->count("date(time_create) = ?", [$app->datetime->format("Y-m-d")->getDate()])];
    $result["transactions"] = ["name"=>translate("tr_77f9b85e7d01590d032f2855362be8f7"), "count"=>$app->model->transactions->count("year(time_create) = ? and month(time_create) = ?", [$app->datetime->currentYear(), $app->datetime->currentMonth()]), "count_today"=>$app->model->transactions->count("date(time_create) = ?", [$app->datetime->format("Y-m-d")->getDate()])];
    $result["ads"] = ["name"=>translate("tr_0c1f524fbb63b2da064e49ce614af003"), "count"=>$app->model->ads_data->count("year(time_create) = ? and month(time_create) = ?", [$app->datetime->currentYear(), $app->datetime->currentMonth()]), "count_today"=>$app->model->ads_data->count("date(time_create) = ?", [$app->datetime->format("Y-m-d")->getDate()])];
    $result["deals"] = ["name"=>translate("tr_a2cd08bbbe3c1bea939897a780561a1c"), "count"=>$app->model->transactions_deals->count("year(time_create) = ? and month(time_create) = ?", [$app->datetime->currentYear(), $app->datetime->currentMonth()]), "count_today"=>$app->model->transactions_deals->count("date(time_create) = ?", [$app->datetime->format("Y-m-d")->getDate()])];
    $result["reviews"] = ["name"=>translate("tr_6e1481c558a14cbcdcabb9a0af726f4e"), "count"=>$app->model->reviews->count("year(time_create) = ? and month(time_create) = ?", [$app->datetime->currentYear(), $app->datetime->currentMonth()]), "count_today"=>$app->model->reviews->count("date(time_create) = ?", [$app->datetime->format("Y-m-d")->getDate()])];
    $result["complaints"] = ["name"=>translate("tr_2f9b9237fd75c2a08052eb443ac81458"), "count"=>$app->model->complaints->count("year(time_create) = ? and month(time_create) = ?", [$app->datetime->currentYear(), $app->datetime->currentMonth()]), "count_today"=>$app->model->complaints->count("date(time_create) = ?", [$app->datetime->format("Y-m-d")->getDate()])];
    $result["users_verifications"] = ["name"=>translate("tr_92b89c7ae75b0cd8e9389022ffde6182"), "count"=>$app->model->users_verifications->count("year(time_create) = ? and month(time_create) = ?", [$app->datetime->currentYear(), $app->datetime->currentMonth()]), "count_today"=>$app->model->users_verifications->count("date(time_create) = ?", [$app->datetime->format("Y-m-d")->getDate()])];

    return $result;

}

public function statisticWaitingAction(){
    global $app;

    $result = [];

    $ads = $app->model->ads_data->count("status=?", [0]);

    if($ads){
        $result[] = ["name"=>translate("tr_083ab3d9a9221cf6a1641c2c7c5f0d3c"), "count"=>$ads, "link"=>$app->router->getRoute("dashboard-ads").'?filter[status]=0'];
    }

    $users_verifications = $app->model->users_verifications->count("status=?", ["awaiting_verification"]);

    if($users_verifications){
        $result[] = ["name"=>translate("tr_0fee6aa9a8fb2dea58559f63f73191fc"), "count"=>$users_verifications, "link"=>$app->router->getRoute("dashboard-users-verifications").'?filter[status]=awaiting_verification'];
    }

    $reviews = $app->model->reviews->count("status=?", [0]);

    if($reviews){
        $result[] = ["name"=>translate("tr_1c3fea01a64e56bd70c233491dd537aa"), "count"=>$reviews, "link"=>$app->router->getRoute("dashboard-reviews").'?filter[status]=0'];
    }

    $complaints = $app->model->complaints->count("status=?", [0]);

    if($complaints){
        $result[] = ["name"=>translate("tr_0a60111d2b41f343bed6a257a4c13d0d"), "count"=>$complaints, "link"=>$app->router->getRoute("dashboard-complaints").'?filter[status]=0'];
    }

    $shops = $app->model->shops->count("status=?", ["awaiting_verification"]);

    if($shops){
        $result[] = ["name"=>translate("tr_cfb8af01cc910b08e8796e03cf662f5f"), "count"=>$shops, "link"=>$app->router->getRoute("dashboard-shops").'?filter[status]=awaiting_verification'];
    }

    $deals = $app->model->transactions_deals->count("status_processing=?", ["open_dispute"]);

    if($deals){
        $result[] = ["name"=>translate("tr_b0dc896806dedb7c1e2e5598905315a0"), "count"=>$deals, "link"=>$app->router->getRoute("dashboard-deals").'?filter[status]=open_dispute'];
    }

    return $result;

}

function uniApi($action=null, $params=[]){
    global $app;

    $params["action"] = $action;
    $params["token"] = $app->settings->uniid_token;
    $params["domain"] = getHost(false);
    $params["version"] = $app->settings->system_version;
    $params["lang"] = $app->system->getSystemTemplate()->language;
    
    $url = http_build_query($params);

    return _json_decode(_file_get_contents("{$app->settings->uni_api_link}/api.php?".$url));

}

public function uniDisguiseLink($link=null){
    global $app;
    return "{$app->settings->uni_api_link}/disguiseLink.php?link=".urlencode($link);
}



 }