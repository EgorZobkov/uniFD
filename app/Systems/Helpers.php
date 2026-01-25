<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

use App\Systems\Session;
use App\Systems\Database;
use App\Systems\ErrorHandler;
use Detection\MobileDetect;

if (!function_exists('_file_get_contents')) {
    function _file_get_contents($data = null)
    {
        return file_get_contents($data);
    }
}

if (!function_exists('_file_put_contents')) {
    function _file_put_contents($filename = null, $data = null, $flag = null)
    {
        return file_put_contents($filename, $data, $flag);
    }
}

if (!function_exists('_json_encode')) {
    function _json_encode($params=[])
    {
        return json_encode($params,JSON_UNESCAPED_UNICODE);
    }
}

if (!function_exists('_json_decode')) {
    function _json_decode($params=[],$associative=true)
    {
        return json_decode($params, $associative);
    }
}

if (!function_exists('_unlink')) {
    function _unlink($file=null)
    {
        unlink($file);
    }
}

if (!function_exists('json_answer')) {
    function json_answer($params=[])
    {
        return _json_encode($params);
    }
}

if (!function_exists('code_answer')) {
    function code_answer($code=null)
    {
        if($code == "record_not_found"){
            return translate("tr_1223dcd0736b6a0a250a5c63b040169e");
        }elseif($code == "delete_successfully"){
            return translate("tr_6f9811271936b72e0d9c1f08d2dca0f4");
        }elseif($code == "add_successfully"){
            return translate("tr_41ccee47d092849723d26014962730cd");
        }elseif($code == "save_successfully"){
            return translate("tr_d06b4135ebb6e3dcb808e76b36cfd60a");
        }elseif($code == "action_successfully"){
            return translate("tr_e3de1e7f001557e31097e57b06a8ef24");
        }elseif($code == "something_went_wrong"){
            return translate("tr_eaf72927132caf9363e1382e59040976");
        }
    }
}


if (!function_exists('_mkdir')) {
    function _mkdir($dir = null, $permissions = '0777')
    {
        return mkdir($dir, $permissions);
    }
}

if (!function_exists('_mb_strlen')) {
    function _mb_strlen($value=null)
    {
        return mb_strlen(trim($value), "UTF-8");
    }
}

if (!function_exists('abort')) {
    function abort($code = 404, $vars = [])
    {
        global $app;
        http_response_code($code);
        $vars['code'] = $code;
        $vars['app'] = $app;
        extract($vars);

        if(file_exists($app->config->resource->answer->path.'/'.$code.'.tpl')){
            require $app->config->resource->answer->path.'/'.$code.'.tpl';
        }elseif(file_exists($app->config->resource->answer->path.'/default.tpl')){
            require $app->config->resource->answer->path.'/default.tpl';
        }else{
            echo '404 - Not found';
        }
        die();
    }
}

if (!function_exists('slug')) {
    function slug($str, $options = array()){
        global $app;

        $str = htmlspecialchars_decode($str, ENT_QUOTES);

        $str = str_replace(["'", '"'], "", $str);

        $defaults = array(
            'delimiter' => '-',
            'limit' => null,
            'lowercase' => true,
            'replacements' => [],
            'transliterate' => true,
        );

        $options = array_merge($defaults, $options);

        $str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);

        if ($options['transliterate']) {
            $str = str_replace(array_keys((array)$app->config->translite), (array)$app->config->translite, $str);
        }

        $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);

        $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);

        $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');

        $str = trim($str, $options['delimiter']);

        return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
    }
}

if (!function_exists('resource')) {
    function resource($filename=null,$path=null,$absolute_url=null){
        global $app;
        if(isset($absolute_url)){
            $url = getHost();
        }else{
            $url = '';
        }
        if(isset($path)) {
            if(isset($filename)){
               return $url.getRelativePath($path) . '/' . trim($filename, '/'); 
            }else{
               return $url.getRelativePath($path);
            }
        }else{ 
            return $url.getRelativePath($app->config->resource->path) . '/' . trim($filename, '/');
        }
    }
}

