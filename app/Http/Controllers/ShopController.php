<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Http\Controllers;

 use App\Systems\Controller;

 class ShopController extends Controller
 {

 public function __construct($app){
 parent::__construct($app); 
 }

 public function addPage()
{   

    $answer = [];

    if(!$this->user->data->service_tariff->items->shop_page){
        return json_answer(["status"=>false]);
    }

    $shop = $this->model->shops->find("user_id=? and id=?", [$this->user->data->id, $_POST['id']]);

    if(!$shop){
        return json_answer(["status"=>false]);
    }

    if($this->model->shops_pages->count("shop_id=?", [$shop->id]) >= $this->settings->shop_max_pages){
        return json_answer(["status"=>false, "answer"=>translate("tr_8104c6c3a3e7b62a653218094b3926ee")]);
    }

    $alias = slug($_POST['name']);

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }else{
        $check = $this->model->shops_pages->find("alias=? and shop_id=?", [$alias, $shop->id]);
        if($check){
            $answer['name'] = translate("tr_0aa88c0caa1820b71895d6f44422da78");
        }
    }

    if(!$answer){

        $this->model->shops_pages->insert(["user_id"=>$this->user->data->id, "name"=>$_POST['name'], "shop_id"=>$shop->id, "alias"=>$alias]);

        $this->event->editShop(["user_id"=>$this->user->data->id, "shop_id"=>$shop->id, "action"=>"add_page_shop"]);

        return json_answer(["status"=>true, "redirect"=>$this->component->shop->linkToPageCard($shop->alias, $alias)]);

    }else{

        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);

    }
       
}

public function catalog($shop_alias, $main_request=null)
{   

    $this->view->visible_header = false;
    $this->view->visible_footer = false;

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/shop.js\" type=\"module\" ></script>"]);

    $data = (object)[];

    if(!$this->settings->shops_status){
        abort(404);
    }

    $data->shop = $this->component->shop->getShopByAlias($shop_alias);

    if($data->shop){
        if($data->shop->status != "published"){
            if($data->shop->user_id != $this->user->data->id){
                abort(404);
            }
        }
    }else{
        abort(404);
    }

    $data->user = $this->model->users->findById($data->shop->user_id, true);

    if(!$data->user || $data->user->delete){
        abort(404);
    }

    if($main_request){
       $data->category = $this->component->shop->checkCategoriesByAliasShop(explode("/", trim($main_request, "/")));
       if(!$data->category){
          abort(404);
       } 
    }

    $data->owner = $data->shop->user_id == $this->user->data->id ? true : false;

    $data->tariff = $this->component->service_tariffs->getOrderByUserId($data->shop->user_id);
    $data->banners = $this->component->shop->getBanners($data->shop->id);

    $this->view->setParamsComponent(['data'=>(object)$data]);

    if(!$_GET['search']){
        $seo = $this->component->seo->content($data);
    }else{
        $seo["meta_title"] = translate("tr_91680e1909fc29c7471d2e8a6dc4159d")." «".$_GET['search']."»";
        $seo["h1"] = translate("tr_91680e1909fc29c7471d2e8a6dc4159d")." «".$_GET['search']."»";
    }

    return $this->view->render('shop-catalog', ["data"=>(object)$data, "seo"=>(object)$seo]);

}

public function delete()
{   

    $this->component->shop->delete($_POST["id"], $this->user->data->id);

    return json_answer(["status"=>true, "redirect"=>outRoute('profile-shop')]);

}

public function deleteBanner()
{   

    $banner = $this->model->shops_banners->find("user_id=? and id=?", [$this->user->data->id, $_POST['id']]);

    if(!$banner){
        return json_answer(["status"=>false]);
    }

    $this->model->shops_banners->delete("id=?", [$_POST['id']]);
    $this->storage->clearAttachFiles([$banner->image]);

    return json_answer(["status"=>true]);
       
}

