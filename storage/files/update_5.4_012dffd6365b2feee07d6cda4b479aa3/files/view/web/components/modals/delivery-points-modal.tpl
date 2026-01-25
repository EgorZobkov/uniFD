<h3 class="modal-title mb-3" > <strong><?php echo translate("tr_ab4040809c63f9356302ecd54e2e0151"); ?></strong> </h3>

<?php
echo $app->component->geo->outMapDeliveryPoints($data->id, (array)$data);
?>

<div class="delivery-points-map-container-modal" >

<div class="delivery-points-map-sidebar-modal" ></div>

<div class="delivery-points-map-modal initMapDeliveryPoints" id="initMapDeliveryPoints" >
</div>

</div>


