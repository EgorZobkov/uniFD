public function deletePage()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $find = $this->model->template_pages->find("id=?", [$_POST['id']]);

    if(!$find->freeze){
        _unlink($this->config->resource->view->web->path.'/'.$find->template_name.'.tpl');
        $this->model->template_pages->delete("id=?", [$_POST['id']]);
    }

    return json_answer(["status"=>true]);
           
}