public function itemPlusCount()
{   

    $result = $this->component->cart->plusCount($_POST['id'], $this->user->data->id);

    return json_answer(["count"=>$result->count, "price"=>$this->system->amount($result->price)]);

}