<div class="sticky-wrapper-container" >

<div class="sticky-wrapper-actions">
  <button class="btn btn-primary waves-effect waves-light buttonSaveSettings" data-route-name="dashboard-settings-graphics-save" ><?php echo translate("tr_74ea58b6a801f0dce4e5d34dbca034dc"); ?></button>
</div>

<div class="card mb-4">

<div class="card-header">
  <h3 class="card-title m-0"><?php echo translate("tr_158176991f43d5bdf6c52b258bf05cf4"); ?></h3>
</div>
<div class="card-body">

  <div class="row g-3">

    <div class="col-12">

      <label class="form-label mb-2" ><?php echo translate("tr_0911cec982aab4463b9732436230f10a"); ?></label>

      <div class="row" >
        <div class="col-6" >
          <?php echo $app->ui->managerFiles(["filename"=>$app->settings->logo_main, "type"=>"images", "path"=>"images", "input_name"=>"logo_main"]); ?>
        </div>
      </div>  

    </div>

    <div class="col-12">

      <label class="form-label mb-2" ><?php echo translate("tr_1f9f297ad004d547e8fc63fecfa0bcf0"); ?></label>

      <div class="row" >
        <div class="col-6" >
          <?php echo $app->ui->managerFiles(["filename"=>$app->settings->logo_emblem, "type"=>"images", "path"=>"images", "input_name"=>"logo_emblem"]); ?>
        </div>
      </div>

    </div>

    <div class="col-12">

      <label class="form-label" ><?php echo translate("tr_49e95301d8fcdbc23f623e0f2d1ed1e6"); ?></label>

      <div class="row" >
        <div class="col-6" >
          <?php echo $app->ui->managerFiles(["filename"=>$app->settings->favicon, "type"=>"images", "path"=>"images", "input_name"=>"favicon"]); ?>
        </div>
      </div>

    </div>

  </div>

</div>
</div>

<div class="card mb-4">
<div class="card-header">
  <h3 class="card-title m-0"><?php echo translate("tr_ee20bb60493f049175fc10c35acd2272"); ?></h3>
