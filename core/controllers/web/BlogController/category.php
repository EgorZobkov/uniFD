public function category($alias)
{   

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/blog.js\" type=\"module\" ></script>"]);

    $data = (object)[];

    $data->category = $this->component->blog_categories->checkCategoriesByAlias(explode("/", $alias));

    if($data->category){
        $this->component->blog->data = $data;
    }else{
        abort(404);
    }

    $seo = $this->component->seo->content($data);

    return $this->view->render('blog', ["data"=>(object)$data, "seo"=>$seo]);

}