
<div class="mb-4">
  <h2 class="role-title font-weight-bold"><?php echo translate("tr_f7ac6fc5c5a477063add9c6d0701985d"); ?></h2>
</div>

<div class="mb-2">
  <div class="mb-1" ><label class="form-label"><?php echo translate("tr_c4666dd6229b9f6cdc544a0b5ab4cb0a"); ?></label></div>

  <select class="form-select form-filter-select selectpicker" name="filter[action_code]" >
    <option value="" ><?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?></option>
    <?php 
      foreach ($app->component->transaction->actionsCode() as $key => $value){
        ?>
        <option value="<?php echo $value["code"]; ?>" <?php if(compareValues($_POST['filter']['action_code'], $value["code"])){ echo 'selected=""'; } ?> ><?php echo $value["name"]; ?></option>
        <?php
      }
    ?>
  </select>
</div>
<div class="mb-2">
  <div class="mb-1" ><label class="form-label"><?php echo translate("tr_19b244e68f789a1ca79e9c9f44e7c16d"); ?></label></div>

  <select class="form-select form-filter-select selectpicker" name="filter[status_payment]" >
    <option value="" ><?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?></option>
    <option value="paid" <?php if(compareValues($_POST['filter']['status_payment'], 'paid')){ echo 'selected=""'; } ?> ><?php echo translate("tr_6d8c0850821a806217ea219a53500d7e"); ?></option>
    <option value="notpaid" <?php if(compareValues($_POST['filter']['status_payment'], 'notpaid')){ echo 'selected=""'; } ?> ><?php echo translate("tr_750d081f2ebe214679c1c209fb550712"); ?></option>
  </select>
</div>
<div class="mb-3">
  <div class="row" >
     <div class="col-12 mb-1" ><label class="form-label"><?php echo translate("tr_e312c6ffa3dc0cd785edfbe3f94caa54"); ?></label></div>
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