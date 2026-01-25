public function orderCard($order_id)
{   

    $this->view->visible_header = false;
    $this->view->visible_footer = false;

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/transaction.js\" type=\"module\" ></script>"]);

    $data = $this->component->transaction->getDealByOrderId($order_id);

    if($data){
        if($data->from_user_id != $this->user->data->id && $data->whom_user_id != $this->user->data->id){
            abort(404);
        }
    }else{
        abort(404);
    }

    $data->payment_service = $this->component->transaction->getServiceSecureDeal();

    if($data->item->booking_status){

        $data->order = $this->model->booking_orders->find("order_id=?", [$data->order_id]);

        return $this->view->render('order/card-booking', ["data"=>(object)$data, "seo"=>(object)["meta_title"=>translate("tr_dad1404ddfa1a8ad48138c0765544fbb").$order_id]]);
        
    }else{
        return $this->view->render('order/card', ["data"=>(object)$data, "seo"=>(object)["meta_title"=>translate("tr_dad1404ddfa1a8ad48138c0765544fbb").$order_id]]);
    }
    
}