public function keywordAdd()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $category_id = 0;
    $answer = [];
    $link = "";

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }

    if($_POST['goal_type'] == 1){

        if($this->validation->requiredField($_POST['link'])->status == false){
            $answer['link'] = $this->validation->error;
        }else{
            $link = trim(clearHostInURI($_POST['link']), "/");
        }        

    }elseif($_POST['goal_type'] == 2){

        if($this->validation->requiredField($_POST['category_id'])->status == false){
            $answer['category_id'] = $this->validation->error;
        }else{
            $category_id = $_POST['category_id'];
        }        

    }elseif($_POST['goal_type'] == 3){

        if($this->validation->requiredField($_POST['filter_link'])->status == false){
            $answer['filter_link'] = $this->validation->error;
        }else{

            if(strpos($_POST['filter_link'], "?") !== false){
                $params = explode("?", $_POST['filter_link']);
                $link = trim(str_replace("&amp;", "&", urldecode($params[1])), "/");
            }else{
                if(strpos($_POST['filter_link'], "filter") === false){
                    $answer['filter_link'] = translate("tr_1ec283fe025a82c2f23df24a964f48bb");
                }
            }

        }

        if($this->validation->requiredField($_POST['filter_category_id'])->status == false){
            $answer['filter_category_id'] = $this->validation->error;
        }else{
            $category_id = $_POST['filter_category_id'];
        }        

    }else{

        if($this->validation->requiredField($_POST['goal_type'])->status == false){
            $answer['goal_type'] = $this->validation->error;
        }        
        
    }

    if(empty($answer)){

        $this->model->search_keywords->insert(["name"=>$_POST['name'], "link"=>$link ?: null,"category_id"=>(int)$category_id, "tags"=>$_POST['tags'] ?: null, "geo_link_status"=>(int)$_POST['geo_link_status'], "goal_type"=>(int)$_POST['goal_type']]);

        $this->session->setNotifyDashboard('success', code_answer("add_successfully"));

        return json_answer(["status"=>true]);

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }    

}