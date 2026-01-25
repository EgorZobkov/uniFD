public function searchItemClick()
{
    $this->component->search->fixingRequest($_POST["query"], $_POST["link"], $this->user->data->id);
}