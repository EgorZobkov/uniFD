
<div class="mb-4">
  <h2 class="role-title font-weight-bold"><?php echo translate("tr_599fc78ac9182c464ce965d1b1094d6c"); ?></h2>
</div>

<form class="row g-3 formAddTask" >

  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?><span class="form-label-importantly" >*</span></label>
    <input type="text" name="name" class="form-control" />
    <label class="form-label-error" data-name="name" ></label>
  </div>

  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_0f3bd19339feee5b5f8c47d0fcac3044"); ?><span class="form-label-importantly" >*</span></label>
    <select name="table" class="form-select selectpicker" >
      <option value="" ><?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?></option>
      <?php foreach ($app->component->import_export->availableTables() as $key => $value){ ?>
        <option value="<?php echo $key; ?>" ><?php echo $value; ?></option>
      <?php } ?>
    </select>
    <label class="form-label-error" data-name="table" ></label>
  </div>

  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_50a761a11275b70272b97775ec641e61"); ?><span class="form-label-importantly" >*</span></label>
    <select name="action" class="form-select selectpicker import-export-select-action" >
      <option value="" ><?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?></option>
      <option value="import" ><?php echo translate("tr_d0cee49f306f8567c3eead3ff8b20265"); ?></option>
      <option value="export" ><?php echo translate("tr_228fb446413f7db5925a4325fb22594a"); ?></option>
    </select>
    <label class="form-label-error" data-name="action" ></label>
  </div>

  <div class="import-export-container-source-change" >
    <div class="col-12">
      <label class="form-label" ><?php echo translate("tr_7a1120532aa97273a04050fa34e867ec"); ?><span class="form-label-importantly" >*</span></label>
      <select name="source" class="form-select selectpicker import-export-select-source" >
        <option value="" ><?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?></option>
        <option value="file" ><?php echo translate("tr_5c3ba2f364f776122498b08e2220968a"); ?></option>
        <option value="link" ><?php echo translate("tr_611f7eb6df68a24f4481334e1f105bd0"); ?></option>
      </select>
      <label class="form-label-error" data-name="source" ></label>
    </div>
  </div>

  <div class="import-export-container-link-file" >
    <div class="col-12">
      <label class="form-label" ><?php echo translate("tr_611f7eb6df68a24f4481334e1f105bd0"); ?><span class="form-label-importantly" >*</span></label>
      <input type="text" name="link_file" class="form-control" />
      <label class="form-label-error" data-name="link_file" ></label>
    </div>
  </div>

  <div class="import-export-container-import-options" >
    <div class="col-12">
        <label class="form-label" ><?php echo translate("tr_a2502c6b42b5455e549cb1bca021e0a9"); ?><span class="form-label-importantly" >*</span></label>
        <select name="link_file_format" class="form-select selectpicker" >
          <option value="" ><?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?></option>
          <option value="csv" >csv</option>
        </select>
        <label class="form-label-error" data-name="link_file_format" ></label>
    </div>
  </div>

  <div class="import-export-container-file-change" >
    <div class="col-12">
      <label class="form-label" ><?php echo translate("tr_8c548c849059112f59f0c962c23ad9bd"); ?></label>
      <input type="file" name="file" class="form-control" />
      <label class="form-label-error" data-name="file" ></label>
    </div>
  </div>

  <div class="import-export-container-action-export" >
    <div class="col-12">
      <label class="form-label" ><?php echo translate("tr_7d8152a0987d5755bccb256491f2f40b"); ?><span class="form-label-importantly" >*</span></label>
      <select name="export_format" class="form-select selectpicker" >
        <option value="xlsx" selected >xlsx</option>
        <option value="csv" >csv</option>
      </select>
    </div>          
  </div>

  <div class="mt-4 d-grid gap-2 col-lg-6 mx-auto">
    <button class="btn btn-primary buttonAddTask"><?php echo translate("tr_5eba283b81890978e67f4aa96dde1724"); ?></button>
  </div>

</form>