if (!function_exists('debug')) {
    function debug($message=null){
        $content = '';

        if (is_array($message)) {
            $content .= var_export($message, true).PHP_EOL;
        } elseif (is_object($message)) {
            $content .= var_export($message, true).PHP_EOL;
        } else {
            $content .= $message.PHP_EOL;
        }

        if(isset($content)) {
            _file_put_contents(BASE_PATH.'/debug.log', $content, FILE_APPEND);
        }

    }
}

if (!function_exists('devMode')) {
    function devMode(){
        return ErrorHandler::devMode();
    }
}

if (!function_exists('obContent')) {
    function obContent($content, $variable=[]){
        if(isset($variable)){
            extract($variable);
        }
        ob_start();
        require $content;
        return ob_get_clean();
    }
}

if (!function_exists('getRelativePath')) {
    function getRelativePath($dir=null){
        global $app;

        if($app->config->app->prefix_path){
            $root = str_replace('\\', '/', trim(str_replace($app->config->app->prefix_path, '', BASE_PATH), '/'));
        }else{
            $root = str_replace('\\', '/', BASE_PATH);
        }

        if(isset($dir)) {
            $dir = str_replace('\\', '/', $dir);
            return '/'.trim(str_replace($root, '', $dir), '/');
        }else{
            $dir = str_replace('\\', '/', BASE_PATH);
            return '/'.trim(str_replace($root, '', $dir), '/');
        }

    }
}

if (!function_exists('getHost')) {
    function getHost($protocol=true, $prefix=true){
        global $app;

        if($prefix){
            $prefix_path = $app->config->app->prefix_path ? '/'.$app->config->app->prefix_path : '';
        }

        if($protocol){
            return $app->request->getScheme().'://'.$app->request->getHttpHost().$prefix_path;
        }

        return $app->request->getHttpHost().$prefix_path;
    }
}

if (!function_exists('getAllRequestURI')) {
    function getAllRequestURI(){
        global $app;
        return "/" . trim($app->request->server->get('REQUEST_URI'), "/");
    }
}

if (!function_exists('getRequestURI')) {
    function getRequestURI(){
        global $app;
        $uri = "/" . trim($app->request->server->get('REQUEST_URI'), "/");
        if(strpos($uri, "?") !== false){
            return explode("?", $uri)[0];
        }
        return $uri;
    }
}

if (!function_exists('getFullURI')) {
    function getFullURI(){
        global $app;

        $url = ((!empty($app->request->server->get('HTTPS'))) ? 'https' : 'http') . '://' . $app->request->server->get('HTTP_HOST') . $app->request->server->get('REQUEST_URI');
        return $url;

    }
}

if (!function_exists('clearRequestURI')) {
    function clearRequestURI($uri=null){
        global $app;

        if(!$uri){
            $uri_explode = explode("/", trim(getRequestURI(), "/"));
        }else{
            $uri_explode = explode("/", trim($uri, "/"));
        }

        if($app->config->app->prefix_path){

            if($uri_explode[0] == $app->config->app->prefix_path){
                unset($uri_explode[0]);
            }

        }

        if($app->settings->multi_languages_status){

            $uri_explode = array_values($uri_explode);

            if($uri_explode[0]){
                if($app->model->languages->find("iso=? and status=?", [$uri_explode[0],1])){
                    unset($uri_explode[0]);
                }
            }

        }

        $uri = implode("/", $uri_explode);

        return $uri;

    }
}

if (!function_exists('clearHostInURI')) {
    function clearHostInURI($link=null){
        global $app;
        return '/' . trim(str_replace(trim(getHost(true), "/"), "", $link), "/");
    }
}

if (!function_exists('getRequestParams')) {
    function getRequestParams(){
        global $app;
        return $app->request->server->get('QUERY_STRING');
    }
}

if (!function_exists('getUrlDashboard')) {
    function getUrlDashboard($protocol = true){
        global $app;
        return getHost(true).'/'.$app->config->app->dashboard_alias;
    }
}

