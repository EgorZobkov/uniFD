<div class="mb-4">
  <h2 class="role-title font-weight-bold"><?php echo translate("tr_d458724f99d3f2b7dc7ce51e17705568"); ?></h2>
</div>

<form class="row g-3 formAddPost" >

  <div class="col-12">
    <div>
      <label class="switch">
        <input type="checkbox" class="switch-input" name="status" value="1" checked="" >
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
    <?php echo $app->ui->managerFiles(["type"=>"images", "path"=>"images"]); ?>
  </div>

  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_2e9d7991efe99efaf9cf325b6f10d8a0"); ?><span class="form-label-importantly" >*</span></label>
    <input type="text" name="title" class="form-control inTranslite" />
    <label class="form-label-error" data-name="title" ></label>
  </div>

  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_32df0c52cac96c2feb95654aab7f6e5a"); ?></label>
    <input type="text" name="alias" class="form-control outTranslite" />
    <label class="form-label-error" data-name="alias" ></label>
  </div>

  <div class="col-12">
    <label class="form-label" >Meta Description</label>
    <textarea rows="4" class="form-control" name="seo_desc" ></textarea>
  </div>

  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_c95a1e2de00ee86634e177aecca00aed"); ?></label>
    <select class="selectpicker" name="category_id" >
      <option value="" ><?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?></option>
      <?php echo $app->component->blog_categories->getRecursionOptions(); ?>
    </select>
    <label class="form-label-error" data-name="category_id" ></label>
  </div>

  <div>
    <div class="mt-4 d-grid gap-2 col-lg-6 mx-auto">
      <button class="btn btn-primary buttonAddPost"><?php echo translate("tr_5eba283b81890978e67f4aa96dde1724"); ?></button>
    </div>
  </div>

</form>