public function deletePage()
{   

    $page = $this->model->shops_pages->find("user_id=? and id=?", [$this->user->data->id, $_POST['id']]);

    if(!$page){
        return json_answer(["status"=>false]);
    }

    $shop = $this->model->shops->find("id=?", [$page->shop_id]);

    $this->model->shops_pages->delete("id=? and user_id=?", [$_POST['id'], $this->user->data->id]);

    return json_answer(["status"=>true, "redirect"=>$this->component->shop->linkToShopCard($shop->alias)]);
       
}

public function edit()
{   

    $answer = [];

    $shop = $this->model->shops->find("user_id=? and id=?", [$this->user->data->id, $_POST['id']]);

    if(!$shop){
        return json_answer(["status"=>false]);
    }

    if($this->validation->requiredField($_POST['title'])->status == false){
        $answer['title'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['category_id'])->status == true){
        if(!$this->component->ads_categories->categories[$_POST['category_id']]){
            $answer['category_id'] = translate("tr_e501b221d7a65fc7efe1e52988bd4d5d");
        }
    }

    $alias = slug($_POST['alias']);

    if($this->user->data->service_tariff->items->unique_shop_address){
        if($this->validation->requiredField($alias)->status == false){
            $answer['alias'] = $this->validation->error;
        }else{
            $check = $this->model->shops->find("alias=? and id!=?", [$alias, $shop->id]);
            if($check){
                $answer['alias'] = translate("tr_4620efb761967524f1d5a5d395d4e3d6");
            }
        }
    }

    if(!$answer){

        if($_POST['attach_files']){
            $_POST["attach_files"] = $this->storage->uploadAttachFiles($_POST['attach_files'], $this->config->storage->users->attached);
        }

        if($this->user->data->service_tariff->items->unique_shop_address){
            $unique_shop_address = $alias;
        }else{
            $unique_shop_address = md5(time() . uniqid());
        }

        $this->model->shops->update(["title"=>$_POST['title'], "text"=>$_POST['text'], "category_id"=>(int)$_POST['category_id'], "image"=>$_POST['attach_files'] ? $_POST['attach_files'][0] : $shop->image, "alias"=>$unique_shop_address, "status"=>$this->settings->shop_moderation_status ? "awaiting_verification" : "published"], $shop->id);

        $this->event->editShop(["user_id"=>$this->user->data->id, "shop_id"=>$shop->id, "action"=>"edit_shop"]);

        return json_answer(["status"=>true, "answer"=>translate("tr_9b23d5607cca7e8b1486ac8055ab9e78")]);

    }else{

        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);

    }

}

public function editPage()
{   

    $answer = [];

    $page = $this->model->shops_pages->find("user_id=? and id=?", [$this->user->data->id, $_POST['id']]);

    if(!$page){
        return json_answer(["status"=>false]);
    }

    $shop = $this->model->shops->find("id=?", [$page->shop_id]);

    $this->model->shops_pages->update(["text"=>$_POST['text']], ["id=?", [$_POST['id']]]);

    $this->event->editShop(["user_id"=>$this->user->data->id, "shop_id"=>$shop->id, "action"=>"edit_page_text_shop", "page_name"=>$page->name]);

    return json_answer(["status"=>true, "answer"=>translate("tr_bc6aff8adc1f810748019a9fbe047de3")]);
       
}

