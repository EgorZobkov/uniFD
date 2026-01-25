public function updateCount()
{   

    $count = $this->component->cart->count($this->user->data->id);
    return json_answer(["count"=>$count]);

}