<div class="mb-4">
  <h2 class="role-title font-weight-bold"><?php echo translate("tr_1167e787a81a5549bc895f4c61dcba4b"); ?></h2>
</div>

<form class="row g-3 formEditSearchKeyword" >

  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?><span class="form-label-importantly" >*</span></label>
    <input type="text" name="name" class="form-control" value="<?php echo $data->name; ?>" />
    <label class="form-label-error" data-name="name" ></label>
  </div>

  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_54f067a401b1d97fb64ed2e6767094e0"); ?></label>
    <textarea class="form-control" name="tags" ><?php echo $data->tags; ?></textarea>
  </div>

  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_55ea7d290d2fb5e9ef0e4b53a2c831ed"); ?><span class="form-label-importantly" >*</span></label>
    <select name="goal_type" class="selectpicker" >
      <option value="0" <?php if($data->goal_type == 0){ echo 'selected'; } ?> ><?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?></option>
      <option value="1" <?php if($data->goal_type == 1){ echo 'selected'; } ?> ><?php echo translate("tr_96f8b1d26868391d276aac301a2ad4ba"); ?></option>
      <option value="2" <?php if($data->goal_type == 2){ echo 'selected'; } ?> ><?php echo translate("tr_c95a1e2de00ee86634e177aecca00aed"); ?></option>
      <option value="3" <?php if($data->goal_type == 3){ echo 'selected'; } ?> ><?php echo translate("tr_f7ac6fc5c5a477063add9c6d0701985d"); ?></option>
    </select>
    <label class="form-label-error" data-name="goal_type" ></label>
  </div>

  <div class="edit-search-keyword-container-1" <?php if($data->goal_type == 1){ echo 'style="display: block;"'; } ?> >
    
    <div class="col-12">
      <label class="form-label" ><?php echo translate("tr_9797b9494600869ec6a941dae3f2a198"); ?><span class="form-label-importantly" >*</span></label>
      <input type="text" name="link" class="form-control" value="<?php echo $data->link; ?>" />
      <label class="form-label-error" data-name="link" ></label>
    </div>    

    <div class="col-12 mt-3">
      <div>
        <label class="switch">
          <input type="checkbox" class="switch-input" name="geo_link_status" value="1" <?php if($data->geo_link_status){ echo 'checked=""'; } ?> >
          <span class="switch-toggle-slider">
            <span class="switch-on"></span>
            <span class="switch-off"></span>
          </span>
          <span class="switch-label" ><?php echo translate("tr_ff5cceec399e8ab8bdbd93118f4caf09"); ?></span>
        </label>
      </div>  
      <div class="alert alert-primary d-flex align-items-center mt-3 mb-0" role="alert"><?php echo translate("tr_e37e4961daa1d706ed46243e21ee8727"); ?></div>        
    </div>

  </div>

  <div class="edit-search-keyword-container-2" <?php if($data->goal_type == 2){ echo 'style="display: block;"'; } ?> >
    
    <div class="col-12">
      <label class="form-label" ><?php echo translate("tr_c95a1e2de00ee86634e177aecca00aed"); ?><span class="form-label-importantly" >*</span></label>
      <select class="selectpicker" name="category_id" >
        <option value="" ><?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?></option>
        <?php echo $app->component->ads_categories->selectedIds($data->category_id)->getRecursionOptions(); ?>
      </select>
      <label class="form-label-error" data-name="category_id" ></label>
    </div>

  </div>

  <div class="edit-search-keyword-container-3" <?php if($data->goal_type == 3){ echo 'style="display: block;"'; } ?> >
    
    <div class="col-12">
      <label class="form-label" ><?php echo translate("tr_9797b9494600869ec6a941dae3f2a198"); ?><span class="form-label-importantly" >*</span></label>
      <input type="text" name="filter_link" class="form-control" value="<?php echo $data->link; ?>" />
      <label class="form-label-error" data-name="filter_link" ></label>
    </div>    

    <div class="col-12 mt-3">
      <label class="form-label" ><?php echo translate("tr_c95a1e2de00ee86634e177aecca00aed"); ?><span class="form-label-importantly" >*</span></label>
      <select class="selectpicker" name="filter_category_id" >
        <option value="" ><?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?></option>
        <?php echo $app->component->ads_categories->selectedIds($data->category_id)->getRecursionOptions(); ?>
      </select>
      <label class="form-label-error" data-name="filter_category_id" ></label>
    </div>

  </div>

  <div>
    <div class="mt-4 d-grid gap-2 col-lg-6 mx-auto">
      <button class="btn btn-primary buttonSaveEditSearchKeyword"><?php echo translate("tr_74ea58b6a801f0dce4e5d34dbca034dc"); ?></button>
    </div>
  </div>

  <input type="hidden" name="id" value="<?php echo $data->id; ?>" >

</form>