public function payment()
{   

    if(!$this->component->profile->checkVerificationPermissions($this->user->data->id, "create_order")){
        return json_answer(["verification"=>false]);
    }

    $delivery_points = [];
    $items_id = $this->session->get($_POST['session']);

    if($_POST['delivery_points']){
        parse_str($_POST['delivery_points'], $delivery_points);
    }else{
        $delivery_points = [];
    }

    $result = $this->component->transaction->initPaymentCart($items_id, $delivery_points ? $delivery_points["delivery_point_id"] : [], $this->user->data->id);

    return json_answer($result);

}