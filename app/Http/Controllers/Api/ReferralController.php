<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Http\Controllers\Api;

use App\Systems\Controller;

class ReferralController extends Controller {

    public function __construct($app){
        parent::__construct($app); 
    }

    public function getData(){ 

        if(!$this->api->verificationAuth($_GET['token'], $_GET['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $result["earned"] = $this->component->profile->totalAwardReferral($_GET['user_id']);
        $result["transitions"] = $this->component->profile->totalCountTransitionsReferral($_GET['user_id']);

        $getUsers = $this->model->users_referrals->sort("id desc")->getAll("whom_user_id=?", [$_GET['user_id']]);

        if($getUsers){
            foreach ($getUsers as $key => $value) {
               
                $user = $this->model->users->find('id=?', [$value["from_user_id"]]);

                $result["referrals"][] = [
                    "id"=>$value["id"],
                    "time_create"=>$this->datetime->outDateTime($value["time_create"]),
                    "user"=>[
                        "id"=>$user->id,
                        "display_name"=>$this->user->name($user),
                        "avatar"=>$this->storage->name($user->avatar)->host(true)->get(),
                    ],
                ];

            }
        }

        $getUsers = $this->model->users_referral_award->sort("id desc")->getAll("whom_user_id=?", [$_GET['user_id']]);

        if($getUsers){
            foreach ($getUsers as $key => $value) {
               
                $user = $this->model->users->find('id=?', [$value["from_user_id"]]);

                $result["rewards"][] = [
                    "id"=>$value["id"],
                    "amount"=>$this->system->amount($value["amount"]),
                    "time_create"=>$this->datetime->outDateTime($value["time_create"]),
                    "user"=>[
                        "id"=>$user->id,
                        "display_name"=>$this->user->name($user),
                        "avatar"=>$this->storage->name($user->avatar)->host(true)->get(),
                    ],
                ];

            }
        }        

        return json_answer(["earned"=>$result["earned"], "transitions"=>$result["transitions"], "referrals"=>$result["referrals"] ?: [], "rewards"=>$result["rewards"] ?: [], "auth"=>true]);

    }


}