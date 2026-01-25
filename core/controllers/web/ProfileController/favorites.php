public function favorites()
{   

    $this->view->visible_header = false;

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/profile.js\" type=\"module\" ></script>"]);

    $data = (object)[];

    if(compareValues($_GET['tab'], 'ads')){
        $data->favorites = $this->component->profile->getFavorites($this->user->data->id);
    }elseif(compareValues($_GET['tab'], 'searches')){
        $data->favorites = $this->component->profile->getSearches($this->user->data->id);
    }elseif(compareValues($_GET['tab'], 'subscriptions')){
        $data->favorites = $this->component->profile->getSubscriptions($this->user->data->id);
    }elseif(compareValues($_GET['tab'], 'viewed')){
        $data->favorites = $this->component->profile->getViewed($this->user->data->id);
    }else{
        $data->favorites = $this->component->profile->getFavorites($this->user->data->id);
    }
    
    return $this->view->render('profile/favorites', ["data"=>(object)$data, "seo"=>(object)["meta_title"=>translate("tr_2fc413929104c1a09ae0a66c48ce0902")]]);
}