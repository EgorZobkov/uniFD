<h3 class="modal-title mb-3" > <strong><?php echo translate("tr_28b76906f14ac4b4d584dfb15226b05a"); ?></strong> </h3>

<form class="profile-statistics-dates-form" >

<div class="row" >
	<div class="col-lg-6 col-6" >
		<input type="date" name="date_start" class="form-control" value="<?php echo $data->date_start; ?>" >
	</div>
	<div class="col-lg-6 col-6" >
		<input type="date" name="date_end" class="form-control" value="<?php echo $data->date_end; ?>" >
	</div>
</div>

<input type="hidden" name="item_id" value="<?php echo $data->item_id; ?>" >

<div class="text-end mt-4">
	<?php if($data->date_start || $data->date_end){ ?>
	<button class="btn-custom button-color-scheme2 actionClearProfileStatisticsDates" ><?php echo translate("tr_02d901c131a1b8c2d1dd669e1f6c88a5"); ?></button>
	<?php } ?>
	<button class="btn-custom button-color-scheme1 actionAcceptProfileStatisticsDates" ><?php echo translate("tr_2cd844110d28e3bcfa13e55927643a88"); ?></button>
</div>

</form>
