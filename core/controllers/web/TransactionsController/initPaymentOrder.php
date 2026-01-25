public function initPaymentOrder()
{   

    if(!$this->component->profile->checkVerificationPermissions($this->user->data->id, "create_order")){
        return json_answer(["verification"=>false]);
    }

    $result = $this->component->transaction->initPaymentOrder($_POST["id"], $this->user->data->id);

    return json_answer($result);

}