if (!function_exists('getLinkCron')) {
    function getLinkCron(){
        global $app;
        return getHost().'/cron/execution/'.$app->config->app->private_service_key;
    }
}

if (!function_exists('outLink')) {
    function outLink($link=null, $out_host=true){
        global $app;

        $host = "";

        if($out_host){
            $host = getHost();
        }

        if($app->settings->multi_languages_status){

            $current_iso = $app->session->get("current-lang");

            if($current_iso){

                $request = trim(getAllRequestURI(), "/");

                if($request){
                    $request = explode("/", $request);
                    if($current_iso != $app->settings->default_language){

                        if($link){
                            return $host."/".$current_iso."/".trim($link, "/");
                        }else{
                            return $host."/".$current_iso;
                        }

                    }
                }

            }

        }

        if($link){
            return $host."/".trim($link, "/");
        }else{
            return $host;
        }

    }
}

if (!function_exists('outRoute')) {
    function outRoute($route=null, $params=[]){
        global $app;

        if($app->settings->multi_languages_status){

            return outLink($app->router->getRoute($route,$params,false,false));

        }

        return $app->router->getRoute($route,$params);

    }
}

if (!function_exists('path')) {
    function path($dir=null, $host=false){
        if($host){
            return getHost(true, false) . getRelativePath($dir);
        }else{
            return getRelativePath($dir);
        }
    }
}

if (!function_exists('clearPath')) {
    function clearPath($dir=null){
        global $app;

        $path = getRelativePath($dir);

        if($app->config->app->prefix_path){
            return "/" . trim(str_replace($app->config->app->prefix_path."/", "", $path), "/");
        }

        return $path;

    }
}

if (!function_exists('getIp')) {
    function getIp(){
        global $app;
        return $app->request->getClientIp();
    }
}

if (!function_exists('getUserAgent')) {
    function getUserAgent(){
        global $app;
        return $app->request->server->get('HTTP_USER_AGENT');
    }
}

if (!function_exists('getGeolocation')) {
    function getGeolocation($ip=null){
        global $app;
        return $app->geo->getInfoLocation($ip);       
    }
}

if (!function_exists('deviceDetect')) {
    function deviceDetect($userAgent=null, $deviceModel=null){

        $deviceType = '';

        if(!$deviceModel){
            if(isset($userAgent)){
                $detect = new MobileDetect();
                $detect->setUserAgent($userAgent);
                $deviceType = ($detect->isMobile() ? ($detect->isTablet() ? translate("tr_510692696afaa09281eabb48113428ea") : translate("tr_f9a74f707a9044f6f1583ad878f2a24e")) : translate("tr_956d56adff05b7d54a7f6cbdad665702"));
            }            
        }else{
            $deviceType = $deviceModel;
        }

        return $deviceType;
    }
}

if (!function_exists('browserDetect')) {
    function browserDetect($userAgent=null){
        global $app;

        $browsers = [
            '/yabrowser/i' => ["name"=>"Yandex", "image"=>$app->storage->name("/storage/images/browser/yandex.png")->host(true)->get()],
            '/msie/i' => ["name"=>"Internet explorer", "image"=>$app->storage->name("/storage/images/browser/microsoft.png")->host(true)->get()],
            '/firefox/i' => ["name"=>"Firefox", "image"=>$app->storage->name("/storage/images/browser/firefox.png")->host(true)->get()],
            '/safari/i' => ["name"=>"Safari", "image"=>$app->storage->name("/storage/images/browser/safari.png")->host(true)->get()],
            '/chrome/i' => ["name"=>"Chrome", "image"=>$app->storage->name("/storage/images/browser/chrome.png")->host(true)->get()],
            '/edge/i' => ["name"=>"Edge", "image"=>$app->storage->name("/storage/images/browser/microsoft.png")->host(true)->get()],
            '/opera/i' => ["name"=>"Opera", "image"=>$app->storage->name("/storage/images/browser/opera.png")->host(true)->get()],
            '/mobile/i' => ["name"=>"Mobile browser", "image"=>$app->storage->name("/storage/images/browser/mobile-app.png")->host(true)->get()],
        ];

        foreach ($browsers as $regex => $value) {
            if (preg_match($regex, $userAgent)) {
                return (object)$value;
            }
        }

        return (object)["name"=>"-", "image"=>$app->storage->host(true)->noImage()];
    }
}

