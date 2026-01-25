public function advClick()
{
    $this->component->advertising->fixClick($_POST["code"],$this->user->data->id);
}