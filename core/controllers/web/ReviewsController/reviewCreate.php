public function reviewCreate()
{   

    if(!$this->component->profile->checkVerificationPermissions($this->user->data->id, "create_review")){
        return json_answer(["verification"=>false]);
    }

    if($_POST['order_id']){
        $check = $this->model->reviews->find("order_id=? and from_user_id=?", [$_POST['order_id'], $this->user->data->id]);
    }elseif($_POST['user_id']){
        if($_POST['item_id']){
            if(!$this->component->ads->getAd($_POST['item_id'])->delete){
                $check = $this->model->reviews->find("from_user_id=? and whom_user_id=? and item_id=?", [$this->user->data->id,$_POST['user_id'],$_POST['item_id']]);
            }else{
                return json_answer(["status"=>false, "answer"=>translate("tr_d10052a52dfdffe02aa808e4519710e2")]);
            }
            
        }else{
            return json_answer(["status"=>false, "answer"=>translate("tr_a7df722272429dc621d8eb6a76fcd096")]);
        }
    }else{
        return json_answer(["status"=>false, "answer"=>translate("tr_8b1269c207872d7f783a4fe90ecf0ecb")]);
    }

    if(!$check){

        if($this->validation->requiredField($_POST['text'])->status == false){
            return json_answer(["status"=>false, "answer"=>translate("tr_b3e7a762d010c0584a807e107a0c63ba")]);
        }else{
            if(!$this->component->reviews->create(["order_id"=>$_POST["order_id"], "item_id"=>$_POST["item_id"], "from_user_id"=>$this->user->data->id, "whom_user_id"=>$_POST['user_id'], "text"=>$_POST["text"], "rating"=>$_POST["rating"], "attach_files"=>$_POST["attach_files"]])){
                return json_answer(["status"=>false, "answer"=>translate("tr_cd3fef036a21f3338ea222fcf86d1fb8")]);
            }
            return json_answer(["status"=>true]);
        }

    }else{
        return json_answer(["status"=>false, "answer"=>translate("tr_1f46f60acfecc938dc47608454611b8e")]);
    }

}