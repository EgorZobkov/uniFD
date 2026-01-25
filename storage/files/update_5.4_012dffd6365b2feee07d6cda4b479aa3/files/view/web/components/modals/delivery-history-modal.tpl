<h3 class="modal-title mb-3" > <strong><?php echo translate("tr_b8a37dd8c44d4f0452cddd609dd614e9"); ?></strong> </h3>

<?php
echo $app->component->delivery->outHistoryData($data->order_id, $app->user->data->id);
?>