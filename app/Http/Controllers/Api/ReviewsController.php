<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Http\Controllers\Api;

use App\Systems\Controller;

class ReviewsController extends Controller {

    public function __construct($app){
        parent::__construct($app); 
    }

    public function getReviews(){ 

        $result = [];
        $data = [];
        $images = [];
        $parents = [];

        $total_rating = 0;
        $total_rating_int = 0;
        $total_count_reviews_string = "";

        $page = (int)$_GET["page"] ? (int)$_GET["page"] : 1;

        if(intval($_GET["whom_user_id"])){

            $user = $this->model->users->find("id=?", [$_GET["whom_user_id"]]);

            if($user){
                $total_rating = $user->total_rating;
                $total_rating_int = (int)$user->total_rating;
                $total_count_reviews_string = $user->total_reviews .' '.endingWord($user->total_reviews, translate("tr_22c585f75c24d937f90165dc341b1dbd"), translate("tr_702db99a476541dc4de2d765ee4653ac"), translate("tr_cb704af04e2a3ac14a6eae2f02251d72"));
            }

            if($_GET["sorting"] == "only_added"){
                $data = $this->model->reviews->pagination(true)->page($page)->output(50)->sort("id desc")->getAll("from_user_id=? and parent_id=?", [intval($_GET["whom_user_id"]), 0]);
            }else{
                $data = $this->model->reviews->pagination(true)->page($page)->output(50)->sort("id desc")->getAll("whom_user_id=? and status=? and parent_id=?", [intval($_GET["whom_user_id"]), 1, 0]);
            }

        }elseif(intval($_GET["item_id"])){

            $ad = $this->model->ads_data->find("id=?", [$_GET["item_id"]]);
            
            if($ad){
                $total_rating = $ad->total_rating;
                $total_rating_int = (int)$ad->total_rating;
                $total_count_reviews_string = $ad->total_reviews .' '.endingWord($ad->total_reviews, translate("tr_22c585f75c24d937f90165dc341b1dbd"), translate("tr_702db99a476541dc4de2d765ee4653ac"), translate("tr_cb704af04e2a3ac14a6eae2f02251d72"));
            }

            $data = $this->model->reviews->pagination(true)->page($page)->output(50)->sort("id desc")->getAll("item_id=? and status=? and parent_id=?", [intval($_GET["item_id"]), 1, 0]);

        }

        if($data){

            foreach ($data as $key => $value) {

                $parents = [];
                $images = [];
                $ad = $this->component->ads->getAd($value["item_id"]);
                $from_user = $this->model->users->findById($value["from_user_id"]);

                if($value["media"]){
                    foreach (_json_decode($value["media"]) as $item) {
                        $images[] = ["link"=>$this->storage->name($item)->host(true)->get(), "type"=>"image"];
                    }
                }

                $parent_reviews = $this->model->reviews->sort("id asc")->getAll("parent_id=?", [$value["id"]]);

                if($parent_reviews){
                    foreach ($parent_reviews as $parent_value) {

                        $parent_from_user = $this->model->users->find("id=?", [$parent_value["from_user_id"]]);

                        $parents[] = [
                            "id" => $parent_value["id"],
                            "text" => html_entity_decode($parent_value["text"]),
                            "time_create" => $this->datetime->outLastTime($parent_value["time_create"]),
                            "user" => [
                                "id" => $parent_from_user->id,
                                "display_name" => $this->user->name($parent_from_user),
                                "avatar" => $this->storage->name($parent_from_user->avatar)->host(true)->get(),
                            ],
                        ];

                    }
                }

                $result[] = [
                    "id" => $value["id"],
                    "text" => html_entity_decode($value["text"]),
                    "time_create" => $this->datetime->outLastTime($value["time_create"]),
                    "rating" => $value["rating"],
                    "images" => $images ?: null,
                    "ad" => $ad ? [
                        "id" => $ad->id,
                        "title" => $ad->title,
                    ] : [
                        "id" => null,
                        "title" => translate("tr_980279c7b33de4b5dc119d3acd68d981"),
                    ],
                    "whom_user_id" => $value["whom_user_id"],
                    "user" => [
                        "id" => $from_user->id,
                        "display_name" => $this->user->name($from_user),
                        "avatar" => $this->storage->name($from_user->avatar)->host(true)->get(),
                    ],
                    "parents" => $parents ?: null,
                ];

            }

        }

        return json_answer(["data"=>$result ?: null, "pages"=>$this->pagination->totalPages, "auth"=>true, "total_rating"=>$total_rating, "total_rating_int"=>$total_rating_int, "total_count_reviews_string"=>$total_count_reviews_string]);

    }

