<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Http\Controllers\Api;

use App\Systems\Controller;

class UserController extends Controller {

    public function __construct($app){
        parent::__construct($app); 
    }

    public function getData(){   

        $isAuth = false;
        $getInSubscribe = [];
        $getIsBlocked = [];
        $getImBlocked = [];
        
        if($_GET['user_id']){
            if($this->api->verificationAuth($_GET['token'], $_GET['user_id'])){
                $isAuth = true;
            }
        }

        $result = [];

        $user = $this->model->users->findById($_GET['id']);

        if($user){

            if($user->delete){
                $status_note = translate("tr_d4fa6456afc4e0742bcd2e86bbcfb32c");
            }else{
                if($user->status == 2){
                    $status_note = translate("tr_d261feb7b620183b2afd720b31cf3c0e");
                }
            }

            if(!$user->delete){

                if($isAuth){

                    $getSubscribed = $this->model->users_subscriptions->find("user_id=? and whom_user_id=?", [$_GET['user_id'],$user->id]);
                    $getIsBlocked = $this->model->users_blacklist->find('from_user_id = ? and whom_user_id = ?', [$_GET['user_id'],$user->id]);
                    $getImBlocked = $this->model->users_blacklist->find('from_user_id = ? and whom_user_id = ?', [$user->id,$_GET['user_id']]);

                }

                $countAds = $this->model->ads_data->count("user_id = ? and status = ?", [$user->id,1]);
                $countSubscribers = $this->model->users_subscriptions->count("whom_user_id = ?", [$user->id]);


                $result = [
                    "id" => $user->id,
                    "display_name" => $user->name,
                    "full_name" => $user->name . ' ' .$user->surname,
                    "name" => $user->name,
                    "link_profile" => getHost() . '/user/card/' . $user->alias,
                    "surname" => $data->user->surname,
                    "avatar" => $this->storage->name($user->avatar)->host(true)->get(),
                    "rating" => sprintf("%.1f", $user->total_rating),
                    "reviews" => $user->total_reviews,
                    "reviews_label" => $user->total_reviews . " " . endingWord($user->total_reviews, translate("tr_22c585f75c24d937f90165dc341b1dbd"), translate("tr_702db99a476541dc4de2d765ee4653ac"), translate("tr_cb704af04e2a3ac14a6eae2f02251d72")),
                    "uniq_hash" => $user->uniq_hash,
                    "status" => $user->status,
                    "status_note" => $status_note,
                    "mode_online" => $user->time_last_activity ? $this->api->userActivityStatus($user->time_last_activity) : null,
                    "last_auth_date" => $user->time_last_activity ? $this->datetime->outLastTime($user->time_last_activity) : null,
                    "shop" => $shop ? [
                        "id"=>$shop->id,
                        "name"=>$shop->title,
                        "logo"=>$this->storage->name($shop->image)->host(true)->get(),
                        "text"=>$shop->text,
                    ] : null,
                    "verification_status" => $user->verification_status ? true : false,
                    "tariff" => $this->api->usersServiceTariffData($user->id) ?: null,
                    "status_text" => $user->card_status_text ?: null,
                    "count_ads" => $countAds,
                    "subscribers_count" => $countSubscribers,
                    "orders" => null,
                    "ref_programm" => null,
                    "tariff_id" => $user->tariff_id,
                    "stories" => $this->api->usersStoriesData($user->id) ?: null,
                    "subscribed" => $getSubscribed ? true : false,
                    "is_blocked" => $getIsBlocked ? true : false,
                    "im_blocked" => $getImBlocked ? true : false,
                ];

            }

        }

        return json_answer($result);

    }

    public function getAllAds(){ 

        $result = [];

        $page = (int)$_GET["page"] ? (int)$_GET["page"] : 1;

        if($_GET["sorting"] == "active"){
            $status_query = '1';
        }elseif($_GET["sorting"] == "sold"){
            $status_query = '7';
        }else{
            $status_query = '1';
        }

        if(intval($_GET["card_user_id"])){

            $data = $this->model->ads_data->pagination(true)->page($page)->output(50)->sort("id desc")->getAll("user_id=? and status IN(".$status_query.")", [intval($_GET["card_user_id"])]);

        }

        if($data){

            foreach ($data as $key => $value) {

                $value = $this->component->ads->getDataByValue($value);

                $result[] = $this->api->adData($value);

            }

        }

        return json_answer(["data"=>$result ?: null, "pages"=>$this->pagination->totalPages]);

    }

    public function addComplaint(){ 

        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        if($this->validation->requiredField($_POST['text'])->status == false){
            return json_answer(["status"=>false, "answer"=>translate("tr_c5f9d5595eb159c22ec1fed1bf239aa5"), "auth"=>true]);
        }else{

            $data = $this->model->users->findById($_POST['whom_user_id']);

            if($data && !$data->delete){

                if(!$this->model->complaints->find("from_user_id=? and whom_user_id=? and item_id=? and status=?", [$_POST['user_id'],$_POST["whom_user_id"],0,0])){
                    $this->model->complaints->insert(["from_user_id"=>$_POST['user_id'],"text"=>$_POST["text"],"item_id"=>0,"whom_user_id"=>$_POST["whom_user_id"],"time_create"=>$this->datetime->getDate()]);
                    $this->event->addComplaintUser(["from_user_id"=>$_POST['user_id'], "whom_user_id"=>$_POST["whom_user_id"], "text"=>$_POST["text"]]);
                }

            }

        } 

        return json_answer(["status"=>true, "auth"=>true]);

    }

    public function addBlacklist()
    {   

        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $result = $this->component->profile->addToBlacklist($_POST['user_id'], $_POST['whom_user_id']);

        if($result){
            return json_answer(["status"=>true, "auth"=>true, "answer"=>translate("tr_458757e2487f3465434ed5121deda101")]);
        }else{
            return json_answer(["status"=>false, "auth"=>true, "answer"=>translate("tr_a58a5c103be003b8a1a58e101a0e45ca")]);
        }
        
    }

    public function subscribe()
    {   

        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $get = $this->model->users_subscriptions->find("whom_user_id=? and user_id=?", [$_POST['whom_user_id'], $_POST['user_id']]);

        if($get){

            $this->model->users_subscriptions->delete("id=?", [$get->id]);

            $countSubscribers = $this->model->users_subscriptions->count("whom_user_id = ?", [$_POST['whom_user_id']]);

            return json_answer(["status"=>false, "auth"=>true, "count"=>$countSubscribers]);

        }else{

            $user = $this->model->users->findById($_POST['whom_user_id']);

            if($user && !$user->delete){

                $this->model->users_subscriptions->insert(["user_id"=>$_POST['user_id'], "whom_user_id"=>$_POST['whom_user_id'], "time_create"=>$this->datetime->getDate()]);

                $countSubscribers = $this->model->users_subscriptions->count("whom_user_id = ?", [$_POST['whom_user_id']]);

                $this->event->subscribeUser(["from_user_id"=>$_POST['user_id'], "whom_user_id"=>$_POST['whom_user_id']]);

                return json_answer(["status"=>true, "auth"=>true, "count"=>$countSubscribers]);   

            }else{

                $countSubscribers = $this->model->users_subscriptions->count("whom_user_id = ?", [$_POST['whom_user_id']]);

                return json_answer(["status"=>false, "auth"=>true, "count"=>$countSubscribers]);

            }

        }
        
    }

}