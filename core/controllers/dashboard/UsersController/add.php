 public function add()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    if(intval($_POST['status']) == 2){

        if($this->validation->requiredField($_POST['reason_blocking_code'])->status == false){
            $answer['reason_blocking_code'] = $this->validation->error;
        }else{
            if($_POST['reason_blocking_code'] == "other"){
                if($this->validation->requiredField($_POST['reason_blocking_comment'])->status == false){
                    $answer['reason_blocking_comment'] = $this->validation->error;
                }
            }
        } 

        if($this->validation->isUserName($_POST['time_blocking'])->status == false){
            $answer['time_blocking'] = $this->validation->error;
        }

    }

    if($this->validation->isUserName($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }

    if($this->validation->isEmail($_POST['email'])->status == true){
        $check = $this->model->users->find("email=?", [$_POST['email']]);
        if($check){
            $answer['email'] = translate("tr_de1e3f7f8a020772823b30b60c8e970d");
        }
    }else{
        if($_POST["role_id"]){
            $answer['email'] = $this->validation->error;
        }
    } 

    if($this->validation->requiredField($_POST['phone'])->status == true){
        $check = $this->model->users->find("phone=?", [$_POST['phone']]);
        if($check){
            $answer['phone'] = translate("tr_24ccb7a9a72c62fd47e9b876908f2b52");
        }            
    }

    if($this->validation->correctPassword($_POST['password'])->status == false){
        $answer['password'] = $this->validation->error;
    }
 
    if($_POST['role_id']){

        if($this->validation->isRoleAdmin($_POST['role_id'])->status == false){
            $answer['role_id'] = $this->validation->error;
        }else{

            $getRole = $this->model->system_roles->find("id=?", [$_POST['role_id']]);

            if(!$getRole->chief){
                if($this->validation->isRolePrivilege($_POST['privileges'])->status == false){
                    $answer['privileges'] = $this->validation->error;
                }
            }

        }

    }

    if(empty($answer)){

        if($_POST['reason_blocking_code'] == "other"){
            $_POST['reason_blocking_code'] = $this->system->addReasonBlocking($_POST['reason_blocking_comment']);
        }

        if($_POST['time_blocking']){
            if($_POST['time_blocking'] == "forever"){
                $_POST['time_blocking'] = null;
            }else{
                $_POST['time_blocking'] = $this->datetime->addHours($_POST['time_blocking'])->getDate();
            }
        }

        $this->user->params($_POST)->add();

        return json_answer(["status"=>true, "type_answer"=>"success", "type_show"=>"notice", "admin" => $_POST['role_id'] ? true : false]);

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }    

}