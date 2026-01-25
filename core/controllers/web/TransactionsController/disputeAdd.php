public function disputeAdd()
{   

    if($this->validation->requiredField($_POST['text'])->status == false){
        return json_answer(["status"=>false, "answer"=>translate("tr_999a9e5388440a8a000821fd63aa6dd5")]);
    }else{

        $getDeal = $this->model->transactions_deals->find("order_id=? and from_user_id=?", [$_POST["order_id"],$this->user->data->id]);

        if($getDeal){

            $attach_files = $this->storage->uploadAttachFiles($_POST['attach_files'], $this->config->storage->users->attached);

            $this->component->transaction->addDisputeDeal($_POST["order_id"],$this->user->data->id,$_POST["text"],$attach_files);

        }

        return json_answer(["status"=>true]);

    }

}