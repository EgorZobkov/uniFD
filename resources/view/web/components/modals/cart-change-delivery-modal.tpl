<h3 class="modal-title mb-3" > <strong><?php echo translate("tr_01a4d5c77086ce7c8b950ca237510b93"); ?></strong> </h3>

<div class="order-buy-card-delivery" >

<div class="order-buy-card-delivery-item actionCartChangeDelivery" data-id="0" data-item-id="<?php echo $data->id; ?>" data-name="<?php echo translate("tr_85e7df6caf5315c7c987f999f5e31b16"); ?>" >
    <span> <strong><?php echo translate("tr_5d14f6aabcfceaf70a9afe00b38103e9"); ?></strong> </span>
    <span><?php echo translate("tr_6d96fd666927fc73d925d2113fa8053d"); ?></span>
</div>

<?php
echo $app->component->delivery->outDeliveryListInCart($data->id);
?>

</div>