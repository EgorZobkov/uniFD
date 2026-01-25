
<div class="mb-4">
  <h2 class="role-title font-weight-bold"><?php echo translate("tr_1167e787a81a5549bc895f4c61dcba4b"); ?></h2>
</div>

<form class="row g-3 formEditPage" >
  <div class="col-12">

    <label class="switch">
      <input type="checkbox" class="switch-input" name="status" value="1" <?php if($data->status){ echo 'checked=""'; } ?> >
      <span class="switch-toggle-slider">
        <span class="switch-on"></span>
        <span class="switch-off"></span>
      </span>
      <span class="switch-label" ><?php echo translate("tr_87a4286b7b9bf700423b9277ab24c5f1"); ?></span>
    </label>          

  </div>
  <div class="col-12">
    <label class="form-label"><?php echo translate("tr_2c59550905400dee351f67dd9f718c04"); ?></label>
    <input type="text" class="form-control inTranslite" name="name" value="<?php echo translateField($data->name); ?>" />
    <label class="form-label-error" data-name="name" ></label>
  </div>
  <div class="col-12">
    <label class="form-label"><?php echo translate("tr_d291e05931a430ed2bbb924c07e2eabe"); ?></label>
    <input type="text" class="form-control outTranslite" name="alias" value="<?php echo $data->alias; ?>" />
    <label class="form-label-error" data-name="alias" ></label>
  </div>

  <div>
    <div class="mt-3 d-grid gap-2 col-lg-6 mx-auto">
      <button class="btn btn-primary actionTemplatesSaveEditPage"><?php echo translate("tr_74ea58b6a801f0dce4e5d34dbca034dc"); ?></button>
    </div>
  </div>

  <input type="hidden" name="id" value="<?php echo $data->id; ?>" >

</form>