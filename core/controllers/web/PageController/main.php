public function main()
{   

    $data = $this->model->template_pages->find("alias=?", [clearRequestURI()]);

    if(!$data){
        abort(404);
    }else{
        if(!$data->status){
            if(!$this->user->isAdminAuth()){
                abort(404);
            }
        }
    }

    $seo = $this->component->seo->content([],$data->id);

    return $this->view->render($data->template_name, ["seo"=>$seo]);

}