if (!function_exists('isBot')) {
    function isBot($userAgent=null){

        if ($userAgent) {
            $options = [
                'YandexBot', 'YandexAccessibilityBot', 'YandexMobileBot','YandexDirectDyn',
                'YandexScreenshotBot', 'YandexImages', 'YandexVideo', 'YandexVideoParser',
                'YandexMedia', 'YandexBlogs', 'YandexFavicons', 'YandexWebmaster',
                'YandexPagechecker', 'YandexImageResizer','YandexAdNet', 'YandexDirect',
                'YaDirectFetcher', 'YandexCalendar', 'YandexSitelinks', 'YandexMetrika',
                'YandexNews', 'YandexNewslinks', 'YandexCatalog', 'YandexAntivirus',
                'YandexMarket', 'YandexVertis', 'YandexForDomain', 'YandexSpravBot',
                'YandexSearchShop', 'YandexMedianaBot', 'YandexOntoDB', 'YandexOntoDBAPI',
                'Googlebot', 'Googlebot-Image', 'Mediapartners-Google', 'AdsBot-Google',
                'Mail.RU_Bot', 'bingbot', 'Accoona', 'ia_archiver', 'Ask Jeeves', 
                'OmniExplorer_Bot', 'W3C_Validator', 'WebAlta', 'YahooFeedSeeker', 'Yahoo!',
                'Ezooms', 'Tourlentabot', 'MJ12bot', 'AhrefsBot', 'SearchBot', 'SiteStatus', 
                'Nigma.ru', 'Baiduspider', 'Statsbot', 'SISTRIX', 'AcoonBot', 'findlinks', 
                'proximic', 'OpenindexSpider','statdom.ru', 'Exabot', 'Spider', 'SeznamBot', 
                'oBot', 'C-T bot', 'Updownerbot', 'Snoopy', 'heritrix', 'Yeti',
                'DomainVader', 'DCPbot', 'PaperLiBot', 'TelegramBot', 'WhatsApp'
            ];
     
            foreach($options as $row) {
                if (stripos($userAgent, trim($row)) !== false) {
                    return true;
                }
            }
        }
     
        return false; 

    }
}

if (!function_exists('generationCsrfToken')) {
    function generationCsrfToken(){
        $token = bin2hex(random_bytes(32));
        Session::setSubarray('csrf-token',$token);
        return $token;
    }
}

if (!function_exists('generateUuid')){ 
    function generateUuid() {
        return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
            mt_rand( 0, 0xffff ),
            mt_rand( 0, 0x0fff ) | 0x4000,
            mt_rand( 0, 0x3fff ) | 0x8000,
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }
}

if (!function_exists('generateCode')) {
    function generateCode($length=6){
        $arr = [
            'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 
            'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',        
            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 
            'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 
            '1', '2', '3', '4', '5', '6', '7', '8', '9', '0'
        ];
     
        $result = '';
        for ($i = 0; $i < $length; $i++) {
            $result .= $arr[random_int(0, count($arr) - 1)];
        }
        return $result;
    }
}

if (!function_exists('generateNumberCode')) {
    function generateNumberCode($length=6){

        $arr = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'];
     
        $result = '';
        for ($i = 0; $i < $length; $i++) {
            $result .= $arr[random_int(0, count($arr) - 1)];
        }
        return $result;
    }
}

if (!function_exists('generateHashString')) {
    function generateHashString(){
        return hash('sha256', time().uniqid());
    }
}

if (!function_exists('generateOrderId')) {
    function generateOrderId(){
        return mt_rand(10000000000000, 99999999999999);
    }
}

