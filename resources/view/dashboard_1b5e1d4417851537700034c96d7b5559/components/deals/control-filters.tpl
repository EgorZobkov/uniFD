
<div class="mb-4">
  <h2 class="role-title font-weight-bold"><?php echo translate("tr_f7ac6fc5c5a477063add9c6d0701985d"); ?></h2>
</div>

<div class="mb-3">
  <div class="mb-1" ><label class="form-label"><?php echo translate("tr_7203f7a4ff564cb876e8db54c903dbfc"); ?></label></div>

  <select class="form-select form-filter-select selectpicker" name="filter[status]" >
    <option value="" ><?php echo translate("tr_ac1bbd60d1000d2fb97af5367b2e73d4"); ?></option>
    <?php 
      foreach ($app->component->transaction->statusesDeal() as $key => $value){
        ?>
        <option value="<?php echo $value["code"]; ?>" <?php if(compareValues($_POST['filter']['status'], $value["code"])){ echo 'selected=""'; } ?> ><?php echo $value["name"]; ?></option>
        <?php
      }
    ?>
  </select>
</div>
<div class="mb-3">
  <div class="row" >
     <div class="col-12 mb-1" ><label class="form-label"><?php echo translate("tr_9eb6a1f1530b6bcc95d7d86bf42526c9"); ?></label></div>
     <div class="col-12 col-md-6" >
        <input type="date" class="form-control form-filter-input mb-2" name="filter[date_start]" value="<?php echo $_POST['filter']['date_start']; ?>" >
     </div>
    <div class="col-12 col-md-6" >
        <input type="date" class="form-control form-filter-input mb-2" name="filter[date_end]" value="<?php echo $_POST['filter']['date_end']; ?>" >
     </div>
  </div>
</div>

<div class="text-end mt-4">
  <button class="btn btn-label-secondary waves-effect waves-light formControlFiltersClear me-1"><?php echo translate("tr_02d901c131a1b8c2d1dd669e1f6c88a5"); ?></button>
  <button class="btn btn-primary waves-effect waves-light"><?php echo translate("tr_2cd844110d28e3bcfa13e55927643a88"); ?></button>
</div>