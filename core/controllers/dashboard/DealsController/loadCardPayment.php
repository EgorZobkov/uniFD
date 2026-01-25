public function loadCardPayment()
{

    if(!$this->user->verificationAccess('view')->status){
        return json_answer(["access"=>false]);
    }
    
    $data = $this->model->transactions_deals_payments->find("id=?", [$_POST['id']]);

    $data->whom_user = $this->model->users->findById($data->whom_user_id);
    $data->payment_data = $this->component->profile->getPaymentData($data->whom_user_id);

    return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('deals/load-card-payment.tpl')]);
}