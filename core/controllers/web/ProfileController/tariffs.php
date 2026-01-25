public function tariffs()
{   

    $this->view->visible_header = false;

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/profile.js\" type=\"module\" ></script>"]);

    return $this->view->render('profile/tariffs', ["seo"=>(object)["meta_title"=>translate("tr_a49106cadab8ae1ff6a37e7ccea9c665")]]);
}