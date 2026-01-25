<div class="mb-4">
  <h2 class="role-title font-weight-bold"><?php echo translateField($data->name); ?></h2>
</div>

<form class="row g-3 formEditChannel" >

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
    <label class="form-label" ><?php echo translate("tr_c5485c72cc9795ad3bb46ff5b5dd8d4d"); ?><span class="form-label-importantly" >*</span></label>
    <input type="text" name="name" class="form-control" value="<?php echo translateField($data->name); ?>" />
    <label class="form-label-error" data-name="name" ></label>
  </div>
  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_62b685c7d7c78ac9b69b36cfc70c566f"); ?></label>
    <textarea class="form-control" name="text" ><?php echo translateField($data->text); ?></textarea>
  </div>

  <div>
    <div class="mt-2 d-grid gap-2 col-lg-6 mx-auto">
      <button class="btn btn-primary buttonSaveEditChannel"><?php echo translate("tr_74ea58b6a801f0dce4e5d34dbca034dc"); ?></button>
    </div>
  </div>

  <input type="hidden" name="id" value="<?php echo $data->id; ?>" >

</form>