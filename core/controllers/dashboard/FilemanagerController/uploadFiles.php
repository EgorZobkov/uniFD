public function uploadFiles(){   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $resultUpload = $this->storage->files($_FILES['filemanager_upload_file'])->path('images')->extList('images')->use("resize")->upload();

    return json_answer(['status'=>true]);

}