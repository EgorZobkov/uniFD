public function initPaymentTarget()
{

    $result = $this->component->transaction->initPaymentTarget($_POST["payment_id"], $_POST["params"] ?_json_decode(urldecode($_POST["params"])) : [], $this->user->data->id);

    return json_answer($result);

}