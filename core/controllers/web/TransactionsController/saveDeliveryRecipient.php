public function saveDeliveryRecipient()
{   

    $answer = [];

    if($this->validation->requiredField($_POST['delivery_recipient_name'])->status == false){
        $answer['delivery_recipient_name'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['delivery_recipient_surname'])->status == false){
        $answer['delivery_recipient_surname'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['delivery_recipient_patronymic'])->status == false){
        $answer['delivery_recipient_patronymic'] = $this->validation->error;
    }

    if($this->validation->isEmail($_POST['delivery_recipient_email'])->status == false){
        $answer['delivery_recipient_email'] = $this->validation->error;
    }

    if($this->validation->isPhone($_POST['delivery_recipient_phone'])->status == false){
        $answer['delivery_recipient_phone'] = $this->validation->error;
    }

    if(empty($answer)){

        $data = $this->model->users_delivery_data->find("user_id=?", [$this->user->data->id]);

        if(!$data){

            $this->model->users_delivery_data->insert(["name"=>$_POST['delivery_recipient_name'],"surname"=>$_POST['delivery_recipient_surname'],"patronymic"=>$_POST['delivery_recipient_patronymic'],"phone"=>encrypt($this->clean->phone($_POST['delivery_recipient_phone'])),"email"=>encrypt($_POST['delivery_recipient_email']),"user_id"=>$this->user->data->id]);

        }else{

            $this->model->users_delivery_data->update(["name"=>$_POST['delivery_recipient_name'],"surname"=>$_POST['delivery_recipient_surname'],"patronymic"=>$_POST['delivery_recipient_patronymic'],"phone"=>encrypt($this->clean->phone($_POST['delivery_recipient_phone'])),"email"=>encrypt($_POST['delivery_recipient_email'])], $data->id);

        }

        return json_answer(["status"=>true]);

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }

}