<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Http\Controllers;

 use App\Systems\Controller;

 class ShopsController extends Controller
 {

 public function __construct($app){
 parent::__construct($app); 
 }

 public function loadItems()
{   

    $content = '';
    $data = [];
    
    $this->pagination->request($_POST);

    if($_POST['category_id']){
        $data = $this->model->shops->pagination(true)->page($_POST['page'])->output($this->settings->out_default_count_items)->sort('id desc')->getAll("status=? and (category_id=? or category_id=?)", ["published", intval($_POST['category_id']), 0]);
    }else{
        $data = $this->model->shops->pagination(true)->page($_POST['page'])->output($this->settings->out_default_count_items)->sort('id desc')->getAll("status=?", ["published"]);
    }

    if($data){

        foreach ($data as $key => $value) {

            $user = $this->model->users->find("id=?", [$value["user_id"]]);

            $content .= $this->view->setParamsComponent(['value'=>$value, 'user'=>$user])->includeComponent('items/shop-grid.tpl');

        }

        $result = '

           <div class="row row-cols-2 g-2 g-lg-3" >

              '.$content.'

           </div>

        ';

    }else{

        if($_POST['category_id']){
            $result = '

               <div class="catalog-not-found" >

                  <h4>'.translate("tr_73f1cef4d9e4b35286c168a73e0ad30c").'</h4>
                  <p>'.translate("tr_f640371d5eda35c2f4e2d7a7a653ed7b").'</p>

               </div>

            ';    
        }else{
            $result = '

               <div class="catalog-not-found" >

                  <h4>'.translate("tr_73f1cef4d9e4b35286c168a73e0ad30c").'</h4>
                  <p>'.translate("tr_1d46790b9b13b6699b428fccb881e46a").'</p>

               </div>

            ';
        }     

    }

    return json_answer(["content"=>$result]);

}

public function shops()
{   

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/shops.js\" type=\"module\" ></script>"]);

    $data = (object)[];

    if(!$this->settings->shops_status){
        abort(404);
    }

    $seo = $this->component->seo->content($data);

    return $this->view->render('shops', ["data"=>(object)$data, "seo"=>$seo]);

}

public function shopsByCategories($alias)
{   

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/shops.js\" type=\"module\" ></script>"]);

    $data = (object)[];

    $data->category = $this->component->ads_categories->getCategoryByAlias($alias, true);

    if(!$data->category){
        abort(404);
    }

    return $this->view->render('shops', ["data"=>(object)$data, "seo"=>(object)["meta_title"=>$data->category["name"], "h1"=>$data->category["name"]]]);

}



 }