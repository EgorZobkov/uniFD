<div class="sticky-wrapper-container" >

<div class="sticky-wrapper-actions">
  <button class="btn btn-primary waves-effect waves-light buttonSaveSettings" data-route-name="dashboard-settings-information-save" ><?php echo translate("tr_74ea58b6a801f0dce4e5d34dbca034dc"); ?></button>
</div>

<div class="card mb-4">

<div class="card-header">
  <h3 class="card-title m-0"><?php echo translate("tr_47dc068e89b16d23b808d1afb495de78"); ?></h3>
</div>
<div class="card-body">

  <div class="row g-3">

    <div class="col-12">

      <label class="form-label mb-2" ><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >
          <input type="text" name="project_name" class="form-control" value="<?php echo $app->settings->project_name; ?>" /> 
        </div>
      </div>

      <label class="form-label-error" data-name="project_name" ></label>

    </div>

    <div class="col-12">

      <div class="alert alert-primary d-flex align-items-center mb-1" role="alert">
        <?php echo translate("tr_c3c61e6d194fd1ebe29e2e8f804e118e"); ?>
      </div>

      <label class="form-label mb-2" ><?php echo translate("tr_2e9d7991efe99efaf9cf325b6f10d8a0"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >
          <input type="text" name="project_title" class="form-control" value="<?php echo $app->settings->project_title; ?>" /> 
        </div>
      </div>

      <label class="form-label-error" data-name="project_title" ></label>

    </div>

  </div>

</div>
</div>

<div class="card mb-4">
<div class="card-header">
  <h3 class="card-title m-0"><?php echo translate("tr_75768c49c24662cc4465237b0731e1ce"); ?></h3>
</div>
<div class="card-body">

  <div class="row g-3">

    <div class="col-12">

      <label class="form-label mb-2" ><?php echo translate("tr_ce8ae9da5b7cd6c3df2929543a9af92d"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >
          <input type="text" name="contact_email" class="form-control" value="<?php echo $app->settings->contact_email; ?>" /> 
        </div>
      </div>

    </div>

    <div class="col-12">

      <label class="form-label mb-2" ><?php echo translate("tr_2928e19c705428df3c9f1e6d4ea8042f"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >
          <input type="text" name="contact_phone" class="form-control" value="<?php echo $app->settings->contact_phone; ?>" /> 
        </div>
      </div>

    </div>

  </div>

</div>
</div>

<div class="card mb-4">
<div class="card-header">
  <h3 class="card-title m-0"><?php echo translate("tr_d43bbf2f76f993e3ea7df349207d5ff0"); ?></h3>
</div>
<div class="card-body">

  <div class="row g-3">

    <div class="col-12 mb-1">

      <label class="form-label mb-2" ><?php echo translate("tr_16c3e7e34102c34643e18ddc60acac86"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >
          <input type="text" name="contact_organization_name" class="form-control" value="<?php echo $app->settings->contact_organization_name; ?>" /> 
        </div>
      </div>

    </div>

    <div class="col-12 mb-1">

      <label class="form-label mb-2" ><?php echo translate("tr_80148fa5ada7bcd36bf3b351ee3ca3b0"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >
          <input type="text" name="contact_organization_address" class="form-control" value="<?php echo $app->settings->contact_organization_address; ?>" /> 
        </div>
      </div>

    </div>

  </div>

</div>
</div>

<div class="card mb-4">
<div class="card-header">
  <h3 class="card-title m-0"><?php echo translate("tr_0e87f94474f2a252bf4c8110a2d943fc"); ?></h3>
</div>
<div class="card-body">

  <div class="alert alert-primary d-flex align-items-center" role="alert">
    <?php echo translate("tr_c9e1f11c1c2fe3b8edf653b229e84f50"); ?>
  </div>

  <div class="row g-3">

    <div class="settings-information-contact-social-links-container" >

      <?php echo $app->component->settings->outContactSocialLinks(); ?>

    </div>

    <div class="col-12 mt-2" >
      
      <span class="btn btn-sm btn-primary waves-effect waves-light settingsInformationAddSocialLink"><?php echo translate("tr_5eba283b81890978e67f4aa96dde1724"); ?></span>

    </div>


  </div>

</div>
</div>

</div>