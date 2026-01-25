public function user($alias)
{   

    $this->view->visible_header = false;

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/profile.js\" type=\"module\" ></script>"]);
   
    $data = (object)[];

    $data->user = $this->model->users->findByAlias($alias, true);

    if($data->user && !$data->user->delete){

        if($data->user->id == $this->user->data->id){ 
            $this->router->goToRoute("profile");
        }else{

            $shop = $this->component->shop->getShopByUserId($data->user->id);

            if($shop){
                if($shop->status == "published"){
                    $this->router->goToUrl($this->component->shop->linkToShopCard($shop->alias));
                }
            }

        }

    }else{
        abort(404);
    }

    $data->ads = $this->component->profile->getHomeAdsUserOnlyActive($data->user->id);
    $data->reviews = $this->component->profile->getMyReviews($data->user->id);

    $seo = $this->component->seo->content($data);

    $this->view->setParamsComponent(['data'=>(object)$data]);

    return $this->view->render('user-card', ["data"=>(object)$data, "seo"=>$seo]);
}