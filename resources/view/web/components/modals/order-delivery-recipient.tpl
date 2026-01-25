<h3 class="modal-title mb-3" > <strong><?php echo translate("tr_e3956f167dd00ecf8648f41119bd5a3e"); ?></strong> </h3>

<form class="order-buy-delivery-recipient-form" >

      <div class="row" >

        <div class="col-lg-12 mb10" >
          <input type="text" class="form-control" name="delivery_recipient_name" placeholder="<?php echo translate("tr_d38d6d925c80a2267031f3f03d0a9070"); ?>" value="<?php echo $app->user->data->delivery_data->name; ?>" >
          <label class="form-label-error" data-name="delivery_recipient_name"></label>
        </div>

        <div class="col-lg-12 mb10" >
          <input type="text" class="form-control" name="delivery_recipient_surname" placeholder="<?php echo translate("tr_a7b7df8362d60258a7208dde0a392643"); ?>" value="<?php echo $app->user->data->delivery_data->surname; ?>" >
          <label class="form-label-error" data-name="delivery_recipient_surname"></label>
        </div>

        <div class="col-lg-12 mb10" >
          <input type="text" class="form-control" name="delivery_recipient_patronymic" placeholder="<?php echo translate("tr_62899cefc8855544723baae88cbfce9c"); ?>" value="<?php echo $app->user->data->delivery_data->patronymic; ?>" >
          <label class="form-label-error" data-name="delivery_recipient_patronymic"></label>
        </div>

        <div class="col-lg-12 mb10" >
          <input type="text" class="form-control" name="delivery_recipient_phone" placeholder="<?php echo translate("tr_2928e19c705428df3c9f1e6d4ea8042f"); ?>" value="<?php echo decrypt($app->user->data->delivery_data->phone); ?>" >
          <label class="form-label-error" data-name="delivery_recipient_phone"></label>
        </div>

        <div class="col-lg-12" >
          <input type="text" class="form-control" name="delivery_recipient_email" placeholder="<?php echo translate("tr_7a176a6a64c888d6496097dc0440cbc3"); ?>" value="<?php echo decrypt($app->user->data->delivery_data->email); ?>" >
          <label class="form-label-error" data-name="delivery_recipient_email"></label>
        </div>

      </div>

	  <div class="text-end mt-4">
		  <button class="btn-custom button-color-scheme1 actionSaveDeliveryRecipient"><?php echo translate("tr_74ea58b6a801f0dce4e5d34dbca034dc"); ?></button>
	  </div>

</form>
