<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Http\Controllers;

 use App\Systems\Controller;

 class CartController extends Controller
 {

 public function __construct($app){
 parent::__construct($app); 
 }

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

public function cart(){   

    $this->view->visible_header = false;
    $this->view->visible_footer = false;

    $data = (object)[];

    if(!$this->settings->basket_status){
        abort(404);
    }

    $data->items = $this->component->cart->getCartItems($this->user->data->id);

    $seo = $this->component->seo->content();

    return $this->view->render('cart', ["data"=>(object)$data, "seo"=>$seo]);
}

public function checkout(){   

    $this->view->visible_header = false;
    $this->view->visible_footer = false;

    $data = (object)[];

    if(!$this->settings->basket_status){
        abort(404);
    }

    if(!$this->session->get($_GET['session_id']) || !$_GET['session_id']){
        abort(404);
    }

    $data->items = $this->component->cart->getCartItems($this->user->data->id, $this->session->get($_GET['session_id']));

    if(!$data->items){
        abort(404);
    }

    $data->session_id = $_GET['session_id'];
    $data->total_count = $this->component->cart->totalCountChangeItems($this->user->data->id, $this->session->get($_GET['session_id']));
    $data->total_amount = $this->component->cart->totalAmount($this->user->data->id, $this->session->get($_GET['session_id']));

    $seo = $this->component->seo->content();

    return $this->view->render('cart-checkout', ["data"=>(object)$data, "seo"=>$seo]);
}

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

public function itemDelete()
{   

    $this->component->cart->delete($_POST['id'], $this->user->data->id);
    return json_answer(["status"=>true]);

}

public function itemMinusCount()
{   

    $result = $this->component->cart->minusCount($_POST['id'], $this->user->data->id);

    return json_answer(["count"=>$result->count, "price"=>$this->system->amount($result->price)]);

}

public function itemPlusCount()
{   

    $result = $this->component->cart->plusCount($_POST['id'], $this->user->data->id);

    return json_answer(["count"=>$result->count, "price"=>$this->system->amount($result->price)]);

}

public function payment()
{   

    if(!$this->component->profile->checkVerificationPermissions($this->user->data->id, "create_order")){
        return json_answer(["verification"=>false]);
    }

    $delivery_points = [];
    $items_id = $this->session->get($_POST['session']);

    if($_POST['delivery_points']){
        parse_str($_POST['delivery_points'], $delivery_points);
    }else{
        $delivery_points = [];
    }

    $result = $this->component->transaction->initPaymentCart($items_id, $delivery_points ? $delivery_points["delivery_point_id"] : [], $this->user->data->id);

    return json_answer($result);

}

public function update()
{   

    $total_count = $this->component->cart->totalCountChangeItems($this->user->data->id, $_POST['item_id']);
    $total_amount = $this->component->cart->totalAmount($this->user->data->id, $_POST['item_id']);

    return json_answer(["total_count"=>$total_count, "total_amount"=>$this->system->amount($total_amount)]);

}

public function updateCount()
{   

    $count = $this->component->cart->count($this->user->data->id);
    return json_answer(["count"=>$count]);

}



 }