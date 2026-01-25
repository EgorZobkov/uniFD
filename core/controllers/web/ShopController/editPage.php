public function editPage()
{   

    $answer = [];

    $page = $this->model->shops_pages->find("user_id=? and id=?", [$this->user->data->id, $_POST['id']]);

    if(!$page){
        return json_answer(["status"=>false]);
    }

    $shop = $this->model->shops->find("id=?", [$page->shop_id]);

    $this->model->shops_pages->update(["text"=>$_POST['text']], ["id=?", [$_POST['id']]]);

    $this->event->editShop(["user_id"=>$this->user->data->id, "shop_id"=>$shop->id, "action"=>"edit_page_text_shop", "page_name"=>$page->name]);

    return json_answer(["status"=>true, "answer"=>translate("tr_bc6aff8adc1f810748019a9fbe047de3")]);
       
}