<div class="sticky-wrapper-container" >

<div class="sticky-wrapper-actions">
  <button class="btn btn-primary waves-effect waves-light buttonSaveSettings" data-route-name="dashboard-settings-access-save" ><?php echo translate("tr_74ea58b6a801f0dce4e5d34dbca034dc"); ?></button>
</div>

<div class="card mb-4">

<div class="card-header">
  <h3 class="card-title m-0"><?php echo translate("tr_dbf2fcc8d96e960a90917b8733fbd804"); ?></h3>
</div>
<div class="card-body">

  <div class="row">

    <div class="col-12 mb-3 mt-0">

      <div class="row" >
        <div class="col-12 col-md-6" >

            <label class="switch">
              <input type="checkbox" name="access_status" value="1" class="switch-input" <?php if($app->settings->access_status){ echo 'checked=""'; } ?> >
              <span class="switch-toggle-slider">
                <span class="switch-on"></span>
                <span class="switch-off"></span>
              </span>
              <span class="switch-label"><?php echo translate("tr_034c5817953d70e92e74c5aee71111e2"); ?></span>
            </label>

        </div>
      </div>

    </div>

    <div class="col-12 mb-3 mt-0">

      <label class="form-label mb-2" ><?php echo translate("tr_50a761a11275b70272b97775ec641e61"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >
            <select class="form-select settings-select-access-action selectpicker" name="access_action" >
              <option value="" ><?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?></option>
              <option value="text" <?php if($app->settings->access_action == "text"){ echo 'selected=""'; } ?> ><?php echo translate("tr_f7b85f29e3bf48c77591dd251784f96e"); ?></option>
              <option value="redirect" <?php if($app->settings->access_action == "redirect"){ echo 'selected=""'; } ?> ><?php echo translate("tr_86f1106393d61dc0e83586c80a13a7f9"); ?></option>
            </select>   
            <label class="form-label-error" data-name="access_action" ></label>      
        </div>
      </div>

    </div>

    <div class="settings-access-text-container" <?php if($app->settings->access_action == "text"){ echo 'style="display:block"'; } ?> >
      <div class="col-12 mb-3 mt-0">

        <label class="form-label mb-2" ><?php echo translate("tr_8c45d9cf5766a98100df8108d3235247"); ?></label>

        <div class="row" >
          <div class="col-12 col-md-6" >
              <textarea class="form-control" name="access_text" ><?php echo $app->settings->access_text; ?></textarea>       
              <label class="form-label-error" data-name="access_text" ></label> 
          </div>
        </div>

      </div>
    </div>

    <div class="settings-access-redirect-link-container" <?php if($app->settings->access_action == "redirect"){ echo 'style="display:block"'; } ?> >
      <div class="col-12 mb-3 mt-0">

        <label class="form-label mb-2" ><?php echo translate("tr_c9030a2784e16f12a1dad8805d9d1834"); ?></label>

        <div class="row" >
          <div class="col-12 col-md-6" >
            <input type="text" name="access_redirect_link" class="form-control" value="<?php echo $app->settings->access_redirect_link; ?>" >     
            <label class="form-label-error" data-name="access_redirect_link" ></label>   
          </div>
        </div>

      </div>
    </div>

    <div class="col-12 mb-3 mt-0">

      <label class="form-label mb-2" ><?php echo translate("tr_764af1abe26db4c92c93d74265d60cc2"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >
            <textarea class="form-control" name="access_allowed_ip" ><?php echo $app->settings->access_allowed_ip ?: getIp(); ?></textarea>       
        </div>
      </div>

    </div>

  </div>

</div>
</div>

</div>
