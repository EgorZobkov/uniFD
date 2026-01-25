public function channelDisableNotify()
{   

    $result = $this->component->chat->channelDisableNotify($_POST['id'], $this->user->data->id);

    if($result){
        return json_answer(["status"=>true, "answer"=>translate("tr_01c876d00ece03bb17a12c3bf56cbed8"), "label"=>translate("tr_d31197c4fee0b3f97578d4fa41be8939")]);
    }else{
        return json_answer(["status"=>true, "answer"=>translate("tr_82117011f27f10617684a4386eeb248d"), "label"=>translate("tr_d155d300b3d5e139185b987e1962fd87")]);
    }

}