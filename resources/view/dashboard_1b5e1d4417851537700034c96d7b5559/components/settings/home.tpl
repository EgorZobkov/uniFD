<div class="sticky-wrapper-container" >

<div class="sticky-wrapper-actions">
  <button class="btn btn-primary waves-effect waves-light buttonSaveSettings" data-route-name="dashboard-settings-home-save" ><?php echo translate("tr_74ea58b6a801f0dce4e5d34dbca034dc"); ?></button>
</div>

<div class="card mb-4">

<div class="card-header">
  <h3 class="card-title m-0"><?php echo translate("tr_cecdd096144eccaeb28c4c2bc233ed63"); ?></h3>
</div>
<div class="card-body">

  <div class="row mb-3 g-3">

    <div class="col-12">

      <label class="form-label mb-2" ><?php echo translate("tr_6926e02be4135897ae84b36941554684"); ?></label>

      <div class="alert alert-primary d-flex align-items-center mb-2" role="alert">
        <?php echo translate("tr_507a0e8dadb36f7e0ca27cc038d50c6a"); ?>
      </div>

      <div class="row" >
        <div class="col-12 col-md-6" >

          <select name="frontend_home_slider_categories_ids[]" multiple class="form-select selectpicker" title="<?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?>" >
            <option value="" ><?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?></option>
            <?php echo $app->component->ads_categories->selectedIds($app->settings->frontend_home_slider_categories_ids)->getRecursionOptions(); ?>
          </select>          

        </div>
      </div>

    </div>

    <div class="col-12">

      <label class="form-label mb-2" ><?php echo translate("tr_e1228efa56c6d4ecd5b146dc12b11e69"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >
          
          <div class="settings-home-widgets-container" id="settings-home-widgets-container" >
            <?php echo $app->component->settings->outFrontendHomeWidgetsItem(); ?>
          </div>

        </div>
      </div>

    </div>

    <div class="col-12">

      <label class="form-label mb-2" ><?php echo translate("tr_342a6611d9bae58f896d18c53683b85a"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >

          <input type="number" name="out_default_count_items_home" class="form-control" value="<?php echo $app->settings->out_default_count_items_home; ?>" >

        </div>
      </div>

    </div>

  </div>

</div>

</div>

</div>