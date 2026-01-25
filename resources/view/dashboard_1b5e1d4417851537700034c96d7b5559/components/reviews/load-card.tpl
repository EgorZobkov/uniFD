<div class="mb-4">
  <h2 class="role-title font-weight-bold"><?php echo translate("tr_2264a8a8231b5a667dc789ce9b2c66ee"); ?></h2>
</div>

<div class="btn-group-horizontal text-md-center">

  <?php if($data->status == 0){ ?>
    <button type="button" class="btn btn-outline-primary buttonConfirmReview" data-id="<?php echo $data->id; ?>" ><?php echo translate("tr_f161d552b95159c1b88ed5b967142c0b"); ?></button>
  <?php } ?>

    <button class="btn btn-outline-danger deleteReview" data-id="<?php echo $data->id; ?>" ><i class="ti ti-trash"></i></button>

</div>

<div class="row g-3 mt-2" >
  
  <div class="col-12">
    <strong><label class="form-label" ><?php echo translate("tr_fdeffcf2a0a6bec14a315d097703e92a"); ?></label></strong>
    <div> <a href="<?php echo $app->router->getRoute("dashboard-user-card", [$data->from_user->id]); ?>"><?php echo $data->from_user->name; ?></a> </div>
  </div>

  <div class="col-12">
    <strong><label class="form-label" ><?php echo translate("tr_25043a84d4b50ae9b01583a7aeedef77"); ?></label></strong>
    <div> <a href="<?php echo $app->router->getRoute("dashboard-user-card", [$data->whom_user->id]); ?>"><?php echo $data->whom_user->name; ?></a> </div>
  </div>

  <?php if($data->ad){ ?>

  <div class="col-12">
    <strong><label class="form-label" ><?php echo translate("tr_a8017171f9cfb1e5367ef6d7ae6a8e9d"); ?></label></strong>
    <div> <a href="<?php echo $app->component->ads->buildAliasesAdCard($data->ad); ?>" target="_blank" ><?php echo $data->ad->title; ?></a> </div>
  </div>

  <?php } ?>

  <div class="col-12">
    <strong><label class="form-label" ><?php echo translate("tr_304ce2c8c71568195da204b85122598a"); ?></label></strong>
    <div><?php echo $data->rating; ?></div>
  </div>

  <div class="col-12">
    <strong><label class="form-label" ><?php echo translate("tr_4a3f5e52678242b15f4e65f85ff3345c"); ?></label></strong>
    <div><?php echo $data->text; ?></div>
  </div>

  <?php if($data->media){ ?>
  <div class="col-12">
    <strong><label class="form-label" ><?php echo translate("tr_67d53f4b12586c176055108451bb8355"); ?></label></strong>
    <div class="container-media-gallery uniMediaSliderContainer mt-2" >
      <?php
        foreach ($data->media as $key => $value) {

            ?>
            <a href="<?php echo $app->storage->name($value)->host(true)->get(); ?>" class="container-media-gallery-item uniMediaSliderItem" data-media-type="image" data-media-key="<?php echo $key; ?>" >
                <img src="<?php echo $app->storage->name($value)->host(true)->get(); ?>" data-key="<?php echo $key; ?>" class="image-autofocus" >
            </a>
            <?php

        }
      ?>
    </div>
  </div>
  <?php } ?>

</div>