public function loadItems()
{   

    $content = '';
    $data = [];
    $ids = [];
    $shop = [];

    $this->pagination->request($_POST);

    $page = (int)$_POST["page"] ? (int)$_POST["page"] : 1;
    $url = $_POST['url'] ? clearRequestURI(urldecode($_POST['url'])) : '';

    if($_POST["sort"] == "news"){
        $sort = 'id desc';
    }elseif($_POST["sort"] == "price_asc"){
        $sort = 'price asc';
    }elseif($_POST["sort"] == "price_desc"){
        $sort = 'price desc';
    }else{
        $sort = 'time_sorting desc';
    }

    if(trim($url, "/")){

        $url_explode = explode("/", trim($url, "/"));
        
        if($url_explode[1]){
            $shop = $this->model->shops->find("alias=?", [$url_explode[1]]);
        }

    }

    if(!$shop){
        return json_answer(["content"=>"<h4>".translate("tr_8767f9ec282489d3e8e29021d0967187")."</h4>"]);
    }

    $build = $this->component->catalog->buildQuery($_POST, $_POST["c_id"]);

    if($build){
        if($shop->user_id){
            $build["query"] = $build["query"] . " and user_id=?";
            $build["params"][] = $shop->user_id;
        }
        $data = $this->model->ads_data->pagination(true)->page($page)->output($this->settings->out_default_count_items)->sort($sort)->getAll($build["query"], $build["params"]);
    }

    if($data){

        if($page <= $this->pagination->pages()){

            foreach ($data as $key => $value) {

                $value = $this->component->ads->getDataByValue($value);

                $ids[] = $value->id;

                if($this->component->catalog->getViewItems() == "grid"){
                    $content .= $this->view->setParamsComponent(['value'=>$value])->includeComponent('items/grid.tpl');
                }else{
                    $content .= $this->view->setParamsComponent(['value'=>$value])->includeComponent('items/list.tpl');
                }

            }

            $this->component->catalog->updateCountDisplay($ids);

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

               <div class="text-center mt15" >
                  <p>'.translate("tr_6b377edee6db2cf591176951b7cd497e").'</p>
               </div>

            ';

        }

    }else{

        $result = '

           <div class="catalog-not-found" >

              <h4>'.translate("tr_8767f9ec282489d3e8e29021d0967187").'</h4>
              <p>'.translate("tr_a7b03ac2b15fd0bff35a274c8b603c63").'</p>
              <p>'.translate("tr_e9d264db2a7d22c56ac22e8750838d49").'</p>

           </div>

        ';            

    }

    return json_answer(["content"=>$result]);

}

public function open()
{   

    $answer = [];

    $getShop = $this->model->shops->find("user_id=?", [$this->user->data->id]);

    if($getShop){
        return json_answer(["status"=>false, "answer"=>translate("tr_d1c60794308340dbc7ef0acfd4b82e1a")]);
    }

    if(!$this->component->profile->checkVerificationPermissions($this->user->data->id, "open_shop")){
        return json_answer(["verification"=>false, "answer"=>translate("tr_0e28cd53f7623cf9ffab15a7a719a274")]);
    }

    if(!$this->user->data->service_tariff->items->shop){
        return json_answer(["status"=>false]);
    }

    if($this->validation->requiredFieldArray($_POST['attach_files'])->status == false){
        $answer['logo'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['title'])->status == false){
        $answer['title'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['category_id'])->status == true){
        if(!$this->component->ads_categories->categories[$_POST['category_id']]){
            $answer['category_id'] = translate("tr_e501b221d7a65fc7efe1e52988bd4d5d");
        }
    }

    $alias = slug($_POST['alias']);

    if($this->user->data->service_tariff->items->unique_shop_address){
        if($this->validation->requiredField($alias)->status == false){
            $answer['alias'] = $this->validation->error;
        }else{
            $check = $this->model->shops->find("alias=?", [$alias]);
            if($check){
                $answer['alias'] = translate("tr_4620efb761967524f1d5a5d395d4e3d6");
            }else{
                $unique_shop_address = $alias;
            }
        }
    }else{
        $unique_shop_address = generateCode(30);
    }

    if(!$answer){

        if($_POST['attach_files']){
            $_POST["attach_files"] = $this->storage->uploadAttachFiles($_POST['attach_files'], $this->config->storage->users->attached);
        }

        $shop_id = $this->model->shops->insert(["user_id"=>$this->user->data->id, "title"=>$_POST['title'], "text"=>$_POST['text'], "category_id"=>(int)$_POST['category_id'], "image"=>$_POST['attach_files'] ? $_POST['attach_files'][0] : null, "alias"=>$unique_shop_address, "status"=>$this->settings->shop_moderation_status ? "awaiting_verification" : "published", "time_create"=>$this->datetime->getDate()]);

        $this->event->createShop(["user_id"=>$this->user->data->id, "shop_id"=>$shop_id]);

        return json_answer(["status"=>true, "redirect"=>$this->component->shop->linkToShopCard($unique_shop_address)]);

    }else{

        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);

    }

}

