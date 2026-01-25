public function uploadImage()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }
    
    $resultUpload = $this->storage->files($_FILES['attach_files'])->path('blog')->extList('images')->deleteOriginal(true)->use("resize")->upload();

    if($resultUpload){

        return json_answer(["status"=>true, "path"=>path($resultUpload["path"]), "clear_path"=>clearPath($resultUpload["path"])]);

    }

    return json_answer(["status"=>false]);

}