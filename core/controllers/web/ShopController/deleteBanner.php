public function deleteBanner()
{   

    $banner = $this->model->shops_banners->find("user_id=? and id=?", [$this->user->data->id, $_POST['id']]);

    if(!$banner){
        return json_answer(["status"=>false]);
    }

    $this->model->shops_banners->delete("id=?", [$_POST['id']]);
    $this->storage->clearAttachFiles([$banner->image]);

    return json_answer(["status"=>true]);
       
}