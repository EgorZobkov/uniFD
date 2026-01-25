
<div class="mb-4">
  <h2 class="role-title font-weight-bold"><?php echo translate("tr_4494d573fcfd21edaa313456eb3b3cc6"); ?></h2>
</div>

<form class="formAddCategory" >

<div class="nav-align-top">
  <ul class="nav nav-pills nav-fill mb-4" role="tablist">
    <li class="nav-item">
      <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-add-category-1" aria-controls="navs-pills-add-category-1" aria-selected="true"><?php echo translate("tr_cecdd096144eccaeb28c4c2bc233ed63"); ?></button>
    </li>
    <li class="nav-item">
      <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-add-category-2" aria-controls="navs-pills-add-category-2" aria-selected="true">Seo</button>
    </li>
  </ul>
  <div class="tab-content">

    <div class="tab-pane fade show active" id="navs-pills-add-category-1" role="tabpanel">

      <div class="row g-3" >

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
          <label class="form-label" ><?php echo translate("tr_c318d6aece415f27decf21b272d94fa2"); ?></label>
          <?php echo $app->ui->managerFiles(["type"=>"images", "path"=>"images"]); ?>
        </div>
        <div class="col-12">
          <label class="form-label" ><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?><span class="form-label-importantly" >*</span></label>
          <input type="text" name="name" class="form-control inTranslite" />
          <label class="form-label-error" data-name="name" ></label>
        </div>
        <div class="col-12">
          <label class="form-label" ><?php echo translate("tr_32df0c52cac96c2feb95654aab7f6e5a"); ?><span class="form-label-importantly" >*</span></label>
          <input type="text" name="alias" class="form-control outTranslite" />
          <label class="form-label-error" data-name="alias" ></label>
        </div>

        <div class="col-12">
          <label class="form-label" ><?php echo translate("tr_c0981e606859b36e8c92c1c3d9949eff"); ?></label>
          <select name="parent_id" data-live-search="true" class="form-select selectpicker" >
            <option value="" ><?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?></option>
            <?php echo $app->component->blog_categories->getRecursionOptions(); ?>
          </select>
        </div>

        <div class="col-12">
          <div class="alert alert-primary d-flex align-items-center mb-0" role="alert">
           <?php echo translate("tr_ad419e27246a1c8de39e4068dc322731"); ?> 
          </div>
        </div>

      </div>

    </div>

    <div class="tab-pane fade" id="navs-pills-add-category-2" role="tabpanel">

      <div class="row g-3" >

        <div class="col-12">
          <label class="form-label" >Meta title</label>
          <input type="text" name="seo_title" class="form-control" />
        </div>

        <div class="col-12">
          <label class="form-label" ><?php echo translate("tr_81a35ec1dc4a194f938b211a86a57826"); ?></label>
          <input type="text" name="seo_desc" class="form-control" />
        </div>

        <div class="col-12">
          <label class="form-label" >H1</label>
          <input type="text" name="seo_h1" class="form-control" />
        </div>

        <div class="col-12">
          <label class="form-label" ><?php echo translate("tr_8c45d9cf5766a98100df8108d3235247"); ?></label>
          <textarea rows="4" class="form-control" name="seo_text" ></textarea>
        </div>

      </div>

    </div>

    <div class="mt-4 d-grid gap-2 col-lg-6 mx-auto">
      <button class="btn btn-primary buttonAddCategory"><?php echo translate("tr_5eba283b81890978e67f4aa96dde1724"); ?></button>
    </div>

  </div>
</div>

</form>
