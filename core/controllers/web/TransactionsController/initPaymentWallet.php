public function initPaymentWallet()
{

    $result = $this->component->transaction->initPaymentWallet($_POST, $this->user->data->id);

    return json_answer($result);

}