<h3 class="modal-title mb-3" > <strong><?php echo translate("tr_e85a7a1e7fa019e4adc10385f05ec4b1"); ?></strong> </h3>

<form class="profile-settings-password-form" >

	<div class="row" >
		
		<?php if($app->user->data->password){ ?>
		<div class="col-md-12 mb10" >
			
			<label class="form-label" ><?php echo translate("tr_3aade9cda6ac8bfed9edad80f01e9b17"); ?></label>
			<input type="text" name="old_pass" class="form-control" >
			<label class="form-label-error" data-name="old_pass"></label>

		</div>
		<?php } ?>

		<div class="col-md-12" >
			
			<label class="form-label" ><?php echo translate("tr_56786d1ef87790c1fc15cada02db97ae"); ?></label>
			<input type="text" name="new_pass" class="form-control" >
			<label class="form-label-error" data-name="new_pass"></label>

		</div>

	</div>

</form>

<div class="text-end mt-4">
	<button class="btn-custom button-color-scheme1 actionSettingsSaveEditProfilePassword"><?php echo translate("tr_74ea58b6a801f0dce4e5d34dbca034dc"); ?></button>
</div>
