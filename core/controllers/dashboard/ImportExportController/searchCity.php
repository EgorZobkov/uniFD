public function searchCity()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $results = "";

    $result = $this->component->geo->importSearchCity($_POST['query']);

    return json_answer(["content"=>$result]);

}