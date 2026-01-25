
<div class="mb-4">
  <h2 class="role-title font-weight-bold"><?php echo translate("tr_37f992f04c262206e619a98008935515"); ?></h2>
</div>

<div class="btn-group-horizontal text-center mt-4">

  <?php if($data->status == 0 || $data->status == 2 || $data->status == 3 || $data->status == 4 || $data->status == 5){ ?>
    <button type="button" class="btn btn-primary actionAdApprove me-1 mb-2" data-id="<?php echo $data->id; ?>" data-status="1" ><?php echo translate("tr_fd47eb2e78af443b8fac35a0ca0a5e0a"); ?></button>
  <?php }elseif($data->status == 1){ ?>
    <button type="button" class="btn btn-primary actionAdChangeStatus me-1 mb-2" data-id="<?php echo $data->id; ?>" data-status="3" ><?php echo translate("tr_af1939bb99d547ff54c8623ba556ab5a"); ?></button>
  <?php } ?>

  <div class="btn-group me-1 mb-2">
    <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown"><?php echo translate("tr_ac1bbd60d1000d2fb97af5367b2e73d4"); ?></button>
    <ul class="dropdown-menu">

      <?php
      foreach ($app->component->ads->allStatuses() as $key => $value){
        ?>
        <li><span class="dropdown-item selectAdChangeStatus" data-id="<?php echo $data->id; ?>" data-status="<?php echo $value["status"]; ?>" ><?php echo $value["name"]; ?></span></li>
        <?php
      }
      ?>

    </ul>
  </div>

  <a href="<?php echo $app->router->getRoute("ad-edit", [$data->id]);  ?>" target="_blank" class="btn btn-outline-primary me-1 mb-2"><i class="ti ti-pencil"></i></a>

  <a href="<?php echo $app->component->ads->buildAliasesAdCard($data);  ?>" target="_blank" class="btn btn-outline-primary me-1 mb-2"><i class="ti ti-share-3"></i></a>
 
  <button class="btn btn-danger deleteAd mb-2" data-id="<?php echo $data->id; ?>" ><i class="ti ti-trash"></i></button>

</div>

