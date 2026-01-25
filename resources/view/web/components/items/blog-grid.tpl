<div class="col-lg-4 col-md-6 col-12" >

    <a class="blog-grid-item" href="<?php echo $app->component->blog->buildAliasesPostCard($value); ?>" >
      <div class="blog-grid-item-image" >
        <img src="<?php echo $app->storage->name($value->image)->get(); ?>" class="image-autofocus" >
      </div>
      <div class="blog-grid-item-date" ><?php echo $app->datetime->outDate($value->time_create); ?></div>
      <div class="blog-grid-item-title" ><?php echo translateFieldReplace($value, "title"); ?></div>
      <div class="blog-grid-item-category" >#<?php echo translateFieldReplace($app->component->blog_categories->categories[$value->category_id], "name"); ?></div>
    </a>

</div>