if (!function_exists('_setcookie')) {
    function _setcookie($params=[]){
        setcookie($params["key"], $params["value"], [
            "expires" => (int)$params["lifetime"],
            "path" => "/",
            "secure" => true,
            "httponly" => true,
            "samesite" => "Strict"       
        ]);
    }
}

if (!function_exists('_getcookie')) {
    function _getcookie($key=null){
        return isset($_COOKIE[$key]) ? $_COOKIE[$key] : null;
    }
}

if (!function_exists('goToRoute')) {
    function goToRoute($name=null){
        global $app;
        $app->router->goToRoute($name);
    }
}

if (!function_exists('_ucfirst')) {
    function _ucfirst($string="", $firstLetter=false){
        $firstChar = mb_substr(trim($string), 0, 1, "utf-8");
        $then = mb_substr(trim($string), 1, null, "utf-8");
        return $firstLetter ? mb_strtoupper($firstChar, "utf-8") : mb_strtoupper($firstChar, "utf-8") . $then;
    }
}

if (!function_exists('_strtoupper')) {
    function _strtoupper($string=""){
        return mb_strtoupper($string, "utf-8");
    }
}

if (!function_exists('_strtolower')) {
    function _strtolower($string=""){
        return mb_strtolower($string, "utf-8");
    }
}

if (!function_exists('trimStr')) {
    function trimStr($string=null, $max=null, $dots=false){
        if(isset($string)){
            if(mb_strlen($string, "utf-8") > $max){
                if($dots){
                    return mb_substr($string, 0, $max, "utf-8") . '...';
                }else{
                    return mb_substr($string, 0, $max, "utf-8");
                }
            }
        }
        return $string;
    }
}

if (!function_exists('trimPrice')) {
    function trimPrice($amount=0, $max=null){
        if($amount){
            if(mb_strlen($amount, "utf-8") > $max){
                return mb_substr($amount, 0, $max, "utf-8");
            }
        }
        return $amount;
    }
}

if (!function_exists('formattedPrice')){     
   function formattedPrice($amount=null)
   {
        $amount = preg_replace('/[^0-9.,]/', '', $amount);
        return $amount ? trimPrice($amount, 10) : 0;
   }
}

if (!function_exists('breakStr')) {
    function breakStr($string=null, $max=null){
        if($string){
            if(mb_strlen($string, "utf-8") > $max){
                return mb_substr($string, 0, $max, "utf-8") . '<br>' . mb_substr($string, $max, mb_strlen($string, "utf-8"), "utf-8");
            }else{
                return $string;
            }
        }
        return $string;
    }
}

if (!function_exists('_deletecookie')) {
    function _deletecookie($key=null){
        setcookie($key, '', -1, '/');
    }
}

if (!function_exists('normalizeFilesArray')) {
    function normalizeFilesArray($files=[]) {

        if($files["tmp_name"]){
            return [$files];
        }

        $result = [];

        if($files){

            foreach ($files as $key => $nested) {
                if(is_array($nested)){
                    foreach ($nested as $key2 => $value) {
                        $result[$key2][$key] = $value;
                    }
                }else{
                    if(trim($files['name'])){
                        $result[] = $files;
                    }
                    break;
                }
            }

        }

        return $result;

    }
}

if (!function_exists('getInfoFile')) {
    function getInfoFile($filename=null) {
        $path_info = pathinfo($filename);
        return $path_info ? (object)$path_info : [];
    }
}

if (!function_exists('encrypt')) {
    function encrypt($plaintext) {
      global $app;
      $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
      $iv = openssl_random_pseudo_bytes($ivlen);
      $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $app->config->app->encryption_token, $options=OPENSSL_RAW_DATA, $iv);
      $hmac = hash_hmac('sha256', $ciphertext_raw, $app->config->app->encryption_token, $as_binary=true);
      return base64_encode( $iv.$hmac.$ciphertext_raw );
    }
}

