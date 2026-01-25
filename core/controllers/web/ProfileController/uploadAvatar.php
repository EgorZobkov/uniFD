public function uploadAvatar()
{   

    $resultUpload = $this->storage->files($_FILES['attach_files'])->path('user-avatar')->extList('images')->deleteOriginal(true)->use("resize")->upload();

    if($resultUpload){

        $this->storage->name($this->user->data->avatar)->delete();
        $this->model->users->cacheKey(["id"=>$this->user->data->id])->update(["avatar"=>clearPath($resultUpload["path"])], $this->user->data->id);

    }

    return json_answer(["status"=>true]);
       
}