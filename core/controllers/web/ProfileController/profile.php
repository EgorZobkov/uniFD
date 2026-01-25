public function profile()
{   

    $this->view->visible_header = false;

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/profile.js\" type=\"module\" ></script>"]);

    $data = (object)[];

    $data->ads = $this->component->profile->getHomeAdsUser($this->user->data->id);
    $data->favorites = $this->component->profile->getHomeFavoritesAdsUser($this->user->data->id);
    $data->orders = $this->component->profile->getHomeOrdersUser($this->user->data->id);
    $data->reviews = $this->component->profile->getHomeReviews($this->user->data->id);

    return $this->view->render('profile', ["data"=>(object)$data, "seo"=>(object)["meta_title"=>translate("tr_a46c372347e02010f5ef45fe441e4349")]]);
}