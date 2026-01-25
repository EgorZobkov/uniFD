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