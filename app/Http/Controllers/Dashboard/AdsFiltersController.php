<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Http\Controllers\Dashboard;

 use App\Systems\Controller;

 class AdsFiltersController extends Controller
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

    if($this->validation->requiredField($_POST['view'])->status == false){
        $answer['view'] = $this->validation->error;
    }

    if($this->validation->isSelectedCategories($_POST['categories'])->status == false){
        $answer['categories'] = $this->validation->error;
    }

    if($_POST['view'] != 'input_text'){
        if($this->validation->requiredItemsFilters($_POST['items'])->status == false){
            $answer['items'] = $this->validation->error;
        }
    }

    if(empty($answer)){

        $filter_id = $this->model->ads_filters->insert(["status"=>(int)$_POST['status'], "name"=>$_POST['name'], "alias"=>slug($_POST['alias']), "required"=>(int)$_POST['required'], "view"=>$_POST['view'], "item_sorting"=>$_POST['item_sorting'], "default_status"=>(int)$_POST['default_status']]);  

        if($filter_id){

            foreach ($_POST['categories'] as $key => $value) {
                $this->model->ads_filters_categories->insert(["category_id"=>$value, "filter_id"=>$filter_id]);
            } 

            $sorting = 1;

            if($_POST['view'] != 'input_text'){
               foreach ($_POST["items"] as $action => $nested) {
                 foreach ($nested as $id => $value) {

                    if($action == "add" && trim($value) != ""){
                       $this->model->ads_filters_items->insert(["filter_id"=>$filter_id, "name"=>_ucfirst($value), "alias"=>slug($value), "sorting"=>$sorting]);
                    }

                    $sorting++;
                    
                 }
               }
            }  

        }

        $this->session->setNotifyDashboard('success', code_answer("add_successfully"));

        return json_answer(["status"=>true]);             

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }

}

public function addFilterLink()
{
    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }else{
        if(!$_POST['seo_title']){
            $_POST['seo_title'] = $_POST['name'];
        }
        if(!$_POST['seo_h1']){
            $_POST['seo_h1'] = $_POST['name'];
        }
    }   

    if($this->validation->requiredField($_POST['alias'])->status == false){
        $answer['alias'] = $this->validation->error;
    } 

    if($this->validation->requiredField($_POST['category_id'])->status == false){
        $answer['category_id'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['params'])->status == false){
        $answer['params'] = $this->validation->error;
    }else{
        if(strpos($_POST['params'], "?") !== false){
            $params = explode("?", $_POST['params']);
            $_POST['params'] = trim(str_replace("&amp;", "&", urldecode($params[1])), "/");
        }else{
            if(strpos($_POST['params'], "filter") === false){
                $answer['params'] = translate("tr_1ec283fe025a82c2f23df24a964f48bb");
            }
        }
    }

    if(empty($answer)){

        $chainCategory = $this->component->ads_categories->chainCategory($_POST['category_id']);

        $this->model->ads_filters_links->insert(["name"=>$_POST['name'], "alias"=>slug($_POST['alias']), "params"=>$_POST['params'], "category_id"=>(int)$_POST['category_id'], "seo_title"=>$_POST['seo_title'], "seo_desc"=>$_POST['seo_desc'], "seo_h1"=>$_POST['seo_h1'], "seo_text"=>$_POST['seo_text'], "full_aliases"=>$chainCategory->chain_build_alias_request.'/'.slug($_POST['alias'])]);

        $this->session->setNotifyDashboard('success', code_answer("add_successfully"));

        return json_answer(["status"=>true]);             

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }

}

public function addPodfilter()
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

    if($this->validation->requiredField($_POST['view'])->status == false){
        $answer['view'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['filter_item_id'])->status == false){
        $answer['filter_item_id'] = $this->validation->error;
    }

    if($_POST['view'] != 'input_text'){
        if($this->validation->requiredItemsFilters($_POST['items'])->status == false){
            $answer['items'] = $this->validation->error;
        }
    }

    if(empty($answer)){

        $filter_id = $this->model->ads_filters->insert(["status"=>(int)$_POST['status'], "name"=>$_POST['name'], "alias"=>slug($_POST['alias']), "required"=>(int)$_POST['required'], "view"=>$_POST['view'], "item_sorting"=>$_POST['item_sorting'], "parent_id"=>$_POST["id"]]);  

        if($filter_id){

            foreach ($_POST['categories'] as $key => $value) {
                $this->model->ads_filters_categories->insert(["category_id"=>$value, "filter_id"=>$filter_id]);
            }

            $sorting = 1;

            if($_POST['view'] != 'input_text'){
                foreach ($_POST["items"] as $action => $nested) {
                    foreach ($nested as $id => $value) {
                    
                        $item_insert_id = $this->model->ads_filters_items->insert(["filter_id"=>$filter_id, "name"=>_ucfirst($value), "alias"=>slug($value), "sorting"=>$sorting, "item_parent_id"=>$_POST['filter_item_id']]);

                        $sorting++;
                    
                    }
                }

            }  

        }

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

    $this->component->ads_filters->delete($_POST['id']);

    $this->session->setNotifyDashboard('success', code_answer("delete_successfully"));

    return json_answer(["status"=>true]);
}

