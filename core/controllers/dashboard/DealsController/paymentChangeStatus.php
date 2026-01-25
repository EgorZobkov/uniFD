public function paymentChangeStatus()
{

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }
    
    $this->model->transactions_deals_payments->update(["status_processing"=>$_POST['status'], "comment"=>null, "user_show_error"=>0], $_POST['id']);

    return json_answer(['status'=>true]);

}