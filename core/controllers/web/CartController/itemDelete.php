public function itemDelete()
{   

    $this->component->cart->delete($_POST['id'], $this->user->data->id);
    return json_answer(["status"=>true]);

}