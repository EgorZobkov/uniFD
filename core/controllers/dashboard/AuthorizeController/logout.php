public function logout(){
    $this->user->dashboard(true)->logout();
    $this->router->goToRoute("dashboard-auth");
}