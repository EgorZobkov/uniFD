<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme" data-status="<?php if($app->system->getSystemTemplate()->collapsed_sidebar == true){ echo 'hidden'; }else{ echo 'visible'; } ?>" >
  
  <div class="app-brand demo">
    <span class="app-brand-link">
      <span class="app-brand-logo demo">
        <img src="<?php echo $app->storage->logoMini(); ?>" />
      </span>
      <span class="app-brand-text demo menu-text fw-bold"><?php echo getInitialsString($app->settings->project_name); ?></span>
    </span>

    <span class="layout-menu-toggle cursor-pointer menu-link text-large ms-auto">
      <?php if($app->system->getSystemTemplate()->collapsed_sidebar == true){ ?>
      <i class="ti ti-circle sidebar-menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
      <?php }else{ ?>
      <i class="ti ti-circle-dot sidebar-menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
      <?php } ?>
      <i class="ti ti-x d-block d-xl-none ti-sm align-middle close-mobile-navbar"></i>
    </span>
  </div>

  <div class="menu-inner-list-container" >
  <ul class="menu-inner menu-inner-list">

    <?php echo $app->system->outSystemMenu(); ?>

  </ul>

  </div>

</aside>