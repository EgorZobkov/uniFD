<h3 class="modal-title mb-3" > <strong><?php echo translate("tr_dcaa92e2ddc6a6305e3592910fee8df6"); ?></strong> </h3>

<?php echo $app->ui->outInputPaymentScore($data->payment_service); ?>

<?php if($data->payment_service->secure_description){ ?>

	<div class="mt15" ><?php echo $data->payment_service->secure_description; ?></div>

<?php } ?>

<div class="mt10" ><?php echo translate("tr_3e4fd1d258f005454c84d5ca0f5eee5c"); ?></div>

<input type="hidden" name="deal_order_id" value="<?php echo $data->order_id; ?>" >

<div class="text-end mt30">
	<button class="btn-custom button-color-scheme5 actionAddPaymentScoreOrderDeal" ><?php echo translate("tr_5eba283b81890978e67f4aa96dde1724"); ?></button>
</div>