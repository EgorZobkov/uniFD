public function outCardPosts($id=0,$count=4){
    global $app;

    $data = $app->model->blog_posts->sort("id desc limit 50")->getAll("status=? and id!=?", [1,$id]);
    if($data){

        shuffle($data);

        foreach (array_slice($data, 0, $count) as $key => $value) {

            echo $app->view->setParamsComponent(['value'=>(object)$value])->includeComponent('items/post.tpl');

        }

    }

}