<?php

/**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Components;

class Filters
{

 public $alias = "ads_filters";
 public $filters;

 public function __construct(){

 $this->filters = $this->getFilters();

 }

 public function addSelectedFilterItemsAd($filters = [], $category_id = 0, $ad_id = 0){
    global $app;

    $app->model->ads_filters_ids->delete("ad_id=?", [$ad_id]);

    if($filters){

        foreach ($filters as $filter_id => $nested) {

            $getFilter = $app->model->ads_filters->find("id=? and status=?", [$filter_id,1]);

            if($getFilter){

                foreach ($nested as $key => $item) {
                    if(isset($item)){

                        if($getFilter->view == "input"){
                            if($item) $app->model->ads_filters_ids->insert(["filter_id"=>$filter_id,"item_id"=>0,"value"=>round($item,2),"ad_id"=>$ad_id]);
                        }elseif($getFilter->view == "input_text"){
                            if($item) $app->model->ads_filters_ids->insert(["filter_id"=>$filter_id,"item_id"=>0,"value"=>$item,"ad_id"=>$ad_id]);
                        }else{
                            if(intval($item)) $app->model->ads_filters_ids->insert(["filter_id"=>$filter_id,"item_id"=>intval($item),"value"=>null,"ad_id"=>$ad_id]);
                        }

                    }
                }

            }

        }

    }

    $app->caching->delete($app->caching->buildKey("uni_ads_filters_ids", ["ad_id"=>$ad_id]));

}

public function buildAliasesLink($data=[]){
    global $app;

    $geo = $app->session->get("geo");

    $chain = $app->component->ads_categories->chainCategory($data["category_id"]);

    if($geo){
        return outLink($geo->alias . '/' . $chain->chain_build_alias_request . '/' . translateFieldReplace($data, "alias"));
    }else{
        return outLink($chain->chain_build_alias_request . '/' . translateFieldReplace($data, "alias"));
    }

}

public function buildIdsByNames($template=null){
    global $app;

    $result = [];
    $exp_tpl = explode("|", $template);

    if($exp_tpl){
        foreach ($exp_tpl as $filter_string) {

            $equally_tpl = explode("=", $filter_string);
            
            if($equally_tpl[0]){
                $getFilter = $app->model->ads_filters->find("name=?", [$equally_tpl[0]]);
                if($getFilter){

                    if($getFilter->view == "input" || $getFilter->view == "input_text"){
                        $result[$getFilter->id][] = $equally_tpl[1];
                    }else{
                        $comma_tpl = explode(",", $equally_tpl[1]);
                        if($comma_tpl){
                            foreach ($comma_tpl as $item_name) {
                               $getFilterItem = $app->model->ads_filters_items->find("filter_id=? and name=?", [$getFilter->id, $item_name]);
                               if($getFilterItem){
                                    $result[$getFilter->id][] = $getFilterItem->id;
                               }
                            }
                        }
                    }

                }
            }

        }
    }

    return $result;

}

public function buildPresetFilters($ad_id=0, $category_id = 0){
      global $app;

      $ids = [];
      $template = $app->component->ads_categories->categories[$category_id]["filter_template_preset"];
      
      if(!$template){
          return '';
      }

      preg_match_all("|{(.*?)}|", $template, $result);

      if($result[1]){

         foreach ($result[1] as $id) {

             $ids[] = $id;

         }

      }

      if($ids){
         return $this->outPropertyAd($ad_id,$ids);
      }else{
         return '';
      }

 }

public function checkSubcategories($id=0){

    if ($this->filters){
        if(isset($this->filters["parent_id"][$id])){
            return true;
        }
    }

    return false;

}

public function countFiltersIsNotDefault($category_id=0){
    global $app;

    $filters_id = $this->getFiltersByCategory($category_id);

    if(!$filters_id) return 0;

    return $app->model->ads_filters->count("status=? and parent_id=? and default_status=? and id IN(".implode(",", $filters_id).")", [1,0,0]);

}

public function delete($id=0){
    global $app;

    $parent_filter_ids = $this->getParentIds($id);
    if($parent_filter_ids){
        foreach (explode(",", $parent_filter_ids) as $filter_id) {
            $app->model->ads_filters->delete("id=?", [$filter_id]);
            $app->model->ads_filters_categories->delete("filter_id=?", [$filter_id]);
            $app->model->ads_filters_ids->delete("filter_id=?", [$filter_id]);
            $app->model->ads_filters_items->delete("filter_id=?", [$filter_id]);
        }
    }

    $app->model->ads_filters->delete("id=?", [$id]);
    $app->model->ads_filters_categories->delete("filter_id=?", [$id]);
    $app->model->ads_filters_ids->delete("filter_id=?", [$id]);
    $app->model->ads_filters_items->delete("filter_id=?", [$id]);

}

public function generationTitle($filters = [], $category_id = 0){
     global $app;

     $title = $app->component->ads_categories->categories[$category_id]["filter_template_title"];
     
     if(!$title){
         return $app->component->ads_categories->categories[$category_id]["name"];
     }

     $getIdFilters = $app->component->ads_filters->getFiltersByCategory($category_id);

     if($getIdFilters){

         $getFilters = $app->model->ads_filters->sort("sorting asc")->getAll("status=? and id IN(".implode(",", $getIdFilters).")", [1]);

         if($getFilters){

            foreach ($getFilters as $key => $value) {

                if($filters[$value["id"]][0]){ 


                    if($value["view"] == "input" || $value["view"] == "input_text"){
                        $title = str_replace('{'.$value["id"].'}', $filters[$value["id"]][0], $title);
                    }else{
                        $item = $app->model->ads_filters_items->find("filter_id=? and id=?", [$value["id"],$filters[$value["id"]][0]]);
                        if($item){
                            $title = str_replace('{'.$value["id"].'}', $item->name, $title);
                        }else{
                            $title = str_replace('{'.$value["id"].'}', "", $title);
                        }
                    }

                }
                
            }

            return $title ?: $app->component->ads_categories->categories[$category_id]["name"];

         }

     }

}

public function getCategories($filter_id=0){
    global $app;

    $ids = [];

    $getCategories = $app->model->ads_filters_categories->getAll("filter_id=?", [$filter_id]);

    if($getCategories){
        foreach ($getCategories as $key => $value) {
            $ids[] = $value["category_id"];
        }
    }

    return $ids;

}

public function getFilterItems($filter_id=0){
    global $app;

    $getFilter = $app->model->ads_filters->find("id=?", [$filter_id]);

    if($getFilter->item_sorting == "abs"){
        return $app->model->ads_filters_items->getAll("filter_id=? order by name asc", [$filter_id]);
    }else{
        return $app->model->ads_filters_items->getAll("filter_id=? order by sorting asc", [$filter_id]);
    }

}

public function getFilters(){
    global $app;

    $results = [];

    $filters = $app->model->ads_filters->sort("sorting asc")->getAll();
    if($filters){
        foreach ($filters as $key => $value) {
            $results["parent_id"][$value["parent_id"]][$value["id"]] = $value;
            $results["alias"][translateFieldReplace($value, "alias")][$value["id"]] = $value;
            $results[$value["id"]] = $value;
        }
    }

    return $results;

}

public function getFiltersByCategory($category_id=0){
    global $app;

    $ids = [];

    $getCategories = $app->model->ads_filters_categories->getAll("category_id=?", [$category_id]);

    if($getCategories){
        foreach ($getCategories as $key => $value) {
            $ids[] = $value["filter_id"];
        }
    }

    return $ids;

}

public function getFiltersItemsAndViewByCatalog($filters=[], $value=[],$item_id=0){
    global $app;

    $result = '';

    if($value["view"] == "input"){

            $result .= '
                <div class="params-form-item" data-id="'.$value["id"].'" data-parent-ids="'.$this->getParentIds($value["id"]).'" >
                    <label class="params-form-item-label" >'.translateFieldReplace($value, "name").'</label>
                    '.$app->ui->buildUniSelectFilters(["input_name_from"=>"filter[".$value["id"]."][from]", "input_name_to"=>"filter[".$value["id"]."][to]","input_value_from"=>$filters[$value["id"]]["from"],"input_value_to"=>$filters[$value["id"]]["to"]], ["view"=>"input", "filter"=>$filters]).'
                </div>
            ';

    }elseif($value["view"] == "input_text"){

            $result .= '
                <div class="params-form-item" data-id="'.$value["id"].'" data-parent-ids="'.$this->getParentIds($value["id"]).'" >
                    <label class="params-form-item-label" >'.translateFieldReplace($value, "name").'</label>
                    '.$app->ui->buildUniSelectFilters(["input_name"=>"filter[".$value["id"]."][]","input_value"=>$filters[$value["id"]][0]], ["view"=>"input", "filter"=>$filters]).'
                </div>
            ';

    }else{

        $items = $this->getItems($value,$item_id);

        if($items){

            $checkParent = $app->model->ads_filters->find("status=? and parent_id=?", [1,$value["id"]]);

            if($checkParent){
                $result .= '
                    <div class="params-form-item" data-id="'.$value["id"].'" data-parent-ids="'.$this->getParentIds($value["id"]).'" >
                        <label class="params-form-item-label" >'.translateFieldReplace($value, "name").'</label>
                        '.$app->ui->buildUniSelectFilters($items, ["view"=>"radio", "input_name"=>"filter[".$value["id"]."][]", "filter"=>$filters]).'
                    </div>
                ';
            }else{
                $result .= '
                    <div class="params-form-item" data-id="'.$value["id"].'" data-parent-ids="'.$this->getParentIds($value["id"]).'" >
                        <label class="params-form-item-label" >'.translateFieldReplace($value, "name").'</label>
                        '.$app->ui->buildUniSelectFilters($items, ["view"=>"multi", "input_name"=>"filter[".$value["id"]."][]", "filter"=>$filters]).'
                    </div>
                ';                    
            }

        }

    }

    return $result;

}

public function getFiltersItemsAndViewInAdCreate($value=[],$item_id=0,$ad_filters=[]){
    global $app;

    $result = '';
    $required = '';

    if($value["required"]){
        $required = '<span class="params-form-item-label-required" >*</span>';
    }

    if($value["view"] == "input"){

            $result .= '
                <div class="params-form-item" >
                    <div class="row" >
                        <div class="col-md-6" ><label class="params-form-item-label" >'.translateFieldReplace($value, "name").$required.'</label></div>
                        <div class="col-md-6" >
                        <input type="number" name="filter['.$value["id"].'][]" value="'.($ad_filters ? $ad_filters[$value["id"]][0] : '').'" step="0.01" class="form-control" >
                        <label class="form-label-error" data-name="filter'.$value["id"].'"></label>
                        </div>
                    </div>
                </div>
            ';

    }elseif($value["view"] == "input_text"){

            $result .= '
                <div class="params-form-item" >
                    <div class="row" >
                        <div class="col-md-6" ><label class="params-form-item-label" >'.translateFieldReplace($value, "name").$required.'</label></div>
                        <div class="col-md-6" >
                        <input type="text" name="filter['.$value["id"].'][]" value="'.($ad_filters ? $ad_filters[$value["id"]][0] : '').'" class="form-control" >
                        <label class="form-label-error" data-name="filter'.$value["id"].'"></label>
                        </div>
                    </div>
                </div>
            ';

    }elseif($value["view"] == "select"){

        $items = $this->getItems($value,$item_id);

        if($items){

            $result .= '
                <div class="params-form-item" data-id="'.$value["id"].'" data-parent-ids="'.$this->getParentIds($value["id"]).'" >
                    <div class="row" >
                        <div class="col-md-6" ><label class="params-form-item-label" >'.translateFieldReplace($value, "name").$required.'</label></div>
                        <div class="col-md-6" >
                        '.$app->ui->buildUniSelectFilters($items, ["view"=>"radio", "input_name"=>"filter[".$value["id"]."][]", "filter"=>$ad_filters]).'
                        <label class="form-label-error" data-name="filter'.$value["id"].'"></label>
                        </div>
                    </div>
                </div>
            ';

        }

    }elseif($value["view"] == "select_multi"){

        $items = $this->getItems($value,$item_id);

        if($items){

            $result .= '
                <div class="params-form-item" data-id="'.$value["id"].'" data-parent-ids="'.$this->getParentIds($value["id"]).'" >
                    <div class="row" >
                        <div class="col-md-6" ><label class="params-form-item-label" >'.translateFieldReplace($value, "name").$required.'</label></div>
                        <div class="col-md-6" >
                        '.$app->ui->buildUniSelectFilters($items, ["view"=>"multi", "input_name"=>"filter[".$value["id"]."][]", "filter"=>$ad_filters]).'
                        <label class="form-label-error" data-name="filter'.$value["id"].'"></label>
                        </div>
                    </div>
                </div>
            ';

        }

    }

    return $result;

}

public function getFiltersParentByCatalog($filters=[], $filter_id=0, $item_id=0){
     global $app;

     $result = '';

     $getFilters = $app->model->ads_filters->sort("sorting asc")->getAll("status=? and parent_id=?", [1,$filter_id]);

     if($getFilters){

        foreach ($getFilters as $key => $value) {

            $result .= $this->getFiltersItemsAndViewByCatalog($filters, $value,$item_id);

            if($filters[$value["id"]]){
                $result .= $this->getFiltersParentByCatalog($filters, $value["id"], $filters[$value["id"]][0]);
            }

        }

     }

     return $result;

}

public function getFiltersParentInAdCreate($filter_id=0, $item_id=0, $ad_filters=[]){
     global $app;

     $result = '';

     $getFilters = $app->model->ads_filters->sort("sorting asc")->getAll("status=? and parent_id=?", [1,$filter_id]);

     if($getFilters){

        foreach ($getFilters as $key => $value) {

            $result .= $this->getFiltersItemsAndViewInAdCreate($value,$item_id,$ad_filters);

            if($_POST["filter"][$value["id"]]){
                $result .= $this->getFiltersParentInAdCreate($value["id"],$_POST["filter"][$value["id"]][0],$ad_filters);
            }

        }

     }

     return $result;

}

public function getItems($value=[], $item_id=0){
    global $app;

    if($value["item_sorting"] == "manual"){
        $sorting = 'sorting asc';
    }else{
        $sorting = 'name asc';
    }

    if($item_id){
        return $app->model->ads_filters_items->sort($sorting)->getAll("filter_id=? and item_parent_id=?", [$value["id"],$item_id]);
    }else{
        return $app->model->ads_filters_items->sort($sorting)->getAll("filter_id=?", [$value["id"]]);
    }

}

public function getParentIds($id=0){
    
    $ids = [];

    if($this->filters){
        if(isset($this->filters["parent_id"][$id])){
            foreach ($this->filters["parent_id"][$id] as $key => $value) {
                
                $ids[] = $value["id"];

                if($this->filters["parent_id"][$value["id"]]){
                  $ids[] = $this->getParentIds($value["id"]);
                }

            }
            return isset($ids) ? implode(",", $ids) : '';
        }
    }

    return "";
}

public function getRecursionOptions($parent_id=0, $level=0){

    if ($this->filters){
        foreach ($this->filters["parent_id"][$parent_id] as $value) {

            while ($x++<$level) $retreat .= "-";

            echo '<option value="' . $value["id"] . '" >'.$retreat.translateFieldReplace($value, "name").'</option>';

            $level++;
            
            $this->getRecursionOptions($value["id"], $level);
            
            $level--;
            
        }
    }

}

function getReverseMainIds($id=0){

    if($this->filters){

        if($this->filters[$id]["parent_id"] != 0){
            $result[] = $this->getReverseMainIds($this->filters[$id]["parent_id"]);
        }

        $result[] = $id;

        return trim(implode(',',$result), ",");

    }

    return ""; 
           
}

public function outButtonExtraFilters($category_id=0){
    global $app;

     $countFilters = $app->component->ads_filters->countFiltersIsNotDefault($category_id);    

     if($countFilters){
         return '<a class="btn-custom button-color-scheme4 width100 mb5 openModal" data-modal-id="extraFiltersModal" >'.translate("tr_beb17c7b102f4290331f8480b73bdfc1").' '.$countFilters.' '.endingWord($countFilters, translate("tr_f8e3cefbce6a55c82347db390278ddcc"), translate("tr_5da50b4c1f50b4dccbaf2c7d0ab3d86e"), translate("tr_05cd7932399b0242502822357140aaf8")).'</a>';
     }        

}

public function outFilterLinks(){
    global $app;

    if($app->component->catalog->data->category){

        if($app->component->catalog->data->filter_link){
            $getFilterLinks = $app->model->ads_filters_links->sort("name asc")->getAll("category_id=? and id!=?", [$app->component->catalog->data->category->id,$app->component->catalog->data->filter_link->id]);
        }else{
            $getFilterLinks = $app->model->ads_filters_links->sort("name asc")->getAll("category_id=?", [$app->component->catalog->data->category->id]);
        }

        if($getFilterLinks){
            ?>
            <div class="catalog-filter-links-container" >
            <?php
            foreach ($getFilterLinks as $key => $value) {
                ?>
                <a href="<?php echo $this->buildAliasesLink($value); ?>" title="<?php echo translateFieldReplace($value, "name"); ?>" ><?php echo translateFieldReplace($value, "name"); ?></a>
                <?php
            }
            ?>
            </div>
            <?php
        }

    }

}

public function outFiltersByCatalog($filters=[], $category_id=0, $only_default_filters=true){
     global $app;

      $result = '';

      $filters_id = $this->getFiltersByCategory($category_id);

      if(!$filters_id) return '';

      if($only_default_filters){
         $getFilters = $app->model->ads_filters->sort("sorting asc")->getAll("status=? and parent_id=? and default_status=? and id IN(".implode(",", $filters_id).")", [1,0,1]);
      }else{
         $getFilters = $app->model->ads_filters->sort("sorting asc")->getAll("status=? and parent_id=? and id IN(".implode(",", $filters_id).")", [1,0]);
      }

      if($getFilters){

         foreach ($getFilters as $key => $value) {

             $result .= $this->getFiltersItemsAndViewByCatalog($filters, $value);

             if($filters[$value["id"]]){
                 $result .= $this->getFiltersParentByCatalog($filters, $value["id"], $filters[$value["id"]][0]);
             }

         }

      }

      return $result;

 }

public function outFiltersByModal($filters, $category_id=0){
    global $app;

     $result = '';

     $filters_id = $this->getFiltersByCategory($category_id);

     if(!$filters_id) return '';

     $getFilters = $app->model->ads_filters->sort("sorting asc")->getAll("status=? and parent_id=? and default_status=? and id IN(".implode(",", $filters_id).")", [1,0,0]);

     if($getFilters){

        foreach ($getFilters as $key => $value) {

            $result .= $this->getFiltersItemsAndViewByCatalog($filters, $value);

            if($filters[$value["id"]]){
                $result .= $this->getFiltersParentByCatalog($filters, $value["id"], $filters[$value["id"]][0]);
            }

        }

     }

     return $result;

}

public function outFiltersInAdCreate($category_id=0, $ad_id=0){
    global $app;

     $result = '';
     $ad_filters = [];

     $filters_id = $this->getFiltersByCategory($category_id);

     if($ad_id){
        $getAdFilters = $app->model->ads_filters_ids->getAll("ad_id=?", [$ad_id]);
        if($getAdFilters){
            foreach ($getAdFilters as $value) {
                if($value["item_id"]){
                    $ad_filters[$value["filter_id"]][] = $value["item_id"];
                }else{
                    $ad_filters[$value["filter_id"]][] = $value["value"];
                }
            }
        }
     }

     if(!$filters_id) return '';

     $getFilters = $app->model->ads_filters->sort("sorting asc")->getAll("status=? and parent_id=? and id IN(".implode(",", $filters_id).")", [1,0]);

     if($getFilters){

        foreach ($getFilters as $key => $value) {

            $result .= $this->getFiltersItemsAndViewInAdCreate($value,0,$ad_filters);

            if($ad_filters[$value["id"]]){
                $result .= $this->getFiltersParentInAdCreate($value["id"],$ad_filters[$value["id"]][0],$ad_filters);
            }

        }

     }

     return $result;

}

public function outPodFilterItemsOptions($filter_id=0){
    global $app;

    $items = $app->model->ads_filters_items->getAll("filter_id=? order by name asc", [$filter_id]);

    if($items){
        foreach ($items as $key => $value) {
           $parentItem = $app->model->ads_filters_items->find("id=?", [$value["item_parent_id"]]);
           if($parentItem){
                ?>
                <option value="<?php echo $value["id"]; ?>" ><?php echo translateFieldReplace($parentItem, "name"); ?> - <?php echo translateFieldReplace($value, "name"); ?></option>
                <?php                
           }else{
                ?>
                <option value="<?php echo $value["id"]; ?>" ><?php echo translateFieldReplace($value, "name"); ?></option>
                <?php
           }
        }
    }

}

public function outPropertyAd($ad_id=0, $filters_ids=[], $out_array=false){
    global $app;

    $result = [];
    $group = [];
    $items = [];

    if($filters_ids){
        $getFilters = $app->model->ads_filters_ids->cacheKey(["ad_id"=>$ad_id, "filter_id"=>implode(",",$filters_ids)])->getAll("ad_id=? and filter_id IN(".implode(",",$filters_ids).")", [$ad_id]);
    }else{
        $getFilters = $app->model->ads_filters_ids->cacheKey(["ad_id"=>$ad_id])->getAll("ad_id=?", [$ad_id]);
    }

    if($getFilters){

        foreach ($getFilters as $value) {

            $group[$value["filter_id"]][] = $value["item_id"] ? $value["item_id"] : $value["value"];

        }

        if($group){

            foreach ($group as $filter_id => $nested) {

                $items = [];

                $getFilter = $app->model->ads_filters->find("id=?", [$filter_id]);

                if($getFilter){

                    if($getFilter->view == "input" || $getFilter->view == "input_text"){

                        foreach ($nested as $key => $value) {

                            $items[] = $value;

                        }

                    }else{

                        foreach ($nested as $key => $value) {

                            $getFilterItem = $app->model->ads_filters_items->cacheKey(["id"=>$value, "filter_id"=>$filter_id])->find("id=? and filter_id=?", [$value,$filter_id]);
                            if($getFilterItem){
                                $items[] = translateFieldReplace($getFilterItem, "name");
                            }

                        }

                    }

                    if($items){

                        if(!$out_array){
                            $result[] = '<div class="list-properties-item" ><span>'.translateFieldReplace($getFilter, "name").':</span> '.implode(", ", $items).'</div>';
                        }else{
                            $result[translateFieldReplace($getFilter, "name")] = implode(", ", $items);
                        }

                    }                       

                }

            }

        }


    }

    if(!$out_array){
        return implode("", $result);
    }else{
        return $result; 
    }

}

public function required($filters = [], $category_id = 0){
     global $app;

     $result = [];

     $getIdFilters = $app->component->ads_filters->getFiltersByCategory($category_id);

     if($getIdFilters){

         $getFilters = $app->model->ads_filters->sort("sorting asc")->getAll("status=? and id IN(".implode(",", $getIdFilters).")", [1]);

         if($getFilters){

            foreach ($getFilters as $key => $value) {

                if($value["required"]){

                    if($value["view"] == "input"){

                        $items = $app->model->ads_filters_items->getAll("filter_id=?", [$value["id"]]);
                        
                        if($filters[$value["id"]][0] < $items[0]["name"] || $filters[$value["id"]][0] > $items[1]["name"]){ 

                            $result["filter".$value["id"]] = translate("tr_2ea71bfcae51fae6575e527f528611a6")." ".$items[0]["name"]." ".translate("tr_538dc63d3c6db1a1839cafbaf359799b")." ".$items[1]["name"];

                        }

                    }else{

                        if($value["parent_id"]){

                            if($filters[$value["parent_id"]][0]){ 

                                $filterItem = $app->model->ads_filters_items->getAll("filter_id=? and item_parent_id=?", [$value["id"], $filters[$value["parent_id"]][0]]);

                                if($filterItem){
                                    if(!$filters[$value["id"]][0] || $filters[$value["id"]][0] == ""){ 

                                        $result["filter".$value["id"]] = translate("tr_bca62e8bb39a76f12905896f5388d8ac");

                                    }
                                }

                            }

                        }else{

                            if(!$filters[$value["id"]][0] || $filters[$value["id"]][0] == ""){ 

                                $result["filter".$value["id"]] = translate("tr_bca62e8bb39a76f12905896f5388d8ac");

                            }                            

                        }

                    }

                }else{

                    if($value["view"] == "input"){

                        if($filters[$value["id"]][0]){

                            $items = $app->model->ads_filters_items->getAll("filter_id=?", [$value["id"]]);
                            
                            if($filters[$value["id"]][0] < $items[0]["name"] || $filters[$value["id"]][0] > $items[1]["name"]){ 

                                $result["filter".$value["id"]] = translate("tr_2ea71bfcae51fae6575e527f528611a6")." ".$items[0]["name"]." ".translate("tr_538dc63d3c6db1a1839cafbaf359799b")." ".$items[1]["name"];

                            }

                        }

                    }                        

                }

            }

         }

     }

     return $result;

}

public function typesViews(){
    return [
        "select" => translate("tr_add7cf9008566a3f817789a5b3296369"),
        "select_multi" => translate("tr_1aa45c99f13612fc907352e2d3af3880"),
        "input" => translate("tr_130c0261284c8f5c4d0d3bc87407d8cd"),
        "input_text" => translate("tr_8b68a1b5191b68a7c44f4b3bebc5d2d8"),
    ];
}



}