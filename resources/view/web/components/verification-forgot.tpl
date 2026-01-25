<div class="mb10" ><span class="auth-forgot-back auth-block-tab-back" ><i class="ti ti-arrow-left"></i></span></div>

<h4 class="mb20" > <strong><?php echo translate("tr_f490b86156968b0c43cbf28feefacd33"); ?></strong> </h4>

<?php if($data->phone){ ?>

<?php if($app->settings->phone_confirmation_service == "sms"){ ?>

<?php if($app->settings->integration_sms_service_data["method_confirmation"] == "by_call"){ ?>

	<p><?php echo translate("tr_2fef908acd6aa0263c29833ab5ddb2ac"); ?> <strong class="verify-call-phone-container" ></strong> </p>

<?php }else{ ?>

	<p><?php echo translate("tr_fef464bba618801c48ffecfbf7999fa9"); ?></p>

	<input type="text"  class="form-control" placeholder="<?php echo translate("tr_61112418e30deb702485741e154e7fc2"); ?>" name="forgot_verify_code">

	<label class="form-label-error" data-name="forgot_verify_code" ></label>

	<button class="btn-custom button-color-scheme1 buttonActionForgot mt25 width100" ><?php echo translate("tr_e9c3a648ce9e5dcf3c96940e682a72a2"); ?></button>

	<input type="hidden" name="forgot_verify_phone_contact" class="form-control" value="<?php echo $data->phone; ?>" >

<?php } ?>

<?php }else{ ?>

  <p><?php echo translate("tr_fa35bd6af583c14e4be2668064d0c4af"); ?></p>

  <input type="text"  class="form-control" placeholder="<?php echo translate("tr_61112418e30deb702485741e154e7fc2"); ?>" name="forgot_verify_code">

  <label class="form-label-error" data-name="forgot_verify_code" ></label>

  <button class="btn-custom button-color-scheme1 buttonActionForgot mt25 width100" ><?php echo translate("tr_e9c3a648ce9e5dcf3c96940e682a72a2"); ?></button>

  <input type="hidden" name="forgot_verify_phone_contact" class="form-control" value="<?php echo $data->phone; ?>" >

<?php } ?>

<?php }else{ ?>

  <p><?php echo translate("tr_fef464bba618801c48ffecfbf7999fa9"); ?></p>

  <input type="text"  class="form-control" placeholder="<?php echo translate("tr_61112418e30deb702485741e154e7fc2"); ?>" name="forgot_verify_code">

  <label class="form-label-error" data-name="forgot_verify_code" ></label>

  <button class="btn-custom button-color-scheme1 buttonActionForgot mt25 width100" ><?php echo translate("tr_e9c3a648ce9e5dcf3c96940e682a72a2"); ?></button>

  <input type="hidden" name="forgot_verify_email_contact" class="form-control" value="<?php echo $data->email; ?>" >

<?php } ?>