public function deleteFilterLink()
{
    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->model->ads_filters_links->delete("id=?", [$_POST['id']]);

    $this->session->setNotifyDashboard('success', code_answer("delete_successfully"));

    return json_answer(["status"=>true]);
}

public function edit()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    $getFilter = $this->model->ads_filters->find('id=?', [$_POST['id']]);

    if(!$getFilter) return json_answer(["status"=>true, "type_answer"=>"error", "type_show"=>"notice", "answer"=>code_answer("record_not_found")]);

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }   

    if($this->validation->requiredField($_POST['alias'])->status == false){
        $answer['alias'] = $this->validation->error;
    } 

    if($this->validation->requiredField($_POST['view'])->status == false){
        $answer['view'] = $this->validation->error;
    }

    if($getFilter->parent_id){
        if($this->validation->requiredField($_POST['filter_item_id'])->status == false){
            $answer['filter_item_id'] = $this->validation->error;
        }            
    }else{
        if($this->validation->isSelectedCategories($_POST['categories'])->status == false){
            $answer['categories'] = $this->validation->error;
        }
    }

    if($_POST['view'] != 'input_text'){
        if($this->validation->requiredItemsFilters($_POST['items'])->status == false){
            $answer['items'] = $this->validation->error;
        }
    }

    if(empty($answer)){

        $this->model->ads_filters->update(["status"=>(int)$_POST['status'], "name"=>$_POST['name'], "alias"=>slug($_POST['alias']), "required"=>(int)$_POST['required'], "view"=>$_POST['view'], "item_sorting"=>$_POST['item_sorting'], "default_status"=>(int)$_POST['default_status']], $getFilter->id);  

        if(!$getFilter->parent_id){

            $this->model->ads_filters_categories->delete("filter_id=?", [$getFilter->id]);

            foreach ($_POST['categories'] as $category_id) {
                $this->model->ads_filters_categories->insert(["category_id"=>$category_id, "filter_id"=>$getFilter->id]);
            }

            $parent_filter_ids = $this->component->ads_filters->getParentIds($getFilter->id);

            if($parent_filter_ids){
                foreach (explode(",", $parent_filter_ids) as $filter_id) {
                    $this->model->ads_filters_categories->delete("filter_id=?", [$filter_id]);
                    foreach ($_POST['categories'] as $category_id) {
                        $this->model->ads_filters_categories->insert(["category_id"=>$category_id, "filter_id"=>$filter_id]);
                    }
                }
            }

        }

        $sorting = 1;
        $idsNotDelete = [];

        if($_POST['view'] != 'input_text'){

            foreach ($_POST["items"] as $action => $nested) {
                foreach ($nested as $id => $value) {
                
                    if(trim($value) != ""){
                      if($action == "add"){
                         $item_insert_id = $this->model->ads_filters_items->insert(["filter_id"=>$getFilter->id, "name"=>_ucfirst($value), "alias"=>slug($value), "sorting"=>$sorting, "item_parent_id"=>$_POST['filter_item_id']?:0]);
                         $idsNotDelete[$item_insert_id] = $item_insert_id;
                      }elseif($action == "edit"){
                         $this->model->ads_filters_items->update(["name"=>_ucfirst($value), "alias"=>slug($value), "sorting"=>$sorting], $id);
                         $idsNotDelete[$id] = $id;
                      }
                    }

                    $sorting++;
                
                }
            }

            if($idsNotDelete){
                if(isset($_POST['filter_item_id'])){
                    $this->model->ads_filters_items->delete("filter_id=? and item_parent_id=? and id NOT IN(".implode(",", $idsNotDelete).")", [$getFilter->id,$_POST['filter_item_id']]);
                }else{
                    $this->model->ads_filters_items->delete("filter_id=? and id NOT IN(".implode(",", $idsNotDelete).")", [$getFilter->id]);
                }
            }

        }

        return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("save_successfully")]);
        
    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }

}

