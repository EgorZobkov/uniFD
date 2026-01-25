<h3 class="modal-title mb-3" > <strong><?php echo translate("tr_66b19874aa1bb6b1b565d42d54b0dee2"); ?></strong> </h3>

<?php if($data->phone){ ?>

<?php if($app->settings->integration_sms_service_data["method_confirmation"] == "by_call"){ ?>

	<p><?php echo translate("tr_2fef908acd6aa0263c29833ab5ddb2ac"); ?> <strong class="verify-call-phone-container" ></strong> </p>

<?php }else{ ?>

	<p><?php echo translate("tr_3b054f98922602d314708484c7a482b8"); ?></p>

	<input type="text" name="verify_code_contact" class="form-control" value="" >
	<label class="verify-code-label-error"></label>

	<div class="text-end mt-4">
		<button class="btn-custom button-color-scheme1 actionCheckVerifyCodeContact"><?php echo translate("tr_e2603bcce79e0b861ac1f1bd464de2b6"); ?></button>
	</div>

	<input type="hidden" name="verify_phone_contact" class="form-control" value="<?php echo $data->phone; ?>" >

<?php } ?>

<?php }else{ ?>

	<p><?php echo translate("tr_3b054f98922602d314708484c7a482b8"); ?></p>

	<input type="text" name="verify_code_contact" class="form-control" value="" >
	<label class="verify-code-label-error"></label>

	<div class="text-end mt-4">
		<button class="btn-custom button-color-scheme1 actionCheckVerifyCodeContact"><?php echo translate("tr_e2603bcce79e0b861ac1f1bd464de2b6"); ?></button>
	</div>

	<input type="hidden" name="verify_email_contact" class="form-control" value="<?php echo $data->email; ?>" >

<?php } ?>
