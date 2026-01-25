public function outHintAuth(){
    global $app;

    if($app->settings->registration_authorization_method == "email-phone"){
        return translate("tr_67447516ca358807f932af8f1f6b5382");
    }

    if($app->settings->registration_authorization_method == "email"){
        return translate("tr_3fad34c27c3081915cd17c2537551da0");
    }
       
    if($app->settings->registration_authorization_method == "phone"){
        return translate("tr_2afc9a58330df7d927a3f146028092ac");
    }

    if($app->settings->registration_authorization_method == "services"){
        return translate("tr_03b84f2ef87ed6858a43803016b6f643");
    }

}