<h3 class="modal-title mb-3" > <strong><?php echo translate("tr_294f68362eb5d1b8990dc940145801f7"); ?></strong> </h3>

<form class="order-deal-dispute-form" >

	<textarea class="form-control-textarea" rows="5" placeholder="<?php echo translate("tr_5984bb35b753f52e42fd44f94cbcfa7c"); ?>" name="text" ></textarea>

	<small><?php echo translate("tr_36f140d1f39f4adaf01fda6c76364c3e"); ?></small>

	<div class="mt15 mb10" >
		<span class="btn-custom-mini button-color-scheme1 uniAttachFilesChange" data-accept="images" data-upload-route="order-deal-dispute-upload-attach" data-parent-container="order-deal-dispute-form"><?php echo translate("tr_6c683344169fc61c019fc34917e9972c"); ?></span>
	</div>

	<div class="uni-attach-files-container"></div>

	<small><?php echo translate("tr_74dea07cfdb735bcbf13684da8cc0d2f"); ?></small>

	<input type="hidden" name="order_id" value="<?php echo $data->order_id; ?>" >

</form>

<div class="text-end mt30">
	<button class="btn-custom button-color-scheme5 actionOpenDisputeOrderDeal" ><?php echo translate("tr_0285fcf16e0e6fc509ba686b22ba3c44"); ?></button>
</div>