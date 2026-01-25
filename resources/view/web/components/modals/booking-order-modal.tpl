
<?php
$ad = $app->component->ads->getAd($data->id);
?>

<?php
if($app->component->ads_categories->categories[$ad->category_id]["booking_action"] == "booking"){
?>
<h3 class="modal-title mb-3" > <strong><?php echo translate("tr_543c872407d0aa834e734f713afdcf33"); ?></strong> </h3>
<?php }else{ ?>
<h3 class="modal-title mb-3" > <strong><?php echo translate("tr_9f0bba0dacad1eacd3a9fcd80e8bd00a"); ?></strong> </h3>
<?php
}
?>

<div><?php echo translate("tr_91b2417d13d076fabf08a2684f817476"); ?> <?php echo date("d.m", strtotime($data->date_start)); ?> <?php echo translate("tr_22d57c9399ca22ffbe414f057e8ff6dc"); ?> <?php echo date("d.m", strtotime($data->date_end)); ?>, <?php echo $data->count_days; ?> <?php echo $app->component->ads->outBookingEndingWord($data->count_days, $ad->category_id); ?></div>

<form class="modal-booking-order-form mt20" >

	<div class="row" >
		
		<div class="col-lg-7" >

			<div class="row" >
				
				<div class="col-12" >
					<span><?php echo translate("tr_d38d6d925c80a2267031f3f03d0a9070"); ?></span>
					<input type="text" name="name" class="form-control mt5" value="<?php echo $app->user->data->name; ?>" >
					<label class="form-label-error" data-name="name"></label>
				</div>

				<div class="col-12 mt10" >
					<span><?php echo translate("tr_9fdc3f131f7923e7bdd4ec60d465ae87"); ?></span>
					<input type="text" name="phone" class="form-control mt5" value="<?php echo $app->user->data->phone; ?>" >
					<label class="form-label-error" data-name="phone"></label>
				</div>

				<div class="col-12 mt10" >
					<span><?php echo translate("tr_ce8ae9da5b7cd6c3df2929543a9af92d"); ?></span>
					<input type="text" name="email" class="form-control mt5" value="<?php echo $app->user->data->email; ?>" >
					<label class="form-label-error" data-name="email"></label>
				</div>

				<?php if($app->component->ads_categories->categories[$ad->category_id]["booking_action"] == "booking"){ ?>

				<div class="col-12 mt10" >
					<span><?php echo translate("tr_1f064117dd26241fc09adf91f989e667"); ?></span>
					<input type="time" name="time" class="form-control mt5" >
					<label class="form-label-error" data-name="time"></label>
				</div>

				<div class="col-12 mt10" >
					<span><?php echo translate("tr_29fe0bba61116ffa9b5abdbbcbdd01a5"); ?></span>
					<input type="text" name="guests" class="form-control mt5" >
					<label class="form-label-error" data-name="guests"></label>
				</div>

				<?php }else{ ?>

				<div class="col-12 mt10" >
					<span><?php echo translate("tr_5cbc38f12cb7c6d03d13d370fd56ccea"); ?></span>
					<input type="time" name="time" class="form-control mt5" >
					<label class="form-label-error" data-name="time"></label>
				</div>

				<?php } ?>

			</div>

			<h5 class="mt20" > <strong><?php echo translate("tr_e3c1f39b86bb7162bddb548e2cfd6077"); ?></strong> </h5>

			<p><?php echo translate("tr_4254f0425c694161ed45e29470fb1bca"); ?></p>

			<ul class="list-points modal-booking-order-prices-container">
			  <li>
			    <span class="list-points-title"><?php echo translate("tr_bd4cff11ef068d53f12becf7fc98f517"); ?></span>
			    <span class="list-points-chapter"><?php echo $app->system->amount($data->total_price); ?></span>
			  </li>
			  <?php if(!$ad->booking->full_payment_status){ ?>
			  <li>
			    <span class="list-points-title"><?php echo translate("tr_f1d0076b2267f5559b482d28106b33a1"); ?></span>
			    <span class="list-points-chapter"><?php echo $app->system->amount(calculatePercent($data->total_price, $ad->booking->prepayment_percent)); ?></span>
			  </li>	
			  <?php } ?>
			  <?php if($ad->booking->deposit_status){ ?>		  
			  <li>
			    <span class="list-points-title"><?php echo translate("tr_c7bb13829f0c52a28e01bedd29bdfe0d"); ?></span>
			    <span class="list-points-chapter"><?php echo $app->system->amount($ad->booking->deposit_amount); ?></span>
			  </li>
			  <?php } ?>
			  <?php if(!$ad->booking->full_payment_status){ ?>
			  <li>
			    <span class="list-points-title"><?php echo translate("tr_9a6054b1258786529c4dd909ec032383"); ?></span>
			    <span class="list-points-chapter"><?php echo $app->system->amount($data->total_price-calculatePercent($data->total_price, $ad->booking->prepayment_percent)); ?></span>
			  </li>
			  <?php } ?>
			</ul>

			<?php if($ad->booking->additional_services){ ?>
			<h5 class="mt20" > <strong><?php echo translate("tr_2f65331185abdf3f4a7ac9f810ebbcb2"); ?></strong> </h5>

			<div class="modal-booking-order-additional-services-container" >
				
				<?php
				foreach ($ad->booking->additional_services as $key => $value) {
					?>
					<div class="modal-booking-order-additional-services-item" >
						
						<div class="row" >
							<div class="col-lg-9 col-8" >
				                <label class="switch">
				                  <input type="checkbox" class="switch-input" name="order_additional_services[<?php echo $key; ?>]" value="1" >
				                  <span class="switch-toggle-slider">
				                    <span class="switch-on"></span>
				                    <span class="switch-off"></span>
				                  </span>
				                  <span class="switch-label"><?php echo $value["name"]; ?></span>
				                </label>							
							</div>
							<div class="col-lg-3 col-4 text-end" >
								<?php echo $app->system->amount($value["price"]); ?>
							</div>
						</div>

					</div>
					<?php
				}
				?>

			</div>
			<?php } ?>

		</div>

		<div class="col-lg-5" >

			<div class="modal-booking-order-info-container" >
				
				<?php if($app->component->ads_categories->categories[$ad->category_id]["booking_action"] == "booking"){ ?>
				<div>
					<i class="ti ti-thumb-up"></i> <br> <?php echo translate("tr_2e9af366754ea01cfb14ae7838c13c92"); ?>
				</div>
				<?php } ?>

				<div>
					<i class="ti ti-thumb-up"></i> <br> <?php echo translate("tr_3182577c6401ade8fdb11bdfb7c53d23"); ?>
				</div>

			</div>

		</div>

	</div>

	<input type="hidden" name="id" value="<?php echo $data->id; ?>" >
	<input type="hidden" name="date_start" value="<?php echo $data->date_start; ?>" >
	<input type="hidden" name="date_end" value="<?php echo $data->date_end; ?>" >

	<div class="mt30">
		<button class="btn-custom button-color-scheme1 actionBookingSendOrder"><?php echo translate("tr_7094b4a52292700eb58ee4c231615757"); ?></button>
		<div class="mt10" > <small><?php echo translate("tr_92a514364b7f3f9a003cfa7c92691108"); ?></small> </div>
	</div>

</form>
