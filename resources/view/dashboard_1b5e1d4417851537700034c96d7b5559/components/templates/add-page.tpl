
<div class="mb-4">
  <h2 class="role-title font-weight-bold"><?php echo translate("tr_cb4b1897e6fbd5db0d0b3fd62e33799d"); ?></h2>
</div>

<form class="row g-3 formAddPage" >
  <div class="col-12">

    <label class="switch">
      <input type="checkbox" class="switch-input" name="status" value="1" checked="" >
      <span class="switch-toggle-slider">
        <span class="switch-on"></span>
        <span class="switch-off"></span>
      </span>
      <span class="switch-label" ><?php echo translate("tr_87a4286b7b9bf700423b9277ab24c5f1"); ?></span>
    </label>          

  </div>
  <div class="col-12">
    <label class="form-label"><?php echo translate("tr_2c59550905400dee351f67dd9f718c04"); ?></label>
    <input type="text" class="form-control inTranslite" name="name" />
    <label class="form-label-error" data-name="name" ></label>
  </div>
  <div class="col-12">
    <label class="form-label"><?php echo translate("tr_d291e05931a430ed2bbb924c07e2eabe"); ?></label>
    <input type="text" class="form-control outTranslite" name="alias" />
    <label class="form-label-error" data-name="alias" ></label>
  </div>

  <div>
    <div class="mt-3 d-grid gap-2 col-lg-6 mx-auto">
      <button class="btn btn-primary actionTemplatesAddPage"><?php echo translate("tr_5eba283b81890978e67f4aa96dde1724"); ?></button>
    </div>
  </div>

</form>