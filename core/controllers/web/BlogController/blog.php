 public function blog()
{   

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/blog.js\" type=\"module\" ></script>"]);

    $data = (object)[];

    $seo = $this->component->seo->content($data);

    return $this->view->render('blog', ["data"=>(object)$data, "seo"=>$seo]);

}