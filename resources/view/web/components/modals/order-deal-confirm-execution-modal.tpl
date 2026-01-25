<h3 class="modal-title mb-3" > <strong><?php echo translate("tr_5b8a6effa132d9be7fa4ff73355813fa"); ?></strong> </h3>

<div><?php echo translate("tr_ad7d90c8e14e773f6cb8ecc902c769a4"); ?></div>

<?php
if($data->item->category->type_goods == "physical_goods"){
    if($data->delivery_status){
        ?>
		<div class="text-end mt30">
			<button class="btn-custom button-color-scheme5 actionChangeStatusOrderDeal" data-status="confirmed_send_shipment" data-id="<?php echo $data->order_id; ?>" ><?php echo translate("tr_e2603bcce79e0b861ac1f1bd464de2b6"); ?></button>
		</div>
        <?php
    }else{
        ?>
		<div class="text-end mt30">
			<button class="btn-custom button-color-scheme5 actionChangeStatusOrderDeal" data-status="confirmed_transfer" data-id="<?php echo $data->order_id; ?>" ><?php echo translate("tr_e2603bcce79e0b861ac1f1bd464de2b6"); ?></button>
		</div>
        <?php                        
    }
}elseif($data->item->category->type_goods == "electronic_goods"){
    ?>
    
    <?php
}elseif($data->item->category->type_goods == "services"){
    ?>
	<div class="text-end mt30">
		<button class="btn-custom button-color-scheme5 actionChangeStatusOrderDeal" data-status="confirmed_completion_service" data-id="<?php echo $data->order_id; ?>" ><?php echo translate("tr_e2603bcce79e0b861ac1f1bd464de2b6"); ?></button>
	</div>
    <?php
}
?>