
<div class="mb-4">
  <h2 class="role-title font-weight-bold"><?php echo translate("tr_9d7cde6d42933676d76eea2352d74be1"); ?></h2>
</div>

<form class="formAddServiceTariff" >

<div class="row g-3" >

  <div class="col-12">

    <label class="switch">
      <input type="checkbox" class="switch-input" name="status" value="1" checked >
      <span class="switch-toggle-slider">
        <span class="switch-on"></span>
        <span class="switch-off"></span>
      </span>
      <span class="switch-label" ><?php echo translate("tr_047e75c532cfc056f40ed8e8ae5d62f5"); ?></span>
    </label>          

  </div>

  <div class="col-12">

    <label class="switch">
      <input type="checkbox" class="switch-input" name="recommended" value="1" >
      <span class="switch-toggle-slider">
        <span class="switch-on"></span>
        <span class="switch-off"></span>
      </span>
      <span class="switch-label" ><?php echo translate("tr_5337da67414717b997205b40ad3dcee8"); ?></span>
    </label>          

  </div>

  <div class="col-12">

    <label class="switch">
      <input type="checkbox" class="switch-input" name="onetime" value="1" >
      <span class="switch-toggle-slider">
        <span class="switch-on"></span>
        <span class="switch-off"></span>
      </span>
      <span class="switch-label" ><?php echo translate("tr_0cfb4a5046e46f0616ecfe929aacfb3d"); ?></span>
    </label>          

  </div>

  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_c318d6aece415f27decf21b272d94fa2"); ?></label>

    <?php echo $app->ui->managerFiles(["type"=>"images", "path"=>"images"]); ?>

  </div>

  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?><span class="form-label-importantly" >*</span></label>
    <input type="text" name="name" class="form-control" />
    <label class="form-label-error" data-name="name" ></label>
  </div>

  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_38ca0af80cd7bd241500e81ba2e6efff"); ?><span class="form-label-importantly" >*</span></label>
    <textarea name="text" class="form-control" rows="4" ></textarea>
    <label class="form-label-error" data-name="text" ></label>
  </div>

  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_682fa8dbadd54fda355b27f124938c93"); ?><span class="form-label-importantly" >*</span></label>

    <div class="row" >
      <div class="col-6" >
        
        <div class="input-group">
          <input type="number" class="form-control" name="price" >
          <span class="input-group-text"><?php echo $app->system->getDefaultCurrency()->symbol; ?></span>
        </div>
        <label class="form-label-error" data-name="price" ></label>

      </div>
    </div>

  </div>

  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_206948fb3ef1bd8a92285aee29a5b2f5"); ?></label>

    <div class="row" >
      <div class="col-6" >
        
        <div class="input-group">
          <input type="number" class="form-control" name="old_price" >
          <span class="input-group-text"><?php echo $app->system->getDefaultCurrency()->symbol; ?></span>
        </div>

      </div>
    </div>

    <label class="form-label-error" data-name="old_price" ></label>
  </div>

  <div class="col-12">

    <div class="row" >
      <div class="col-6" >
        
        <label class="switch">
          <input type="checkbox" class="switch-input" name="count_day_fixed" value="1" >
          <span class="switch-toggle-slider">
            <span class="switch-on"></span>
            <span class="switch-off"></span>
          </span>
          <span class="switch-label" ><?php echo translate("tr_7b238bb1cf1c11952e95abd83fc2f070"); ?></span>
        </label>

      </div>
    </div>          

  </div>

  <div class="container-services-fixed-count-day" >
    
    <div class="col-12">
      <label class="form-label" ><?php echo translate("tr_c01e0c8978d2e4f48dd7f70f62dbeef0"); ?><span class="form-label-importantly" >*</span></label>

      <div class="row" >
        <div class="col-6" >
          
          <div class="input-group">
            <input type="number" name="count_day" class="form-control" value="">  
            <span class="input-group-text"><?php echo translate("tr_c183655a02377815e6542875555b1340"); ?></span>
          </div>

        </div>
      </div>

      <label class="form-label-error" data-name="count_day" ></label>
    </div>

  </div>

  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_4e1a0e95e6e3f392f99811caba17f550"); ?><span class="form-label-importantly" >*</span></label>

    <div class="row" >
      <div class="col-6" >
  
        <select class="selectpicker" name="items[]" multiple title="<?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?>" >
           <?php echo $app->component->service_tariffs->outItemsOptions(); ?>
        </select>
  
      </div>
    </div>

    <label class="form-label-error" data-name="items" ></label>
  </div>

</div>

<div class="mt-4 d-grid gap-2 col-lg-6 mx-auto">
  <button class="btn btn-primary buttonAddServiceTariff"><?php echo translate("tr_5eba283b81890978e67f4aa96dde1724"); ?></button>
</div>

</form>
