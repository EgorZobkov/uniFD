<h3 class="modal-title mb-3" > <strong><?php echo translate("tr_15ec7acc80d41d1524ad6d61311b3182"); ?></strong> </h3>

<form class="modal-open-shop-form" >

	<div class="modal-shop-container" >
		
		<div class="modal-shop-container-item" >
			<span><?php echo translate("tr_158176991f43d5bdf6c52b258bf05cf4"); ?></span>
			<div class="btn-custom-mini button-color-scheme2 uniAttachFilesChange" data-accept="images" data-upload-route="shop-upload-attach" data-parent-container="modal-shop-container" ><?php echo translate("tr_2b02caddb199f024c4a10c37660db0a1"); ?></div>
			<label class="form-label-error" data-name="logo"></label>

			<div class="uni-attach-files-container"></div>

		</div>

		<div class="modal-shop-container-item" >
			<span><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?></span>
			<input type="text" name="title" class="form-control" >
			<label class="form-label-error" data-name="title"></label>
		</div>

		<div class="modal-shop-container-item" >
			<span><?php echo translate("tr_be518714837d2c2581d28f8eed0f323b"); ?></span>
			<select class="form-control" name="category_id" >
				<option value="" ><?php echo translate("tr_4896dde4b49d7659c6e24c34ae55be1e"); ?></option>
				<?php echo $app->component->ads_categories->outMainCategoriesOptions(); ?>
			</select>
			<label class="form-label-error" data-name="category_id"></label>
		</div>

		<div class="modal-shop-container-item" >
			<span><?php echo translate("tr_38ca0af80cd7bd241500e81ba2e6efff"); ?></span>
			<textarea rows="4" name="text" class="form-control-textarea" ></textarea>
		</div>

		<?php if($app->user->data->service_tariff->items->unique_shop_address){ ?>
		<div class="modal-shop-container-item" >
			<span><?php echo translate("tr_89f761e974f521378e312444b39b11de"); ?></span>
			<input type="text" name="alias" class="form-control" placeholder="<?php echo translate("tr_b314dfb0d2e31f9598a601d55e5ce8c3"); ?>" >
			<label class="form-label-error" data-name="alias"></label>
		</div>
		<?php }else{ ?>
		<div class="modal-shop-container-item" >
			<span><?php echo translate("tr_89f761e974f521378e312444b39b11de"); ?></span>
			<input type="text" name="alias" class="form-control" placeholder="<?php echo translate("tr_b314dfb0d2e31f9598a601d55e5ce8c3"); ?>" disabled >
			<small class="text-color-red" ><?php echo translate("tr_b2858cd9f6d9c4cf9595c77d1cdfd9ce"); ?></small>
		</div>
		<?php } ?>

	</div>

</form>

<div class="text-end mt-4">
	<button class="btn-custom button-color-scheme1 actionOpenShop"><?php echo translate("tr_e9c3a648ce9e5dcf3c96940e682a72a2"); ?></button>
</div>
