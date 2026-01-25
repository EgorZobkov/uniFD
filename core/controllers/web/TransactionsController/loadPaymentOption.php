public function loadPaymentOption()
{

    return json_answer(['content'=>$this->component->transaction->optionsPayment($_POST["params"] ?_json_decode(urldecode($_POST["params"])) : $_POST)]);

}