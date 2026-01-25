

<div class="row mb-4" >
  
  <div class="col-lg-9 col-md-9 order-md-1 order-2" >
    
    <div class="breadcrumbs-links" > 
      Дашборд / <?php echo $app->system->breadcrumbs($breadcrumbs["chain"]); ?>
    </div>

  </div>

  <div class="col-lg-3 col-md-3 order-1 text-end" >
    
    <?php if($breadcrumbs["favorite_status"]){ ?>
    <div class="gap-3">
      <button class="btn rounded-pill btn-icon btn-label-danger waves-effect template-add-to-favorites" data-route-name="<?php echo $breadcrumbs["route_name"]; ?>" data-page-icon="<?php echo $breadcrumbs["page_icon"]; ?>" data-page-name="<?php echo $breadcrumbs["page_name"]; ?>" >
        <?php if($app->system->checkSystemFavorite($breadcrumbs["route_name"])->status){ ?>
          <span class="ti ti-heart-filled"></span>
        <?php }else{ ?>
          <span class="ti ti-heart-plus"></span>
        <?php } ?>
      </button>
    </div>
    <?php } ?>

  </div>

</div>

