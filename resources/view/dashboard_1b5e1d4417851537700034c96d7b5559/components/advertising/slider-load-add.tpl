<div class="mb-4">
  <h2 class="role-title font-weight-bold"><?php echo translate("tr_f5e7d84bc2bfefedfcdac77fb8528fc6"); ?></h2>
</div>

<form class="row g-3 formAddSliderAdvertising" >

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
    <label class="form-label" ><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?><span class="form-label-importantly" >*</span></label>
    <input type="text" name="name" class="form-control" />
    <label class="form-label-error" data-name="name" ></label>
  </div>

  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_345805b88b9ca1e189fa11ea817e5666"); ?><span class="form-label-importantly" >*</span></label>
    <select name="type" class="selectpicker" >
       <option value="" ><?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?></option>
       <option value="banner" ><?php echo translate("tr_d7db33a6872d6b343275c54a84f80d05"); ?></option>
       <option value="code" ><?php echo translate("tr_92f27225752dbbd9ecea3049fb1184ec"); ?></option>
    </select>
    <label class="form-label-error" data-name="type" ></label>
  </div>

  <div class="advertising-add-type-banner-container" >
    <div class="col-12 mb-3">
      <label class="form-label" ><?php echo translate("tr_d7db33a6872d6b343275c54a84f80d05"); ?></label>
      <?php echo $app->ui->managerFiles(["type"=>"images", "path"=>"images"]); ?>
      <label class="form-label-error" data-name="manager_image" ></label>
    </div>
    <div class="col-12">
      <label class="form-label" ><?php echo translate("tr_c9030a2784e16f12a1dad8805d9d1834"); ?><span class="form-label-importantly" >*</span></label>
      <input type="text" name="link" class="form-control" />
      <label class="form-label-error" data-name="link" ></label>
    </div>
  </div>

  <div class="advertising-add-type-code-container" >
    <div class="col-12">
      <label class="form-label" ><?php echo translate("tr_92f27225752dbbd9ecea3049fb1184ec"); ?></label>
      <textarea class="form-control" name="code" rows="4" ></textarea>
      <label class="form-label-error" data-name="code" ></label>
    </div>
  </div>

  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_52fce691a5c3e33fac0aecd5483b1236"); ?></label>
    <input type="date" name="time_start" class="form-control" value="<?php echo $app->datetime->format("Y-m-d")->getDate(); ?>" />
    <label class="form-label-error" data-name="time_start" ></label>
  </div>

  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_e5dfcb5eeae08bbb1fd8247ccab0d7d5"); ?></label>
    <input type="date" name="time_end" class="form-control" value="" />
    <label class="form-label-error" data-name="time_end" ></label>
    <div class="alert alert-primary d-flex align-items-center mt-2 mb-0" role="alert"><?php echo translate("tr_d5a5f3f091a21c24b960281877d9854e"); ?></div>
  </div>

  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_6d64a9f994b401fe158374662189b0f3"); ?></label>
    <div>
    <label class="switch">
      <input type="checkbox" class="switch-input" name="lang_all" value="1" checked="" >
      <span class="switch-toggle-slider">
        <span class="switch-on"></span>
        <span class="switch-off"></span>
      </span>
      <span class="switch-label" ><?php echo translate("tr_e2a2f18a9df7a9acea26b0a2b41f12e0"); ?></span>
    </label>
    </div>      
  </div>

  <div class="advertising-add-lang-container" >

    <div class="col-12">
      <label class="form-label" ><?php echo translate("tr_0577df9ad7a2256702cd04371b2abecb"); ?></label>
      <select name="lang_iso" class="selectpicker" >
         <option value="" ><?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?></option>
         <?php echo $app->component->translate->outLanguagesOptions(); ?>
      </select>
    </div>

  </div>

  <?php if($app->settings->active_countries){ ?>
  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_0127e8ab69abe5201f96d41f131b1ebb"); ?></label>
    <div>
    <label class="switch">
      <input type="checkbox" class="switch-input" name="geo_all" value="1" checked="" >
      <span class="switch-toggle-slider">
        <span class="switch-on"></span>
        <span class="switch-off"></span>
      </span>
      <span class="switch-label" ><?php echo translate("tr_9a73b1e5b44bee481ab175b7e327451e"); ?></span>
    </label>
    </div>      
  </div>

  <div class="advertising-add-geo-container" >
    <div class="col-12">

      <div class="advertising-geo-search-container" >
          <input type="text" class="form-control advertising-geo-search" placeholder="<?php echo translate("tr_7102dd265f51a9c70f230bf190c2ce44"); ?>" >
          <div class="advertising-geo-search-results" ></div>
          <div class="advertising-geo-inputs" ></div>
      </div>

    </div>
  </div>
  <?php } ?>

  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_98b157cf73827bb29dd3f1afce6975d1"); ?></label>
    <div>
    <label class="switch">
      <input type="checkbox" class="switch-input" name="category_all" value="1" checked="" >
      <span class="switch-toggle-slider">
        <span class="switch-on"></span>
        <span class="switch-off"></span>
      </span>
      <span class="switch-label" ><?php echo translate("tr_53660e081bed47bc53e7d4d247f7b15d"); ?></span>
    </label>
    </div>      
  </div>

  <div class="advertising-add-category-container" >

    <div class="col-12">
      <label class="form-label" ><?php echo translate("tr_c95a1e2de00ee86634e177aecca00aed"); ?></label>
      <select name="category_id" class="selectpicker" >
         <option value="" ><?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?></option>
         <?php echo $app->component->ads_categories->getRecursionOptions(); ?>
      </select>
    </div>

  </div>

  <div>
    <div class="mt-4 d-grid gap-2 col-lg-6 mx-auto">
      <button class="btn btn-primary buttonAddSliderAdvertising"><?php echo translate("tr_5eba283b81890978e67f4aa96dde1724"); ?></button>
    </div>
  </div>

  <input type="hidden" name="uniq_code" value="<?php echo $data->uniq_code; ?>" >
  <input type="hidden" name="position" value="page" >

</form>