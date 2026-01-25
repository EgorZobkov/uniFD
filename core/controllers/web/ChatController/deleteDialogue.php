public function deleteDialogue()
{   

    $this->component->chat->deleteDialogue($this->user->data->id, $_POST['id']);

    return json_answer(["status"=>true]);

}