    public function getReview(){ 

        $result = [];
        $data = [];
        $images = [];
        
        $data = $this->model->reviews->find("id=? and status=?", [intval($_GET["id"]),1]);

        if($data){

            $images = [];

            $ad = $this->component->ads->getAd($data->item_id);
            $user = $this->model->users->findById($data->from_user_id);

            if($data->media){
                foreach (_json_decode($data->media) as $item) {
                    $images[] = ["link"=>$this->storage->name($item)->host(true)->get(), "type"=>"image"];
                }
            }

            $result = [
                "id" => $data->id,
                "text" => html_entity_decode($data->text),
                "time_create" => $this->datetime->outLastTime($data->time_create),
                "rating" => $data->rating,
                "images" => $images ?: null,
                "ad" => $ad ? [
                    "id" => $ad->id,
                    "title" => $ad->title,
                ] : null,
                "user" => [
                    "id" => $user->id,
                    "display_name" => $this->user->name($user),
                    "avatar" => $this->storage->name($user->avatar)->host(true)->get(),
                ],
            ];

        }

        return json_answer(["data"=>$result ?: null, "auth"=>true]);

    }

    public function addAnswer(){ 

        if(!$this->api->verificationAuth($_POST["token"], $_POST["user_id"])){
            return json_answer(["auth"=>false]);
        }

        if($this->validation->requiredField($_POST['text'])->status == false){
            return json_answer(["status"=>false, "auth"=>true, "answer"=>translate("tr_9236dee57cf1f06c152210bf429c87e1")]);
        }else{
            $this->component->reviews->responseCreate(["review_id"=>$_POST["id"], "user_id"=>$_POST["user_id"], "text"=>$_POST["text"]]);
            return json_answer(["status"=>true, "auth"=>true]);
        }

    }

    public function deleteReview(){ 

        if(!$this->api->verificationAuth($_POST["token"], $_POST["user_id"])){
            return json_answer(["auth"=>false]);
        }

        $this->component->reviews->delete($_POST["id"], $_POST["user_id"]);

        return json_answer(["status"=>true, "auth"=>true]);

    }

    public function getData(){ 

        if(!$this->api->verificationAuth($_GET["token"], $_GET["user_id"])){
            return json_answer(["auth"=>false]);
        }

        $items = [];
        $result = [];
        $user_id = (int)$_GET["whom_user_id"];

        $user = $this->model->users->findById($user_id, true);

        if(!$user){
            return json_answer(null);
        }else{
            if($user->id == $_GET["user_id"]){
               return json_answer(null);
            }
        }

        $shop = $this->component->shop->getActiveShopByUserId($user->id);

        if($_GET['order_id']){
            $order = $this->component->transaction->getDealItem($_GET['order_id']);
            if($order){
                if($order->from_user_id == $_GET["user_id"] || $order->whom_user_id == $_GET["user_id"]){
                    $ad = $this->component->ads->getAd($order->item->item_id);
                }
            }
        }elseif($_GET['item_id']){
            $ad = $this->component->ads->getAd($_GET['item_id']);
        }

        $getAds = $this->model->ads_data->sort("id desc limit 30")->getAll("user_id=? and status IN(1,3,7)", [$user->id]);

        if($getAds){
            foreach ($getAds as $key => $value) {
                $value = $this->component->ads->getDataByValue($value);
                $items[] = ["id"=>$value->id, "title"=>$value->title, "image"=>$value->media->images->first, "city"=>$value->geo->name];
            }
        }

        $result = [
            "ad"=>$ad ? ["id"=>$ad->id, "title"=>$ad->title, "image"=>$ad->media->images->first, "city"=>$ad->geo->name ?: null] : null,
            "items"=>$items ?: null,
            "user"=>["id"=>$user->id, "display_name"=>$this->user->name($user), "avatar"=>$this->storage->name($user->avatar)->host(true)->get()],
            "shop"=>$shop ? ["id"=>$shop->id, "title"=>$shop->title, "logo"=>$this->storage->name($shop->image)->host(true)->get()] : null,
        ];

        return json_answer(["data"=>$result, "status"=>true, "auth"=>true]);

    }