if (!function_exists('decrypt')) {
    function decrypt($ciphertext) {
      global $app;
      if($ciphertext){
        $c = base64_decode($ciphertext);
        $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
        $iv = substr($c, 0, $ivlen);
        $hmac = substr($c, $ivlen, $sha2len=32);
        $ciphertext_raw = substr($c, $ivlen+$sha2len);
        $plaintext = openssl_decrypt($ciphertext_raw, $cipher, $app->config->app->encryption_token, $options=OPENSSL_RAW_DATA, $iv);
        $calcmac = hash_hmac('sha256', $ciphertext_raw, $app->config->app->encryption_token, $as_binary=true);
        if (hash_equals($hmac, $calcmac))
        {
            return $plaintext;
        }
      }
    }
}

if (!function_exists('randomColor')) {
    function randomColor($opacity=null){
        if($opacity){
            return "rgba(".rand(0, 255).", ".rand(0, 255).", ".rand(0, 255).", ".$opacity.")";
        }
        return "rgba(".rand(0, 255).", ".rand(0, 255).", ".rand(0, 255).")";
    }
}

if (!function_exists('randomColorHex')) {
    function randomColorHex(){   
        $red = mt_rand(0, 255);
        $green = mt_rand(0, 255);
        $blue = mt_rand(0, 255);

        $hex = sprintf("#%02x%02x%02x", $red, $green, $blue);  
        return $hex;
    }
}

if (!function_exists('randomColorCertain')) {
    function randomColorCertain(){
        $certain = ['#B2EC5D','#9ACD32','#BEBD7F','#D8DEBA','#FFCA86','#A8E4A0','#009B77','#9FE2BF','#78DBE2','#30D5C8','#42AAFF','#30BA8F','#9966CC','#CDA4DE','#DBD7D2'];
        return $certain[mt_rand(0, count($certain)-1)];
    }
}

if (!function_exists('endingWord')) {
    function endingWord($number, $one, $two, $five) {
        $number = $number % 100;
        if (($number > 4 && $number < 21) || $number == 0){
            $ending = $five;
        }else{
            $last_digit = substr($number, -1);
            if ($last_digit > 1 && $last_digit < 5)
                $ending = $two;
            elseif ($last_digit == 1)
                $ending = $one;
            else
                $ending = $five;
        }
        return $ending;
    }
}

