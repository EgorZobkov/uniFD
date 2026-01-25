public function login()
{   

    if($this->user->data->id){
        $this->router->goToRoute("profile");
    }  

    $seo = $this->component->seo->content();      

    return $this->view->render('auth', ["seo"=>$seo]);
}