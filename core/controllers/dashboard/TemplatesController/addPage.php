public function addPage()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['alias'])->status == true){
        $find = $this->model->template_pages->find("alias=?", [$_POST['alias']]);
        if($find){
            $answer['alias'] = translate("tr_36103ff759652e3b17f5fb189a1173f7");
        }
    }else{
        $_POST['alias'] = $_POST['name'];
    }

    $filename = md5(uniqid());

    if(empty($answer)){

        if(_file_put_contents($this->config->resource->view->web->path.'/'.$filename.'.tpl', $this->component->templates->defaultTplBody())){
            $insert_id = $this->model->template_pages->insert(["status"=>(int)$_POST['status'], "name"=>$_POST['name'], "template_name"=>$filename, 'alias'=>slug($_POST['alias']), "edit_status"=>1]);
            $this->model->seo_content->insert(["page_id"=>$insert_id]);
            return json_answer(["status"=>true, "redirect"=>$this->router->getRoute("dashboard-template-view-page", [$insert_id])]); 
        }else{
            return json_answer(["status"=>false, "type_show"=>"notice", "type_answer"=>"error", "answer"=>translate("tr_2465d68db9bbf3d1960c0262503e8a22")]); 
        }

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }

           
}