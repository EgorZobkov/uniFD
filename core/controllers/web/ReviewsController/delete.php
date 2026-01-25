public function delete()
{   

    if($this->user->data->id){
        $this->component->reviews->delete($_POST["id"], $this->user->data->id);
    }

    return json_answer(["status"=>true]);

}