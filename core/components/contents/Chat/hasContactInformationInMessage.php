public function hasContactInformationInMessage($text=null){
    global $app;

    if($text){

          if(preg_match('/([A-Za-z0-9_\-]+\.)*[A-Za-z0-9_\-]+@([A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9]\.)+[A-Za-z]{2,4}/u',$text)){
              return true;
          }

          foreach ($app->config->phone_codes as $phone) {
              if(strpos($text, "+".$phone->code) !== false){
                  return true;
              }
          }

          foreach ($app->config->domain_zones as $zone) {
              if(strpos($text, $zone) !== false){
                  return true;
              }
          }

          if(strpos($text, "://") !== false || strpos($text, "www.") !== false || strpos($text, "http") !== false){
              return true;
          }

    }

    return false;

}