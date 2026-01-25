public function paymentStatusOrder($order_id=null)
{   

    $this->view->visible_header = false;
    $this->view->visible_footer = false;

    $order = $this->component->transaction->getOperation($order_id);

    if(!$order){
        return $this->view->render('payment/fail', ["order"=>(object)$order, "seo"=>(object)["meta_title"=>translate("tr_39747e975806eaa650385b84f760cb92")]]);
    }else{
        if($order->status_processing == "awaiting_payment"){
            return $this->view->render('payment/awaiting_payment', ["order"=>(object)$order, "seo"=>(object)["meta_title"=>translate("tr_be476b6da31948fbd3fcb3021718cfb6")]]);
        }elseif($order->status_processing == "paid"){
            return $this->view->render('payment/success', ["order"=>(object)$order, "seo"=>(object)["meta_title"=>translate("tr_1ec8bd15c6af4d32aea09b6e7ad4f1f3")]]);
        }elseif($order->status_processing == "awaiting_refund"){
            return $this->view->render('payment/awaiting_refund', ["order"=>(object)$order, "seo"=>(object)["meta_title"=>translate("tr_fec1f30fcfe956fed8f5f2b5446abd10")]]);
        }elseif($order->status_processing == "refund"){
            return $this->view->render('payment/refund', ["order"=>(object)$order, "seo"=>(object)["meta_title"=>translate("tr_8c5fa79d745ebec6136f766f37ffacbe")]]);
        }elseif($order->status_processing == "error"){
            return $this->view->render('payment/fail', ["order"=>(object)$order, "seo"=>(object)["meta_title"=>translate("tr_c6fd3c6a629b51b28c19e8495994f4ca")]]);
        }
    }

}