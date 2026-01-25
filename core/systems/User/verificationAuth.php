public function verificationAuth($token=null){
    global $app;

    if(!isset($token)){
        $token = $this->getToken();
    }

    if(!$this->dashboard){
        if($app->session->get("administrator-enter-profile")){

            $user = $this->getData($app->session->get("administrator-enter-profile"));

            if($user && !$user->delete){
                $this->data = $user;
                return true;
            }
            
        }
    }
    
    if(isset($token)){

        $auth = $this->isAdminAuth($token);

        if($auth->status){

            $user = $this->getData($auth->user_id);

            if($user && !$user->delete){
                $this->data = $user;
                $this->setTimeLastActivity($auth->user_id);
                return true;
            }
                
        }

    }

    return false;
}