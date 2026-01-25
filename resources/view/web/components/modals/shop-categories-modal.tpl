<h3 class="modal-title mb-3" > <strong><?php echo translate("tr_6926e02be4135897ae84b36941554684"); ?></strong> </h3>

<div class="shop-categories-list-modal" >
	<div><a href="<?php echo $app->component->shop->linkToCatalog($data->shop_alias); ?>" ><?php echo translate("tr_53660e081bed47bc53e7d4d247f7b15d"); ?></a></div>
	<?php echo $app->component->shop->outCategoriesList($data->shop_id); ?>
</div>

