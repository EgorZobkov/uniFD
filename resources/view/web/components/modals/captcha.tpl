
<h4 class="modal-title mb-3 mt0" > <strong><?php echo translate("tr_af1289744a307b5a16d3efbb02d9549a"); ?></strong> </h4>

<div class="row">
<div class="col">

  <div class="mb-2" >
    <div class="captchaModalImageContainer" ></div>
  </div>

  <label class="form-label label-bold"><?php echo translate("tr_f7b16c743c21082261be47d39374f46a"); ?></label>
  
  <input type="text" class="form-control" name="captchaModalInputCode" >
  <input type="hidden" name="captchaModalId" value="<?php echo $data->captcha_id; ?>" >

</div>
</div>

<div class="text-end mt-4" >
	<button  class="btn-custom button-color-scheme1 captchaModalVerifyCode" ><?php echo translate("tr_e2603bcce79e0b861ac1f1bd464de2b6"); ?></button>
</div>


