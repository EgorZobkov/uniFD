<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Http\Controllers\Dashboard;

 use App\Systems\Controller;

 class AdsCategoriesController extends Controller
 {

 public function __construct($app){
 parent::__construct($app); 
 }

 public function add()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['alias'])->status == false){
        $answer['alias'] = $this->validation->error;
    }  
 
    if($_POST['paid_status']){
        if($this->validation->requiredField($_POST['paid_cost'])->status == false){
            $answer['paid_cost'] = $this->validation->error;
        }
    }

    if($_POST['filter_generation_title']){
        if($this->validation->requiredField($_POST['filter_template_title'])->status == false){
            $answer['filter_template_title'] = $this->validation->error;
        }
    }

    if($_POST['delivery_status']){
        if($this->validation->requiredField($_POST['delivery_size_weight'])->status == false){
            $answer['delivery_size_weight'] = $this->validation->error;
        }            
    }

    if(empty($answer)){

        if($_POST['personal_page_status']){
            $page_id = $this->component->templates->addPageByMainCatalog($_POST['name']);
        }

        $params["status"] = (int)$_POST['status'];
        $params["name"] = $_POST['name'];
        $params["alias"] = slug($_POST['name']);
        $params["parent_id"] = (int)$_POST['parent_id'];
        $params["image"] = $_POST["manager_image"] ?: null;
        $params["price_name_id"] = (int)$_POST["price_name_id"];
        $params["price_measure_ids"] = $_POST["price_measure_ids"] ? _json_encode($_POST["price_measure_ids"]) : null;
        $params["price_status"] = (int)$_POST['price_status'];
        $params["paid_status"] = (int)$_POST['paid_status'];
        $params["paid_cost"] = $_POST['paid_cost'];
        $params["paid_free_count"] = (int)$_POST['paid_free_count'];
        $params["marketplace_status"] = (int)$_POST['marketplace_status'];
        $params["secure_status"] = (int)$_POST['secure_status'];
        $params["auction_status"] = (int)$_POST['auction_status'];
        $params["booking_status"] = (int)$_POST['booking_status'];
        $params["booking_action"] = $_POST['booking_action'];
        $params["gratis_status"] = (int)$_POST['gratis_status'];
        $params["online_view_status"] = (int)$_POST['online_view_status'];
        $params["condition_new_status"] = (int)$_POST['condition_new_status'];
        $params["condition_brand_status"] = (int)$_POST['condition_brand_status'];
        $params["seo_title"] = $_POST['seo_title'];
        $params["seo_desc"] = $_POST['seo_desc'];
        $params["seo_h1"] = $_POST['seo_h1'];
        $params["seo_text"] = $_POST['seo_text'] ? urldecode($_POST['seo_text']) : $_POST['seo_text'];
        $params["personal_page_status"] = (int)$_POST['personal_page_status'];
        $params["personal_page_id"] = $page_id ?: 0;
        $params["filter_generation_title"] = (int)$_POST['filter_generation_title'];
        $params["filter_template_title"] = $_POST['filter_template_title'];
        $params["filter_template_preset"] = $_POST['filter_template_preset'];
        $params["price_fixed_change"] = (int)$_POST['price_fixed_change'];
        $params["price_required"] = (int)$_POST['price_required'];
        $params["type_goods"] = $_POST['type_goods']?:null;
        $params["change_city_status"] = (int)$_POST['change_city_status'];
        $params["default_view_items_catalog"] = $_POST['default_view_items_catalog'];
        $params["delivery_status"] = (int)$_POST['delivery_status'];
        $params["delivery_size_weight"] = (int)$_POST['delivery_size_weight'];
        $params["delivery_size_width"] = (int)$_POST['delivery_size_width'];
        $params["delivery_size_height"] = (int)$_POST['delivery_size_height'];
        $params["delivery_size_depth"] = (int)$_POST['delivery_size_depth'];

        $this->model->ads_categories->insert($params);

        $this->caching->delete($this->caching->buildKey("uni_ads_categories", ["all_categories"]));

        $this->session->setNotifyDashboard('success', code_answer("add_successfully"));

        return json_answer(["status"=>true]);

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }    

}

public function delete()
{
    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->component->ads_categories->delete($_POST['id']);

    $this->session->setNotifyDashboard('success', code_answer("delete_successfully"));

    return json_answer(["status"=>true]);
}

