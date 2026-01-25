
<div class="mb-4">
  <h2 class="role-title font-weight-bold"><?php echo translate("tr_e0abe1ea3d0f76f997734100f4e78caf"); ?></h2>
</div>

<form class="formAddFilterLink" >

<div class="nav-align-top">
  <ul class="nav nav-pills mb-4" role="tablist">
    <li class="nav-item">
      <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-add-filter-link-1" aria-controls="navs-pills-add-filter-link-1" aria-selected="true"><?php echo translate("tr_cecdd096144eccaeb28c4c2bc233ed63"); ?></button>
    </li>
    <li class="nav-item">
      <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-add-filter-link-2" aria-controls="navs-pills-add-filter-link-2" aria-selected="true">Seo</button>
    </li>
  </ul>
  <div class="tab-content">

    <div class="tab-pane fade show active" id="navs-pills-add-filter-link-1" role="tabpanel">

      <div class="row g-3" >

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
          <label class="form-label" ><?php echo translate("tr_c95a1e2de00ee86634e177aecca00aed"); ?><span class="form-label-importantly" >*</span></label>
          <select name="category_id" data-live-search="true" class="form-select selectpicker" >
            <option value="" ><?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?></option>
            <?php echo $app->component->ads_categories->getRecursionOptions(); ?>
          </select>
          <label class="form-label-error" data-name="category_id" ></label>
        </div>

        <div class="col-12">
          <label class="form-label" ><?php echo translate("tr_2c34bf7475ce67cfad1c45882be01ca8"); ?><span class="form-label-importantly" >*</span></label>
          <input type="text" name="params" class="form-control" />
          <label class="form-label-error" data-name="params" ></label>

          <div class="alert alert-primary d-flex align-items-center mt-2 mb-0" role="alert"><?php echo translate("tr_ee5846ac3aada845bfac98385149d285"); ?> <?php echo getHost(); ?>/auto?filter[1]=2&filter[2]=3</div>
        </div>

      </div>

    </div>

    <div class="tab-pane fade" id="navs-pills-add-filter-link-2" role="tabpanel">

      <div class="row g-3" >

        <div class="col-12">
           <label class="form-label" ><?php echo translate("tr_a7a9e7a0e8845cb3afe2e7080082fe1c"); ?></label>
           <div class="seo-container-makros-list" >
             <?php echo $app->component->seo->outMacrosList(); ?>
           </div>
        </div>

        <div class="col-12">
          <label class="form-label" >Meta title</label>
          <input type="text" name="seo_title" class="form-control" />
        </div>

        <div class="col-12">
          <label class="form-label" >Meta Description</label>
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
      <button class="btn btn-primary buttonAddFilterLink"><?php echo translate("tr_5eba283b81890978e67f4aa96dde1724"); ?></button>
    </div>

  </div>
</div>

</form>
