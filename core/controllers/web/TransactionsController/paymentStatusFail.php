public function paymentStatusFail()
{   

    $this->view->visible_header = false;
    $this->view->visible_footer = false;

    $order = [];
    return $this->view->render('payment/fail', ["order"=>(object)$order, "seo"=>(object)["meta_title"=>translate("tr_94848568e6805b1081f23272106f9548")]]);
    
}