    public function create(){   

        if(!$this->api->verificationAuth($_POST["token"], $_POST["user_id"])){
            return json_answer(["auth"=>false]);
        }

        if(!$this->component->profile->checkVerificationPermissions($_POST["user_id"], "create_review")){
            return json_answer(["verification"=>false, "auth"=>true]);
        }

        $attach = [];

        $_POST['attach'] = $_POST["attach"] ? _json_decode(html_entity_decode($_POST["attach"])) : [];

        if($_POST['order_id']){
            $check = $this->model->reviews->find("order_id=? and from_user_id=?", [$_POST['order_id'], $_POST["user_id"]]);
        }elseif(intval($_POST['whom_user_id'])){
            if(intval($_POST['item_id'])){
                if(!$this->component->ads->getAd(intval($_POST['item_id']))->delete){
                    $check = $this->model->reviews->find("from_user_id=? and whom_user_id=? and item_id=?", [$_POST["user_id"],(int)$_POST['whom_user_id'],(int)$_POST['item_id']]);
                }else{
                    return json_answer(["status"=>false, "auth"=>true, "answer"=>translate("tr_d10052a52dfdffe02aa808e4519710e2"), "verification"=>true]);
                }
                
            }else{
                return json_answer(["status"=>false, "auth"=>true, "answer"=>translate("tr_a7df722272429dc621d8eb6a76fcd096"), "verification"=>true]);
            }
        }else{
            return json_answer(["status"=>false, "auth"=>true, "answer"=>translate("tr_8b1269c207872d7f783a4fe90ecf0ecb"), "verification"=>true]);
        }

        if(!$check){

            if($this->validation->requiredField($_POST['text'])->status == false){
                return json_answer(["status"=>false, "auth"=>true, "answer"=>translate("tr_b3e7a762d010c0584a807e107a0c63ba"), "verification"=>true]);
            }else{

                if($_POST['attach']){

                    foreach ($_POST['attach'] as $key => $value) {
                        $attach[] = $value["name"];
                    }

                }

                if(!$this->component->reviews->create(["order_id"=>$_POST["order_id"], "item_id"=>(int)$_POST["item_id"], "from_user_id"=>(int)$_POST["user_id"], "whom_user_id"=>(int)$_POST['whom_user_id'], "text"=>$_POST["text"], "rating"=>(int)$_POST["rating"], "attach_files"=>$attach])){
                    return json_answer(["status"=>false, "auth"=>true, "answer"=>translate("tr_cd3fef036a21f3338ea222fcf86d1fb8"), "verification"=>true]);
                }

                return json_answer(["status"=>true, "auth"=>true, "verification"=>true]);

            }

        }else{
            return json_answer(["status"=>false, "auth"=>true, "answer"=>translate("tr_1f46f60acfecc938dc47608454611b8e"), "verification"=>true]);
        }

    }

    public function searchUserItems(){   

        if(!$this->api->verificationAuth($_POST["token"], $_POST["user_id"])){
            return json_answer(["auth"=>false]);
        }

        $result = [];

        if(!intval($_POST['whom_user_id'])){
            return json_answer(["data"=>null, "auth"=>true]);
        }

        if(_mb_strlen($_POST['search']) < 2){
            return json_answer(["data"=>null, "auth"=>true]);
        }

        $getAds = $this->model->ads_data->sort("id desc")->search($_POST['search'])->getAll("user_id=? and status IN(1,3,7)", [intval($_POST['whom_user_id'])]);

        if($getAds){
            foreach ($getAds as $key => $value) {
                $value = $this->component->ads->getDataByValue($value);
                $result[] = ["id"=>$value->id, "title"=>$value->title, "image"=>$value->media->images->first, "city"=>$value->geo->name];
            }
        }

        return json_answer(["data"=>$result, "auth"=>true]);
           
    }

}