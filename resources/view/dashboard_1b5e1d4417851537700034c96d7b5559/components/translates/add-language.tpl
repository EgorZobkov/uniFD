<div class="mb-4">
  <h2 class="role-title font-weight-bold"><?php echo translate("tr_726095f0af6fe790dd8675b919ad67ee"); ?></h2>
</div>

<form class="row g-3 formAddLanguage" >

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
    <label class="form-label" ><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?><span class="form-label-importantly" >*</span></label>
    <input type="text" name="name" class="form-control" />
    <label class="form-label-error" data-name="name" ></label>
  </div>
  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_5b512ee8a59deb284ad0a6a035ba10b1"); ?><span class="form-label-importantly" >*</span></label>
    <input type="text" name="iso" class="form-control" placeholder="<?php echo translate("tr_734eff48f70ad10d1c63946c637d768b"); ?>" />
    <label class="form-label-error" data-name="iso" ></label>
  </div>
  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_7c7e33cd1dbe7e713d80243da571e45c"); ?><span class="form-label-importantly" >*</span></label>
    <input type="text" name="locale" class="form-control" placeholder="<?php echo translate("tr_74b85b361f3ed793152ba0e19f90d98e"); ?>" />
    <label class="form-label-error" data-name="locale" ></label>
  </div>

  <div>
    <div class="mt-2 d-grid gap-2 col-lg-6 mx-auto">
      <button class="btn btn-primary buttonAddLanguage"><?php echo translate("tr_5eba283b81890978e67f4aa96dde1724"); ?></button>
    </div>
  </div>

</form>