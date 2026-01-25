public function updateContent()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = '';

    $this->translate->updateTables();
    $result = $this->translate->updateContent();
    
    $answer = translate("tr_3730f24523f306465f053d44d1c5dadd") . ' ' . $result["added"] . ', ' . translate("tr_49aa33d713bc42ce830521c598405b97") . ' ' . $result["errors"]."\n";

    if($result["errors_answer"]){
        foreach ($result["errors_answer"] as $value) {
            $answer .= translate("tr_9942c0ae6ea91f45c97d8b56e76c5764").' '.$value."\n";
        }
    }
    
    return json_answer(["status"=>true, "answer"=>$answer]);

}