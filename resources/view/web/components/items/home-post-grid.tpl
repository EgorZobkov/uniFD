<div class="col-md-4 col-12" >

    <a class="widget-article-blog-item" href="<?php echo $app->component->blog->buildAliasesPostCard($value); ?>" >
    	<img src="<?php echo $app->storage->name($value->image)->get(); ?>" class="image-autofocus" >
    	<div class="widget-article-blog-item-title" ><h4><?php echo translateFieldReplace($value, "title"); ?></h4></div>
    </a>

</div>