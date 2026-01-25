<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Http\Controllers\Dashboard;

 use App\Systems\Controller;

 class BlogCategoriesController extends Controller
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
 
    if(empty($answer)){

        $params["status"] = (int)$_POST['status'];
        $params["name"] = $_POST['name'];
        $params["alias"] = slug($_POST['alias']);
        $params["parent_id"] = (int)$_POST['parent_id'];
        $params["image"] = $_POST["manager_image"] ?: null;
        $params["seo_title"] = $_POST['seo_title'];
        $params["seo_desc"] = $_POST['seo_desc'];
        $params["seo_h1"] = $_POST['seo_h1'];
        $params["seo_text"] = $_POST['seo_text'] ? urldecode($_POST['seo_text']) : $_POST['seo_text'];

        $this->model->blog_categories->insert($params);

        $this->session->setNotifyDashboard('success', code_answer("add_successfully"));

        return json_answer(["status"=>true]);

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }    

}

public function categories()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/blog-categories.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_4c239493d16523d932847244c80c028a")=>$this->router->getRoute("dashboard-blog-categories")],"route_name"=>$this->router->currentRoute->name,"page_name"=>translate("tr_4c239493d16523d932847244c80c028a"),"page_icon"=>"ti-article","favorite_status"=>true]]);

    return $this->view->preload('blog/categories', ["title"=>translate("tr_4c239493d16523d932847244c80c028a")]);

}

public function delete()
{
    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->component->blog_categories->delete($_POST['id']);

    $this->session->setNotifyDashboard('success', code_answer("delete_successfully"));

    return json_answer(["status"=>true]);
}

public function edit()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    $getCategory = $this->model->blog_categories->find('id=?', [$_POST['id']]);

    if(!$getCategory) return json_answer(["status"=>false, "answer"=>code_answer("record_not_found")]);

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['alias'])->status == false){
        $answer['alias'] = $this->validation->error;
    }  

    if($_POST['id'] != $_POST['parent_id']){
      $parentIds = $this->component->blog_categories->joinId($_POST['id'])->getParentIds($_POST['id']);
      if(!$parentIds){
         $getCategory->parent_id = $_POST["parent_id"];
      }else{
         if(!in_array($_POST["parent_id"], explode(",",$parentIds))){
            $getCategory->parent_id = $_POST["parent_id"];
         }
      }
    }

    if(empty($answer)){

        $params["status"] = (int)$_POST['status'];
        $params["name"] = $_POST['name'];
        $params["alias"] = slug($_POST['alias']);
        $params["parent_id"] = $getCategory->parent_id;
        $params["image"] = $_POST["manager_image"] ?: null;
        $params["seo_title"] = $_POST['seo_title'];
        $params["seo_desc"] = $_POST['seo_desc'];
        $params["seo_h1"] = $_POST['seo_h1'];
        $params["seo_text"] = $_POST['seo_text'] ? urldecode($_POST['seo_text']) : $_POST['seo_text'];

        $this->model->blog_categories->cacheKey(["id"=>$getCategory->id])->update($params, $getCategory->id);

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

    $data = $this->model->blog_categories->find("id=?", [$_POST['id']]);

    return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('blog/load-edit-category.tpl')]);

}

public function loadSubcategories()
{
    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $content = '';
    $level = 0;

    $categories = $this->component->blog_categories->getCategories();

    $reverseMainIds = $this->component->blog_categories->getReverseMainIds($_POST['id']);

    if($reverseMainIds){
        foreach (explode(",", $reverseMainIds) as $key => $value) {
          $level += 10;
        }
    }

    foreach ($categories["parent_id"][$_POST['id']] as $category) {

        $sub = $this->component->blog_categories->checkSubcategories($category["id"]) ? '<span class="categories-table-open-subcategories btn btn-sm rounded-pill btn-icon btn-label-primary waves-effect waves-light loadTableSubcategories" data-id="'.$category["id"].'" data-parent-ids="'.$this->component->blog_categories->getParentIds($category["id"]).'" data-open="false" ><i class="ti ti-xs ti ti-arrow-down"></i></span>' : '';

        $content .= '
            <tr class="subcategory-item-'.$category["id"].' categories-tr-container" data-id="'.$category['id'].'" >
              <td> <div class="handle-sorting handle-sorting-move" ><i class="ti ti-arrows-sort"></i></div> </td>
              <td>'.$category['id'].'</td>
              <td><div style="margin-left:'. $level .'px;" >'.translateField($category["name"]).' '.$sub.'</div></td>
              <td>'.$this->component->blog->countPostsByIdCategory($category['id']).'</td>
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

public function sorting(){

    if($_POST["ids"]){
        foreach (explode(",", $_POST["ids"]) as $key => $id) {
            $this->model->blog_categories->cacheKey(["id"=>$id])->update(["sorting"=>$key], $id);
        }
    }

    return json_answer(["status"=>true]);

}



 }