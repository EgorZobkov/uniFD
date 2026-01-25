public function addFilterLink()
{
    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }else{
        if(!$_POST['seo_title']){
            $_POST['seo_title'] = $_POST['name'];
        }
        if(!$_POST['seo_h1']){
            $_POST['seo_h1'] = $_POST['name'];
        }
    }   

    if($this->validation->requiredField($_POST['alias'])->status == false){
        $answer['alias'] = $this->validation->error;
    } 

    if($this->validation->requiredField($_POST['category_id'])->status == false){
        $answer['category_id'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['params'])->status == false){
        $answer['params'] = $this->validation->error;
    }else{
        if(strpos($_POST['params'], "?") !== false){
            $params = explode("?", $_POST['params']);
            $_POST['params'] = trim(str_replace("&amp;", "&", urldecode($params[1])), "/");
        }else{
            if(strpos($_POST['params'], "filter") === false){
                $answer['params'] = translate("tr_1ec283fe025a82c2f23df24a964f48bb");
            }
        }
    }

    if(empty($answer)){

        $chainCategory = $this->component->ads_categories->chainCategory($_POST['category_id']);

        $this->model->ads_filters_links->insert(["name"=>$_POST['name'], "alias"=>slug($_POST['alias']), "params"=>$_POST['params'], "category_id"=>(int)$_POST['category_id'], "seo_title"=>$_POST['seo_title'], "seo_desc"=>$_POST['seo_desc'], "seo_h1"=>$_POST['seo_h1'], "seo_text"=>$_POST['seo_text'], "full_aliases"=>$chainCategory->chain_build_alias_request.'/'.slug($_POST['alias'])]);

        $this->session->setNotifyDashboard('success', code_answer("add_successfully"));

        return json_answer(["status"=>true]);             

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }

}