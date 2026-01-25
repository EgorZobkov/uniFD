<div class="mb-4">
  <h2 class="role-title font-weight-bold"><?php echo translateField($data->title); ?></h2>
</div>

<form class="row g-3 formEditPromoBanner" >

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
    <input type="text" name="title" class="form-control" value="<?php echo translateField($data->title); ?>" />
    <label class="form-label-error" data-name="title" ></label>
  </div>

  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_c96d7d681ffb88348312080411372cb4"); ?></label>
    <select name="page_show" class="form-control selectpicker" >
       <option value="" ><?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?></option>
       <option value="home" <?php if(compareValues($data->page_show, "home")){ echo 'selected=""'; } ?> ><?php echo translate("tr_047f5653b183292396e67f14c8750b73"); ?></option>
       <option value="catalog" <?php if(compareValues($data->page_show, "catalog")){ echo 'selected=""'; } ?> ><?php echo translate("tr_ad51225e2ef05117a709b83a87d45440"); ?></option>
    </select>
    <label class="form-label-error" data-name="page_show" ></label>
  </div>

  <div class="add-promo-banner-categories-container" <?php if($data->page_show == "catalog"){ echo 'style="display: block;"'; } ?> >
    <div class="col-12">
      <label class="form-label" ><?php echo translate("tr_c95a1e2de00ee86634e177aecca00aed"); ?></label>
      <select name="category_id" class="form-select selectpicker" >
        <option value="" ><?php echo translate("tr_53660e081bed47bc53e7d4d247f7b15d"); ?></option>
        <?php echo $app->component->ads_categories->selectedIds($data->category_id)->getRecursionOptions(); ?>
      </select>
    </div>
  </div>

  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_cfe494c750a7c11908a7c19249bf200f"); ?></label>
    <input type="text" name="subtitle" class="form-control" value="<?php echo translateField($data->text); ?>" />
    <label class="form-label-error" data-name="subtitle" ></label>
  </div>

  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_544cca5cb61dcdd02a248f8062dc2957"); ?></label>
    <input type="text" name="bg_color" class="form-control" value="<?php echo $data->bg_color; ?>" />
    <label class="form-label-error" data-name="bg_color" ></label>
  </div>

  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_8bb4a3e13a130f6b9311d47a89291f3b"); ?></label>
    <input type="text" name="text_color" class="form-control" value="<?php echo $data->text_color; ?>" />
    <label class="form-label-error" data-name="text_color" ></label>
  </div>

  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_9797b9494600869ec6a941dae3f2a198"); ?><span class="form-label-importantly" >*</span></label>
    <input type="text" name="link" class="form-control" value="<?php echo $data->link; ?>" />
    <label class="form-label-error" data-name="link" ></label>
  </div>

  <div class="col-12">
    <div class="mb-3" >
      <label class="switch">
        <input type="checkbox" class="switch-input" name="geo_link_status" value="1" <?php if($data->geo_link_status){ echo 'checked=""'; } ?> >
        <span class="switch-toggle-slider">
          <span class="switch-on"></span>
          <span class="switch-off"></span>
        </span>
        <span class="switch-label" ><?php echo translate("tr_ff5cceec399e8ab8bdbd93118f4caf09"); ?></span>
      </label>
    </div>  
    <div class="alert alert-primary d-flex align-items-center" role="alert"><?php echo translate("tr_e37e4961daa1d706ed46243e21ee8727"); ?></div>        
  </div>

  <input type="hidden" name="id" value="<?php echo $data->id; ?>" >

  <div>
    <div class="mt-4 d-grid gap-2 col-lg-6 mx-auto">
      <button class="btn btn-primary buttonSaveEditPromoBanner"><?php echo translate("tr_74ea58b6a801f0dce4e5d34dbca034dc"); ?></button>
    </div>
  </div>

</form>