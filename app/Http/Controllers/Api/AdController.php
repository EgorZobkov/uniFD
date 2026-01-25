<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Http\Controllers\Api;

use App\Systems\Controller;

class AdController extends Controller {

    public function __construct($app){
        parent::__construct($app); 
    }

    public function getOptions(){

        if(!$this->api->verificationAuth($_GET['token'], $_GET['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $result = [];

        $category_id = (int)$_GET['cat_id'];

        if(!$this->component->ads_categories->categories[$category_id]){
            return null;
        }

        return json_answer(["data"=>$this->api->getCategoryOptions($category_id, $_GET['user_id']), "auth"=>true]);

    }

    public function validation(){ 

        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $_POST['filters'] = $_POST['filters'] ? $this->api->normalizedFiltersCatalogArray(_json_decode(html_entity_decode($_POST['filters']))) : [];
        $_POST['media'] = $_POST['media'] ? $this->api->normalizedMediaArray(_json_decode(html_entity_decode($_POST['media']))) : [];

        $result = $this->api->validationStepCreate($_POST, $_POST['user_id'], (int)$_POST['step'], (int)$_POST['ad_id'] ? true : false);

        if(!$result){
            return json_answer(["data"=>$result, "status"=>true, "auth"=>true]);
        }else{
            return json_answer(["data"=>$result, "status"=>false, "answer"=>implode("\n", $result), "auth"=>true]);
        }

    }

    public function adCreate(){

        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        if($this->system->checkingBadRequests("ad_create", $_POST['user_id'])){
            return json_answer(null);
        }

        if(!$this->component->profile->checkVerificationPermissions($_POST['user_id'], "create_ad")){
            return json_answer(["verification"=>false, "auth"=>true]);
        }

        $_POST['filters'] = $_POST['filters'] ? $this->api->normalizedFiltersCatalogArray(_json_decode(html_entity_decode($_POST['filters']))) : [];
        $_POST['media'] = $_POST['media'] ? $this->api->normalizedMediaArray(_json_decode(html_entity_decode($_POST['media']))) : [];

        $_POST['booking_additional_services'] = $_POST['booking_additional_services'] ? _json_decode(html_entity_decode($_POST['booking_additional_services'])) : [];
        $_POST['booking_special_days'] = $_POST['booking_special_days'] ? _json_decode(html_entity_decode($_POST['booking_special_days'])) : [];
        $_POST['booking_week_days_price'] = $_POST['booking_week_days_price'] ? _json_decode(html_entity_decode($_POST['booking_week_days_price'])) : [];

        $result = $this->api->validationStepCreate($_POST, $_POST['user_id'], null);

        if(!$result){

            $result = $this->api->adCreate($_POST,$_POST['user_id']);

            return json_answer(["status"=>true, "auth"=>true, "id"=>$result->ad_id, "detect_status"=>(int)$result->status, "verification"=>true]);
        }else{
            return json_answer(["data"=>$result, "status"=>false, "answer"=>implode("\n", $result), "auth"=>true, "verification"=>true]);
        }

    }

    public function adUpdate(){

        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $_POST['filters'] = $_POST['filters'] ? $this->api->normalizedFiltersCatalogArray(_json_decode(html_entity_decode($_POST['filters']))) : [];
        $_POST['media'] = $_POST['media'] ? $this->api->normalizedMediaArray(_json_decode(html_entity_decode($_POST['media']))) : [];

        $_POST['booking_additional_services'] = $_POST['booking_additional_services'] ? _json_decode(html_entity_decode($_POST['booking_additional_services'])) : [];
        $_POST['booking_special_days'] = $_POST['booking_special_days'] ? _json_decode(html_entity_decode($_POST['booking_special_days'])) : [];
        $_POST['booking_week_days_price'] = $_POST['booking_week_days_price'] ? _json_decode(html_entity_decode($_POST['booking_week_days_price'])) : [];

        $result = $this->api->validationStepCreate($_POST, $_POST['user_id'], null, true);

        if(!$result){

            $this->api->adUpdate($_POST,$_POST['user_id'],$_POST['ad_id']);

            return json_answer(["status"=>true, "auth"=>true, "id"=>$_POST['ad_id']]);
        }else{
            return json_answer(["data"=>$result, "status"=>false, "answer"=>implode("\n", $result), "auth"=>true]);
        }

    }

    public function getServicesTariffsAll(){

        if(!$this->api->verificationAuth($_GET['token'], $_GET['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $result = [];

        $data = $this->model->ads_services->sort("recommended desc, sorting asc")->getAll("status=?", [1]);

        if($data){

            foreach ($data as $key => $value) {

                $result[] = [
                    "id" => $value["id"],
                    "name" => html_entity_decode($value["name"]),
                    "image" => $value["image"] ? $this->storage->name($value["image"])->host(true)->get() : null,
                    "price" => $value["old_price"] ? ["now"=>$value["price"], 'old'=>$value["old_price"]] : ["now"=>$value["price"], "old"=>null],
                    "text" => html_entity_decode($value["text"]),
                    "variant" => $value["count_day_fixed"] ? 'fix' : 'change',
                    "count_day" => "Действует ".$value["count_day"]." ".endingWord($value["count_day"], translate("tr_48e438a146f96b54bbe9d5046ffc3a2b"), translate("tr_0871eeafdf38726742fa5affa8a5d6eb"), translate("tr_c183655a02377815e6542875555b1340")),
                    "recommended" => $value["recommended"] ? true : false,
                    "package_status" => $value["package_status"] ? true : false,
                    "alias" => $value["alias"],
                ];

            }

        }

        return json_answer(["auth"=>true, "data"=>$result]);
        
    }

    public function adLoad(){

        if(!$this->api->verificationAuth($_GET['token'], $_GET['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $result = [];
        $media = [];
        $params = [];

        $contacts_method = ["all"=>translate("tr_2896f02474404ef29588f3489d8a461e"), "call"=>translate("tr_6aa1128b7f28aa917e80ee45c0da715f"), "message"=>translate("tr_0994356b1cef3b535e4900be810d7759"), "hide"=>translate("tr_bd21fbcbe7f325040fc3dd6bfe4a0245")];

        $data = $this->component->ads->getAd($_GET['id'], $_GET['user_id']);

        if($data){

            $category_id = (int)$_GET['cat_id'] ? (int)$_GET['cat_id'] : $data->category_id;

            if($data->media->inline){
                foreach ($data->media->inline as $key => $value) {
                    $info = pathinfo($value->link);
                    if($value->type == "image"){
                        $media[] = ["name"=>$info["filename"].".webp", "link"=>$value->link, "type"=>$value->type];
                    }else{
                        $media[] = ["name"=>$info["filename"].".webp", "link"=>$value->preview, "type"=>$value->type];
                    }
                }
            }

            $measurementData = $this->model->system_measurements->find("id=?", [$data->price_measure_id]);
            $bookingData = $this->model->ads_booking_data->find("ad_id=?", [$_GET['id']]);

            $breadcrumb = $this->component->ads_categories->getBuildNameChain($this->component->ads_categories->getParentsId($category_id));

            $filtersIds = $this->model->ads_filters_ids->getAll("ad_id=?", [$_GET['id']]);
            if($filtersIds){
                foreach ($filtersIds as $key => $value) {
                    $filter = $this->model->ads_filters->find("id=?", [$value["filter_id"]]);
                    if($filter->view == "input" || $filter->view == "input_text"){
                        $params[] = ['filterId'=>$value['filter_id'], 'item'=>$value['value'], 'field'=>'text'];
                    }else{
                        $filterItem = $this->model->ads_filters_items->find("id=?", [$value["item_id"]]);
                        $params[] = ['filterId'=>$value['filter_id'], 'item'=>$value["item_id"], 'name'=>html_entity_decode($filterItem->name), 'field'=>null];
                    }
                }
            }

            $result = [
                "option" => $this->api->getCategoryOptions($category_id, $_GET['user_id'], $this->api->normalizedFiltersArray($params)),
                "params" => $params,
                "id"=>$data->id,
                "title"=>$data->title,
                "text"=>$data->text,
                "cat_id"=>$data->category_id,
                "cat_breadcrumb"=>$breadcrumb,
                "city_id"=>$data->city_id,
                "city_name" => $data->geo ? $data->geo->name : null,
                "price"=>$data->price,
                "media"=>$media ?: null,
                "contacts"=>$data->contacts ? (array)$data->contacts : null,
                "video_link"=>$data->video_link ?: '',
                "category_name" => $data->category->name,
                "geo_address_latitude" => $data->address_latitude,
                "geo_address_longitude" => $data->address_longitude,
                "geo_address" => $data->address,
                "price_gratis_status" => $data->price_gratis_status ? true : false,
                "price_measurement" => $data->price_measure_id ?: null,
                "price_measurement_name" => $measurementData ? $measurementData->name : null,
                "price_currency_code" => $data->currency_code,
                "price_currency_sign" => $this->settings->system_extra_currency[$data->currency_code]["symbol"],
                "price_fixed_status" => $data->price_fixed_status ? true : false,
                "online_view_status" => $data->online_view_status ? true : false,
                "condition_new_status" => $data->condition_new_status ? true : false,
                "condition_brand_status" => $data->condition_brand_status ? true : false,
                "external_content" => $data->external_content,
                "booking_status" => $data->booking_status ? true : false,
                "renewal_status" => $data->auto_renewal_status ? true : false,
                "partner_link" => $data->partner_link,
                "delivery_status" => $data->delivery_status ? true : false,
                "partner_button_name" => $data->partner_button_name,
                "partner_button_color" => $data->partner_button_color,
                "in_stock" => $data->in_stock,
                "not_limited" => $data->not_limited ? true : false,
                "contact_method" => $data->contact_method,
                "contact_method_name" => $contacts_method[$data->contact_method],
                "booking_deposit_status" => $bookingData->deposit_status ? true : false,
                "booking_full_payment_status" => $bookingData->full_payment_status ? true : false,
                "booking_prepayment_percent" => $bookingData->prepayment_percent,
                "booking_deposit_amount"=>$bookingData->deposit_amount,
                "booking_max_guests"=>$bookingData->max_guests,
                "booking_min_days"=>$bookingData->min_days,
                "booking_max_days"=>$bookingData->max_days,
                "booking_week_days_price"=>$bookingData->week_days_price ? _json_decode($bookingData->week_days_price) : [],
                "booking_additional_services"=>$bookingData->additional_services ? _json_decode($bookingData->additional_services) : [],
                "booking_special_days"=>$bookingData->special_days ? _json_decode($bookingData->special_days) : [],
            ];

        }

        return json_answer(["auth"=>true, "data"=>$result]);
        
    }

}