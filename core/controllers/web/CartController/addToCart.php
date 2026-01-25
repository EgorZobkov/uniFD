public function addToCart()
{   

    $result = $this->component->cart->addToCart($_POST["item_id"],1,$this->user->data->id);

    if($result == "added"){
        return json_answer(["status"=>true, "label"=>translate("tr_5aa28eac85643cd8b1d7be4570391d11"), "route"=>$this->router->getRoute("cart")]);
    }elseif($result == "error"){
        return json_answer(["status"=>true, "answer"=>translate("tr_5806b0fd6cb91d6b69435dbac3b096c7")]);
    }elseif($result == "not_available"){
        return json_answer(["status"=>true, "answer"=>translate("tr_53386eb6c3288e6d955babc408ee2e40")]);
    }

}