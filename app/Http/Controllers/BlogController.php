<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Http\Controllers;

 use App\Systems\Controller;

 class BlogController extends Controller
 {

 public function __construct($app){
 parent::__construct($app); 
 }

 public function blog()
{   

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/blog.js\" type=\"module\" ></script>"]);

    $data = (object)[];

    $seo = $this->component->seo->content($data);

    return $this->view->render('blog', ["data"=>(object)$data, "seo"=>$seo]);

}

public function category($alias)
{   

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/blog.js\" type=\"module\" ></script>"]);

    $data = (object)[];

    $data->category = $this->component->blog_categories->checkCategoriesByAlias(explode("/", $alias));

    if($data->category){
        $this->component->blog->data = $data;
    }else{
        abort(404);
    }

    $seo = $this->component->seo->content($data);

    return $this->view->render('blog', ["data"=>(object)$data, "seo"=>$seo]);

}

public function loadItems()
{   

    $content = '';
    $data = [];

    $page = (int)$_POST["page"] ? (int)$_POST["page"] : 1;

    $this->pagination->request($_POST);

    if(intval($_POST['category_id'])){
        $data = $this->model->blog_posts->pagination(true)->page($_POST['page'])->output($this->settings->out_default_count_items_blog)->sort('id desc')->getAll("status=? and category_id IN(".$this->component->blog_categories->joinId($_POST['category_id'])->getParentIds($_POST['category_id']).")", [1]);
    }else{
        $data = $this->model->blog_posts->pagination(true)->page($_POST['page'])->output($this->settings->out_default_count_items_blog)->sort('id desc')->getAll("status=?", [1]);
    }

    if($data){

        if($page <= $this->pagination->pages()){

            foreach ($data as $key => $value) {

                $content .= $this->view->setParamsComponent(['value'=>(object)$value])->includeComponent('items/blog-grid.tpl');

            }

        }

        if($page + 1 <= $this->pagination->pages()){

            $result = '

               <div class="row row-cols-2 g-2 g-lg-3" style="display: none;" >

                  '.$content.'

               </div>

               <div class="text-center" >
                  <button class="btn-custom button-color-scheme1 actionShowMoreItems" >'.translate("tr_11d9e7ea0320006d822a967777abd16a").'</button>
               </div>

            ';

        }else{

            $result = '

               <div class="row row-cols-2 g-2 g-lg-3" style="display: none;" >

                  '.$content.'

               </div>

            ';

        }

    }else{

        if($_POST['category_id']){
            $result = '

               <div class="catalog-not-found" >

                  <h4>'.translate("tr_01fc6515f20863a6d905efd8a323cda8").'</h4>
                  <p>'.translate("tr_3a0ed9450b27faa7c05ead7caac6bbdc").'</p>

               </div>

            ';    
        }else{
            $result = '

               <div class="catalog-not-found" >

                  <h4>'.translate("tr_01fc6515f20863a6d905efd8a323cda8").'</h4>

               </div>

            ';
        }            

    }

    return json_answer(["content"=>$result]);

}

public function post($category_alias, $alias, $id)
{   

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/blog.js\" type=\"module\" ></script>"]);

    $data = (object)[];

    $data = $this->model->blog_posts->find("id=? and status=?", [$id, 1]);

    if($data){

        $alias_field = (array)$data;

        if($alias_field["alias"] != $alias && $alias_field["alias_".$this->translate->getChangeLang()] != $alias){
            abort(404);
        }

        $chain = $this->component->blog_categories->chainCategory($data->category_id);
        if($chain->chain_build_alias_dash != $category_alias){
            abort(404);
        }

    }else{
        abort(404);
    }

    $this->component->blog->fixView($data->id, $this->user->data->id, getIp());

    $seo = $this->component->seo->content($data);

    return $this->view->render('blog-post', ["data"=>(object)$data, "seo"=>$seo]);

}



 }