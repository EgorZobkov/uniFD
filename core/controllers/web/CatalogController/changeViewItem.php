public function changeViewItem()
{   

    if($_POST['view'] == "grid"){
        $this->session->set("item-view", "grid");
    }else{
        $this->session->set("item-view", "list");
    }

    return json_answer(["status"=>true]);

}