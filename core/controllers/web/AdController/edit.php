public function edit($id){   

    $this->view->visible_header = false;
    $this->view->visible_footer = false;

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/ad.js\" type=\"module\" ></script>"]);
    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/vendors/minicolors/jquery.minicolors.min.js\" ></script>"]);
    $this->asset->registerCss(["view"=>"web", "name"=>"<link rel=\"stylesheet\" href=\"{assets_path}/vendors/minicolors/jquery.minicolors.css\" />"]);
    
    $data = $this->component->ads->getAd($id);

    if($data && !$data->delete){

        if($this->user->isAdminAuthAndCheckAccess("control", "dashboard-ads")->status){
            $data->isAdmin = true;
        }else{
            $data->isAdmin = false;
            if($data->user_id == $this->user->data->id){
                if($data->status == 4 && $data->block_forever_status){
                     abort(404);
                }                
            }else{
                abort(404);
            }
        }
    }else{
        abort(404);
    }

    return $this->view->render('ad-edit', ["data"=>(object)$data, "seo"=>(object)["meta_title"=>$data->title]]);
}