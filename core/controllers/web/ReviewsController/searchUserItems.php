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