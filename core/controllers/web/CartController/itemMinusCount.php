public function itemMinusCount()
{   

    $result = $this->component->cart->minusCount($_POST['id'], $this->user->data->id);

    return json_answer(["count"=>$result->count, "price"=>$this->system->amount($result->price)]);

}