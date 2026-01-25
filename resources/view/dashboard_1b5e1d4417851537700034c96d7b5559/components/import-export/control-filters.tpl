
<div class="mb-4">
  <h2 class="role-title font-weight-bold"><?php echo translate("tr_f7ac6fc5c5a477063add9c6d0701985d"); ?></h2>
</div>

<div class="mb-3">
  <div class="mb-1" ><label class="form-label"><?php echo translate("tr_7203f7a4ff564cb876e8db54c903dbfc"); ?></label></div>

  <select class="form-select form-filter-select selectpicker" name="filter[status]" >
    <option value="" ><?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?></option>
    <?php
      foreach ($app->component->import_export->allStatuses() as $key => $value){
        ?>
        <option value="<?php echo  $key; ?>" <?php if(compareValues($_POST['filter']['status'], $key)){ echo 'selected=""'; } ?> ><?php echo $value; ?></option>
        <?php
      }
    ?>
  </select>
</div>

<div class="mb-3">
  <div class="mb-1" ><label class="form-label"><?php echo translate("tr_50a761a11275b70272b97775ec641e61"); ?></label></div>

  <select class="form-select form-filter-select selectpicker" name="filter[action]" >
    <option value="" ><?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?></option>
    <option value="import" <?php if(compareValues($_POST['filter']['action'], 'import')){ echo 'selected=""'; } ?> ><?php echo translate("tr_d0cee49f306f8567c3eead3ff8b20265"); ?></option>
    <option value="export" <?php if(compareValues($_POST['filter']['action'], 'export')){ echo 'selected=""'; } ?> ><?php echo translate("tr_228fb446413f7db5925a4325fb22594a"); ?></option>
  </select>
</div>

<div class="text-end mt-4">
  <button class="btn btn-label-secondary waves-effect waves-light formControlFiltersClear"><?php echo translate("tr_02d901c131a1b8c2d1dd669e1f6c88a5"); ?></button>
  <button class="btn btn-primary waves-effect waves-light"><?php echo translate("tr_2cd844110d28e3bcfa13e55927643a88"); ?></button>
</div>