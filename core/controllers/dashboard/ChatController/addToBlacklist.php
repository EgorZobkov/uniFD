public function addToBlacklist()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $result = $this->component->profile->addToBlacklist(0, $_POST['id'], $_POST['channel_id']);

    if($result){
        return json_answer(["answer"=>translate("tr_dc322d08f2015f6b63d17cb7b8b15d3e"), "label"=>translate("tr_e3d48147853bb99996169256b5eb7cb9")]);
    }else{
        return json_answer(["answer"=>translate("tr_a58a5c103be003b8a1a58e101a0e45ca"), "label"=>translate("tr_35903deefce1704c3623df8a08d9880f")]);
    }

}