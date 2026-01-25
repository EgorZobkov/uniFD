
<div class="mb-4">
  <h2 class="role-title font-weight-bold"><?php echo translate("tr_1167e787a81a5549bc895f4c61dcba4b"); ?></h2>
</div>

<form class="row g-3 formEditCountry" >
  <div class="col-12">
    <div>
      <label class="switch">
        <input type="checkbox" class="switch-input" name="status" value="1" <?php if($data->status){ echo 'checked=""'; }; ?> >
        <span class="switch-toggle-slider">
          <span class="switch-on"></span>
          <span class="switch-off"></span>
        </span>
        <span class="switch-label" ><?php echo translate("tr_87a4286b7b9bf700423b9277ab24c5f1"); ?></span>
      </label>
    </div>          
  </div>
  <div class="col-12">
    <div>
      <label class="switch">
        <input type="checkbox" class="switch-input" name="default" value="1"  <?php if($data->default_status){ echo 'checked=""'; }; ?> >
        <span class="switch-toggle-slider">
          <span class="switch-on"></span>
          <span class="switch-off"></span>
        </span>
        <span class="switch-label" ><?php echo translate("tr_d3b9e440144ac3cb320cf4627f2e0e90"); ?></span>
      </label>
    </div>          
  </div>
  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_c318d6aece415f27decf21b272d94fa2"); ?> </label>

    <?php echo $app->ui->managerFiles(["filename"=>$data->image, "type"=>"images", "path"=>"images"]); ?>

  </div>
  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?><span class="form-label-importantly" >*</span></label>
    <input type="text" name="name" class="form-control inTranslite" value="<?php echo $data->name; ?>" />
    <label class="form-label-error" data-name="name" ></label>
  </div>
  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_32df0c52cac96c2feb95654aab7f6e5a"); ?><span class="form-label-importantly" >*</span></label>
    <input type="text" name="alias" class="form-control outTranslite" value="<?php echo $data->alias; ?>" />
    <label class="form-label-error" data-name="alias" ></label>
  </div>
  <div class="col-12">
    <label class="form-label" >ISO<span class="form-label-importantly" >*</span></label>
    <input type="text" name="iso" class="form-control" value="<?php echo $data->code; ?>" />
    <label class="form-label-error" data-name="iso" ></label>
  </div>
  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_d2af44591aef5ad60899f4904a9ce047"); ?></label>
    <input type="text" name="declension" class="form-control" value="<?php echo $data->declension; ?>" />
  </div>
  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_074cc965d5263d5d7268b8210d8df18d"); ?></label>
    <textarea name="seo_text" class="form-control" rows="4" ><?php echo $data->seo_text; ?></textarea>
  </div>
  <div class="col-12">
  <div class="alert alert-primary d-flex align-items-center mb-0" role="alert">
    <span class="alert-icon text-primary me-2">
      <i class="ti ti-info-circle ti-xs"></i>
    </span>
    <?php echo translate("tr_34d1ca0d2422d5731f06ddbfa1bac252"); ?>
  </div>
  </div>

  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_2ed78978c74d70d32a6ef2d03ba64df4"); ?><span class="form-label-importantly" >*</span></label>
    <input type="text" name="latitude" class="form-control" value="<?php echo $data->capital_latitude; ?>" />
    <label class="form-label-error" data-name="latitude" ></label>
  </div>
  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_fb04bb05febca0efec9dfd33d042db8a"); ?><span class="form-label-importantly" >*</span></label>
    <input type="text" name="longitude" class="form-control" value="<?php echo $data->capital_longitude; ?>" />
    <label class="form-label-error" data-name="longitude" ></label>
  </div>

  <input type="hidden" name="id" value="<?php echo $data->id; ?>" >
  
  <div>
    <div class="mt-4 d-grid gap-2 col-lg-6 mx-auto">
      <button class="btn btn-primary buttonSaveEditCountry"><?php echo translate("tr_74ea58b6a801f0dce4e5d34dbca034dc"); ?></button>
    </div>
  </div>

</form>