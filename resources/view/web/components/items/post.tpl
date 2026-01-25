<div class="col-12 col-md-6 col-lg-12" >
	<a class="widget-article-blog-item mb15" href="<?php echo $app->component->blog->buildAliasesPostCard($value); ?>" >
		<img src="<?php echo $app->storage->name($value->image)->get(); ?>" class="image-autofocus" >
		<div class="widget-article-blog-item-title" ><h4><?php echo translateFieldReplace($value, "title"); ?></h4></div>
	</a>
</div>