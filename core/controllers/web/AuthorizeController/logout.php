public function logout(){   
    $this->user->logout();
    $this->router->goToRoute("auth");
}