<?php

/**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Components;
use App\Systems\Container;

class AdsCategories
{

 public $alias = "ads_categories";
 public $categories;

 public function __construct(){

 $this->categories = $this->getCategories();

 }

 public function buildAliases($data=[]){
    global $app;

    $geo = $app->session->get("geo");

    $chain = $this->chainCategory($data["id"]);

    if($geo){
        return outLink($geo->alias . '/' . $chain->chain_build_alias_request);
    }else{
        return outLink($chain->chain_build_alias_request);
    }

}

public function buildAliasesShops($data=[]){
    global $app;

    $chain = $this->chainCategory($data["id"]);

    return outLink('shops/' . $chain->chain_build_alias_request);

}

public function chainCategory($id=0){
    global $app;

    $results = [];

    if($this->categories[$id]["parent_id"]){
        $results["chain_array"] = $this->getParentsId($id);
        $results["chain_build"] = $this->getBuildNameChain($results["chain_array"]);
        $results["chain_build_alias_request"] = $this->getBuildAliasRequest($results["chain_array"], "/");
        $results["chain_build_alias_dash"] = $this->getBuildAliasRequest($results["chain_array"], "-");
    }else{
        $results["chain_array"] = [$this->categories[$id]];
        $results["chain_build"] = translateFieldReplace($this->categories[$id], "name");
        $results["chain_build_alias_request"] = translateFieldReplace($this->categories[$id], "alias");
        $results["chain_build_alias_dash"] = translateFieldReplace($this->categories[$id], "alias");
    }

    return (object)$results;

}

public function checkCategoriesByAliasCatalog($request=null){
     global $app;

     if($this->categories){

        $end_alias = end($request);

        if($this->categories["alias"][$end_alias]){
             foreach ($this->categories["alias"][$end_alias] as $category_id => $value) {
                $chain = $this->chainCategory($category_id);
                if($chain->chain_build_alias_request == implode("/", $request)){
                   $value["chain"] = $chain;
                   return (object)$value;
                }
             }                
        }       

     }

     return [];

}

public function checkCategoriesByIdCatalog($category_id=0){
    global $app;

    if($this->categories){

       if($this->categories[$category_id]){
           $chain = $this->chainCategory($category_id);
           $this->categories[$category_id]["chain"] = $chain;
           return (object)$this->categories[$category_id];              
       }       

    }

    return [];

}

public function checkSubcategories($id=0){

    if ($this->categories){
        if(isset($this->categories["parent_id"][$id])){
            return true;
        }
    }

    return false;

}

public function delete($id=0){
    global $app;

    $parentIds = $this->getParentIds($id);

    if($parentIds){
        foreach (explode(",", $parentIds) as $key => $value) {
           $app->model->ads_categories->cacheKey(["id"=>$value])->delete("id=?", [$value]);
        }
    }

    $app->model->ads_categories->cacheKey(["id"=>$id])->delete("id=?", [$id]);

    $key = $app->caching->buildKey($this->table, $cacheKey);

    $app->caching->delete($app->caching->buildKey("uni_ads_categories", ["all_categories"]));

}

public function deleteByImport($id=0,$limit=null){
    global $app;

    if(isset($limit)){
       $getIds = $app->model->ads_categories->getAll("import_id=? limit $limit", [$id]); 
    }else{
       $getIds = $app->model->ads_categories->getAll("import_id=?", [$id]);
    }

    if($getIds){

        foreach ($getIds as $key => $value) {

            $this->delete($value["id"]);

        }          

    }

}

public function getBuildAliasRequest($data=[], $glue="/"){

    $result = [];

    if($data){
        foreach ($data as $key => $value) {
            $result[] = translateFieldReplace($value, "alias");
        }
        return implode($glue, $result);
    }

    return '';

}

public function getBuildNameChain($data=[]){

    $result = [];

    if($data){
        foreach ($data as $key => $value) {
            $result[] = translateFieldReplace($value, "name");
        }
        return implode(" - ", $result);
    }

    return '';

}

public function getCategories($ids=null){
    global $app;

    $results = [];

    if($ids){
        $categories = $app->model->ads_categories->sort("sorting asc")->getAll("id IN(".$ids.") and status=?", [1]);
    }else{
        $categories = $app->model->ads_categories->sort("sorting asc")->getAll("status=?", [1]);
    }

    if($categories){
        foreach ($categories as $key => $value) {
            $results["parent_id"][$value["parent_id"]][$value["id"]] = $value;
            $results["alias"][translateFieldReplace($value, "alias")][$value["id"]] = $value;
            $results[$value["id"]] = $value;
        }
    }

    return $results;

}

public function getCategory($id=0){
    global $app;

    $results = [];

    $result = $app->model->ads_categories->cacheKey(["id"=>$id])->getRow("id=?", [$id]);

    return $result;

}

public function getCategoryByAlias($alias=null,$only_main=false){

    global $app;

    $results = [];

    if($only_main){
        $result = $app->model->ads_categories->cacheKey(["alias"=>$alias, "parent_id"=>0])->getRow("alias=? and parent_id=?", [$alias,0]);
    }else{
        $result = $app->model->ads_categories->cacheKey(["alias"=>$alias])->getRow("alias=?", [$alias]);
    }

    return $result;
}

public function getMainCategories(){
    global $app;

    return $this->categories["parent_id"][0];

}

public function getParentIds($id=0){
    
    $ids = [];

    if($this->joinId){
         $ids[] = $this->joinId;
         $this->joinId = null;
    }

    if($this->categories){
        if(isset($this->categories["parent_id"][$id])){
            foreach ($this->categories["parent_id"][$id] as $key => $value) {
                
                $ids[] = $value["id"];

                if($this->categories["parent_id"][$value["id"]]){
                  $ids[] = $this->getParentIds($value["id"]);
                }

            }
        }
        return isset($ids) ? implode(",", $ids) : '';
    }

    return "";
}

public function getParentsId($id=0){
    global $app;

    $data = [];

    $category = $this->getCategory($id);

    if($category["parent_id"]!=0){ 
        $data = $this->getParentsId($category["parent_id"]);            
    }

    $data[] = $category;

    return $data; 
           
}

public function getRecursionOptions($parent_id=0, $level=0){

    if ($this->categories){
        foreach ($this->categories["parent_id"][$parent_id] as $value) {

            $selected = "";

            if(isset($this->selectedIds)){
                if(is_array($this->selectedIds)){
                    if(in_array($value["id"], $this->selectedIds)){
                        $selected = 'selected=""';
                    }
                }else{
                    if($value["id"] == $this->selectedIds){
                        $selected = 'selected=""';
                    }
                }
            }

            while ($x++<$level) $retreat .= "-";

            echo '<option '.$selected.' value="' . $value["id"] . '" >'.$retreat.translateFieldReplace($value, "name").'</option>';

            $level++;
            
            $this->getRecursionOptions($value["id"], $level);
            
            $level--;
            
        }
    }

}

function getReverseMainIds($id=0){

    if($this->categories){

        if($this->categories[$id]["parent_id"] != 0){
            $result[] = $this->getReverseMainIds($this->categories[$id]["parent_id"]);
        }

        $result[] = $id;

        return trim(implode(',',$result), ",");

    }

    return ""; 
           
}

public function joinId($id=null){
    $this->joinId = $id;
    return $this;
}

public function outCategoriesByShops($category_id=0){
    global $app;

    if($this->categories){

          foreach ($this->getMainCategories() as $key => $value) {

            $active = '';

            if($category_id == $value["id"]){
                $active = 'class="active"';
            }

            echo $app->view->setParamsComponent(['value'=>$value, "active"=>$active])->includeComponent('items/shops-view-categories.tpl');

          }

    }

}

public function outCategoriesOrSubCategoriesByCatalog(){
    global $app;

    $geo = $app->session->get("geo");

    if($this->categories){

        if($app->component->catalog->data->category){

          if($this->categories["parent_id"][$app->component->catalog->data->category->id]){

              foreach ($this->categories["parent_id"][$app->component->catalog->data->category->id] as $key => $value) {

                $active = '';

                if($app->component->catalog->data->category){
                    if($app->component->catalog->data->category->id == $value["id"]){
                        $active = "active";
                    }
                }

                echo $app->view->setParamsComponent(['value'=>$value, "active"=>$active, "geo"=>$geo])->includeComponent('items/catalog-view-categories.tpl');

              }

          }else{

              $id = $this->categories[$app->component->catalog->data->category->parent_id]["id"];

              if($id){
                  foreach ($this->categories["parent_id"][$id] as $key => $value) {

                    $active = '';

                    if($app->component->catalog->data->category){
                        if($app->component->catalog->data->category->id == $value["id"]){
                            $active = "active";
                        }
                    }

                    echo $app->view->setParamsComponent(['value'=>$value, "active"=>$active, "geo"=>$geo])->includeComponent('items/catalog-view-categories.tpl');

                  }
              }else{
                  foreach ($this->getMainCategories() as $key => $value) {

                    $active = '';

                    if($app->component->catalog->data->category){
                        if($app->component->catalog->data->category->id == $value["id"]){
                            $active = "active";
                        }
                    }

                    echo $app->view->setParamsComponent(['value'=>$value, "active"=>$active, "geo"=>$geo])->includeComponent('items/catalog-view-categories.tpl');

                  }                    
              }

          }


        }else{

          foreach ($this->getMainCategories() as $key => $value) {

            echo $app->view->setParamsComponent(['value'=>$value, "geo"=>$geo])->includeComponent('items/catalog-view-categories.tpl');

          }

        }

    }

}

public function outMainCategoriesByCatalog(){
    global $app;

    if($this->getMainCategories()){

          $count_key = 0;

          foreach ($this->getMainCategories() as $key => $value) {

            $active = '';

            if($count_key == 0){
                $active = 'active';
            }

            $count_key++;

            ?>

            <a class="big-catalog-menu-category-item <?php echo $active; ?>" data-id="<?php echo $value["id"]; ?>" href="<?php echo $this->buildAliases($value); ?>" >
                <?php if($app->storage->name($value["image"])->exist()){ ?>
                <div> <img src="<?php echo $app->storage->name($value["image"])->host(true)->get(); ?>"> </div>
                <?php } ?>
                <?php echo translateFieldReplace($value, "name"); ?>
            </a>

            <?php

          }

    }

}

public function outMainCategoriesGrid(){
    global $app;

    $content = '';

    if($this->getMainCategories()){

          foreach ($this->getMainCategories() as $key => $value) {

            $content .= $app->view->setParamsComponent(['value'=>$value])->includeComponent('items/grid-mobile-categories.tpl');

          }

    }

    return $content;

}

public function outMainCategoriesMobileList(){
    global $app;

    $content = '';

    if($this->getMainCategories()){

          foreach ($this->getMainCategories() as $key => $value) {

            $subcategories = [];

            if(isset($this->categories["parent_id"][ $value["id"] ])){
                $subcategories = $this->categories["parent_id"][ $value["id"] ];
            }

            $content .= $app->view->setParamsComponent(['value'=>$value, 'subcategories'=>$subcategories])->includeComponent('items/mobile-menu-category-item.tpl');

          }

    }

    return $content;

}



public function outMainCategoriesInAdCreate(){
    global $app;

    $items = '';

    if($this->categories){

        if($this->categories["parent_id"][0]){

              foreach ($this->categories["parent_id"][0] as $key => $value) {

                   $items .= '<span class="ad-create-categories-item" data-id="'.$value["id"].'">'.translateFieldReplace($value, "name").'</span>';

              }

              return $items;
        }

    }

}

public function outMainCategoriesOptions($category_id=0){

    if($this->getMainCategories()){

          foreach ($this->getMainCategories() as $key => $value) {
            if($category_id == $value["id"]){
                ?>
                <option value="<?php echo $value["id"]; ?>" selected="" ><?php echo translateFieldReplace($value, "name"); ?></option>
                <?php
            }else{
                ?>
                <option value="<?php echo $value["id"]; ?>" ><?php echo translateFieldReplace($value, "name"); ?></option>
                <?php
            }
          }

    }

}

public function outReverseCategories($id=0){
    global $app;

    $content = '';
    $items = [];
    $reverseIds = [];

    if($id){

        $mainIds = $this->getReverseMainIds($id);

        $mainIdsArray = explode(",", $mainIds);

        foreach ($mainIdsArray as $key => $value) {
            $reverseIds[$value] = $mainIdsArray[$key+1] ?: 0;
        }

        if(count($mainIdsArray) > 1){

            foreach ($this->categories["parent_id"][0] as $value) {
                
                $items[] = ["item_name"=>translateFieldReplace($value, "name"),"input_name"=>"","input_value"=>$value["id"]];

            }   

            $content .= $app->ui->buildUniSelect($items, ["view"=>"radio", "selected"=>$mainIdsArray[0]]);

            foreach ($reverseIds as $category_id => $subcategory_id) {

                $items = [];

                if($this->categories["parent_id"][$category_id]){

                    foreach ($this->categories["parent_id"][$category_id] as $value) {
                        
                        $items[] = ["item_name"=>translateFieldReplace($value, "name"),"input_name"=>"","input_value"=>$value["id"]];

                    }   

                    $content .= $app->ui->buildUniSelect($items, ["view"=>"radio", "selected"=>explode(",", $mainIds), "no_selected"=>["input_name"=>"", "input_value"=>$category_id]]); 
                      
                }

            }            

        }else{

            foreach ($this->categories["parent_id"][0] as $value) {
                
                $items[] = ["item_name"=>translateFieldReplace($value, "name"),"input_name"=>"","input_value"=>$value["id"]];

            }   

            $content .= $app->ui->buildUniSelect($items, ["view"=>"radio", "selected"=>$id]);

            $items = [];

            if($this->categories["parent_id"][$id]){

                foreach ($this->categories["parent_id"][$id] as $value) {
                    
                    $items[] = ["item_name"=>translateFieldReplace($value, "name"),"input_name"=>"","input_value"=>$value["id"]];

                }   

                $content .= $app->ui->buildUniSelect($items, ["view"=>"radio", "no_selected"=>["input_name"=>"", "input_value"=>$category_id]]); 
                  
            }

        }

    }else{

        foreach ($this->getMainCategories() as $value) {
            $items[] = ["item_name"=>translateFieldReplace($value, "name"),"input_name"=>"","input_value"=>$value["id"]];
        }  

        $content = $app->ui->buildUniSelect($items, ["view"=>"radio"]);

    }

    return $content;

}

public function outSubCategoriesByCatalog(){
    global $app;

    $count_key = 0;

    if($this->categories){
          foreach ($this->categories as $key => $value) {

               if($this->categories["parent_id"][$value["id"]]){
                    
                    $show = '';

                    if( $count_key == 0 ){
                        $show = ' style="display: block;" ';
                    }

                    $count_key++;

                    echo '
                      <div class="big-catalog-menu-content-subcategories" '.$show.' data-id-parent="'.$value["id"].'" >

                      <h4><strong>'.translateFieldReplace($value, "name").'</strong></h4>

                      <div class="row no-gutters mt25" >
                    ';

                        foreach ($this->categories["parent_id"][ $value["id"] ] as $subvalue) {

                            echo '
                               <div class="col-lg-6" >
                                   <a href="'.$this->buildAliases($subvalue).'">'.translateFieldReplace($subvalue, "name").'</a>
                               </div>
                            ';

                        }

                    echo '
                      </div>
                      </div>
                    ';

               }

          }
    }

}

public function selectedIds($id=null){
    $this->selectedIds = $id;
    return $this;
}



}