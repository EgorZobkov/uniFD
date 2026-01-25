public function delete()
{   

    $this->component->shop->delete($_POST["id"], $this->user->data->id);

    return json_answer(["status"=>true, "redirect"=>outRoute('profile-shop')]);

}