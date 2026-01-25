public function createSessionId(){
    global $app;

    $session_id = md5(time().uniqid());

    if(_getcookie("user-session-id")){
        $session_id = _getcookie("user-session-id");
    }elseif($app->session->get("user-session-id")){
        $session_id = $app->session->get("user-session-id");
    }

    _setcookie(["key"=>"user-session-id", "value"=>$session_id, "lifetime"=>strtotime('+360 days')]);
    $app->session->set("user-session-id", $session_id);

}