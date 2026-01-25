public function ckfinder()
{   

    $resultUpload = $this->storage->files($_FILES['upload'])->path('temp')->extList('images')->deleteOriginal(true)->use("resize")->upload();

    if($resultUpload){

        $image = $this->storage->uploadAttachFiles([$resultUpload["name"]], $this->config->storage->users->attached);

        echo json_answer(["uploaded"=>true, "url"=>$this->storage->name($image[0])->get()]);

    }

}