public function edit()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    $getCategory = $this->model->ads_categories->find('id=?', [$_POST['id']]);

    if(!$getCategory) return json_answer(["status"=>true, "type_answer"=>"error", "type_show"=>"notice", "answer"=>translate("tr_bd7388001c80bdcba20d26ef3ce22464")]);

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['alias'])->status == false){
        $answer['alias'] = $this->validation->error;
    }  

    if($_POST['paid_status']){
        if($this->validation->requiredField($_POST['paid_cost'])->status == false){
            $answer['paid_cost'] = $this->validation->error;
        }
    }

    if($_POST['filter_generation_title']){
        if($this->validation->requiredField($_POST['filter_template_title'])->status == false){
            $answer['filter_template_title'] = $this->validation->error;
        }
    }

    if($_POST['delivery_status']){
        if($this->validation->requiredField($_POST['delivery_size_weight'])->status == false){
            $answer['delivery_size_weight'] = $this->validation->error;
        }            
    }

    if($_POST['id'] != $_POST['parent_id']){
      $parentIds = $this->component->ads_categories->joinId($_POST['id'])->getParentIds($_POST['id']);
      if(!$parentIds){
         $getCategory->parent_id = $_POST["parent_id"];
      }else{
         if(!in_array($_POST["parent_id"], explode(",",$parentIds))){
            $getCategory->parent_id = $_POST["parent_id"];
         }
      }
    }

    if(empty($answer)){

        if($getCategory->personal_page_id){
            if(!$this->model->template_pages->find("id=?", [$getCategory->personal_page_id])){
                $getCategory->personal_page_id = 0;
            }
        }

        if($_POST['personal_page_status']){
            if(!$getCategory->personal_page_id){
                $getCategory->personal_page_id = $this->component->templates->addPageByMainCatalog($_POST['name']);
            }
        }

        $params["status"] = (int)$_POST['status'];
        $params["name"] = $_POST['name'];
        $params["alias"] = slug($_POST['alias']);
        $params["parent_id"] = $getCategory->parent_id;
        $params["image"] = $_POST["manager_image"] ?: null;
        $params["price_name_id"] = (int)$_POST["price_name_id"];
        $params["price_measure_ids"] = $_POST["price_measure_ids"] ? _json_encode($_POST["price_measure_ids"]) : null;
        $params["price_status"] = (int)$_POST['price_status'];
        $params["paid_status"] = (int)$_POST['paid_status'];
        $params["paid_cost"] = $_POST['paid_cost'];
        $params["paid_free_count"] = (int)$_POST['paid_free_count'];
        $params["marketplace_status"] = (int)$_POST['marketplace_status'];
        $params["secure_status"] = (int)$_POST['secure_status'];
        $params["auction_status"] = (int)$_POST['auction_status'];
        $params["booking_status"] = (int)$_POST['booking_status'];
        $params["booking_action"] = $_POST['booking_action'];
        $params["gratis_status"] = (int)$_POST['gratis_status'];
        $params["online_view_status"] = (int)$_POST['online_view_status'];
        $params["condition_new_status"] = (int)$_POST['condition_new_status'];
        $params["condition_brand_status"] = (int)$_POST['condition_brand_status'];
        $params["seo_title"] = $_POST['seo_title'];
        $params["seo_desc"] = $_POST['seo_desc'];
        $params["seo_h1"] = $_POST['seo_h1'];
        $params["seo_text"] = $_POST['seo_text'] ? urldecode($_POST['seo_text']) : $_POST['seo_text'];
        $params["personal_page_status"] = (int)$_POST['personal_page_status'];
        $params["personal_page_id"] = $getCategory->personal_page_id;
        $params["filter_generation_title"] = (int)$_POST['filter_generation_title'];
        $params["filter_template_title"] = $_POST['filter_template_title'];
        $params["filter_template_preset"] = $_POST['filter_template_preset'];
        $params["price_fixed_change"] = (int)$_POST['price_fixed_change'];
        $params["price_required"] = (int)$_POST['price_required'];
        $params["type_goods"] = $_POST['type_goods']?:null;
        $params["change_city_status"] = (int)$_POST['change_city_status'];
        $params["default_view_items_catalog"] = $_POST['default_view_items_catalog'];
        $params["delivery_status"] = (int)$_POST['delivery_status'];
        $params["delivery_size_weight"] = (int)$_POST['delivery_size_weight'];
        $params["delivery_size_width"] = (int)$_POST['delivery_size_width'];
        $params["delivery_size_height"] = (int)$_POST['delivery_size_height'];
        $params["delivery_size_depth"] = (int)$_POST['delivery_size_depth'];

        $this->model->ads_categories->cacheKey(["id"=>$getCategory->id])->update($params, $getCategory->id);

        if($_POST["apply_subcategories"]){

            unset($params["status"]);
            unset($params["name"]);
            unset($params["alias"]);
            unset($params["parent_id"]);
            unset($params["image"]);
            unset($params["filter_generation_title"]);
            unset($params["filter_template_title"]);
            unset($params["filter_template_preset"]);
            unset($params["seo_title"]);
            unset($params["seo_desc"]);
            unset($params["seo_h1"]);
            unset($params["seo_text"]);
            unset($params["personal_page_status"]);
            unset($params["personal_page_id"]);

            $parentIds = $this->component->ads_categories->getParentIds($_POST['id']);
            if($parentIds){
                foreach (explode(",", $parentIds) as $key => $id) {

                    $this->model->ads_categories->cacheKey(["id"=>$id])->update($params, $id);

                }
            }
        }

        $this->caching->delete($this->caching->buildKey("uni_ads_categories", ["all_categories"]));

        return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("save_successfully")]);

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }    

}

