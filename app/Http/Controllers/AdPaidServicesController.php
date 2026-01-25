<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Http\Controllers;

 use App\Systems\Controller;

 class AdPaidServicesController extends Controller
 {

 public function __construct($app){
 parent::__construct($app); 
 }

 public function main($ad_id){   

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/ad_paid_services.js\" type=\"module\" ></script>"]);

    $data = $this->component->ads->getAd($ad_id);

    if(!$data || !$this->settings->paid_services_status){
        abort(404);
    }else{

        if($data->user_id != $this->user->data->id){
            abort(404);
        }

        if($data->status != 1){
            abort(404);
        }

    }

    $seo = $this->component->seo->content($data);

    return $this->view->render('ad-paid-services', ["data"=>(object)$data, "seo"=>$seo]);
}

public function searchUserItems(){ 

    $result = '';

    if(_mb_strlen($_POST['query']) < 2){
        return json_answer(["status"=>false]);
    }    

    return json_answer(["status"=>true, "answer"=>$this->component->ad_paid_services->searchItemsWaitingList($_POST['query'], $this->user->data->id)]);

}

public function updateCount(){   

    $total_price = 0;
    $total_price_old = 0;
    $count = $_POST['count'] ? abs(intval($_POST['count'])) : 1;

    if($_POST['service_id']){

        $getService = $this->model->ads_services->find("id=?", [$_POST['service_id']]);

        if($getService){

            $total_price = $count * $getService->price;

            if($getService->old_price){
                $total_price_old = $count * $getService->old_price;
            }

            return json_answer(["price_now"=>$this->system->amount($total_price), "price_old"=>$this->system->amount($total_price_old), "count"=> translate("tr_1f6c150ae7fba44b3897f51c51c4ca47") . ' ' . $count . ' ' . endingWord($count, translate("tr_48e438a146f96b54bbe9d5046ffc3a2b"), translate("tr_0871eeafdf38726742fa5affa8a5d6eb"), translate("tr_c183655a02377815e6542875555b1340"))]);

        }

    }

}



 }