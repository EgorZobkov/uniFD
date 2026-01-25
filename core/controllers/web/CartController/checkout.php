public function checkout(){   

    $this->view->visible_header = false;
    $this->view->visible_footer = false;

    $data = (object)[];

    if(!$this->settings->basket_status){
        abort(404);
    }

    if(!$this->session->get($_GET['session_id']) || !$_GET['session_id']){
        abort(404);
    }

    $data->items = $this->component->cart->getCartItems($this->user->data->id, $this->session->get($_GET['session_id']));

    if(!$data->items){
        abort(404);
    }

    $data->session_id = $_GET['session_id'];
    $data->total_count = $this->component->cart->totalCountChangeItems($this->user->data->id, $this->session->get($_GET['session_id']));
    $data->total_amount = $this->component->cart->totalAmount($this->user->data->id, $this->session->get($_GET['session_id']));

    $seo = $this->component->seo->content();

    return $this->view->render('cart-checkout', ["data"=>(object)$data, "seo"=>$seo]);
}