<h3 class="modal-title mb-3" > <strong><?php echo translate("tr_dcaa92e2ddc6a6305e3592910fee8df6"); ?></strong> </h3>

<?php
	$payment = $app->component->transaction->getServiceSecureDeal();
	echo $app->ui->outInputPaymentScore($payment);
?>

<?php if($payment->secure_description){ ?>

	<div class="mt15" ><?php echo $payment->secure_description; ?></div>

<?php } ?>

<div class="text-end mt30">
	<button class="btn-custom button-color-scheme5 actionAddPaymentScore" ><?php echo translate("tr_5eba283b81890978e67f4aa96dde1724"); ?></button>
</div>