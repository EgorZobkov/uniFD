public function card($order_id)
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/deals.js\" type=\"module\" ></script>"]);

    $data = $this->component->transaction->getDealByOrderId($order_id);

    if(!$data){
        abort(404);
    }

    $data->payments = $this->model->transactions_deals_payments->getAll("order_id=?", [$order_id]);

    $this->view->setParamsComponent(["data"=>(object)$data, "breadcrumbs"=>["chain"=>[translate("tr_9a3dc867f2fd583f53c561442ecf34b0")=>$this->router->getRoute("dashboard-deals"), $order_id=>null]]]);

    return $this->view->preload('deals/card', ["data"=>(object)$data, "title"=>translate("tr_9a3dc867f2fd583f53c561442ecf34b0")]);

}