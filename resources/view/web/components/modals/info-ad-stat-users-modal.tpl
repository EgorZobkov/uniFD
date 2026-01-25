
<?php if($data->view == "cart"){ ?>
<h3 class="modal-title mb-3" > <strong><?php echo translate("tr_6a904d70a0d502e05b5de3b4170738fe"); ?></strong> </h3>
<?php }elseif($data->view == "favorite"){ ?>
<h3 class="modal-title mb-3" > <strong><?php echo translate("tr_039655cd90b7a55151dfed2054b24fed"); ?></strong> </h3>
<?php }elseif($data->view == "contacts"){ ?>
<h3 class="modal-title mb-3" > <strong><?php echo translate("tr_cc7158dce083ce9fa040443223868d51"); ?></strong> </h3>
<?php } ?>

<?php 
if(!$app->user->data->service_tariff->items->extra_statistics){ 
?>

<p><?php echo translate("tr_b5e350683399ad0bc4921dae3f02d5da"); ?></p>

<div class="text-end mt-4">
	<button class="btn-custom button-color-scheme1" data-bs-dismiss="modal" ><?php echo translate("tr_96dfcf5d9a4882379041072245f3bc17"); ?></button>
</div>

<?php }else{ ?>

<div class="ad-users-info-stat-modal" >
	<?php echo $app->component->ads->outUsersExtraStat($data->id, $data->view); ?>
</div>

<?php
}
?>
