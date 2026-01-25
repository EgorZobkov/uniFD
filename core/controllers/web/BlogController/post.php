public function post($category_alias, $alias, $id)
{   

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/blog.js\" type=\"module\" ></script>"]);

    $data = (object)[];

    $data = $this->model->blog_posts->find("id=? and status=?", [$id, 1]);

    if($data){

        $alias_field = (array)$data;

        if($alias_field["alias"] != $alias && $alias_field["alias_".$this->translate->getChangeLang()] != $alias){
            abort(404);
        }

        $chain = $this->component->blog_categories->chainCategory($data->category_id);
        if($chain->chain_build_alias_dash != $category_alias){
            abort(404);
        }

    }else{
        abort(404);
    }

    $this->component->blog->fixView($data->id, $this->user->data->id, getIp());

    $seo = $this->component->seo->content($data);

    return $this->view->render('blog-post', ["data"=>(object)$data, "seo"=>$seo]);

}