<div class="row g-3" >

  <form class="reason-blocking-form" >
  <div class="ad-card-container-reason-change-status" <?php if($data->reason_blocking_code){ echo 'style="display: block;"'; }else{ echo 'style="display: none;"'; } ?> >
    <div class="col-12">
      <strong><label class="form-label" ><?php echo translate("tr_85b385928b60d0bbb6c9ac74f5c6ac56"); ?></label></strong>
      <div class="mt-1" >
        <select class="form-select selectpicker ad-card-select-reason" name="reason_code" >
          <option value="" ><?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?></option>
          <?php
          foreach ($app->system->getAllReasonsBlocking() as $key => $value){
            if(compareValues($data->reason_blocking_code, $value["code"])){
              ?>
              <option value="<?php echo $value["code"]; ?>" selected="" ><?php echo $value["name"]; ?></option>
              <?php
            }else{
              ?>
              <option value="<?php echo $value["code"]; ?>" ><?php echo $value["name"]; ?></option>
              <?php
            }
          }
          ?>
          <option value="other" ><?php echo translate("tr_15291f4233174b813811b7489b48c712"); ?></option>
        </select>
        <label class="form-label-error" data-name="reason_code" ></label>
      </div>
      <div class="ad-card-container-reason-text-status" >
        <div class="mt-2" >
          <strong><label class="form-label" ><?php echo translate("tr_d8ef4d305370a3d4416ce85a4d8791d8"); ?></label></strong>
          <textarea class="form-control" name="reason_comment" ></textarea>
          <label class="form-label-error" data-name="reason_comment" ></label>
        </div>
      </div>
    </div>
    <div class="col-12 mt-2">
      <label class="switch">
        <input type="checkbox" class="switch-input" name="block_forever_status" value="1"  <?php if($data->block_forever_status){ echo 'checked=""'; } ?> >
        <span class="switch-toggle-slider">
          <span class="switch-on"></span>
          <span class="switch-off"></span>
        </span>
        <span class="switch-label" ><?php echo translate("tr_a5febf58c638b3164de3be832477c439"); ?></span>
      </label>          
    </div>
    <div class="text-end" ><button class="btn btn-label-primary waves-effect waves-light mt-2 buttonSaveAdReasonStatus" ><?php echo translate("tr_74ea58b6a801f0dce4e5d34dbca034dc"); ?></button></div>
  </div>
  <input type="hidden" name="status" value="4" >
  <input type="hidden" name="id" value="<?php echo $data->id; ?>" >
  </form>

  <div class="col-12">
    <strong><label class="form-label" >ID</label></strong>
    <div><?php echo $data->id; ?></div>
  </div>

  <div class="col-12">
    <strong><label class="form-label" ><?php echo translate("tr_7203f7a4ff564cb876e8db54c903dbfc"); ?></label></strong>
    <div><span class="badge rounded-pill bg-label-<?php echo $app->component->ads->status($data->status)->label; ?> me-1"><?php echo $app->component->ads->status($data->status)->name; ?></span></div>
  </div>

  <div class="col-12">
    <strong><label class="form-label" ><?php echo translate("tr_fe6cbec9220d2d26fa94a66a7568d553"); ?></label></strong>
    <div> <a href="<?php echo $app->router->getRoute("dashboard-user-card", [$data->user->id]); ?>" target="_blank" ><?php echo $data->user->full_name; ?></a> </div>
  </div>

  <div class="col-12">
    <strong><label class="form-label" ><?php echo translate("tr_c95a1e2de00ee86634e177aecca00aed"); ?></label></strong>
    <div><?php echo $app->component->ads_categories->chainCategory($data->category_id)->chain_build; ?></div>
  </div>

  <div class="col-12">
    <strong><label class="form-label" ><?php echo translate("tr_2e9d7991efe99efaf9cf325b6f10d8a0"); ?></label></strong>
    <div><?php echo $data->title; ?></div>
  </div>

  <div class="col-12">
    <strong><label class="form-label" ><?php echo translate("tr_069c9cb17c0aca1e499f3a00fdeb9b3a"); ?></label></strong>
    <div><?php echo $app->component->ads->outGeoAndAddressInAdCard($data) ?: '-'; ?></div>
  </div>

  <div class="col-12">
    <strong><label class="form-label" ><?php echo translate("tr_682fa8dbadd54fda355b27f124938c93"); ?></label></strong>
    <div><?php echo $app->system->amount($data->price, $data->currency_code); ?></div>
  </div>

  <div class="col-12">
    <strong><label class="form-label" ><?php echo translate("tr_38ca0af80cd7bd241500e81ba2e6efff"); ?></label></strong>
    <div><?php echo nl2br($data->text); ?></div>
  </div>

  <div class="col-12">
    <strong><label class="form-label" ><?php echo translate("tr_f7ac6fc5c5a477063add9c6d0701985d"); ?></label></strong>
    <div><?php echo $app->component->ads_filters->outPropertyAd($data->id) ?: '-'; ?></div>
  </div>

  <?php if($data->external_content){ ?>
  <div class="col-12">
    <strong><label class="form-label" ><?php echo translate("tr_2fa24fd4629940f6e1db85913923d0f6"); ?></label></strong>
    <div><?php echo $data->external_content ? outTextWithLinks($data->external_content) : '-'; ?></div>
  </div>
  <?php } ?>

  <?php if($data->partner_link){ ?>
  <div class="col-12">
    <strong><label class="form-label" ><?php echo translate("tr_6b5d775b64e9503706984360194843b8"); ?></label></strong>
    <div><?php echo $data->partner_link ?: '-'; ?></div>
  </div>
  <?php } ?>

  <div class="col-12">
    <strong><label class="form-label" ><?php echo translate("tr_c24797c4abfb4ebe54dc45b9e411ac3a"); ?></label></strong>
    <div class="mt-2" >
      <div class="container-media-gallery uniMediaSliderContainer" >
        <?php
        if($data->media->images->all){

          $source_video = $data->link_video ? $app->video->parseLinkSource($data->link_video) : '';

          foreach ($data->media->inline as $key => $value) {

                if($value->type == "image"){
                    ?>
                    <a href="<?php echo $value->link; ?>" class="container-media-gallery-item uniMediaSliderItem" data-media-type="<?php echo $value->type; ?>" data-media-key="<?php echo $key; ?>" >
                        <img src="<?php echo $value->link; ?>" data-key="<?php echo $key; ?>" class="image-autofocus" >
                    </a>
                    <?php
                }elseif($value->type == "video"){
                    ?>
                    <a href="<?php echo $value->preview; ?>" class="container-media-gallery-item uniMediaSliderItem" data-media-video="<?php echo $value->link; ?>" data-media-type="<?php echo $value->type; ?>" data-media-key="<?php echo $key; ?>"  >
                        <img src="<?php echo $value->preview; ?>" data-key="<?php echo $key; ?>" class="image-autofocus" >
                    </a>
                    <?php
                }
          }

          if($source_video){
                ?>
                <a href="<?php echo $source_video->image; ?>" class="container-media-gallery-item uniMediaSliderItem" data-media-video="<?php echo $source_video->link; ?>" data-media-type="link_video" data-media-key="<?php echo $data->media->count; ?>" >
                    <img src="<?php echo $source_video->image; ?>" data-key="<?php echo $data->media->count; ?>" class="image-autofocus" >
                </a>
                <?php                
          }

        }elseif($source_video){

            ?>
            <a href="<?php echo $source_video->image; ?>" class="container-media-gallery-item uniMediaSliderItem" data-media-video="<?php echo $source_video->link; ?>" data-media-type="link_video" data-media-key="<?php echo $data->media->count; ?>" >
                <img src="<?php echo $source_video->image; ?>" data-key="<?php echo $data->media->count; ?>" class="image-autofocus" >
            </a>
            <?php

        }else{
          echo '-';
        }
        ?>
      </div>
    </div>
  </div>

</div>
