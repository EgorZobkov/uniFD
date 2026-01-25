
<div class="mb-4">
  <h2 class="role-title font-weight-bold"><?php echo $data->name; ?></h2>
</div>

<form class="row g-3 formEditLanguage" >

  <div class="col-12">
    <div>
      <label class="switch">
        <input type="checkbox" class="switch-input" name="status" value="1" <?php if($data->status){ echo 'checked=""'; } ?> >
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
    <?php echo $app->ui->managerFiles(["filename"=>$data->image, "type"=>"images", "path"=>"images"]); ?>
  </div>
  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?><span class="form-label-importantly" >*</span></label>
    <input type="text" name="name" class="form-control" value="<?php echo $data->name; ?>" />
    <label class="form-label-error" data-name="name" ></label>
  </div>
  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_7c7e33cd1dbe7e713d80243da571e45c"); ?><span class="form-label-importantly" >*</span></label>
    <input type="text" name="locale" class="form-control" value="<?php echo $data->locale; ?>" placeholder="<?php echo translate("tr_74b85b361f3ed793152ba0e19f90d98e"); ?>" />
    <label class="form-label-error" data-name="locale" ></label>
  </div>

  <div>
    <div class="mt-2 d-grid gap-2 col-lg-6 mx-auto">
      <button class="btn btn-primary buttonSaveEditLanguage"><?php echo translate("tr_74ea58b6a801f0dce4e5d34dbca034dc"); ?></button>
    </div>
  </div>

  <input type="hidden" name="id" value="<?php echo $data->id; ?>" >

</form>
