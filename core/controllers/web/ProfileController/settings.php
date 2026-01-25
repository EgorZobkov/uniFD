public function settings()
{   

    $this->view->visible_header = false;

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/profile.js\" type=\"module\" ></script>"]);

    $data = (object)[];
    
    return $this->view->render('profile/settings', ["data"=>(object)$data, "seo"=>(object)["meta_title"=>translate("tr_c919d65bd95698af8f15fa8133bf490d")]]);
}