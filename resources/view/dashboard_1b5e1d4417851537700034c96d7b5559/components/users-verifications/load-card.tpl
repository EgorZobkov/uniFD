<div class="mb-4">
  <h2 class="role-title font-weight-bold"><?php echo translate("tr_35e1a89219a1a7e4c606bece9f4c687e"); ?></h2>
</div>

<div class="btn-group-horizontal text-md-center mt-4">

  <div class="btn-group">
    <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown"><?php echo translate("tr_ac1bbd60d1000d2fb97af5367b2e73d4"); ?></button>
    <ul class="dropdown-menu">

      <?php
      foreach ($app->user->codeVerification() as $key => $value){
        ?>
        <li><span class="dropdown-item selectVerificationChangeStatus" data-id="<?php echo $data->id; ?>" data-status="<?php echo $value["code"]; ?>" ><?php echo $value["name"]; ?></span></li>
        <?php
      }
      ?>

    </ul>
  </div>

  <button class="btn btn-outline-danger deleteVerification" data-id="<?php echo $data->id; ?>" ><i class="ti ti-trash"></i></button>

</div>

<div class="row g-3 mt-2" >
  
  <form class="reason-blocking-form" >
    <div class="verification-card-container-reason" <?php if($data->status == "rejected"){ echo 'style="display: block;"'; }else{ echo 'style="display: none;"'; } ?> >
      <div class="col-12">
        <strong><label class="form-label" ><?php echo translate("tr_ce37b3138fcdc15dff8f22c128981d06"); ?></label></strong>
        <textarea class="form-control" name="reason_comment" ><?php echo $data->comment; ?></textarea>
        <label class="form-label-error" data-name="reason_comment" ></label>
      </div>
      <div class="text-end" ><button class="btn btn-label-primary waves-effect waves-light mt-2 buttonSaveVerificationReasonStatus" ><?php echo translate("tr_74ea58b6a801f0dce4e5d34dbca034dc"); ?></button></div>
    </div>
    <input type="hidden" name="id" value="<?php echo $data->id; ?>" >
  </form>

  <div class="col-12">
    <strong><label class="form-label" ><?php echo translate("tr_f154d6cc8945d799f4b31ccc1e0019f5"); ?></label></strong>
    <div> <a href="<?php echo $app->router->getRoute("dashboard-user-card", [$data->user->id]); ?>"><?php echo $app->user->name($data->user); ?></a> </div>
  </div>

  <div class="col-12">
    <strong><label class="form-label" ><?php echo translate("tr_1c9da712eaa7f2c757d738c7d293a336"); ?></label></strong>
    <div> <?php echo $data->uniq_code; ?> </div>
  </div>

  <div class="col-12">
    <strong><label class="form-label" ><?php echo translate("tr_5a34e5446905d8389a6dc403bdb76b72"); ?></label></strong>
    <div>
      <div class="container-media-gallery uniMediaSliderContainer" >
        <?php
          if($data->media){
             foreach (_json_decode($data->media) as $key => $value) {
                $image = $app->image->toBase64ByPath(BASE_PATH.$value, true);
                ?>
                <a href="<?php echo $image; ?>" class="container-media-gallery-item uniMediaSliderItem" data-media-type="image" data-media-key="<?php echo $key; ?>" >
                    <img src="<?php echo $image; ?>" data-key="<?php echo $key; ?>" class="image-autofocus" >
                </a>
                <?php
             }
          }
        ?>
      </div>

    </div>
  </div>

</div>
