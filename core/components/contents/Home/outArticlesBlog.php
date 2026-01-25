public function outArticlesBlog(){
    global $app;

    $data = $app->model->blog_posts->sort("id desc limit 50")->getAll("status=?", [1]);
    if($data){

        shuffle($data);

        ?>

        <div class="bold-title-and-link" >
            <span><?php echo translate("tr_103a554114af7c598a4f835ac463722e"); ?></span>
            <a class="btn-custom-mini button-color-scheme1" href="<?php echo outRoute('blog'); ?>"><?php echo translate("tr_9cc58bef25297a7f6a867891be20657c"); ?></a>
        </div>

        <div class="row row-cols-2 g-2 g-lg-3" >
        <?php

        foreach (array_slice($data, 0, 3) as $key => $value) {

            echo $app->view->setParamsComponent(['value'=>(object)$value])->includeComponent('items/home-post-grid.tpl');

        }

        ?>
        </div>
        <?php

    }

}