public function loadEdit()
{

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $data = $this->model->ads_categories->find("id=?", [$_POST['id']]);

    return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('board/categories/load-edit.tpl')]);

}

public function loadSubcategories()
{
    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $content = '';
    $level = 0;

    $categories = $this->component->ads_categories->getCategories();

    $reverseMainIds = $this->component->ads_categories->getReverseMainIds($_POST['id']);

    if($reverseMainIds){
        foreach (explode(",", $reverseMainIds) as $key => $value) {
          $level += 10;
        }
    }

    foreach ($categories["parent_id"][$_POST['id']] as $category) {

        $sub = $this->component->ads_categories->checkSubcategories($category["id"]) ? '<span class="categories-table-open-subcategories btn btn-sm rounded-pill btn-icon btn-label-primary waves-effect waves-light loadTableSubcategories" data-id="'.$category["id"].'" data-parent-ids="'.$this->component->ads_categories->getParentIds($category["id"]).'" data-open="false" ><i class="ti ti-xs ti ti-arrow-down"></i></span>' : '';

        $content .= '
            <tr class="subcategory-item-'.$category["id"].' categories-tr-container" data-id="'.$category['id'].'" >
              <td> <div class="handle-sorting handle-sorting-move" ><i class="ti ti-arrows-sort"></i></div> </td>
              <td>'.$category['id'].'</td>
              <td><div style="margin-left:'. $level .'px;" >'.translateField($category["name"]).' '.$sub.'</div></td>
              <td>'.($this->component->ads_counter->countItemsCategories($category["id"]) ?: 0).'</td>
              <td>'.($category["paid_status"] ? translate("tr_e04af96afe53462f72f39331b209a810") : translate("tr_d0cd2248137f1acac2e79777d856305e")).'</td>
              <td>'.($category["secure_status"] ? translate("tr_e04af96afe53462f72f39331b209a810") : translate("tr_d0cd2248137f1acac2e79777d856305e")).'</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditCategory" data-id="'.$category['id'].'" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteCategory" data-id="'.$category['id'].'" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>
        ';
    }

    return json_answer(["content"=>$content]);
}

public function loadTemplateFilterItems()
{

    $items = '';

    $getIdFilters = $this->component->ads_filters->getFiltersByCategory($_POST['id']);

    if($getIdFilters){

         $getFilters = $this->model->ads_filters->sort("sorting asc")->getAll("status=? and id IN(".implode(",", $getIdFilters).")", [1]);

         if($getFilters){

            foreach ($getFilters as $key => $value) {

                $items .= '<div class="filter-template-item" > '.translateField($value["name"]).': <span class="copyToClipboard" >{'.$value["id"].'}</span> </div>';

            }

            return json_answer(['content'=>$items]);

         }

    }

    return json_answer(['content'=>'<div class="filter-template-item" >'.translate("tr_fc02fd451c3f9ffae8d60144fca321d7").'</div>']);

}

public function main()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/categories.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_6926e02be4135897ae84b36941554684")=>$this->router->getRoute("dashboard-ads-categories")],"route_name"=>$this->router->currentRoute->name,"page_name"=>translate("tr_e00f391c7735dc851cfed26cbd6bbfb7"),"page_icon"=>"ti-list","favorite_status"=>true]]);

    return $this->view->preload('board/ads-categories', ["title"=>translate("tr_6926e02be4135897ae84b36941554684")]);

}

public function sorting(){

    if($_POST["ids"]){
        foreach (explode(",", $_POST["ids"]) as $key => $id) {
            $this->model->ads_categories->cacheKey(["id"=>$id])->update(["sorting"=>$key], $id);
        }
    }

    return json_answer(["status"=>true]);

}



 }