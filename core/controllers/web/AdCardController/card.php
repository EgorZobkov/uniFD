public function card($aliases, $ad_alias, $ad_id){   

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/ad_card.js\" type=\"module\" ></script>"]);

    $data = $this->component->ads->getAd($ad_id);

    if(!$data || !$data->user){
        abort(404);
    }else{

        $chain = $this->component->ads_categories->chainCategory($data->category_id);

        $aliases = explode("/", $aliases);

        if($this->translate->getChangeLang() == $aliases[0]){
            unset($aliases[0]);
            $aliases = array_values($aliases);
        }            

        if($data->geo){
            if($data->geo->alias != $aliases[0] || $chain->chain_build_alias_dash != $aliases[1] || $data->alias != $ad_alias){
                abort(404);
            }                
        }else{
            if($chain->chain_build_alias_dash != $aliases[0] || $data->alias != $ad_alias){
                abort(404);
            }                 
        }

    }

    $data->owner = $data->user_id == $this->user->data->id ? true : false;

    $this->session->setNestedSubarray("ad-contact", $data->id, $data->id);

    $data->in_favorites = $this->component->profile->inFavorite($data->id, $this->user->data->id);

    $property = $this->component->ads_filters->outPropertyAd($data->id);
    if($property){
        $data->property = $property;
    }

    if(!$data->owner){
        $this->component->ads->fixView($data->id, $this->user->data->id);
    }

    $data->count_reviews = $this->component->reviews->countByAdId($data);

    $data->similar_items = $this->component->ads->getSimilarItems($data);

    $seo = $this->component->seo->content($data);

    return $this->view->render('ad-card', ["data"=>(object)$data, "seo"=>$seo]);
}