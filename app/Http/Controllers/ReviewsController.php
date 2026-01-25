<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Http\Controllers;

 use App\Systems\Controller;

 class ReviewsController extends Controller
 {

 public function __construct($app){
 parent::__construct($app); 
 }

 public function add($user_id)
{   

    $this->view->visible_header = false;
    $this->view->visible_footer = false;

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/reviews.js\" type=\"module\" ></script>"]);

    $data = $this->model->users->findById($user_id, true);

    if(!$data){
        abort(404);
    }else{
        if($data->id == $this->user->data->id){
            abort(404);
        }
    }

    if($_GET['order_id']){
        $order = $this->component->transaction->getDealItem($_GET['order_id']);
        if($order){
            if($order->from_user_id == $this->user->data->id || $order->whom_user_id == $this->user->data->id){
                $data->item = $this->component->ads->getAd($order->item->item_id);
                $data->order_id = $_GET['order_id'];
            }
        }
    }elseif($_GET['item_id']){
        $data->item = $this->component->ads->getAd($_GET['item_id']);
    }

    $data->user_items = $this->model->ads_data->sort("id desc limit 10")->getAll("user_id=? and status IN(1,3,7)", [$data->id]);

    return $this->view->render('review-add', ["data"=>(object)$data, "seo"=>(object)["meta_title"=>translate("tr_a1808993eb91e69573b41167cac0fee9")]]);

}

public function delete()
{   

    if($this->user->data->id){
        $this->component->reviews->delete($_POST["id"], $this->user->data->id);
    }

    return json_answer(["status"=>true]);

}

public function responseCreate()
{   

    if($this->validation->requiredField($_POST['text'])->status == false){
        return json_answer(["status"=>false, "answer"=>translate("tr_9236dee57cf1f06c152210bf429c87e1")]);
    }else{
        $this->component->reviews->responseCreate(["review_id"=>$_POST["id"], "user_id"=>$this->user->data->id, "text"=>$_POST["text"]]);
        return json_answer(["status"=>true]);
    }

}

public function reviewCreate()
{   

    if(!$this->component->profile->checkVerificationPermissions($this->user->data->id, "create_review")){
        return json_answer(["verification"=>false]);
    }

    if($_POST['order_id']){
        $check = $this->model->reviews->find("order_id=? and from_user_id=?", [$_POST['order_id'], $this->user->data->id]);
    }elseif($_POST['user_id']){
        if($_POST['item_id']){
            if(!$this->component->ads->getAd($_POST['item_id'])->delete){
                $check = $this->model->reviews->find("from_user_id=? and whom_user_id=? and item_id=?", [$this->user->data->id,$_POST['user_id'],$_POST['item_id']]);
            }else{
                return json_answer(["status"=>false, "answer"=>translate("tr_d10052a52dfdffe02aa808e4519710e2")]);
            }
            
        }else{
            return json_answer(["status"=>false, "answer"=>translate("tr_a7df722272429dc621d8eb6a76fcd096")]);
        }
    }else{
        return json_answer(["status"=>false, "answer"=>translate("tr_8b1269c207872d7f783a4fe90ecf0ecb")]);
    }

    if(!$check){

        if($this->validation->requiredField($_POST['text'])->status == false){
            return json_answer(["status"=>false, "answer"=>translate("tr_b3e7a762d010c0584a807e107a0c63ba")]);
        }else{
            if(!$this->component->reviews->create(["order_id"=>$_POST["order_id"], "item_id"=>$_POST["item_id"], "from_user_id"=>$this->user->data->id, "whom_user_id"=>$_POST['user_id'], "text"=>$_POST["text"], "rating"=>$_POST["rating"], "attach_files"=>$_POST["attach_files"]])){
                return json_answer(["status"=>false, "answer"=>translate("tr_cd3fef036a21f3338ea222fcf86d1fb8")]);
            }
            return json_answer(["status"=>true]);
        }

    }else{
        return json_answer(["status"=>false, "answer"=>translate("tr_1f46f60acfecc938dc47608454611b8e")]);
    }

}

public function searchUserItems()
{   

    $result = '';

    if(_mb_strlen($_POST['query']) < 2){
        return json_answer(["status"=>false]);
    }

    $getAds = $this->model->ads_data->sort("id desc")->search($_POST['query'])->getAll("user_id=? and status IN(1,3,7)", [$_POST['user_id']]);

    if($getAds){
        foreach ($getAds as $key => $value) {
            $result .= '
                  <div class="review-add-item-container" data-id="'.$value["id"].'" >
                      <div class="review-add-item-container-box1" >
                         <div class="review-add-item-container-image" >
                            <img src="'.$this->component->ads->getMedia($value["media"])->images->first.'" class="image-autofocus" >
                         </div>
                      </div>
                      <div class="review-add-item-container-box2" >
                         <span>'.$value["title"].'</span>
                         <span>'.$this->component->ads->outPriceAndCurrency($value).'</span>
                         <span>'.$this->component->ads->outLocationByCatalog($value).'</span>
                      </div>
                  </div>
            ';
        }
        return json_answer(["status"=>true, "answer"=>$result]);
    }

    return json_answer(["status"=>false, "answer"=>translate("tr_8767f9ec282489d3e8e29021d0967187")]);
       
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



 }