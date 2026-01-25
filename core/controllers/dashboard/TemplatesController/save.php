public function save()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    if($this->settings->testdrive){
        return json_answer(["status"=>false, "type_show"=>"notice", "type_answer"=>"error", "answer"=>"В тестовом режиме редактирование ограничено"]);
    }

    $template_body = htmlspecialchars_decode(urldecode($_POST["template_body"]));

    if($_POST["section"] == "page"){

        if($_POST["id"]){
            $getTpl = $this->model->template_pages->find("id=?", [$_POST["id"]]);
            if($getTpl){
                if(_file_put_contents($this->config->resource->view->web->path.'/'.$getTpl->template_name.'.tpl', $this->clean->phpCode($template_body))){
                    return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("save_successfully")]); 
                }else{
                    return json_answer(["status"=>false, "type_show"=>"notice", "type_answer"=>"error", "answer"=>translate("tr_fbd01e115e08ce45beb48a3748012392")]); 
                }
            }
        }

    }elseif($_POST["section"] == "css"){
        
        if(file_exists($this->config->resource->assets->web->css.'/'.$_POST["name"].'.css')){
            if(_file_put_contents($this->config->resource->assets->web->css.'/'.$_POST["name"].'.css', $this->clean->phpCode($template_body))){
                return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("save_successfully")]); 
            }else{
                return json_answer(["status"=>false, "type_show"=>"notice", "type_answer"=>"error", "answer"=>translate("tr_434b7d95a4183a81265ad3e3a6567bcc")]); 
            }
        }else{
            return json_answer(["status"=>false, "type_show"=>"notice", "type_answer"=>"error", "answer"=>translate("tr_2d46f36e5b6490dbc8b78f6e8dd5f122")." ".$_POST["name"].".css".translate("tr_5075a7c6c714a179a8f066d2c372e48f")]);
        }

    }elseif($_POST["section"] == "js"){
        
        if(file_exists($this->config->resource->assets->web->js.'/'.$_POST["name"].'.js')){
            if(_file_put_contents($this->config->resource->assets->web->js.'/'.$_POST["name"].'.js', $this->clean->phpCode($template_body))){
                return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("save_successfully")]); 
            }else{
                return json_answer(["status"=>false, "type_show"=>"notice", "type_answer"=>"error", "answer"=>translate("tr_ba4c89b48eb1b266a4709a1a3bff4503")]); 
            }
        }else{
            return json_answer(["status"=>false, "type_show"=>"notice", "type_answer"=>"error", "answer"=>translate("tr_2d46f36e5b6490dbc8b78f6e8dd5f122")." ".$_POST["name"].".css".translate("tr_5075a7c6c714a179a8f066d2c372e48f")]);
        }

    }
    
}