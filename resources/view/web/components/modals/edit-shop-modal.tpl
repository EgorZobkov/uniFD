<h3 class="modal-title mb-3" > <strong><?php echo translate("tr_1167e787a81a5549bc895f4c61dcba4b"); ?></strong> </h3>

<form class="modal-edit-shop-form" >

	<div class="modal-shop-container" >
		
		<div class="modal-shop-container-item" >
			<span><?php echo translate("tr_158176991f43d5bdf6c52b258bf05cf4"); ?></span>
			<div class="btn-custom-mini button-color-scheme2 uniAttachFilesChange" data-accept="images" data-upload-route="shop-upload-attach" data-parent-container="modal-shop-container" ><?php echo translate("tr_2b02caddb199f024c4a10c37660db0a1"); ?></div>
			<label class="form-label-error" data-name="logo"></label>

			<div class="uni-attach-files-container"></div>

		</div>

		<div class="modal-shop-container-item" >
			<span><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?></span>
			<input type="text" name="title" class="form-control" value="<?php echo $data->title; ?>" >
			<label class="form-label-error" data-name="title"></label>
		</div>

		<div class="modal-shop-container-item" >
			<span><?php echo translate("tr_be518714837d2c2581d28f8eed0f323b"); ?></span>
			<select class="form-control" name="category_id" >
				<option value="" ><?php echo translate("tr_4896dde4b49d7659c6e24c34ae55be1e"); ?></option>
				<?php echo $app->component->ads_categories->outMainCategoriesOptions($data->category_id); ?>
			</select>
			<label class="form-label-error" data-name="category_id"></label>
		</div>

		<div class="modal-shop-container-item" >
			<span><?php echo translate("tr_38ca0af80cd7bd241500e81ba2e6efff"); ?></span>
			<textarea rows="4" name="text" class="form-control-textarea" ><?php echo $data->text; ?></textarea>
		</div>

		<?php if($app->user->data->service_tariff->items->unique_shop_address){ ?>
		<div class="modal-shop-container-item" >
			<span><?php echo translate("tr_89f761e974f521378e312444b39b11de"); ?></span>
			<input type="text" name="alias" class="form-control" placeholder="<?php echo translate("tr_b314dfb0d2e31f9598a601d55e5ce8c3"); ?>" value="<?php echo $data->alias; ?>" >
			<label class="form-label-error" data-name="alias"></label>
		</div>
		<?php }else{ ?>
		<div class="modal-shop-container-item" >
			<span><?php echo translate("tr_89f761e974f521378e312444b39b11de"); ?></span>
			<input type="text" name="alias" class="form-control" placeholder="<?php echo translate("tr_b314dfb0d2e31f9598a601d55e5ce8c3"); ?>" disabled >
			<small class="text-color-red" ><?php echo translate("tr_b2858cd9f6d9c4cf9595c77d1cdfd9ce"); ?></small>
		</div>
		<?php } ?>

		<button class="btn-custom-mini button-color-scheme6 actionDeleteShop" data-id="<?php echo $data->id; ?>" ><?php echo translate("tr_a422f834f47970e3d906cae3e3dd0b9a"); ?></button>

		<div class="mt10" > <small><?php echo translate("tr_b10605b78754e9900f51012634d83458"); ?></small> </div>

	</div>

	<input type="hidden" name="id" value="<?php echo $data->id; ?>" >

</form>

<div class="text-end mt-4">
	<button class="btn-custom button-color-scheme1 actionSaveEditShop"><?php echo translate("tr_74ea58b6a801f0dce4e5d34dbca034dc"); ?></button>
</div>
