public function updateCountMessages()
{   

    return json_answer($this->component->chat->updateCountMessages($this->user->data->id));

}