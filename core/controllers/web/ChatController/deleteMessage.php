public function deleteMessage()
{   

    $this->component->chat->deleteMessage($this->user->data->id, $_POST['id']);

    return json_answer(["status"=>true]);

}