if (!function_exists('curl')) {
    function curl($method=null, $url=null, $params=[], $header=[]) {

        if($method == "get"){

            if($params){
                $ch = curl_init($url . '?' . http_build_query($params));
            }else{
                $ch = curl_init($url);
            }

            curl_setopt($ch, CURLOPT_POST, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        }elseif($method == "post"){
            
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

        }

        if($header){
            curl_setopt($ch, CURLOPT_HEADER, true);
            foreach ($header as $key => $value) {
                $header_data[] = $key . ":" . $value;
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header_data);
        }else{
            curl_setopt($ch, CURLOPT_HEADER, false);
        }

        $result = curl_exec($ch);
        $curl_error = curl_error($ch);

        curl_close($ch);

        if($curl_error){
            logger("Curl: " . $curl_error);
        }

        return $result;

    }
}

if (!function_exists('logger')) {
    function logger($message=null) {

        $storage = (object)require BASE_PATH . '/config/storage.php';

        if (is_dir($storage->logs)) {

            if (isset($message)) {

                $content = '['.date('Y-m-d H:i:s').']: ';

                if (is_array($message)) {
                    $content .= var_export($message, true).PHP_EOL;
                } elseif (is_object($message)) {
                    $content .= var_export($message, true).PHP_EOL;
                } else {
                    $content .= $message.PHP_EOL;
                }

                file_put_contents($storage->logs.'/logs_'.date('Y-m-d').'.log', $content, FILE_APPEND);

            }

        }

    }
}

if (!function_exists('requestBuildVars')) {
    function requestBuildVars($variables=[], $request=null) {
        global $app;
        $query = [];

        if(!$request){

            $parse = parse_url($app->request->server->get('REQUEST_URI'));

            if(isset($parse['query'])){
                parse_str($parse['query'], $query);
                return '?' . http_build_query(array_merge($query,$variables));
            }

            return '?' . http_build_query($variables);

        }else{

            return '?' . http_build_query(array_merge($request,$variables));

        }

    }
}

if (!function_exists('globRecursive')){     
   function globRecursive($path=null, $nestedPath=null)
   {
        if (is_null($nestedPath)) {
            $nestedPath = '';
        } else {
            $nestedPath .= basename($path) . '/';
        }
     
        $data = [];
        foreach(glob($path . '/*') as $file) {
            if (is_dir($file)) {
                $data = array_merge($data, globRecursive($file, $nestedPath));
            } else {
                $data[] = (object)["folder"=>$nestedPath, "path"=>$file];
            }
        }
     
        return $data;
   }
}

if (!function_exists('numberFormat')){     
   function numberFormat($value=null,$decimals=0,$decimal_separator=".",$thousands_separator=",")
   {
        return number_format($value,$decimals,$decimal_separator,$thousands_separator);
   }
}

if (!function_exists('percentToCompletion')){     
   function percentToCompletion($numberStart=0,$numberEnd=0)
   {
        $result = round(($numberStart / $numberEnd) * 100, 2);
        $result = $result > 100 ? 100 : $result;
        return $result;
   }
}

if (!function_exists('formattedPhone')){     
   function formattedPhone($string=null)
   {
        return $string;
   }
}

if (!function_exists('issetNull')){     
   function issetNull($string=null)
   {
        return isset($string) ? $string : null;
   }
}

if (!function_exists('isJson')){ 
    function isJson($str)
    {
        return is_array(_json_decode($str));
    }
}

if (!function_exists('compareValues')){ 
    function compareValues($items=null, $value=null)
    {

        if(is_array($items)){
            if(in_array($value, $items)){
                return true;
            }
        }else{
            if((string)$items == (string)$value){
                return true;
            }
        }
        return false;
    }
}

if (!function_exists('arrayToObject')){ 
    function arrayToObject($array=[])
    {

        return (object)json_decode(json_encode($array), false);

    }
}

if (!function_exists('createFolder')){ 
    function createFolder($path)
    {

        if(!is_dir($path)){
            mkdir($path, 0777, true);
        }
        
    }
}

if (!function_exists('calculatePercent')){ 
    function calculatePercent($amount=0, $percent=0)
    {
        if($amount && $percent){
            return (($amount / 100) * $percent);
        }
        return 0;
    }
}

if (!function_exists('outTextWithLinks')){ 
    function outTextWithLinks($text=null, $nl2br=true)
    {

        if($nl2br){
            $text = nl2br($text);
        }

        $text = preg_replace("/(^|[\n ])([\w]*?)((www|ftp)\.[^ \,\"\t\n\r<]*[^ \.])/is", "$1$2<a href=\"http://$3\" >$3</a>", $text);
        $text = preg_replace("/(^|[\n ])([\w]*?)((ht|f)tp(s)?:\/\/[\w]+[^ \,\"\n\r\t<]*[^ \.])/is", "$1$2<a href=\"$3\" >$3</a>", $text);
        
        return($text);
       
    }
}

if (!function_exists('buildAttributeParams')){ 
    function buildAttributeParams($data=[])
    {
        return urlencode(_json_encode($data));
    }
}

if (!function_exists('outUserLinkTelegramBot')){ 
    function outUserLinkTelegramBot($uniq_hash=null)
    {
        global $app;
        return $app->addons->messenger("telegram")->outUserLinkBot($uniq_hash);
    }
}

if (!function_exists('deleteFolder')){ 
    function deleteFolder($dir=null, $extensions="*") {
        if(isset($dir) && $dir != "/" && trim($dir, "/") != trim(BASE_PATH, "/") && is_dir($dir)){
            if ($objs = glob($dir."/".$extensions)) {
                foreach($objs as $obj) {
                    is_dir($obj) ? deleteFolder($dir, $extensions) : _unlink($obj);
                }
            }
            rmdir($dir);
        }
    }
}

if (!function_exists('getInitialsString')) {
    function getInitialsString($string=null){

        $string = trim($string);

        if(_mb_strlen($string) <= 12){
            return $string;
        }

        if($string){

            if(strpos($string, "-") !== false){
                $result = explode("-", $string);
                return _ucfirst($result[0], true)._ucfirst($result[1], true);
            }elseif(strpos($string, " ") !== false){
                $result = explode(" ", $string);
                return _ucfirst($result[0], true)._ucfirst($result[1], true);
            }elseif(strpos($string, ".") !== false){
                $result = explode(".", $string);
                return _ucfirst($result[0], true)._ucfirst($result[1], true);
            }else{
                $result = mb_str_split($string);
                return _ucfirst($result[0], true)._ucfirst($result[1], true);
            }

        }

    }
}

if (!function_exists('translate')) {
    function translate($string=null){
        global $app;

        return $app->translate->code($string);

    }
}

if (!function_exists('translateField')) {
    function translateField($string=null){
        global $app;

        return $app->translate->code($string);

    }
}

if (!function_exists('translateFieldReplace')) {
    function translateFieldReplace($value=[], $field=null, $iso=null){
        global $app;

        $value = (array)$value;

        if($app->view->isolated == "dashboard"){
            return $value[$field];
        }

        $current_iso = $iso ?: $app->session->get("current-lang");

        if($current_iso){
            if($current_iso != $app->settings->default_language){
                return $value[$field . "_" . $current_iso] ?: $value[$field];
            }
        }

        return $value[$field];

    }
}

if (!function_exists('getMainDomain')){ 
    function getMainDomain($domain=null){
       global $app;

       if(!$domain){
            return;
       }

       $list_main_zones = $app->config->domain_zones;

       if( strpos($domain, "://") !== false ){
           $explode_protocol = explode("://", $domain);
           unset($explode_protocol[0]);
           $explode_point = explode(".", $explode_protocol[1]);
           if( $explode_point[0] == "www" ){
               unset($explode_point[0]);
           }
       }else{
           $explode_point = explode(".", $domain);
           if( $explode_point[0] == "www" ){
               unset($explode_point[0]);
           }       
       }

       $domain = array_values($explode_point);

       if( count($domain) == 2 ){

           return implode(".", $domain);

       }elseif( count($domain) >= 3 ){

           foreach ($list_main_zones as $zone) {

               if($zone == '.'.$domain[count($domain)-1]){
                 unset($domain[0]);
                 return implode(".", $domain);

               }elseif($zone == '.'.$domain[count($domain)-2].'.'.$domain[count($domain)-1]){

                 if( count($domain) >= 4 ){
                     unset($domain[0]);
                     return implode(".", $domain);
                 }else{
                     return implode(".", $domain);
                 }
                 
               }

           }

       }
    }
}

if (!function_exists('detectBankCardType')) {
    function detectBankCardType($card_num){
        $card_num=preg_replace('/[^0-9]/','',$card_num);
        $card_prefixes = array(
            'Visa' => '/^4/',
            'Mastercard' => '/^(5[1-5]|(?:222[1-9]|22[3-9][0-9]|'.
                            '2[3-6][0-9]{2}|27[01][0-9]|2720))/',
            'Мир' => '/^220[0-4]/',
            'China UnionPay' => '/^(62|88)/',
        );
        foreach ($card_prefixes as $type => $regexp) {
            if (preg_match($regexp, $card_num)) {
                return $type;
            }
        }
        return null;
    }
}

if (!function_exists('distanceByCoordinates')) {
    function distanceByCoordinates($lat_1, $lon_1, $lat_2, $lon_2){
        $radius_earth = 6371;

        $lat_1 = deg2rad($lat_1);
        $lon_1 = deg2rad($lon_1);
        $lat_2 = deg2rad($lat_2);
        $lon_2 = deg2rad($lon_2);

        $d = 2 * $radius_earth * asin(sqrt(sin(($lat_2 - $lat_1) / 2) ** 2 + cos($lat_1) * cos($lat_2) * sin(($lon_2 - $lon_1) / 2) ** 2));

        return $d;
    }
}

