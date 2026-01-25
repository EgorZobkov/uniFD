public function update()
{   

    $total_count = $this->component->cart->totalCountChangeItems($this->user->data->id, $_POST['item_id']);
    $total_amount = $this->component->cart->totalAmount($this->user->data->id, $_POST['item_id']);

    return json_answer(["total_count"=>$total_count, "total_amount"=>$this->system->amount($total_amount)]);

}