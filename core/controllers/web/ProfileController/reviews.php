public function reviews()
{   

    $this->view->visible_header = false;

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/profile.js\" type=\"module\" ></script>"]);

    $data = (object)[];

    if(compareValues($_GET['tab'], 'my_reviews')){
        $data->reviews = $this->component->profile->getMyReviews($this->user->data->id);
    }elseif(compareValues($_GET['tab'], 'added')){
        $data->reviews = $this->component->profile->getAddedReviews($this->user->data->id);
    }else{
        $data->reviews = $this->component->profile->getMyReviews($this->user->data->id);
    }
    
    return $this->view->render('profile/reviews', ["data"=>(object)$data, "seo"=>(object)["meta_title"=>translate("tr_1c3fea01a64e56bd70c233491dd537aa")]]);
}