public function editFilterLink()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    $getFilterLink = $this->model->ads_filters_links->find('id=?', [$_POST['id']]);

    if(!$getFilterLink) return json_answer(["status"=>true, "type_answer"=>"error", "type_show"=>"notice", "answer"=>code_answer("record_not_found")]);

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }else{
        if(!$_POST['seo_title']){
            $_POST['seo_title'] = $_POST['name'];
        }
        if(!$_POST['seo_h1']){
            $_POST['seo_h1'] = $_POST['name'];
        }
    }   

    if($this->validation->requiredField($_POST['alias'])->status == false){
        $answer['alias'] = $this->validation->error;
    } 

    if($this->validation->requiredField($_POST['category_id'])->status == false){
        $answer['category_id'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['params'])->status == false){
        $answer['params'] = $this->validation->error;
    }else{
        if(strpos($_POST['params'], "?") !== false){
            $params = explode("?", $_POST['params']);
            $_POST['params'] = trim(str_replace("&amp;", "&", urldecode($params[1])), "/");
        }else{
            if(strpos($_POST['params'], "filter") === false){
                $answer['params'] = translate("tr_1ec283fe025a82c2f23df24a964f48bb");
            }
        }
    }

    if(empty($answer)){

        $chainCategory = $this->component->ads_categories->chainCategory($_POST['category_id']);

        $this->model->ads_filters_links->update(["name"=>$_POST['name'], "alias"=>slug($_POST['alias']), "params"=>str_replace("&amp;", "&", urldecode($_POST['params'])), "category_id"=>(int)$_POST['category_id'], "seo_title"=>$_POST['seo_title'], "seo_desc"=>$_POST['seo_desc'], "seo_h1"=>$_POST['seo_h1'], "seo_text"=>$_POST['seo_text'], "full_aliases"=>$chainCategory->chain_build_alias_request.'/'.slug($_POST['alias'])], $getFilterLink->id);  

        return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("save_successfully")]);
        
    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }

}

public function filtersSorting(){

    if($_POST["ids"]){
        foreach (explode(",", $_POST["ids"]) as $key => $id) {
            $this->model->ads_filters->cacheKey(["id"=>$id])->update(["sorting"=>$key], $id);
        }
    }

    return json_answer(["status"=>true]);

}

public function insertListItems(){

    $result = '';

    if(trim($_POST["list"])){

        $list = explode("\n", trim($_POST["list"]));

        foreach (array_slice($list, 0, 1000) as $key => $value) {
            
            if(trim($value)){
                $result .= '<div class="block-filter-item"><div class="input-group"><span class="input-group-text"><div class="handle-sorting handle-sorting-move"><i class="ti ti-arrows-sort"></i></div></span><input type="text" class="form-control" name="items[add][]" value="'.trimStr($value, 128).'" ><span class="btn btn-icon btn-label-danger waves-effect buttonDeleteItemFilter"><i class="ti ti-trash"></i></span></div></div>';
            }

        }

    }

    return json_answer(["status"=>true, "content"=>$result]);

}

public function links()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/filters.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_f7ac6fc5c5a477063add9c6d0701985d")=>$this->router->getRoute("dashboard-ads-filters"), translate("tr_9f58935eaf5d4cdda0f114e4f325ed0f")=>null],"route_name"=>$this->router->currentRoute->name,"page_name"=>translate("tr_9f58935eaf5d4cdda0f114e4f325ed0f"),"page_icon"=>"ti-filter","favorite_status"=>true]]);

    return $this->view->preload('board/ads-filters-links', ["title"=>translate("tr_9f58935eaf5d4cdda0f114e4f325ed0f")]);

}

public function loadAddPodfilter()
{

    $data = $this->model->ads_filters->find("id=?", [$_POST['id']]);

    return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('board/filters/load-add-podfilter.tpl')]);

}

public function loadEdit()
{

    $data = $this->model->ads_filters->find("id=?", [$_POST['id']]);

    $data->filterCategories = $this->component->ads_filters->getCategories($_POST['id']);
    $data->filterItems = $this->component->ads_filters->getFilterItems($_POST['id']);

    return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('board/filters/load-edit.tpl')]);

}

