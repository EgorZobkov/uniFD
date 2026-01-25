public function searchUserItemsInStatistics()
{   

    $result = '';

    if(_mb_strlen($_POST['query']) < 2){
        return json_answer(["status"=>false]);
    }

    $getAds = $this->model->ads_data->sort("id desc")->search($_POST['query'])->getAll("user_id=? and status IN(1,3,7)", [$this->user->data->id]);

    if($getAds){
        foreach ($getAds as $key => $value) {
            $result .= '
                  <a class="user-item-container" href="'.$this->router->getRoute('profile-statistics').'?item_id='.$value["id"].'" >
                      <div class="user-item-container-box1" >
                         <div class="user-item-container-image" >
                            <img src="'.$this->component->ads->getMedia($value["media"])->images->first.'" class="image-autofocus" >
                         </div>
                      </div>
                      <div class="user-item-container-box2" >
                         <span>'.$value["title"].'</span>
                         <span>'.$this->component->ads->outPriceAndCurrency($value).'</span>
                      </div>
                  </a>
            ';
        }
        return json_answer(["status"=>true, "answer"=>$result]);
    }

    return json_answer(["status"=>false, "answer"=>translate("tr_8767f9ec282489d3e8e29021d0967187")]);
       
}