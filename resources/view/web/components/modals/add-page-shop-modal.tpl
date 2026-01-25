<h3 class="modal-title mb-3" > <strong><?php echo translate("tr_cb4b1897e6fbd5db0d0b3fd62e33799d"); ?></strong> </h3>

<form class="modal-add-page-shop-form" >

	<div class="modal-shop-container" >
		
		<div class="modal-shop-container-item" >
			<span><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?></span>
			<input type="text" name="name" class="form-control" >
			<label class="form-label-error" data-name="name"></label>
		</div>

	</div>

	<input type="hidden" name="id" value="<?php echo $data->id; ?>" >

</form>

<div class="text-end mt-4">
	<button class="btn-custom button-color-scheme1 actionAddPageShop"><?php echo translate("tr_5eba283b81890978e67f4aa96dde1724"); ?></button>
</div>