public function loadEditFilterLink()
{

    $data = $this->model->ads_filters_links->find("id=?", [$_POST['id']]);

    return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('board/filters/load-edit-link.tpl')]);

}

public function loadItemsFilter()
{   

    $content = [];

    $filter = $this->model->ads_filters->find("id=?", [$_POST['id']]);

    if($filter->view != "input_text"){

        if($filter->item_sorting == "abs"){
            $items = $this->model->ads_filters_items->getAll("filter_id=? and item_parent_id=? order by name asc", [$_POST['id'],$_POST['item_id']]);
        }else{
            $items = $this->model->ads_filters_items->getAll("filter_id=? and item_parent_id=? order by sorting asc", [$_POST['id'],$_POST['item_id']]);
        }

        if($items){
            foreach ($items as $key => $value) {
                $content[] = '<div class="block-filter-item" ><div class="input-group"><span class="input-group-text"><div class="handle-sorting handle-sorting-move"><i class="ti ti-arrows-sort"></i></div></span><input type="text" class="form-control" name="items[edit]['.$value["id"].']" value="'.translateField($value["name"]).'" ><span class="btn btn-icon btn-label-danger waves-effect buttonDeleteItemFilter"><i class="ti ti-trash"></i></span></div></div>';
            }
        }

    }

    return json_answer(['content'=>implode("", $content)]);

}

public function loadSubfilters()
{
    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $content = '';
    $sort = '';
    $level = 0;

    $filters = $this->component->ads_filters->getFilters();

    $reverseMainIds = $this->component->ads_filters->getReverseMainIds($_POST['id']);

    if($reverseMainIds){
        foreach (explode(",", $reverseMainIds) as $key => $value) {
          $level += 10;
        }
    }

    foreach ($filters["parent_id"][$_POST['id']] as $filter) {

        $loadAddPodFilter = '';
        $sort = '';

        $sub = $this->component->ads_filters->checkSubcategories($filter["id"]) ? '<span class="filters-table-open-subfilters btn btn-sm rounded-pill btn-icon btn-label-primary waves-effect waves-light loadTableSubfilters" data-id="'.$filter["id"].'" data-parent-ids="'.$this->component->ads_filters->getParentIds($filter["id"]).'" data-open="false" ><i class="ti ti-xs ti ti-arrow-down"></i></span>' : '';

        if($filter['view'] == "select" || $filter['view'] == "radiobutton"){
           $loadAddPodFilter = '
              <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadAddPodFilter" data-id="'.$filter['id'].'" >
                <span class="ti ti-xs ti-plus"></span>
              </button>';
        }

        if($_POST['category_id']){
            $sort = '<td> <div class="handle-sorting handle-sorting-move" ><i class="ti ti-arrows-sort"></i></div> </td>';
        }

        $content .= '
            <tr class="subfilter-item-'.$filter["id"].' filters-tr-container" data-id="'.$filter['id'].'" >
              '.$sort.'
              <td><div style="margin-left:'. $level .'px;" >'.translateField($filter["name"]).' '.$sub.'</div></td>
              <td>'.($filter["required"] ? translate("tr_e04af96afe53462f72f39331b209a810") : translate("tr_d0cd2248137f1acac2e79777d856305e")).'</td>
              <td>'.($filter["default_status"] ? translate("tr_e04af96afe53462f72f39331b209a810") : translate("tr_d0cd2248137f1acac2e79777d856305e")).'</td>
              <td>'.($filter["status"] ? '<span class="badge bg-label-success me-1">'.translate("tr_318150c53b2ec43a3ffef0f443596df1").'</span>' : '<span class="badge bg-label-secondary me-1">'.translate("tr_17de549418a3c05ceb11239adee121a8").'</span>').'</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">
                  '.$loadAddPodFilter.'

                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditFilter" data-id="'.$filter['id'].'" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteFilter" data-id="'.$filter['id'].'" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>
        ';
    }

    return json_answer(["content"=>$content]);
}

public function main()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/filters.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_f7ac6fc5c5a477063add9c6d0701985d")=>$this->router->getRoute("dashboard-ads-filters")],"route_name"=>$this->router->currentRoute->name,"page_name"=>translate("tr_f7ac6fc5c5a477063add9c6d0701985d"),"page_icon"=>"ti-filter","favorite_status"=>true]]);

    return $this->view->preload('board/ads-filters', ["title"=>translate("tr_f7ac6fc5c5a477063add9c6d0701985d")]);

}



 }