
<div class="mb-4">
  <h2 class="role-title font-weight-bold"><?php echo translate("tr_bddc59cd280fcb5c36608fc92dc43bd0"); ?></h2>
</div>

<form class="row g-3 formAddFilter" >
  <div class="col-12">
      <label class="switch">
        <input type="checkbox" class="switch-input" name="status" value="1" checked="" >
        <span class="switch-toggle-slider">
          <span class="switch-on"></span>
          <span class="switch-off"></span>
        </span>
        <span class="switch-label" ><?php echo translate("tr_318150c53b2ec43a3ffef0f443596df1"); ?></span>
      </label>          
  </div>
  <div class="col-12">
      <label class="switch">
        <input type="checkbox" class="switch-input" name="required" value="1" >
        <span class="switch-toggle-slider">
          <span class="switch-on"></span>
          <span class="switch-off"></span>
        </span>
        <span class="switch-label" ><?php echo translate("tr_09c6a16fff548e3c3044c1f37fac7008"); ?></span>
      </label>          
  </div>
  <div class="col-12">
      <label class="switch">
        <input type="checkbox" class="switch-input" name="default_status" value="1" >
        <span class="switch-toggle-slider">
          <span class="switch-on"></span>
          <span class="switch-off"></span>
        </span>
        <span class="switch-label" ><?php echo translate("tr_d3b9e440144ac3cb320cf4627f2e0e90"); ?></span>
      </label>          
  </div>
  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?><span class="form-label-importantly" >*</span></label>
    <input type="text" name="name" class="form-control inTranslite" />
    <label class="form-label-error" data-name="name" ></label>
  </div>
  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_32df0c52cac96c2feb95654aab7f6e5a"); ?><span class="form-label-importantly" >*</span></label>
    <input type="text" name="alias" class="form-control outTranslite" />
    <label class="form-label-error" data-name="alias" ></label>
  </div>

  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_2c59adaafc2c86b362c2b67ee91ba5f6"); ?><span class="form-label-importantly" >*</span></label>
    <select name="view" class="form-select select-filters-type-view selectpicker" >
    <?php foreach($app->component->ads_filters->typesViews() as $key => $value){ ?>
    <option value="<?php echo $key; ?>" ><?php echo $value; ?></option>
    <?php } ?>
    </select>
    <label class="form-label-error" data-name="view" ></label>
  </div>

  <div class="col-12">
    <div class="alert alert-primary d-flex align-items-center mb-0" role="alert">
      <?php echo translate("tr_b9a491597150a95d492209bc4f5b33e2"); ?> 
    </div>
  </div>
  
  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_c95a1e2de00ee86634e177aecca00aed"); ?><span class="form-label-importantly" >*</span></label>
    <select name="categories[]" class="form-select selectpicker" data-live-search="true" title="<?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?>" multiple >
      <?php echo $app->component->ads_categories->getRecursionOptions(); ?>
    </select>
    <label class="form-label-error" data-name="categories" ></label>
  </div>

  <div class="filters-items-container" >

    <div class="col-12">
      <label class="form-label" ><?php echo translate("tr_49c862f17ce04dfa8a154826082b4b78"); ?></label>
      <select name="item_sorting" class="form-select selectpicker" >
        <option value="abs" ><?php echo translate("tr_c383bb6b9d6744a6f051271d2669672b"); ?></option>
        <option value="manual" ><?php echo translate("tr_5932e2e3b8563e1052cd12a78a5125f5"); ?></option>
      </select>
    </div>

    <div class="col-12 mt-3">
      <label class="form-label mb-2" ><?php echo translate("tr_93aa772cad1b410c5e4627d10ab076ce"); ?><span class="form-label-importantly" >*</span></label>

       <div class="filters-items-input-alert" >
        <div class="col-12 mb-2">
          <div class="alert alert-primary d-flex align-items-center mb-0" role="alert">
            <?php echo translate("tr_a5464ccd19519add97335927f96a85c8"); ?> 
          </div>
        </div>
       </div>

       <div>
         <span class="btn btn-label-primary btn-sm waves-effect btn-sm buttonAddItemFilter"><?php echo translate("tr_5eba283b81890978e67f4aa96dde1724"); ?></span>
         <span class="btn btn-label-secondary btn-sm waves-effect btn-sm buttonAddListItemsFilter openModal" data-modal-id="addListItemsFilterModal" ><?php echo translate("tr_f3471100f330fafd24de1e453580bb97"); ?></span>
       </div>

       <label class="form-label-error" data-name="items" ></label>

       <div class="filter-items-container mt-3" id="add-filter-items-container" ></div>

    </div>

  </div>

  <div class="mt-4 d-grid gap-2 col-lg-6 mx-auto">
    <button class="btn btn-primary buttonAddFilter"><?php echo translate("tr_5eba283b81890978e67f4aa96dde1724"); ?></button>
  </div>

</form>