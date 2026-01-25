<div class="mb-4">
  <h2 class="role-title font-weight-bold"><?php echo translate("tr_67d124a4bcbcffd664dc275f1f91e1e4"); ?></h2>
</div>

<form class="row g-3 formAddChannel" >

  <div class="col-12">
    <div>
      <label class="switch">
        <input type="checkbox" class="switch-input" name="status" value="1" checked="" >
        <span class="switch-toggle-slider">
          <span class="switch-on"></span>
          <span class="switch-off"></span>
        </span>
        <span class="switch-label" ><?php echo translate("tr_318150c53b2ec43a3ffef0f443596df1"); ?></span>
      </label>
    </div>          
  </div>
  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_c318d6aece415f27decf21b272d94fa2"); ?></label>
    <?php echo $app->ui->managerFiles(["type"=>"images", "path"=>"images"]); ?>
  </div>
  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_c5485c72cc9795ad3bb46ff5b5dd8d4d"); ?><span class="form-label-importantly" >*</span></label>
    <input type="text" name="name" class="form-control" />
    <label class="form-label-error" data-name="name" ></label>
  </div>
  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_345805b88b9ca1e189fa11ea817e5666"); ?></label>
    <select class="form-control selectpicker" name="type" >
      <option value="public" ><?php echo translate("tr_4c5280214e2b752264d2f9d347d143f0"); ?></option>
      <option value="closed" ><?php echo translate("tr_0317d4178ef6c44809287e96e09193aa"); ?></option>
    </select>
  </div>
  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_62b685c7d7c78ac9b69b36cfc70c566f"); ?></label>
    <textarea class="form-control" name="text" ></textarea>
  </div>

  <div>
    <div class="mt-2 d-grid gap-2 col-lg-6 mx-auto">
      <button class="btn btn-primary buttonAddChannel"><?php echo translate("tr_5eba283b81890978e67f4aa96dde1724"); ?></button>
    </div>
  </div>

</form>