public function verificationUploadAttach()
{   

    $result = '';

    $resultUpload = $this->storage->files($_FILES['attach_files'])->path('temp')->extList('images')->deleteOriginal(true)->encrypt(true)->use("resize")->upload();

    if($resultUpload){

        $result = '
          <div class="uni-attach-files-item-delete uniAttachFilesDeleteItem" ><i class="ti ti-x"></i></div>
          <img class="image-autofocus" src="'.$this->storage->getAssetImage("6383224500768844.webp").'" />
          <input type="hidden" name="attach_files[]" value="'.$resultUpload["name"].'" >
        ';

    }

    return json_answer(["content"=>$result]);
       
}