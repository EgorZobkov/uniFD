public function outStories(){
    global $app;

    $geo = $app->session->get("geo");

    ?>

    <section class="widget-stories-container user-stories-swiper mt15" >
       <div class="swiper-wrapper" >
            <?php echo $app->component->stories->outUsersStoriesInCatalog($this->data->category->id, $geo->city_id); ?>
       </div>
    </section>

    <?php

}