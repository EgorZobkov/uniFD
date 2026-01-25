<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Http\Controllers\Api;

use App\Systems\Controller;

class CartController extends Controller {

    public function __construct($app){
        parent::__construct($app); 
    }

    public function getData(){

        $total_price = 0;
        $total_count = 0;
        $ids = $_GET["ids"] ? _json_decode(html_entity_decode($_GET["ids"])) : [];
        $user_id = (int)$_GET['user_id'];

        $result = [];

        if($ids){

            foreach ($ids as $id => $count) {

                $ad = $this->component->ads->getAd($id);

                if($ad){
                    if($user_id){
                        if($user_id != $ad->user_id){
                            $total_count += $count;
                            $total_price += $ad->price * $count;
                            $ads[$ad->user_id][] = ["data"=>$this->api->adData($ad), "count"=>$count];
                        }
                    }else{
                        $total_count += $count;
                        $total_price += $ad->price * $count;
                        $ads[$ad->user_id][] = ["data"=>$this->api->adData($ad), "count"=>$count];
                    }
                }

            }

            if($ads){

                foreach ($ads as $id => $data) {
                    $user = $this->model->users->find("id=?", [$id]);
                    if($user){
                        $shop = $this->component->shop->getActiveShopByUserId($id);
                        if($shop){
                            $result[] = ["display_name"=>$shop->title, "avatar"=>$this->storage->name($shop->image)->host(true)->get(), "ad"=>$data];
                        }else{
                            $result[] = ["display_name"=>$this->user->name($user), "avatar"=>$this->storage->name($user->avatar)->host(true)->get(), "ad"=>$data];
                        }
                    }
                }

            }

        }

        return json_answer(["data"=>$result, "total_count"=>$total_count . ' ' . endingWord($total_count, "товар", "товара", "товаров"), "total_price"=>$this->system->amount($total_price)]);
    }    

    public function update(){

        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $ids = $_POST["ids"] ? _json_decode(html_entity_decode($_POST["ids"])) : [];

        $result = [];

        $getCart = $this->model->cart->getAll("user_id=?", [$_POST['user_id']]);
        if($getCart){
            foreach ($getCart as $key => $value) {
                $item = $this->model->ads_data->find("id=? and status=?", [$value["item_id"], 1]);
                if($item){
                    if($ids[$value["item_id"]]){
                        $ids[$value["item_id"]] = $ids[$value["item_id"]];
                    }else{
                        $ids[$value["item_id"]] = $value["count"];
                    }
                }
            }
        }

        if($ids){
            foreach ($ids as $item_id => $count) {

                $ad = $this->component->ads->getAd($item_id);

                if($this->component->ads->hasAddToCart($ad) && $this->component->ads->checkAvailable($item_id) && $ad && !$ad->delete){
                    $cart_item = $this->model->cart->find("user_id=? and item_id=?", [$_POST['user_id'], $item_id]);
                    if(!$cart_item){
                        $this->model->cart->insert(["user_id"=>(int)$_POST['user_id'], "whom_user_id"=>(int)$ad->user_id, "item_id"=>$item_id, "count"=>$count, "time_create"=>$this->datetime->getDate()]);
                    }else{
                        $this->model->cart->update(["count"=>$cart_item->count], $cart_item->id);
                    }
                }

            }
        }

        return json_answer(["data"=>$ids ?: null, "auth"=>true]);

    }

    public function plusItem(){   

        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $user_id = (int)$_POST['user_id'];
        $result = $this->cartPlusCount($_POST['id'], $user_id, (int)$_POST['count']);

        return json_answer(["status"=>true]);
    }

    public function minusItem(){   

        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $user_id = (int)$_POST['user_id'];
        $result = $this->cartMinusCount($_POST['id'], $user_id, (int)$_POST['count']);

        return json_answer(["status"=>true]);
    }

    public function deleteItem(){   

        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $this->model->cart->delete("user_id=? and item_id=?", [$_POST['user_id'], $_POST['id']]);

        return json_answer(["status"=>true, "auth"=>true]);
    }

    public function clearItems(){   

        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $this->model->cart->delete("user_id=?", [$_POST['user_id']]);

        return json_answer(["status"=>true, "auth"=>true]);
    }

    public function cartPlusCount($id=0, $user_id=0, $count=0){

        $price = 0;

        $cart = $this->model->cart->find("user_id=? and item_id=?", [$user_id, $id]);

        if($cart){

            $item = $this->component->ads->getAd($cart->item_id);

            if($item && !$item->delete){

                if(!$item->not_limited){

                    if($count > $item->in_stock){
                        $count = $item->in_stock;
                    }

                }

            }else{
                $this->model->cart->delete("user_id=? and item_id=?", [$user_id, $id]);
                return;
            }

            $this->model->cart->update(["count"=>$count], $cart->id);

        }

    }

    public function cartMinusCount($id=0, $user_id=0, $count=0){

        $price = 0;

        $cart = $this->model->cart->find("user_id=? and item_id=?", [$user_id, $id]);

        if($cart){

            $item = $this->component->ads->getAd($cart->item_id);

            if($item && !$item->delete){

                if($count >= 1){

                    if(!$item->not_limited){

                        if($count > $item->in_stock){
                            $count = $item->in_stock;
                        }

                    }

                }else{
                    $this->model->cart->delete("user_id=? and item_id=?", [$user_id, $id]);
                    return;
                }

            }else{
                $this->model->cart->delete("user_id=? and item_id=?", [$user_id, $id]);
                return;                
            }

            $this->model->cart->update(["count"=>$count], $cart->id);

        }
        
    }

}
