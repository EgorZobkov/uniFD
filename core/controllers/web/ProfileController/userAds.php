public function userAds($alias)
{   

    $this->view->visible_header = false;

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/profile.js\" type=\"module\" ></script>"]);
   
    $data = (object)[];

    $data->user = $this->model->users->findByAlias($alias, true);

    if($data->user && !$data->user->delete){
        if($data->user->id == $this->user->data->id){
            $this->router->goToRoute("profile");
        }
    }else{
        abort(404);
    }

    $data->ads = $this->component->profile->getAllAdsUserInCard($data->user->id, $_GET['status']);

    $this->view->setParamsComponent(['data'=>(object)$data]);

    $seo = $this->component->seo->content($data);

    return $this->view->render('user-card-ads', ["data"=>(object)$data, "seo"=>$seo]);
}