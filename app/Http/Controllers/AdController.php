<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Http\Controllers;

 use App\Systems\Controller;

 class AdController extends Controller
 {

 public function __construct($app){
 parent::__construct($app); 
 }

 public function create(){   

    $this->view->visible_header = false;
    $this->view->visible_footer = false;

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/ad.js\" type=\"module\" ></script>"]);
    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/vendors/minicolors/jquery.minicolors.min.js\" ></script>"]);
    $this->asset->registerCss(["view"=>"web", "name"=>"<link rel=\"stylesheet\" href=\"{assets_path}/vendors/minicolors/jquery.minicolors.css\" />"]);

    $seo = $this->component->seo->content();

    return $this->view->render('ad-create', ["seo"=>$seo]);
}

public function createChangeCategoryOptions(){   

    $items = '';
    $options = [];
    $price_currency_list = '';
    $measurements = [];
    $price_fixed_change = '';
    $price_gratis_status = '';
    $ad = [];

    if($this->component->ads_categories->categories){

        if($this->component->ads_categories->categories["parent_id"][$_POST['category_id']]){

              if($_POST['category_id']){
                  $items .= '
                    <button class="btn-custom button-color-scheme2 mb15 ad-create-categories-back" data-id="'.$this->component->ads_categories->categories[$_POST['category_id']]["parent_id"].'" >'.translate("tr_2b0b0225a86bb67048840d3da9b899bc").'</button>
                  ';
              }

              foreach ($this->component->ads_categories->categories["parent_id"][$_POST['category_id']] as $key => $value) {

                   $items .= '<span class="ad-create-categories-item" data-id="'.$value["id"].'">'.translateFieldReplace($value, "name").'</span>';

              }

              return json_answer(["subcategories"=>true,"content"=>$items]);

        }else{

            if($_POST['ad_id']){
                $ad = $this->component->ads->getAd($_POST['ad_id'], $this->user->data->id);
            }

            return json_answer(["subcategories"=>false, "content"=>$this->component->ads->getContentAndOptions($_POST,$ad)]);

        }

    }


}

public function createLoadFilterItems(){

    return json_answer(["content"=>$this->component->ads_filters->getFiltersParentInAdCreate($_POST["filter_id"],$_POST["item_id"])]);

}

public function edit($id){   

    $this->view->visible_header = false;
    $this->view->visible_footer = false;

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/ad.js\" type=\"module\" ></script>"]);
    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/vendors/minicolors/jquery.minicolors.min.js\" ></script>"]);
    $this->asset->registerCss(["view"=>"web", "name"=>"<link rel=\"stylesheet\" href=\"{assets_path}/vendors/minicolors/jquery.minicolors.css\" />"]);
    
    $data = $this->component->ads->getAd($id);

    if($data && !$data->delete){

        if($this->user->isAdminAuthAndCheckAccess("control", "dashboard-ads")->status){
            $data->isAdmin = true;
        }else{
            $data->isAdmin = false;
            if($data->user_id == $this->user->data->id){
                if($data->status == 4 && $data->block_forever_status){
                     abort(404);
                }                
            }else{
                abort(404);
            }
        }
    }else{
        abort(404);
    }

    return $this->view->render('ad-edit', ["data"=>(object)$data, "seo"=>(object)["meta_title"=>$data->title]]);
}

public function loadGeoOptions(){

    return json_answer(["status"=>true, "answer"=>$this->component->ads->outMapAndOptionsInAdCreate($_POST['city_id'])]);
    
}

