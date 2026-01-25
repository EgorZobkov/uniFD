<div class="col-12" >
  <div class="profile-searches-item-list">

    <div class="row" >
      <div class="col-lg-10 col-10" >
        <a href="<?php echo getHost().'/'.$value->link; ?>">

        <?php if($category->chain){ ?>
          <div><strong><?php echo $category->chain->chain_build; ?></strong></div>
        <?php }elseif($geo){ ?>
          <div><strong><?php echo $geo->name; ?></strong></div>
        <?php }else{ ?>
          <div><strong><?php echo translate("tr_9a73b1e5b44bee481ab175b7e327451e"); ?></strong></div>
        <?php } ?> 

        <span><?php echo $app->component->catalog->buildChainNamesFilters($value->params, $geo); ?></span>
        
        </a>
      </div>
      <div class="col-lg-2 col-2 text-end" >

        <div class="profile-button-item-delete actionProfileDeleteSearch" data-id="<?php echo $value->id; ?>" ><i class="ti ti-trash"></i></div>

      </div>
    </div>

  </div>
</div>