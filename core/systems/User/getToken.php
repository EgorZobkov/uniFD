public function getToken(){
    global $app;
    $token = null;

    if(isset($this->dashboard)){
        if($app->session->get("dashboard-token-auth")){
            $token = $app->clean->str($app->session->get("dashboard-token-auth"));
        }elseif(_getcookie("dashboard-token-auth")){
            $token = $app->clean->str(_getcookie("dashboard-token-auth"));
            $app->session->set("dashboard-token-auth", $token);
        }
    }else{
        if($app->session->get("token-auth")){
            $token = $app->clean->str($app->session->get("token-auth"));
        }elseif(_getcookie("token-auth")){
            $token = $app->clean->str(_getcookie("token-auth"));
            $app->session->set("token-auth", $token);
        }            
    }

    return $token;
}