public function loadMedia(){

    $result = '';

    $extensions_image = $this->settings->allowed_extensions_images;
    $extensions_video = $this->settings->allowed_extensions_videos;

    $data = normalizeFilesArray($_FILES["unidropzone_files"]);

    if($data){
        foreach ($data as $key => $value) {

            $generatedName = md5(time().'-'.uniqid());
            $extension = getInfoFile($value["name"])->extension;

            if(compareValues($extensions_image, $extension)){

                if($value["size"] < $this->settings->board_publication_max_size_image*1024*1024){

                    if(move_uploaded_file($value['tmp_name'], $this->config->storage->temp.'/'.$generatedName.'.'.$extension)){

                        $upload = $this->image->path($this->config->storage->temp)->name($generatedName.'.'.$extension)->saveTo($this->config->storage->temp)->watermark(true)->resize();
                                
                        $result .= '
                          <span class="unidropzone-item-delete" ><i class="ti ti-x"></i></span>
                          <img class="image-autofocus" src="'.$this->storage->name($upload["name"])->path('temp')->get().'" >
                          <input type="hidden" name="media[][image]" value="'.$generatedName.'" >
                        ';

                    }

                }

            }elseif(compareValues($extensions_video, $extension) && $this->settings->board_publication_add_video_status){
      
                if($value["size"] < $this->settings->board_publication_max_size_video*1024*1024){

                    if(move_uploaded_file($value['tmp_name'], $this->config->storage->temp.'/'.$generatedName.'.mp4')){

                        $upload = $this->video->file($this->config->storage->temp.'/'.$generatedName.'.mp4')->name($generatedName)->saveToImage($this->config->storage->temp)->saveImagePreview();

                        $result .= '
                          <span class="unidropzone-item-delete" ><i class="ti ti-x"></i></span>
                          <img class="image-autofocus" src="'.$this->storage->name($upload["name_image"])->path('temp')->get().'" >
                          <input type="hidden" name="media[][video]" value="'.$generatedName.'" >
                        ';

                    }

                }

            }

        }
    }

    return json_answer(["content"=>$result]);

}

public function publication(){ 

    $answer = [];
    $admin = false;

    if($this->user->isAdminAuthAndCheckAccess("control", "dashboard-ads")->status){
        $admin = true;
    }

    $answer = $this->component->ads->validationFormCreate($_POST);

    if(empty($answer)){

        if($this->system->checkingBadRequests("ad_create", $this->user->data->id)){
            return json_answer(["status"=>false]);
        }

        if(!$this->user->isAuth()){

            $this->session->set("ad-create-save", $_POST);
            return json_answer(["auth"=>false]); 

        }else{

            if(!$this->component->profile->checkVerificationPermissions($this->user->data->id, "create_ad")){
                return json_answer(["verification"=>false]);
            }
            
        }

        $result = $this->component->ads->publication($_POST,$this->user->data->id,$admin);

        return json_answer(["status"=>true, "route"=>$this->component->ads->detectRoute($result)]);

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }

}

public function publicationSuccess($id){   

    $this->view->visible_header = false;
    $this->view->visible_footer = false;

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/ad_paid_services.js\" type=\"module\" ></script>"]);

    $data = $this->component->ads->getAd($id);
    if(!$data){
        abort(404);
    }else{
        if($data->user_id != $this->user->data->id || $data->status != 1){
            abort(404);
        }
    }

    $seo = $this->component->seo->content();

    return $this->view->render('ad-publication-success', ["data"=>(object)$data, "seo"=>$seo]);
}

public function update(){ 

    $answer = [];
    $admin = false;

    if(!$this->user->isAdminAuthAndCheckAccess("control", "dashboard-ads")->status){

        if(!$this->user->verificationAuth()){
            return json_answer(["auth"=>false, "route"=>outRoute("auth")]);
        }else{
            $data = $this->component->ads->getAd($_POST["ad_id"], $this->user->data->id);
        }

    }else{
        $admin = true;
        $data = $this->component->ads->getAd($_POST["ad_id"]);
    }

    $answer = $this->component->ads->validationFormCreate($_POST);

    if(empty($answer)){

        $result = $this->component->ads->update($_POST,$data->user_id,$_POST["ad_id"],$admin);

        return json_answer(["status"=>true, "route"=>$this->component->ads->buildAliasesAdCard($result->data)]);

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }

}



 }