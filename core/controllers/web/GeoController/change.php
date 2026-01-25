public function change()
{   

    $result = $this->component->geo->outOptionsCities($_POST['id']);

    if($result){

        return json_answer(["content"=>$result]);

    }

    $this->component->geo->setChange($_POST['id'], $_POST['purpose']);
    
    return json_answer(["content"=>""]);

}