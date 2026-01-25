public function getSystemsTimezone(){
    global $app;

    if($app->config->timezone){
        foreach ($app->config->timezone as $key => $value){
            if($app->settings->system_timezone == $key){
                echo '<option value="'.$key.'" selected="" >'.$key.'</option>';
            }else{
                echo '<option value="'.$key.'" >'.$key.'</option>';
            }
        }            
    }

}