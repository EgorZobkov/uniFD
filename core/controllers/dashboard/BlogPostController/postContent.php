public function postContent($id)
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/blog.js\" type=\"module\" ></script>"]);
    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/vendors/ckeditor/ckeditor.js\" type=\"module\" ></script>"]);

    $data = $this->model->blog_posts->find("id=?", [$id]);

    if(!$data){
        abort(404);
    }        

    $this->view->setParamsComponent(["data"=>$data, "breadcrumbs"=>["chain"=>[translate("tr_40479311ccd23f5d64eb927684429cbb")=>$this->router->getRoute("dashboard-blog-posts"),$data->title=>null]]]);

    return $this->view->preload('blog/post-content', ["data"=>$data, "title"=>$data->title]);

}