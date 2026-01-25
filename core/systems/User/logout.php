public function logout(){
    global $app;
    $token = $this->getToken();
    if(isset($token)){
        $app->model->auth->delete('token=?', [$token]);
        $this->deleteToken();      
    }
    $app->session->delete("administrator-enter-profile");
}