public function ads()
{   

    $this->view->visible_header = false;

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/profile.js\" type=\"module\" ></script>"]);

    $data = (object)[];

    $data->ads = $this->component->profile->getAllAdsUser($this->user->data->id, $_GET['status']);

    return $this->view->render('profile/ads', ["data"=>(object)$data, "seo"=>(object)["meta_title"=>translate("tr_083ab3d9a9221cf6a1641c2c7c5f0d3c")]]);
}