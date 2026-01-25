public function cart(){   

    $this->view->visible_header = false;
    $this->view->visible_footer = false;

    $data = (object)[];

    if(!$this->settings->basket_status){
        abort(404);
    }

    $data->items = $this->component->cart->getCartItems($this->user->data->id);

    $seo = $this->component->seo->content();

    return $this->view->render('cart', ["data"=>(object)$data, "seo"=>$seo]);
}