public function page($shop_alias, $page_alias)
{   

    $this->view->visible_header = false;
    $this->view->visible_footer = false;

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/shop.js\" type=\"module\" ></script>"]);

    $data = (object)[];

    if(!$this->settings->shops_status){
        abort(404);
    }

    $data->shop = $this->component->shop->getShopByAlias($shop_alias);

    if($data->shop){
        if($data->shop->status != "published"){
            if($data->shop->user_id != $this->user->data->id){
                abort(404);
            }
        }
    }else{
        abort(404);
    }

    $data->user = $this->model->users->findById($data->shop->user_id, true);

    if(!$data->user || $data->user->delete){
        abort(404);
    }

    $data->page = $this->model->shops_pages->find("shop_id=? and alias=?", [$data->shop->id,$page_alias]);

    if(!$data->page){
        abort(404);
    }

    $data->page->text = urldecode($data->page->text);
    $data->owner = $data->shop->user_id == $this->user->data->id ? true : false;

    $this->view->setParamsComponent(['data'=>(object)$data]);

    return $this->view->render('shop-page', ["data"=>(object)$data, "seo"=>(object)["meta_title"=>$data->page->name . ' - ' . $data->shop->title]]);

}

public function shop($shop_alias)
{   

    $this->view->visible_header = false;
    $this->view->visible_footer = false;

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/shop.js\" type=\"module\" ></script>"]);

    $data = (object)[];

    if(!$this->settings->shops_status){
        abort(404);
    }

    $data->shop = $this->component->shop->getShopByAlias($shop_alias);

    if(!$data->shop){
        abort(404);
    }

    $data->user = $this->model->users->findById($data->shop->user_id, true);

    if(!$data->user || $data->user->delete){
        abort(404);
    }

    $data->tariff = $this->component->service_tariffs->getOrderByUserId($data->shop->user_id);

    $data->owner = $data->shop->user_id == $this->user->data->id ? true : false;
    $data->banners = $this->component->shop->getBanners($data->shop->id);
    
    $data->items = $this->component->shop->getHomeAdsUser($data->shop->user_id);
    $data->reviews = $this->component->shop->getHomeReviews($data->shop->user_id);

    $seo = $this->component->seo->content($data);
    $this->view->setParamsComponent(['data'=>(object)$data]);

    return $this->view->render('shop', ["data"=>(object)$data, "seo"=>$seo]);

}

public function uploadAttach()
{   

    $result = '';

    $resultUpload = $this->storage->files($_FILES['attach_files'])->path('temp')->extList('images')->deleteOriginal(true)->use("resize")->upload();

    if($resultUpload){

        $result = '
          <div class="uni-attach-files-item-delete uniAttachFilesDeleteItem" ><i class="ti ti-x"></i></div>
          <img class="image-autofocus" src="'.$this->storage->name($resultUpload["name"])->path('temp')->get().'" />
          <input type="hidden" name="attach_files[]" value="'.$resultUpload["name"].'" >
        ';

    }

    return json_answer(["content"=>$result]);
       
}

public function uploadBanner()
{   

    $shop = $this->model->shops->find("user_id=? and id=?", [$this->user->data->id, $_POST['id']]);

    if(!$shop){
        return json_answer(["status"=>false]);
    }

    if($this->model->shops_banners->count("shop_id=?", [$shop->id]) >= $this->settings->shop_max_banners){
        return json_answer(["status"=>false, "answer"=>translate("tr_e6000795b8f4845f6f660f49de980e11")]);
    }else{

        $resultUpload = $this->storage->files($_FILES['attach_files'])->path('temp')->extList('images')->use("resize")->width(1920)->upload();

        if($resultUpload){

            $image = $this->storage->uploadAttachFiles([$resultUpload["name"]], $this->config->storage->users->attached);

            $this->model->shops_banners->insert(["user_id"=>$this->user->data->id, "shop_id"=>$shop->id, "image"=>$image[0]]);

            $this->event->editShop(["user_id"=>$this->user->data->id, "shop_id"=>$shop->id, "action"=>"add_banner_shop"]);

        }

    }

    return json_answer(["status"=>true]);
       
}



 }