</div>
<div class="card-body">

  <div class="row g-3">

    <div class="col-12">

      <label class="switch">
        <input type="checkbox" class="switch-input" value="1" name="watermark_status" <?php if($app->settings->watermark_status){ echo 'checked=""'; } ?> >
        <span class="switch-toggle-slider">
          <span class="switch-on"></span>
          <span class="switch-off"></span>
        </span>
        <span class="switch-label"><?php echo translate("tr_a1dfe08b29ec08210f980d73d7cff3db"); ?></span>
      </label>

    </div>

    <div class="col-12">

      <label class="form-label mb-2" ><?php echo translate("tr_345805b88b9ca1e189fa11ea817e5666"); ?></label>

      <div class="row" >
        <div class="col-6" >
          <select class="form-select select-watermark-type-settings selectpicker" name="watermark_type" >
            <option value="" ><?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?></option>
            <option value="title" <?php if($app->settings->watermark_type == 'title'){ echo 'selected=""'; } ?> ><?php echo translate("tr_685d284019040abab8211a4a08011b79"); ?></option>
            <option value="image" <?php if($app->settings->watermark_type == 'image'){ echo 'selected=""'; } ?> ><?php echo translate("tr_c318d6aece415f27decf21b272d94fa2"); ?></option>
          </select> 
        </div>
      </div> 

      <label class="form-label-error" data-name="watermark_type" ></label>                   

    </div>

    <div class="settings-watermark-type-title-container" <?php if($app->settings->watermark_type == 'title'){ echo 'style="display:block"'; } ?> >

      <div class="col-12 mb-3">

        <label class="form-label mb-2" ><?php echo translate("tr_685d284019040abab8211a4a08011b79"); ?></label>

        <div class="row" >
          <div class="col-6" >
            <input type="text" name="watermark_title" class="form-control" value="<?php echo $app->settings->watermark_title; ?>" /> 
          </div>
        </div>

        <label class="form-label-error" data-name="watermark_title" ></label>

      </div>

      <div class="col-12 mb-3">

        <label class="form-label mb-2" ><?php echo translate("tr_e479fdc532629dd7f13a19d6bbb81cc7"); ?></label>

        <div class="row" >
          <div class="col-6" >
            <select class="form-select selectpicker" name="watermark_title_font" >
              <?php echo $app->component->settings->getFontsWatermark(); ?>
            </select> 
          </div>
        </div>

        <label class="form-label-error" data-name="watermark_title_font" ></label>                   

      </div>

      <div class="col-12 mb-3">

        <label class="form-label mb-2" ><?php echo translate("tr_97d9d0d68e075cc7a4066c2852da3078"); ?></label>

        <div class="row" >
          <div class="col-6" >
            <select class="form-select selectpicker" name="watermark_title_size" >
              <option value="big" <?php if($app->settings->watermark_title_size == "big"){ echo 'selected=""'; } ?> ><?php echo translate("tr_c341e2b85d8ee939420f9f4b309946cd"); ?></option>
              <option value="medium" <?php if($app->settings->watermark_title_size == "medium"){ echo 'selected=""'; } ?> ><?php echo translate("tr_605ba7cc5e104a6ea6afd91301dd4225"); ?></option>
              <option value="small" <?php if($app->settings->watermark_title_size == "small"){ echo 'selected=""'; } ?> ><?php echo translate("tr_36609e2ed27c6f9fb14014495791e919"); ?></option>
            </select>
          </div>
        </div>

        <label class="form-label-error" data-name="watermark_title_size" ></label>                   

      </div>

      <div class="col-12">

        <label class="form-label mb-2" ><?php echo translate("tr_36e57b2a8eff43f23f1c3689fa093381"); ?></label>

        <div class="row" >
          <div class="col-6" >
              <div class="input-group">
                <span class="input-group-text">%</span>
                <input type="number" class="form-control" name="watermark_title_opacity" value="<?php echo $app->settings->watermark_title_opacity; ?>" >
              </div>
          </div>
        </div>

        <label class="form-label-error" data-name="watermark_title_opacity" ></label>

      </div>

    </div>

    <div class="settings-watermark-type-image-container" <?php if($app->settings->watermark_type == 'image'){ echo 'style="display:block"'; } ?> >

      <div class="col-12 mb-3">

        <label class="form-label mb-2" ><?php echo translate("tr_c318d6aece415f27decf21b272d94fa2"); ?></label>

        <div class="row" >
          <div class="col-6" >
            <?php echo $app->ui->managerFiles(["filename"=>$app->settings->watermark_image, "type"=>"images", "path"=>"images", "input_name"=>"watermark_image"]); ?>
          </div>
        </div>  

        <label class="form-label-error" data-name="watermark_image" ></label>

      </div>

      <div class="col-12 mb-3">

        <label class="form-label mb-2" ><?php echo translate("tr_acddfa5bf77e19b9dfe7f426bc2fa168"); ?></label>

        <div class="row" >
          <div class="col-6" >
              <div class="input-group">
                <span class="input-group-text">%</span>
                <input type="number" class="form-control" name="watermark_image_percent_size" value="<?php echo $app->settings->watermark_image_percent_size; ?>" >
              </div>
          </div>
        </div>

      </div>

      <div class="col-12 mb-3">

        <label class="form-label mb-2" ><?php echo translate("tr_36e57b2a8eff43f23f1c3689fa093381"); ?></label>

        <div class="row" >
          <div class="col-6" >
              <div class="input-group">
                <span class="input-group-text">%</span>
                <input type="number" class="form-control" name="watermark_image_opacity" value="<?php echo $app->settings->watermark_image_opacity; ?>" >
              </div>
          </div>
        </div>

      </div>

      <div class="col-12">

        <label class="form-label mb-2" ><?php echo translate("tr_3b5f2ce093d7d9851a37b75ef4ebc309"); ?></label>

        <div class="row" >
          <div class="col-6" >
            <select class="form-select selectpicker" name="watermark_image_position" >
              <option value="1" <?php if($app->settings->watermark_image_position == "1"){ echo 'selected=""'; } ?> ><?php echo translate("tr_13312f5393d38d30fcaed277a11e6b51"); ?></option>
              <option value="2" <?php if($app->settings->watermark_image_position == "2"){ echo 'selected=""'; } ?> ><?php echo translate("tr_fce46e99f0a28d041081f4ad48a4ad71"); ?></option>
              <option value="3" <?php if($app->settings->watermark_image_position == "3"){ echo 'selected=""'; } ?> ><?php echo translate("tr_7554f5ede2efbc3731f3512c8a15939d"); ?></option>
              <option value="4" <?php if($app->settings->watermark_image_position == "4"){ echo 'selected=""'; } ?> ><?php echo translate("tr_095d912c3caedaba72c78294e90a5e1f"); ?></option>
              <option value="5" <?php if($app->settings->watermark_image_position == "5"){ echo 'selected=""'; } ?> ><?php echo translate("tr_3a76adbfdc8fb967ec4dec429fb6069e"); ?></option>
            </select> 
          </div>
        </div>

        <label class="form-label-error" data-name="watermark_image_position" ></label>                   

      </div>

    </div>

  </div>

</div>
</div>

</div>
