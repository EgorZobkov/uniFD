<h3 class="modal-title mb-3" > <strong><?php echo translate("tr_f7ac6fc5c5a477063add9c6d0701985d"); ?></strong> </h3>

<form class="params-form-modal live-filters" >

<?php echo $app->component->ads_filters->outFiltersByModal($data->filters, $data->category_id); ?>

<div class="text-end mt-4">
	<button class="btn-custom button-color-scheme1 actionApplyLiveFilters"><?php echo translate("tr_130bbbc068f7a58df5d47f6587ff4b43"); ?></button>
</div>

</form>