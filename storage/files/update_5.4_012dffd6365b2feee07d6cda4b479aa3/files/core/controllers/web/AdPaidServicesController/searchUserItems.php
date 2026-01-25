public function searchUserItems(){ 

    $result = '';

    if(_mb_strlen($_POST['query']) < 2){
        return json_answer(["status"=>false]);
    }    

    return json_answer(["status"=>true, "answer"=>$this->component->ad_paid_services->searchItemsWaitingList($_POST['query'], $this->user->data->id)]);

}