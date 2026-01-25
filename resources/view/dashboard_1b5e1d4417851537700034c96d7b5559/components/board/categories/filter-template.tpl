
<div class="mb-4">
  <h2 class="role-title font-weight-bold"><?php echo translate("tr_f7ac6fc5c5a477063add9c6d0701985d"); ?></h2>
</div>

<div class="row g-3" >

  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_db3825af7f18cc7cf700984b9ca5bd4a"); ?></label>
    <select class="form-select selectpicker modal-filter-template-change-category-id" >
      <option value="" ><?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?></option>
      <?php echo $app->component->ads_categories->getRecursionOptions(); ?>
    </select>
  </div>

  <div class="col-12">
    <div class="modal-filter-template-items-list" ></div>
  </div>
  
</div>