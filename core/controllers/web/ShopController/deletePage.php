public function deletePage()
{   

    $page = $this->model->shops_pages->find("user_id=? and id=?", [$this->user->data->id, $_POST['id']]);

    if(!$page){
        return json_answer(["status"=>false]);
    }

    $shop = $this->model->shops->find("id=?", [$page->shop_id]);

    $this->model->shops_pages->delete("id=? and user_id=?", [$_POST['id'], $this->user->data->id]);

    return json_answer(["status"=>true, "redirect"=>$this->component->shop->linkToShopCard($shop->alias)]);
       
}