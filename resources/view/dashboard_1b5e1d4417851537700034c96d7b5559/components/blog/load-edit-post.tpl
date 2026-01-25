<div class="mb-4">
  <h2 class="role-title font-weight-bold"><?php echo translate("tr_1167e787a81a5549bc895f4c61dcba4b"); ?></h2>
</div>

<form class="row g-3 formEditPost" >

  <div class="col-12">
    <div>
      <label class="switch">
        <input type="checkbox" class="switch-input" name="status" value="1" <?php if($data->status){ echo 'checked=""'; } ?> >
        <span class="switch-toggle-slider">
          <span class="switch-on"></span>
          <span class="switch-off"></span>
        </span>
        <span class="switch-label" ><?php echo translate("tr_87a4286b7b9bf700423b9277ab24c5f1"); ?></span>
      </label>
    </div>          
  </div>

  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_c318d6aece415f27decf21b272d94fa2"); ?></label>
    <?php echo $app->ui->managerFiles(["filename"=>$data->image, "type"=>"images", "path"=>"images"]); ?>
  </div>

  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_2e9d7991efe99efaf9cf325b6f10d8a0"); ?><span class="form-label-importantly" >*</span></label>
    <input type="text" name="title" class="form-control inTranslite" value="<?php echo $data->title; ?>" />
    <label class="form-label-error" data-name="title" ></label>
  </div>

  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_32df0c52cac96c2feb95654aab7f6e5a"); ?></label>
    <input type="text" name="alias" class="form-control outTranslite" value="<?php echo $data->alias; ?>" />
    <label class="form-label-error" data-name="alias" ></label>
  </div>

  <div class="col-12">
    <label class="form-label" >Meta Description</label>
    <textarea rows="4" class="form-control" name="seo_desc" ><?php echo $data->seo_desc; ?></textarea>
  </div>

  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_c95a1e2de00ee86634e177aecca00aed"); ?></label>
    <select class="selectpicker" name="category_id" >
      <option value="" ><?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?></option>
      <?php echo $app->component->blog_categories->selectedIds($data->category_id)->getRecursionOptions(); ?>
    </select>
    <label class="form-label-error" data-name="category_id" ></label>
  </div>

  <div>
    <div class="mt-4 d-grid gap-2 col-lg-6 mx-auto">
      <button class="btn btn-primary buttonSaveEditPost"><?php echo translate("tr_74ea58b6a801f0dce4e5d34dbca034dc"); ?></button>
    </div>
  </div>

  <input type="hidden" name="id" value="<?php echo $data->id; ?>" >

</form>