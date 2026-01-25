 public function deleteFile(){   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    if(strpos($_POST['name'], "./") !== false || strpos($_POST['name'], "../") !== false){
        return json_answer(['status'=>false]);
    }

    $this->storage->path('images')->name($_POST['name'])->delete();

    return json_answer(['status'=>true]);

}