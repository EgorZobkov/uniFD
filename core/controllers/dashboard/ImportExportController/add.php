 public function add()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];
    $resultUpload = [];
    $filename = "";

    if($this->validation->isUserName($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['action'])->status == false){
        $answer['action'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['table'])->status == false){
        $answer['table'] = $this->validation->error;
    }

    if($_POST['action'] == "import"){

        if($this->validation->requiredField($_POST['source'])->status == false){
            $answer['source'] = $this->validation->error;
        }else{
            if($_POST['source'] == "link"){
                if($this->validation->requiredField($_POST['link_file'])->status == false){
                    $answer['link_file'] = $this->validation->error;
                }else{
                    if(!_file_get_contents($_POST['link_file'])){
                        $answer['link_file'] = translate("tr_44d131d7f690cf69de83ec59f7e1f9cd");
                    }
                }
                if($this->validation->requiredField($_POST['link_file_format'])->status == false){
                    $answer['link_file_format'] = $this->validation->error;
                }
            }elseif($_POST['source'] == "file"){
                if($this->validation->required(true)->setExt(['xlsx', 'csv'])->isFile($_FILES['file'])->status == false){
                    $answer['file'] = $this->validation->error;
                }
            }
        }

    }elseif($_POST['action'] == "export"){

        if($this->validation->requiredField($_POST['export_format'])->status == false){
            $answer['export_format'] = $this->validation->error;
        }

    }

    if(empty($answer)){

        if($_POST['action'] == "import"){
            if($_POST['source'] == "file"){
                $resultUpload = $this->storage->files($_FILES['file'])->type('file')->path('files-import-export')->extList(['xlsx', 'csv'])->upload();
                if(!$resultUpload){
                    return json_answer(["status"=>false, "type_show"=>"alert", "type_answer"=>"warning", "answer"=>translate("tr_6b0c7b766f6ccb046389ed29c9dfe1e3")." ".$this->config->storage->files_import_export]);
                }
                $filename = $resultUpload['name'];
            }elseif($_POST['source'] == "link"){
                $filename = md5(time().'-'.uniqid()).'.'.$_POST['link_file_format'];
                $data = _file_get_contents($_POST['link_file']);
                _file_put_contents($this->config->storage->files_import_export . '/' . $filename, $data);
            }
        }elseif($_POST['action'] == "export"){
            $filename = 'export_'.$_POST['table'].'_'.md5(time().'-'.uniqid()).'.'.$_POST['export_format'];
        }

        $insert_id = $this->model->import_export->insert(["name"=>$_POST['name'],"filename"=>$filename, "action"=>$_POST['action'], "table"=>$_POST['table'], "time_create"=>$this->datetime->getDate(), "status"=>$_POST['action'] == "export" ? 2 : 0,"export_format"=>$_POST['export_format']?:null, "source"=>$_POST['source'], "link_file"=>$_POST['link_file']?:null, "link_file_format"=>$_POST['link_file_format']?:null]);

        if($_POST['action'] == "import"){
            return json_answer(["status"=>true, "redirect"=>$this->router->getRoute("dashboard-import-card", [$insert_id])]);                
        }elseif($_POST['action'] == "export"){
            $this->session->setNotifyDashboard('success', translate("tr_3460e4fb9ae9a0c15f02954eb51a7ae8"));
            return json_answer(["status"=>true, "redirect"=>$this->router->getRoute("dashboard-import-export")]);                
        }

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }

}