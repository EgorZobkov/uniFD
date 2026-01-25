public function initPaymentItem()
{   

    if(!$this->component->profile->checkVerificationPermissions($this->user->data->id, "create_order")){
        return json_answer(["verification"=>false]);
    }

    $result = $this->component->transaction->initPaymentItem($_POST["id"], $_POST["delivery_point_id"], $this->user->data->id);

    return json_answer($result);

}