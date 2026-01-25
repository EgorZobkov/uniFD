
<div class="mb-4">
  <h2 class="role-title font-weight-bold"><?php echo translate("tr_f7ac6fc5c5a477063add9c6d0701985d"); ?></h2>
</div>

<div class="mb-3">
  <div class="mb-1" ><label class="form-label"><?php echo translate("tr_7203f7a4ff564cb876e8db54c903dbfc"); ?></label></div>

  <select class="form-select form-filter-select selectpicker" name="filter[status]" >
    <option value="" ><?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?></option>
    <?php foreach ($app->component->ads->allStatuses() as $key => $value){ ?>
    <option value="<?php echo $value['status']; ?>" <?php if(compareValues($_POST['filter']['status'], $value['status'])){ echo 'selected=""';  } ?> ><?php echo $value['name']; ?></option>
    <?php } ?>
  </select>
</div>
<div class="mb-3">
  <div class="mb-1" ><label class="form-label"><?php echo translate("tr_6926e02be4135897ae84b36941554684"); ?></label></div>

  <select class="form-select form-filter-select selectpicker" data-live-search="true" name="filter[category_id]" >
    <option value="" ><?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?></option>
    <?php echo $app->component->ads_categories->selectedIds($_POST['filter']['category_id'])->getRecursionOptions() ?>
  </select>
</div>

<div class="mb-3">
  <div class="mb-1" ><label class="form-label"><?php echo translate("tr_d0cee49f306f8567c3eead3ff8b20265"); ?></label></div>

  <select class="form-select form-filter-select selectpicker" name="filter[import_id]" >
    <option value="" ><?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?></option>
    <?php echo $app->component->import_export->getImportsOptions($_POST['filter']['import_id']) ?>
  </select>
</div>

<div class="mb-3">
  <label class="switch">
    <input type="checkbox" class="switch-input form-filter-check" name="filter[today]" <?php if($_POST['filter']['today']){ echo 'checked=""'; } ?> value="1" >
    <span class="switch-toggle-slider">
      <span class="switch-on"></span>
      <span class="switch-off"></span>
    </span>
    <span class="switch-label"><?php echo translate("tr_71497f1fd38776c1ddbe4c629d361a52"); ?></span>
  </label>                      
</div>
<div class="mb-3">
  <div class="row" >
     <div class="col-12 mb-1" ><label class="form-label"><?php echo translate("tr_c497fd1979913cf9671b3341f64865b7"); ?></label></div>
     <div class="col-12 col-md-6" >
        <input type="date" class="form-control form-filter-input mb-2" name="filter[date_start]" value="<?php echo $_POST['filter']['date_start']; ?>" >
     </div>
    <div class="col-12 col-md-6" >
        <input type="date" class="form-control form-filter-input mb-2" name="filter[date_end]" value="<?php echo $_POST['filter']['date_end']; ?>" >
     </div>
  </div>
</div>

<div class="text-end mt-4">
  <button class="btn btn-label-secondary waves-effect waves-light formControlFiltersClear"><?php echo translate("tr_02d901c131a1b8c2d1dd669e1f6c88a5"); ?></button>
  <button class="btn btn-primary waves-effect waves-light"><?php echo translate("tr_2cd844110d28e3bcfa13e55927643a88"); ?></button>
</div>