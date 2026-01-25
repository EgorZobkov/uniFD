public function autorenewal()
{   

    $this->view->visible_header = false;

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/profile.js\" type=\"module\" ></script>"]);

    $data = (object)[];

    $data->ads = $this->component->profile->getRenewalAdsUser($this->user->data->id);
    
    return $this->view->render('profile/autorenewal', ["data"=>(object)$data, "seo"=>(object)["meta_title"=>translate("tr_f139acad6b9e9ae951fc74f9df710e96")]]);
}