public function getSystemsCurrencies(){
    global $app;

    if($app->config->currency){
        foreach ($app->config->currency as $key => $value){
            if($app->settings->system_default_currency == $key){
                echo '<option value="'.$key.'" selected="" >'.$value->name.' ('.$value->symbol_native.')</option>';
            }else{
                echo '<option value="'.$key.'" >'.$value->name.' ('.$value->symbol_native.')</option>';
            }
        }            
    }

}