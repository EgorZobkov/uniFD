public function paymentStatusSuccess()
{   

    $this->view->visible_header = false;
    $this->view->visible_footer = false;

    $order = [];
    return $this->view->render('payment/success', ["order"=>(object)$order, "seo"=>(object)["meta_title"=>translate("tr_fa136a673115aa595edcd74288abdbc1")]]);
    
}