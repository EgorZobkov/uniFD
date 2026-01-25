public function deleteToken(){
    global $app;
    if(isset($this->dashboard)){
        $app->session->delete("dashboard-token-auth");
        _deletecookie("dashboard-token-auth");
    }else{
         $app->session->delete("token-auth");
        _deletecookie("token-auth");           
    }
}