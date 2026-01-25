public function addComplaint(){

    if($this->validation->requiredField($_POST['text'])->status == false){
        return json_answer(["status"=>false, "answer"=>translate("tr_c5f9d5595eb159c22ec1fed1bf239aa5")]);
    }else{

        $data = $this->component->ads->getAd($_POST["id"]);

        if($data && !$data->delete){

            if(!$this->model->complaints->find("from_user_id=? and item_id=? and status=?", [$this->user->data->id,$_POST["id"],0])){
                $this->model->complaints->insert(["from_user_id"=>$this->user->data->id,"text"=>$_POST["text"],"item_id"=>$_POST["id"],"whom_user_id"=>$data->user_id,"time_create"=>$this->datetime->getDate()]);
                $this->event->addComplaintAd(["from_user_id"=>$this->user->data->id, "whom_user_id"=>$data->user_id, "text"=>$_POST["text"], "item_id"=>$_POST["id"]]);
            }

        }

    } 

    return json_answer(["status"=>true, "answer"=>translate("tr_9ce23934d783d857c38fc685eb0b5049")]);
    
}