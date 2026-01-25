<div class="mb-4">
  <h2 class="role-title font-weight-bold"><?php echo translate("tr_1a0f845a820eab15bbdb8ee6baa84c35"); ?></h2>
</div>

<div class="btn-group-horizontal text-md-center mt-4">

  <div class="btn-group">
    <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown"><?php echo translate("tr_ac1bbd60d1000d2fb97af5367b2e73d4"); ?></button>
    <ul class="dropdown-menu">

      <?php
      foreach ($app->component->shop->codeStatuses() as $key => $value){
        ?>
        <li><span class="dropdown-item selectShopChangeStatus" data-id="<?php echo $data->id; ?>" data-status="<?php echo $value["code"]; ?>" ><?php echo $value["name"]; ?></span></li>
        <?php
      }
      ?>

    </ul>
  </div>

  <button class="btn btn-outline-danger deleteShop" data-id="<?php echo $data->id; ?>" ><i class="ti ti-trash"></i></button>

</div>

<div class="row g-3 mt-2" >
  
  <form class="reason-blocking-form" >
    <div class="shop-card-container-reason" <?php if($data->status == "rejected"){ echo 'style="display: block;"'; }else{ echo 'style="display: none;"'; } ?> >
      <div class="col-12">
        <strong><label class="form-label" ><?php echo translate("tr_ce37b3138fcdc15dff8f22c128981d06"); ?></label></strong>
        <textarea class="form-control" name="reason_comment" ><?php echo $data->comment; ?></textarea>
        <label class="form-label-error" data-name="reason_comment" ></label>
      </div>
      <div class="text-end" ><button class="btn btn-label-primary waves-effect waves-light mt-2 buttonSaveShopReasonStatus" ><?php echo translate("tr_74ea58b6a801f0dce4e5d34dbca034dc"); ?></button></div>
    </div>
    <input type="hidden" name="id" value="<?php echo $data->id; ?>" >
  </form>

  <div class="col-12">
    <strong><label class="form-label" ><?php echo translate("tr_f154d6cc8945d799f4b31ccc1e0019f5"); ?></label></strong>
    <div> <a href="<?php echo $app->router->getRoute("dashboard-user-card", [$data->user->id]); ?>"><?php echo $app->user->name($data->user); ?></a> </div>
  </div>

  <div class="col-12">
    <strong><label class="form-label" ><?php echo translate("tr_158176991f43d5bdf6c52b258bf05cf4"); ?></label></strong>
    <div> <img src="<?php echo $app->storage->name($data->image)->get(); ?>" width="128" > </div>
  </div>

  <div class="col-12">
    <strong><label class="form-label" ><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?></label></strong>
    <div> <?php echo $data->title; ?> </div>
  </div>

  <div class="col-12">
    <strong><label class="form-label" ><?php echo translate("tr_38ca0af80cd7bd241500e81ba2e6efff"); ?></label></strong>
    <div> <?php echo $data->text; ?> </div>
  </div>

  <div class="col-12">
    <strong><label class="form-label" ><?php echo translate("tr_be518714837d2c2581d28f8eed0f323b"); ?></label></strong>
    <div> <?php echo $data->category_id ? $app->component->ads_categories->categories[$data->category_id]["name"] : '-'; ?> </div>
  </div>

</div>
