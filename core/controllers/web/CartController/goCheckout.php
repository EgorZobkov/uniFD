public function goCheckout()
{   

    $session_id = md5(time().uniqid());

    $items = [];

    if($_POST['item_id']){
        if(is_array($_POST['item_id'])){

            $getItems = $this->model->cart->getAll("id IN(".implode(",", $_POST['item_id']).")");
    
            if($getItems){
                foreach ($getItems as $value) { 
                    if($this->component->ads->checkAvailable($value["item_id"])){ debug($value["id"]);
                        $items[] = $value["id"];
                    }
                }                
            }

            $this->session->set($session_id, $items);

        }
    }

    return json_answer(["redirect"=>$this->router->getRoute("cart-checkout")."?session_id=".$session_id]);

}