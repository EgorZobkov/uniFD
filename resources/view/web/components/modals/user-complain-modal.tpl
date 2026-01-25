<h3 class="modal-title mb-3" > <strong><?php echo translate("tr_ba5ad8255a037748f918b5a512ad307c"); ?></strong> </h3>

<form class="modal-user-complain-form" >

	<p><?php echo translate("tr_c5f9d5595eb159c22ec1fed1bf239aa5"); ?></p>

	<textarea name="text" class="form-control-textarea" rows="5" ></textarea>

	<input type="hidden" name="id" value="<?php echo $data->id; ?>" >

</form>

<div class="text-end mt-4">
	<button class="btn-custom button-color-scheme1 actionSendUserComplaint"><?php echo translate("tr_6da0f0ae044012e784cdb53ab72a16f1"); ?></button>
</div>
