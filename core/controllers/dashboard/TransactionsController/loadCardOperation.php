public function loadCardOperation()
{

    if(!$this->user->verificationAccess('view')->status){
        return json_answer(["access"=>false]);
    }
    
    $operation = $this->model->transactions_operations->find("id=?", [$_POST['id']]);

    $operation->data = decrypt($operation->data);
    $operation->callback_data = $operation->callback_data ? decrypt($operation->callback_data) : '-';
    $operation->refund_data = $operation->refund_data ? decrypt($operation->refund_data) : '-';

    return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$operation])->includeComponent('transactions/load-card-operation.tpl')]);
}